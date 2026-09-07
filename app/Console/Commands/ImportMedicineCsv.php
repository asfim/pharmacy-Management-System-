<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\Generic;
use App\Models\Manufacturer;
use App\Models\Unit;
use App\Models\ProductImage;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportMedicineCsv extends Command
{
    protected $signature = 'import:medicines {--limit=0 : Limit number of records to import}';
    protected $description = 'Import 20k Bangladesh medicine and drug price data from CSV with images and initial batches';

    public function handle()
    {
        $filePath = base_path('all_medicine_and_drug_price_data(20k)_Bangladesh.csv');

        if (!file_exists($filePath)) {
            $this->error("CSV file not found at: {$filePath}");
            return 1;
        }

        $this->info("Starting medicine import from: {$filePath}");

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->error("Could not open CSV file.");
            return 1;
        }

        // Read header
        $header = fgetcsv($handle);
        $this->info("Columns: " . implode(', ', $header));

        $count = 0;
        $limit = (int) $this->option('limit');

        // Pre-cache lookups for maximum speed
        $categories = [];
        $generics = [];
        $manufacturers = [];
        $units = [];

        $sampleImages = [
            'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=300&q=80',
            'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=300&q=80',
            'https://images.unsplash.com/photo-1550572017-edf7928420e6?w=300&q=80',
            'https://images.unsplash.com/photo-1576602976047-174e57a47881?w=300&q=80',
            'https://images.unsplash.com/photo-1585435557343-3b092031a831?w=300&q=80',
        ];

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 9) continue;

                $medicineName     = trim($row[0]);
                $categoryName     = trim($row[1]) ?: 'General';
                $slug             = trim($row[2]);
                $genericName      = trim($row[3]) ?: 'General Generic';
                $strength         = trim($row[4]);
                $manufacturerName = trim($row[5]) ?: 'Local Manufacturer';
                $unitName         = trim($row[6]) ?: 'Piece';
                $unitSize         = trim($row[7]);
                $price            = (float) trim($row[8]);

                if (empty($medicineName)) continue;

                // Category
                if (!isset($categories[$categoryName])) {
                    $cat = Category::firstOrCreate(['name' => $categoryName]);
                    $categories[$categoryName] = $cat->id;
                }
                $categoryId = $categories[$categoryName];

                // Generic
                if (!isset($generics[$genericName])) {
                    $gen = Generic::firstOrCreate(['name' => $genericName]);
                    $generics[$genericName] = $gen->id;
                }
                $genericId = $generics[$genericName];

                // Manufacturer
                if (!isset($manufacturers[$manufacturerName])) {
                    $mfg = Manufacturer::firstOrCreate(['company_name' => $manufacturerName]);
                    $manufacturers[$manufacturerName] = $mfg->id;
                }
                $manufacturerId = $manufacturers[$manufacturerName];

                // Unit
                if (!isset($units[$unitName])) {
                    $u = Unit::firstOrCreate(['name' => $unitName]);
                    $units[$unitName] = $u->id;
                }
                $unitId = $units[$unitName];

                $purchasePrice = round($price * 0.85, 2);
                $sku = 'MED-' . str_pad($count + 1, 6, '0', STR_PAD_LEFT);

                // Create Product
                $product = Product::create([
                    'sku'                  => $sku,
                    'barcode'              => '880' . sprintf('%010d', $count + 1),
                    'name'                 => $medicineName,
                    'generic_id'           => $genericId,
                    'manufacturer_id'      => $manufacturerId,
                    'category_id'          => $categoryId,
                    'unit_id'              => $unitId,
                    'medicine_type'        => $categoryName,
                    'strength'             => $strength,
                    'dosage_form'          => $categoryName,
                    'pack_size'            => $unitSize,
                    'purchase_price'       => $purchasePrice,
                    'sale_price'           => $price,
                    'mrp'                  => $price,
                    'wholesale_price'      => round($price * 0.90, 2),
                    'min_stock'            => 10,
                    'reorder_level'        => 20,
                    'prescription_required'=> in_array(strtolower($categoryName), ['injection', 'tablet', 'capsule', 'antibiotic']),
                    'status'               => 'active',
                ]);

                // Create Product Image
                $imageUrl = $sampleImages[$count % count($sampleImages)];
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => $imageUrl,
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);

                // Create Initial Batch for Stock
                Batch::create([
                    'product_id'     => $product->id,
                    'batch_no'       => 'B' . sprintf('%05d', $count + 1),
                    'expiry_date'    => now()->addMonths(rand(12, 36))->format('Y-m-d'),
                    'purchase_price' => $purchasePrice,
                    'sale_price'     => $price,
                    'mrp'            => $price,
                    'quantity'       => rand(100, 500),
                    'status'         => 'active',
                ]);

                $count++;

                if ($count % 500 === 0) {
                    DB::commit();
                    DB::beginTransaction();
                    $this->info("Imported {$count} medicines...");
                }

                if ($limit > 0 && $count >= $limit) {
                    break;
                }
            }

            DB::commit();
            fclose($handle);

            $this->info("Successfully imported {$count} medicines with images and batches!");
            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            $this->error("Import failed: " . $e->getMessage());
            return 1;
        }
    }
}
