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
        $filePath = base_path('medicines.csv');

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
        
        $isNetmedsFormat = false;
        if (is_array($header) && count($header) >= 12 && stripos($header[0], 'disease_name') !== false) {
            $isNetmedsFormat = true;
            $this->info("Detected Netmeds format.");
        }

        $count = 0;
        $limit = (int) $this->option('limit');

        // Pre-cache lookups for maximum speed
        $categories = [];
        $generics = [];
        $manufacturers = [];
        $units = [];
        
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $maxBarcode = 0;
        if ($lastProduct) {
            $maxBarcode = (int) str_replace('880', '', $lastProduct->barcode);
        }

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 2) continue;

                if ($isNetmedsFormat) {
                    $medicineName     = trim($row[2] ?? '');
                    $categoryName     = trim($row[0] ?? 'General') ?: 'General';
                    // Extract numeric part from final_price like "₹335.68"
                    $rawPrice         = preg_replace('/[^0-9.]/', '', trim($row[4] ?? '0'));
                    $price            = (float) ($rawPrice ?: 0);
                    $genericName      = trim($row[11] ?? 'General Generic') ?: 'General Generic';
                    $strength         = trim($row[7] ?? '');
                    $manufacturerName = trim($row[8] ?? 'Local Manufacturer') ?: 'Local Manufacturer';
                    $unitName         = 'Piece';
                    $unitSize         = '1';
                    $csvImage         = trim($row[12] ?? '');
                    // Split multiple URLs
                    $csvImages = explode(',', $csvImage);
                    $csvImage = trim($csvImages[0] ?? '');
                } else {
                    $medicineName     = trim($row[0] ?? '');
                    $categoryName     = trim($row[1] ?? 'General') ?: 'General';
                    $genericName      = trim($row[3] ?? 'General Generic') ?: 'General Generic';
                    $strength         = trim($row[4] ?? '');
                    $manufacturerName = trim($row[5] ?? 'Local Manufacturer') ?: 'Local Manufacturer';
                    $unitName         = trim($row[6] ?? 'Piece') ?: 'Piece';
                    $unitSize         = trim($row[7] ?? '1');
                    $price            = (float) trim($row[8] ?? 0);
                    $csvImage         = trim($row[9] ?? '');
                }

                if (empty($medicineName)) continue;
                if (strlen($categoryName) > 250) $categoryName = substr($categoryName, 0, 250);
                if (strlen($genericName) > 250) $genericName = substr($genericName, 0, 250);
                if (strlen($manufacturerName) > 250) $manufacturerName = substr($manufacturerName, 0, 250);
                if (strlen($medicineName) > 250) $medicineName = substr($medicineName, 0, 250);

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
                $sku = 'MED-' . strtoupper(Str::random(6));

                $product = Product::firstOrNew(['name' => $medicineName]);
                $product->generic_id           = $genericId;
                $product->manufacturer_id      = $manufacturerId;
                $product->category_id          = $categoryId;
                $product->unit_id              = $unitId;
                $product->medicine_type        = $categoryName;
                $product->strength             = $strength;
                $product->dosage_form          = $categoryName;
                $product->pack_size            = $unitSize;
                $product->purchase_price       = $purchasePrice;
                $product->sale_price           = $price;
                $product->mrp                  = $price;
                $product->wholesale_price      = round($price * 0.90, 2);
                $product->min_stock            = 10;
                $product->reorder_level        = 20;
                $product->prescription_required= in_array(strtolower($categoryName), ['injection', 'tablet', 'capsule', 'antibiotic']);
                $product->status               = 'active';

                if (!$product->exists) {
                    $product->sku = $sku;
                    $product->barcode = '880' . substr(time(), -3) . sprintf('%07d', $maxBarcode + $count + 1);
                }
                $product->save();

                // Create Product Image
                if (!empty($csvImage)) {
                    ProductImage::firstOrCreate(
                        ['product_id' => $product->id, 'image_url' => $csvImage],
                        ['is_primary' => true, 'sort_order' => 1]
                    );
                }

                // Create Initial Batch for Stock
                Batch::updateOrCreate(
                    ['product_id' => $product->id, 'batch_no' => 'B' . sprintf('%05d', $count + 1)],
                    [
                        'expiry_date'    => now()->addMonths(rand(12, 36))->format('Y-m-d'),
                        'purchase_price' => $purchasePrice,
                        'sale_price'     => $price,
                        'mrp'            => $price,
                        'quantity'       => rand(100, 500),
                        'status'         => 'active',
                    ]
                );

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
