<?php

namespace App\Services;

use App\Models\Prescription;
use Illuminate\Support\Facades\Log;

class PrescriptionAIService
{
    /**
     * Analyzes a prescription image using Google Gemini Vision API
     * (with fallback to OCR.space) and matches the extracted medicines
     * against the ordered products (brand name, generic name, strength).
     *
     * @param Prescription $prescription
     * @param array $orderedProducts
     * @param string|null $originalFilename
     * @return void
     */
    public static function process(Prescription $prescription, array $orderedProducts, ?string $originalFilename = null)
    {
        $imagePath = storage_path('app/public/' . $prescription->image_file);

        if (!file_exists($imagePath)) {
            $prescription->update([
                'verification_status' => 'failed',
                'notes'               => "Prescription file not found on disk. Please verify manually.",
                'verified_at'         => now(),
            ]);
            return;
        }

        // 1. Try Google Gemini Vision API if key is configured
        $geminiKey = config('services.gemini.key');
        if (!empty($geminiKey)) {
            $geminiResult = self::analyzeWithGeminiVision($imagePath, $orderedProducts, $geminiKey, $originalFilename);
            if ($geminiResult !== null) {
                $status = ($geminiResult['all_matched'] ?? false) ? 'verified' : 'failed';

                $notes = "--- Google Gemini Vision AI Analysis ---\n";
                $notes .= "Model: " . config('services.gemini.model', 'gemini-1.5-flash') . "\n";
                if (!empty($geminiResult['pharmacist_summary'])) {
                    $notes .= "Summary: " . $geminiResult['pharmacist_summary'] . "\n\n";
                }

                if (!empty($geminiResult['matched_medicines'])) {
                    $notes .= "✓ Found in Prescription (Match):\n";
                    foreach ($geminiResult['matched_medicines'] as $m) {
                        $prod = is_array($m) ? ($m['product'] ?? '') : $m;
                        $found = is_array($m) ? ($m['found_as'] ?? $prod) : $prod;
                        $notes .= "  - {$prod} (Identified as: {$found})\n";
                    }
                }

                if (!empty($geminiResult['missing_medicines'])) {
                    $notes .= "\n✗ Not Found in Prescription (Mismatch):\n";
                    foreach ($geminiResult['missing_medicines'] as $m) {
                        $prod = is_array($m) ? ($m['product'] ?? '') : $m;
                        $reason = is_array($m) ? ($m['reason'] ?? 'Not found') : 'Not found';
                        $notes .= "  - {$prod}: {$reason}\n";
                    }
                }

                if (!empty($geminiResult['extracted_prescription_text'])) {
                    $notes .= "\n[Prescription Text Detected]:\n" . trim($geminiResult['extracted_prescription_text']);
                }

                $prescription->update([
                    'verification_status' => $status,
                    'notes'               => trim($notes),
                    'verified_at'         => now(),
                    'verified_by'         => null,
                ]);

                Log::info("Prescription {$prescription->prescription_no} analyzed via Google Gemini Vision. Status: {$status}.");
                return;
            }
        }

        // 2. Fallback to OCR.space API and algorithmic matching
        self::processWithOCRSpace($prescription, $imagePath, $orderedProducts, $originalFilename);
    }

    /**
     * Calls Google Gemini Vision API to analyze the prescription and compare with ordered items.
     *
     * @param string $filePath
     * @param array $orderedProducts
     * @param string $apiKey
     * @param string|null $originalFilename
     * @return array|null
     */
    protected static function analyzeWithGeminiVision(string $filePath, array $orderedProducts, string $apiKey, ?string $originalFilename = null): ?array
    {
        $fileBytes = @file_get_contents($filePath);
        if ($fileBytes === false) {
            return null;
        }

        $base64 = base64_encode($fileBytes);
        $mime = mime_content_type($filePath) ?: 'image/jpeg';
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        $itemsSummary = [];
        foreach ($orderedProducts as $prod) {
            $itemsSummary[] = [
                'product_name' => is_array($prod) ? ($prod['name'] ?? '') : $prod,
                'generic_name' => is_array($prod) ? ($prod['generic'] ?? '') : '',
                'strength'     => is_array($prod) ? ($prod['strength'] ?? '') : '',
            ];
        }

        $prompt = "You are an expert pharmacist and medical AI verifier.\n"
            . "Please analyze this uploaded prescription image/document.\n\n"
            . "Ordered Products to verify against this prescription:\n"
            . json_encode($itemsSummary, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n"
            . ($originalFilename ? "Original uploaded filename: {$originalFilename}\n\n" : "")
            . "Instructions:\n"
            . "1. Read all text, handwriting, generic drug names, brand names, and dosages written on the prescription.\n"
            . "2. For each ordered product, check if it or its generic chemical equivalent is mentioned in the prescription.\n"
            . "3. Return your final answer in STRICT JSON format with this exact structure:\n"
            . "{\n"
            . '  "all_matched": true or false,' . "\n"
            . '  "pharmacist_summary": "Short explanation of prescription contents",' . "\n"
            . '  "matched_medicines": [' . "\n"
            . '    {"product": "Ordered Product Name", "found_as": "Name/Generic as found on prescription"}' . "\n"
            . '  ],' . "\n"
            . '  "missing_medicines": [' . "\n"
            . '    {"product": "Ordered Product Name", "reason": "Why it does not match"}' . "\n"
            . '  ],' . "\n"
            . '  "extracted_prescription_text": "Extracted text or medicine lines from image"' . "\n"
            . "}\n"
            . "Provide raw JSON only. Do not wrap in markdown backticks or commentary.";

        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($apiKey);

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => $mime,
                                'data'      => $base64,
                            ],
                        ],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature'        => 0.1,
                'response_mime_type' => 'application/json',
            ],
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError || $httpCode !== 200 || empty($response)) {
            Log::warning("Gemini Vision API call failed (HTTP {$httpCode}): " . ($curlError ?: substr($response, 0, 500)));
            return null;
        }

        $resData = json_decode($response, true);
        $candidateText = $resData['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$candidateText) {
            Log::warning("Gemini Vision API returned empty candidate text.");
            return null;
        }

        // Clean any accidental markdown code fencing
        $cleanedText = trim($candidateText);
        if (str_starts_with($cleanedText, '```json')) {
            $cleanedText = substr($cleanedText, 7);
        } elseif (str_starts_with($cleanedText, '```')) {
            $cleanedText = substr($cleanedText, 3);
        }
        if (str_ends_with($cleanedText, '```')) {
            $cleanedText = substr($cleanedText, 0, -3);
        }
        $cleanedText = trim($cleanedText);

        $parsed = json_decode($cleanedText, true);
        if (!is_array($parsed)) {
            Log::warning("Could not parse JSON from Gemini response: " . substr($cleanedText, 0, 300));
            return null;
        }

        return $parsed;
    }

    /**
     * Fallback OCR.space method to extract text and match algorithmically.
     *
     * @param Prescription $prescription
     * @param string $imagePath
     * @param array $orderedProducts
     * @param string|null $originalFilename
     * @return void
     */
    protected static function processWithOCRSpace(Prescription $prescription, string $imagePath, array $orderedProducts, ?string $originalFilename = null)
    {
        $parsedText = self::extractTextWithOCR($imagePath);

        if ($originalFilename) {
            $parsedText .= ' ' . pathinfo($originalFilename, PATHINFO_FILENAME);
        }

        $cleanParsedText = strtolower($parsedText);
        $normalizedText = preg_replace('/[^a-z0-9\s]/', ' ', $cleanParsedText);
        $ocrTokens = array_values(array_filter(explode(' ', $normalizedText), fn($w) => strlen(trim($w)) >= 3));

        $matchedList = [];
        $missingList = [];

        foreach ($orderedProducts as $prod) {
            $productName = is_array($prod) ? ($prod['name'] ?? '') : $prod;
            $genericName = is_array($prod) ? ($prod['generic'] ?? '') : '';

            $isMatched = false;

            // 1. Direct name check
            $cleanName = strtolower(trim($productName));
            if (!empty($cleanName) && str_contains($normalizedText, $cleanName)) {
                $isMatched = true;
            }

            // 2. Generic name check
            $cleanGeneric = strtolower(trim($genericName));
            if (!$isMatched && !empty($cleanGeneric) && str_contains($normalizedText, $cleanGeneric)) {
                $isMatched = true;
            }

            // 3. Significant word check
            if (!$isMatched && !empty($cleanName)) {
                $words = array_filter(explode(' ', $cleanName), fn($w) => strlen($w) >= 3);
                foreach ($words as $w) {
                    if (str_contains($normalizedText, $w)) {
                        $isMatched = true;
                        break;
                    }
                }
            }

            // 4. Fuzzy token matching
            if (!$isMatched) {
                $targetWords = [];
                if (!empty($cleanName)) $targetWords[] = explode(' ', $cleanName)[0];
                if (!empty($cleanGeneric)) $targetWords[] = explode(' ', $cleanGeneric)[0];

                foreach ($targetWords as $target) {
                    if (strlen($target) < 3) continue;

                    foreach ($ocrTokens as $token) {
                        similar_text($token, $target, $percent);
                        if ($percent >= 75) {
                            $isMatched = true;
                            break 2;
                        }

                        $lev = levenshtein($token, $target);
                        $maxLev = strlen($target) > 6 ? 2 : 1;
                        if ($lev <= $maxLev) {
                            $isMatched = true;
                            break 2;
                        }
                    }
                }
            }

            $displayName = $productName . ($genericName ? " ({$genericName})" : '');
            if ($isMatched) {
                $matchedList[] = $displayName;
            } else {
                $missingList[] = $displayName;
            }
        }

        $status = empty($missingList) ? 'verified' : 'failed';

        $notes = "--- AI Prescription OCR Analysis (OCR.space Engine) ---\n";
        if (empty(config('services.gemini.key'))) {
            $notes .= "[Tip: Set GEMINI_API_KEY in .env to use Google Gemini Vision AI]\n\n";
        }

        if (!empty($matchedList)) {
            $notes .= "✓ Found in Prescription (Match): " . implode(', ', $matchedList) . "\n";
        }
        if (!empty($missingList)) {
            $notes .= "✗ Not Found (Mismatch): " . implode(', ', $missingList) . "\n";
            $notes .= "Please manually verify the uploaded prescription image.";
        } else {
            $notes .= "All ordered medicines were successfully identified in the prescription.";
        }

        $prescription->update([
            'verification_status' => $status,
            'notes'               => $notes,
            'verified_at'         => now(),
            'verified_by'         => null,
        ]);

        Log::info("Prescription {$prescription->prescription_no} analyzed via OCR.space. Status: {$status}.");
    }

    /**
     * Calls OCR.space API to extract text from image or PDF.
     */
    protected static function extractTextWithOCR(string $filePath): string
    {
        $apiKeys = ['helloworld', 'K87899142388957', 'K85673891488957'];
        $mime = mime_content_type($filePath) ?: 'image/jpeg';
        $fileName = basename($filePath);

        foreach ($apiKeys as $key) {
            $ch = curl_init('https://api.ocr.space/parse/image');
            $cfile = new \CURLFile($filePath, $mime, $fileName);
            $data = [
                'apikey'    => $key,
                'file'      => $cfile,
                'OCREngine' => 2,
                'isTable'   => true,
            ];

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);

            $response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if (!$error && $response) {
                $result = json_decode($response, true);
                if (!empty($result['ParsedResults'])) {
                    $text = '';
                    foreach ($result['ParsedResults'] as $page) {
                        $text .= ' ' . ($page['ParsedText'] ?? '');
                    }
                    if (!empty(trim($text))) {
                        return trim($text);
                    }
                }
            }
        }

        return '';
    }
}
