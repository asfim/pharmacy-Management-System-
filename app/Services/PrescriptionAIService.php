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
        // In a real application, you would send $prescription->image_file to an AI API here.
        // For example: Gemini API or OpenAI Vision API.
        
        // Simulating API delay and processing
        $simulatedMatches = [];
        $simulatedMissing = [];

        foreach ($orderedProductNames as $productName) {
            // Simulate 80% chance that the AI "finds" the medicine in the handwritten prescription
            if (rand(1, 100) <= 80) {
                $simulatedMatches[] = $productName;
            } else {
                $simulatedMissing[] = $productName;
            }
        }

        $status = empty($simulatedMissing) ? 'verified' : 'failed';
        
        $notes = "--- AI OCR Match Results ---\n";
        $notes .= "Medicines found in prescription: " . implode(', ', $simulatedMatches) . "\n";
        
        if (!empty($simulatedMissing)) {
            $notes .= "Medicines NOT found in prescription: " . implode(', ', $simulatedMissing) . "\n";
            $notes .= "Please manually verify the uploaded prescription image.";
        } else {
            $notes .= "All ordered medicines were successfully identified in the prescription.";
        }

        // Update the prescription record with the AI's analysis
        $prescription->update([
            'verification_status' => $status,
            'notes' => $notes,
            'verified_at' => now(),
            'verified_by' => null, // AI verification
        ]);

        Log::info("Prescription {$prescription->prescription_no} processed by AI. Status: {$status}");
    }
}
