<?php

namespace App\Services;

use App\Models\Prescription;
use Illuminate\Support\Facades\Log;

class PrescriptionAIService
{
    /**
     * Simulates reading a prescription image using an AI API (like Google Gemini)
     * and matching the extracted medicines against the ordered products.
     *
     * @param Prescription $prescription
     * @param array $orderedProductNames
     * @return void
     */
    public static function process(Prescription $prescription, array $orderedProductNames)
    {
        $imagePath = storage_path('app/public/' . $prescription->image_file);
        
        // If it's a PDF or missing file, fallback to pending manual verification
        if (!file_exists($imagePath) || \Illuminate\Support\Str::endsWith(strtolower($imagePath), '.pdf')) {
            $prescription->update([
                'verification_status' => 'failed',
                'notes' => "Could not read image file or format is unsupported (PDF). Please verify manually.",
                'verified_at' => now(),
            ]);
            return;
        }

        // Call OCR.space API (free tier)
        $url = 'https://api.ocr.space/parse/image';
        $ch = curl_init();
        
        // Try to guess mime type
        $mime = mime_content_type($imagePath);
        if (!$mime) $mime = 'image/jpeg';
        
        $cfile = new \CURLFile($imagePath, $mime, basename($imagePath));
        $data = [
            'apikey' => 'helloworld', // Free test key
            'file' => $cfile,
            'OCREngine' => 2, // Engine 2 is better for numbers/special characters and works well
        ];
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30 seconds timeout
        
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $prescription->update([
                'verification_status' => 'failed',
                'notes' => "OCR API Error: " . $err . "\nPlease verify manually.",
                'verified_at' => now(),
            ]);
            return;
        }

        $result = json_decode($response, true);
        $parsedText = '';
        
        if (isset($result['ParsedResults']) && count($result['ParsedResults']) > 0) {
            foreach ($result['ParsedResults'] as $page) {
                $parsedText .= ' ' . ($page['ParsedText'] ?? '');
            }
        }

        $parsedText = strtolower($parsedText);
        $simulatedMatches = [];
        $simulatedMissing = [];

        foreach ($orderedProductNames as $productName) {
            $cleanProductName = strtolower(trim($productName));
            
            // Check if the medicine name exists in the parsed text
            if (strpos($parsedText, $cleanProductName) !== false) {
                $simulatedMatches[] = $productName;
            } else {
                // Try fuzzy matching (first word or partial string) for better OCR tolerance
                $words = explode(' ', $cleanProductName);
                $firstWord = $words[0] ?? '';
                if (strlen($firstWord) > 3 && strpos($parsedText, $firstWord) !== false) {
                    $simulatedMatches[] = $productName;
                } else {
                    $simulatedMissing[] = $productName;
                }
            }
        }

        $status = empty($simulatedMissing) ? 'verified' : 'failed';
        
        $notes = "--- OCR Analysis Results ---\n";
        if (!empty($simulatedMatches)) {
            $notes .= "Medicines found (Match): " . implode(', ', $simulatedMatches) . "\n";
        }
        
        if (!empty($simulatedMissing)) {
            $notes .= "Medicines NOT found (Mismatch): " . implode(', ', $simulatedMissing) . "\n";
            $notes .= "Please manually verify the uploaded prescription image.";
        } else {
            $notes .= "All ordered medicines were successfully identified in the prescription.";
        }

        // Update the prescription record with the OCR analysis
        $prescription->update([
            'verification_status' => $status,
            'notes' => $notes,
            'verified_at' => now(),
            'verified_by' => null, // AI/OCR verification
        ]);

        Log::info("Prescription {$prescription->prescription_no} processed by OCR. Status: {$status}");
    }
}
