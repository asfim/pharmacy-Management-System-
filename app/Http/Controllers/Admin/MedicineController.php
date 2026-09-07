<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMedicineRequest;
use App\Http\Requests\Admin\UpdateMedicineRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Generic;
use App\Models\Brand;
use App\Models\Manufacturer;
use App\Models\Unit;
use App\Models\ProductImage;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MedicineController extends Controller
{
    private function getFormData(): array
    {
        return [
            'categories'    => Category::all(),
            'subCategories' => SubCategory::all(),
            'generics'      => Generic::all(),
            'brands'        => Brand::all(),
            'manufacturers' => Manufacturer::all(),
            'units'         => Unit::all(),
            'medicineTypes' => [
                'Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream', 'Ointment',
                'Drops', 'Inhaler', 'Spray', 'Powder', 'Suspension', 'Suppository',
                'Gel', 'Lotion',
            ],
        ];
    }

    public function index(Request $request)
    {
        $perPageRaw = $request->get('per_page', 50);
        $perPage = ($perPageRaw === 'all' || (int)$perPageRaw >= 10000) ? 10000 : (int)$perPageRaw;
        if (!in_array($perPage, [50, 100, 200, 500, 10000])) {
            $perPage = 50;
        }

        $query = Product::with(['category', 'brand', 'generic', 'manufacturer', 'product_images']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('strength', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhereHas('generic', function ($g) use ($search) {
                      $g->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('manufacturer', function ($m) use ($search) {
                      $m->where('company_name', 'like', "%{$search}%");
                  });
            });
        }

        $medicines = $query->latest()->paginate($perPage);

        if ($request->ajax()) {
            $html = view('admin.medicines.partials.table_rows', compact('medicines'))->render();
            return response()->json([
                'html'           => $html,
                'has_more_pages' => $medicines->hasMorePages(),
                'current_page'   => $medicines->currentPage(),
                'next_page'      => $medicines->currentPage() + 1,
                'total'          => $medicines->total(),
                'count'          => $medicines->count(),
            ]);
        }

        return view('admin.medicines.index', compact('medicines', 'perPageRaw'));
    }

    public function create()
    {
        return view('admin.medicines.create', $this->getFormData());
    }

    public function store(StoreMedicineRequest $request)
    {
        $data = $request->validated();
        $data['prescription_required'] = $request->boolean('prescription_required');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $product = Product::create($data);

        if (isset($data['image'])) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_url'  => $data['image'],
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function show(Product $medicine)
    {
        $medicine->load(['category', 'brand', 'generic', 'manufacturer', 'batches']);
        return view('admin.medicines.show', compact('medicine'));
    }

    public function edit(Product $medicine)
    {
        return view('admin.medicines.edit', array_merge(['medicine' => $medicine], $this->getFormData()));
    }

    public function update(UpdateMedicineRequest $request, Product $medicine)
    {
        $data = $request->validated();
        $data['prescription_required'] = $request->boolean('prescription_required');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update($data);

        if (isset($data['image'])) {
            ProductImage::updateOrCreate(
                ['product_id' => $medicine->id, 'is_primary' => true],
                ['image_url' => $data['image'], 'sort_order' => 1]
            );
        }

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Product $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:51200',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        if (!$handle) {
            return back()->with('error', 'Unable to open uploaded CSV file.');
        }

        // Available local images in storage/app/public/medicines
        $localImages = [];
        $targetDir = storage_path('app/public/medicines');
        if (File::exists($targetDir)) {
            $localFiles = File::files($targetDir);
            foreach ($localFiles as $lf) {
                $localImages[] = 'medicines/' . $lf->getFilename();
            }
        }
        $totalLocalImages = count($localImages);

        $header = fgetcsv($handle);
        $count = 0;

        $categories = Category::pluck('id', 'name')->toArray();
        $generics = Generic::pluck('id', 'name')->toArray();
        $manufacturers = Manufacturer::pluck('id', 'company_name')->toArray();
        $units = Unit::pluck('id', 'name')->toArray();

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) < 2) continue;

                $medicineName     = trim($row[0] ?? '');
                $categoryName     = trim($row[1] ?? 'General') ?: 'General';
                $slug             = trim($row[2] ?? '');
                $genericName      = trim($row[3] ?? 'General Generic') ?: 'General Generic';
                $strength         = trim($row[4] ?? '');
                $manufacturerName = trim($row[5] ?? 'Local Manufacturer') ?: 'Local Manufacturer';
                $unitName         = trim($row[6] ?? 'Piece') ?: 'Piece';
                $unitSize         = trim($row[7] ?? '1');
                $price            = (float) trim($row[8] ?? 0);

                if (empty($medicineName)) continue;

                if (!isset($categories[$categoryName])) {
                    $cat = Category::firstOrCreate(['name' => $categoryName]);
                    $categories[$categoryName] = $cat->id;
                }
                if (!isset($generics[$genericName])) {
                    $gen = Generic::firstOrCreate(['name' => $genericName]);
                    $generics[$genericName] = $gen->id;
                }
                if (!isset($manufacturers[$manufacturerName])) {
                    $mfg = Manufacturer::firstOrCreate(['company_name' => $manufacturerName]);
                    $manufacturers[$manufacturerName] = $mfg->id;
                }
                if (!isset($units[$unitName])) {
                    $u = Unit::firstOrCreate(['name' => $unitName]);
                    $units[$unitName] = $u->id;
                }

                $purchasePrice = round($price * 0.85, 2);
                $sku = 'MED-' . strtoupper(Str::random(6));

                $assignedImage = $totalLocalImages > 0 ? $localImages[$count % $totalLocalImages] : null;

                $product = Product::create([
                    'sku'                  => $sku,
                    'barcode'              => '880' . sprintf('%010d', rand(100000, 999999)),
                    'name'                 => $medicineName,
                    'generic_id'           => $generics[$genericName],
                    'manufacturer_id'      => $manufacturers[$manufacturerName],
                    'category_id'          => $categories[$categoryName],
                    'unit_id'              => $units[$unitName],
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
                    'image'                => $assignedImage,
                    'status'               => 'active',
                ]);

                if ($assignedImage) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url'  => $assignedImage,
                        'is_primary' => true,
                        'sort_order' => 1,
                    ]);
                }

                Batch::create([
                    'product_id'     => $product->id,
                    'batch_no'       => 'B' . sprintf('%05d', rand(100, 99999)),
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
                }
            }

            DB::commit();
            fclose($handle);

            return back()->with('success', "Bulk Upload Successful! Added {$count} medicines with images and batch stock.");
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Bulk Upload failed: ' . $e->getMessage());
        }
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'medicines_' . date('Y_m_d_His') . '.csv';

        $query = Product::with(['category', 'generic', 'manufacturer']);
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $products = $query->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['SKU', 'Name', 'Generic', 'Manufacturer', 'Category', 'Strength', 'Pack Size', 'Purchase Price', 'Sale Price', 'Status']);

            foreach ($products as $p) {
                fputcsv($file, [
                    $p->sku,
                    $p->name,
                    $p->generic->name ?? '',
                    $p->manufacturer->company_name ?? '',
                    $p->category->name ?? '',
                    $p->strength,
                    $p->pack_size,
                    $p->purchase_price,
                    $p->sale_price,
                    $p->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Product::with(['category', 'generic', 'manufacturer']);
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $medicines = $query->limit(500)->get();

        return view('admin.medicines.pdf', compact('medicines'));
    }
}
