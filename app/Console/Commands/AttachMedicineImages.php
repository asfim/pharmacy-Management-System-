<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AttachMedicineImages extends Command
{
    protected $signature = 'medicines:attach-images';
    protected $description = 'Copy images from Medicine_data to storage and assign to all products';

    public function handle()
    {
        $sourceDir = base_path('Medicine_data');
        $targetDir = storage_path('app/public/medicines');

        if (!File::exists($sourceDir)) {
            $this->error("Medicine_data directory not found at {$sourceDir}");
            return 1;
        }

        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $files = File::files($sourceDir);
        if (empty($files)) {
            $this->error("No files found in Medicine_data");
            return 1;
        }

        $this->info("Found " . count($files) . " image files in Medicine_data.");

        // Copy all files to storage/app/public/medicines
        $relativePaths = [];
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $targetPath = $targetDir . '/' . $filename;
            File::copy($file->getPathname(), $targetPath);
            $relativePaths[] = 'medicines/' . $filename;
        }

        $this->info("Copied " . count($relativePaths) . " images to storage/app/public/medicines/");

        // Match images to products
        $totalImages = count($relativePaths);
        $totalProducts = Product::count();
        $this->info("Assigning images to {$totalProducts} products...");

        $chunkSize = 500;
        $processed = 0;

        Product::chunk($chunkSize, function ($products) use (&$processed, $relativePaths, $totalImages) {
            DB::beginTransaction();
            try {
                foreach ($products as $product) {
                    $imagePath = $relativePaths[$processed % $totalImages];

                    $product->update(['image' => $imagePath]);

                    ProductImage::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'is_primary' => true,
                        ],
                        [
                            'image_url'  => $imagePath,
                            'sort_order' => 1,
                        ]
                    );

                    $processed++;
                }
                DB::commit();
                $this->info("Processed {$processed} / {$totalImages} images mapped...");
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Error chunk: " . $e->getMessage());
            }
        });

        $this->info("Successfully assigned Medicine_data images to all {$processed} medicines!");
        return 0;
    }
}
