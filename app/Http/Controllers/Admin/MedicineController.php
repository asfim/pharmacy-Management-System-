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

use Illuminate\Support\Str;

class MedicineController extends Controller
{
    private function getFormData(): array
    {
        return [
            'categories'    => Category::all(),
            'generics'      => Generic::all(),
            'manufacturers' => Manufacturer::all(),
            'units'         => Unit::all(),
            'branches'      => \App\Models\Branch::where('status', 'active')->orderBy('name')->get(),
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

        $selectedBranchId = session('selected_branch_id');
        $userBranchId     = auth()->user()->branch_id ?? null;
        $activeBranchId   = (!empty($userBranchId) && !auth()->user()->hasRole('Super Admin'))
            ? $userBranchId
            : (($selectedBranchId && $selectedBranchId !== 'all') ? $selectedBranchId : null);

        $stockSub = \App\Models\StockBalance::withoutGlobalScopes()
            ->selectRaw('COALESCE(SUM(qty_on_hand), 0)')
            ->whereColumn('product_id', 'products.id');

        if ($activeBranchId) {
            $stockSub->where('branch_id', $activeBranchId);
        }

        $query = Product::select('products.*')
            ->selectSub($stockSub, 'branch_stock')
            ->with(['category', 'brand', 'generic', 'manufacturer', 'product_images']);

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
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['prescription_required'] = $request->boolean('prescription_required');

            if (empty($data['sku'])) {
                $data['sku'] = 'MED-' . strtoupper(Str::random(6));
            }

            if (empty($data['barcode'])) {
                $data['barcode'] = '880' . sprintf('%010d', rand(100000, 999999));
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('medicines', 'public');
            }

            $product = Product::create($data);

            if (!empty($data['image'])) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => $data['image'],
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);
            }

            $initialStock = (int) ($request->initial_stock ?? 0);
            $batchNo      = $request->filled('batch_no') ? $request->batch_no : ('B' . sprintf('%05d', rand(100, 99999)));
            $expiryDate   = $request->filled('expiry_date') ? $request->expiry_date : now()->addMonths(24)->format('Y-m-d');

            if ($initialStock >= 0) {
                $batch = Batch::create([
                    'product_id'     => $product->id,
                    'batch_no'       => $batchNo,
                    'expiry_date'    => $expiryDate,
                    'purchase_price' => $product->purchase_price,
                    'sale_price'     => $product->sale_price,
                    'mrp'            => $product->mrp ?: $product->sale_price,
                    'quantity'       => $initialStock,
                    'status'         => 'active',
                ]);

                $branchId = $request->branch_id ?: session('selected_branch_id', auth()->user()->branch_id ?? 1);
                \App\Models\StockBalance::withoutGlobalScopes()->updateOrCreate([
                    'branch_id'  => $branchId,
                    'product_id' => $product->id,
                    'batch_id'   => $batch->id,
                ], [
                    'qty_on_hand' => $initialStock
                ]);
            }

            DB::commit();

            return redirect()->route('admin.medicines.index')->with('success', 'Medicine "' . $product->name . '" has been added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating medicine: ' . $e->getMessage());
        }
    }

    public function show(Product $medicine)
    {
        $medicine->load([
            'category', 
            'brand', 
            'generic', 
            'manufacturer', 
            'unit',
            'batches' => function($q) {
                $q->orderBy('expiry_date', 'asc');
            },
            'stock_balances' => function($q) {
                $q->withoutGlobalScopes();
            },
            'stock_balances.branch'
        ]);

        $selectedBranchId = session('selected_branch_id');
        $userBranchId     = auth()->user()->branch_id ?? null;
        $activeBranchId   = (!empty($userBranchId) && !auth()->user()->hasRole('Super Admin'))
            ? $userBranchId
            : (($selectedBranchId && $selectedBranchId !== 'all') ? $selectedBranchId : null);

        $activeBranch = $activeBranchId ? \App\Models\Branch::find($activeBranchId) : null;

        return view('admin.medicines.show', compact('medicine', 'activeBranch'));
    }

    public function edit(Product $medicine)
    {
        $medicine->load(['product_images', 'batches']);
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

        // 1. Handle Multi-Branch Stock Editing (Super Admin / All Branches mode)
        if ($request->has('batch_branch_stocks')) {
            foreach ($request->batch_branch_stocks as $batchId => $branchMap) {
                $b = Batch::where('id', $batchId)->where('product_id', $medicine->id)->first();
                if (!$b) continue;

                if (!empty($request->batches[$batchId]['expiry_date'])) {
                    $b->expiry_date = $request->batches[$batchId]['expiry_date'];
                }

                $totalQty = 0;
                foreach ($branchMap as $branchId => $qtyVal) {
                    $newQty = max(0, (int)$qtyVal);
                    $totalQty += $newQty;

                    $existingBalances = \App\Models\StockBalance::withoutGlobalScopes()
                        ->where('branch_id', $branchId)
                        ->where('product_id', $medicine->id)
                        ->where('batch_id', $b->id)
                        ->get();

                    if ($existingBalances->count() > 1) {
                        $first = $existingBalances->first();
                        $first->update(['qty_on_hand' => $newQty]);
                        $extraIds = $existingBalances->pluck('id')->slice(1);
                        \App\Models\StockBalance::withoutGlobalScopes()->whereIn('id', $extraIds)->delete();
                    } else {
                        \App\Models\StockBalance::withoutGlobalScopes()->updateOrCreate([
                            'branch_id'  => $branchId,
                            'product_id' => $medicine->id,
                            'batch_id'   => $b->id,
                        ], [
                            'qty_on_hand' => $newQty
                        ]);
                    }
                }

                $b->quantity = $totalQty;
                $b->save();
            }
        } 
        // 2. Handle Single-Branch Stock Editing
        elseif ($request->has('batches')) {
            $currentBranchId = session('selected_branch_id', auth()->user()->branch_id ?? 1);
            if ($currentBranchId === 'all') {
                $currentBranchId = 1;
            }

            foreach ($request->batches as $batchId => $batchData) {
                $b = Batch::where('id', $batchId)->where('product_id', $medicine->id)->first();
                if (!$b) continue;

                if (!empty($batchData['expiry_date'])) {
                    $b->expiry_date = $batchData['expiry_date'];
                }

                if (isset($batchData['branch_qty']) && $batchData['branch_qty'] !== '') {
                    $newQty = max(0, (int)$batchData['branch_qty']);
                    
                    \App\Models\StockBalance::withoutGlobalScopes()->updateOrCreate([
                        'branch_id'  => $currentBranchId,
                        'product_id' => $medicine->id,
                        'batch_id'   => $b->id,
                    ], [
                        'qty_on_hand' => $newQty
                    ]);
                }

                $b->quantity = \App\Models\StockBalance::withoutGlobalScopes()->where('batch_id', $b->id)->sum('qty_on_hand');
                $b->save();
            }
        }

        // 3. Handle Add New Batch
        if ($request->filled('new_branch_qty') || $request->filled('new_batch_no') || $request->filled('new_expiry_date')) {
            $newQty = max(0, (int)($request->new_branch_qty ?? 0));
            $batchNo = $request->filled('new_batch_no') ? $request->new_batch_no : ('B' . sprintf('%05d', rand(100, 99999)));
            $expiryDate = $request->filled('new_expiry_date') ? $request->new_expiry_date : now()->addMonths(24)->format('Y-m-d');
            $targetBranchId = $request->new_branch_id ?: session('selected_branch_id', auth()->user()->branch_id ?? 1);
            if ($targetBranchId === 'all') {
                $targetBranchId = 1;
            }

            $newBatch = Batch::create([
                'product_id'     => $medicine->id,
                'batch_no'       => $batchNo,
                'expiry_date'    => $expiryDate,
                'purchase_price' => $medicine->purchase_price,
                'sale_price'     => $medicine->sale_price,
                'mrp'            => $medicine->mrp ?: $medicine->sale_price,
                'quantity'       => $newQty,
                'status'         => 'active',
            ]);

            \App\Models\StockBalance::withoutGlobalScopes()->updateOrCreate(
                [
                    'branch_id'  => $targetBranchId,
                    'product_id' => $medicine->id,
                    'batch_id'   => $newBatch->id,
                ],
                [
                    'qty_on_hand' => $newQty
                ]
            );
        }

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine and branch stock details updated successfully.');
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
        
        $isNetmedsFormat = false;
        if (is_array($header) && count($header) >= 12 && stripos($header[0], 'disease_name') !== false) {
            $isNetmedsFormat = true;
        }

        $categories = Category::pluck('id', 'name')->toArray();
        $generics = Generic::pluck('id', 'name')->toArray();
        $manufacturers = Manufacturer::pluck('id', 'company_name')->toArray();
        $units = Unit::pluck('id', 'name')->toArray();

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

                // Truncate category if it's too long (like ADHD (7))
                if (strlen($categoryName) > 50) $categoryName = substr($categoryName, 0, 50);

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

                if (!empty($csvImage)) {
                    $assignedImage = $csvImage;
                } else {
                    $assignedImage = $totalLocalImages > 0 ? $localImages[$count % $totalLocalImages] : null;
                }

                $product = Product::create([
                    'sku'                  => $sku . '-' . $count,
                    'barcode'              => '880' . sprintf('%010d', time() + $count),
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

                $initQty = rand(100, 500);
                $batch = Batch::create([
                    'product_id'     => $product->id,
                    'batch_no'       => 'B' . sprintf('%05d', rand(100, 99999)),
                    'expiry_date'    => now()->addMonths(rand(12, 36))->format('Y-m-d'),
                    'purchase_price' => $purchasePrice,
                    'sale_price'     => $price,
                    'mrp'            => $price,
                    'quantity'       => $initQty,
                    'status'         => 'active',
                ]);

                $branchId = session('selected_branch_id', auth()->user()->branch_id ?? 1);
                \App\Models\StockBalance::withoutGlobalScopes()->updateOrCreate([
                    'branch_id'  => $branchId,
                    'product_id' => $product->id,
                    'batch_id'   => $batch->id,
                ], [
                    'qty_on_hand' => $initQty
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

        $query = Product::with(['category', 'generic', 'manufacturer', 'product_images']);
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

            fputcsv($file, ['SL', 'SKU', 'Name', 'Generic', 'Manufacturer', 'Category', 'Strength', 'Pack Size', 'Purchase Price', 'Sale Price', 'Status', 'Image URL']);

            foreach ($products as $index => $p) {
                $imgUrl = $p->product_images->first()->image_url ?? $p->image ?? '';
                if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                    $imgUrl = asset('storage/' . $imgUrl);
                }

                fputcsv($file, [
                    $index + 1,
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
                    $imgUrl,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Product::with(['category', 'generic', 'manufacturer', 'product_images']);
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $medicines = $query->limit(1000)->get();

        return view('admin.medicines.pdf', compact('medicines'));
    }

    public function sampleCsv()
    {
        $fileName = 'sample_medicine_import_format.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'medicine_name',
                'category_name',
                'slug',
                'generic_name',
                'strength',
                'manufacturer_name',
                'unit',
                'unit_size',
                'price',
                'image'
            ]);

            $sampleRows = [
                ['Napa', 'Tablet', 'napa', 'Paracetamol', '500 mg', 'Beximco Pharmaceuticals Ltd.', 'Piece', '10 Tablets', '1.20', 'medicines/images01.jpg'],
                ['Seclo 20', 'Capsule', 'seclo-20', 'Omeprazole', '20 mg', 'Square Pharmaceuticals Ltd.', 'Piece', '14 Capsules', '6.00', 'medicines/images02.jpg'],
                ['Ceevit', 'Chewable Tablet', 'ceevit', 'Vitamin C [Ascorbic acid]', '250 mg', 'Square Pharmaceuticals Ltd.', 'Piece', '100 Tablets', '1.90', 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=300&q=80'],
                ['Entacyd Plus', 'Syrup', 'entacyd-plus', 'Aluminium Hydroxide + Simethicone', '200 ml', 'Square Pharmaceuticals Ltd.', 'Bottle', '1 Bottle', '80.00', 'medicines/images04.jpg'],
                ['Alben DS', 'Chewable Tablet', 'alben-ds', 'Albendazole', '400 mg', 'Eskayef Bangladesh Ltd.', 'Piece', '1 Tablet', '5.00', 'medicines/images05.jpg'],
            ];

            foreach ($sampleRows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $ids = $request->input('ids');
        $count = count($ids);

        DB::beginTransaction();
        try {
            ProductImage::whereIn('product_id', $ids)->delete();
            Batch::whereIn('product_id', $ids)->delete();
            Product::whereIn('id', $ids)->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'count'   => $count,
                    'message' => "Successfully deleted {$count} selected medicines."
                ]);
            }

            return back()->with('success', "Successfully deleted {$count} selected medicines.");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Bulk delete failed: " . $e->getMessage()
                ], 500);
            }
            return back()->with('error', "Bulk delete failed: " . $e->getMessage());
        }
    }
}
