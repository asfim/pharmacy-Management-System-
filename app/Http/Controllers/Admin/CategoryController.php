<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPageRaw = $request->get('per_page', 50);
        $perPage = ($perPageRaw === 'all' || (int)$perPageRaw >= 10000) ? 10000 : (int)$perPageRaw;
        if (!in_array($perPage, [50, 100, 200, 500, 10000])) {
            $perPage = 50;
        }

        $query = Category::with('category');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate($perPage);

        if ($request->ajax()) {
            $html = view('admin.categories.partials.table_rows', compact('categories'))->render();
            return response()->json([
                'html'           => $html,
                'has_more_pages' => $categories->hasMorePages(),
                'current_page'   => $categories->currentPage(),
                'next_page'      => $categories->currentPage() + 1,
                'total'          => $categories->total(),
                'count'          => $categories->count(),
            ]);
        }

        return view('admin.categories.index', compact('categories', 'perPageRaw'));
    }

    public function create()
    {
        $parentCategories = Category::orderBy('name')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_category_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:categories,id',
        ]);

        $ids   = $request->input('ids');
        $count = count($ids);

        DB::beginTransaction();
        try {
            Category::whereIn('id', $ids)->delete();
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'count'   => $count,
                    'message' => "Successfully deleted {$count} selected categories.",
                ]);
            }
            return back()->with('success', "Successfully deleted {$count} selected categories.");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Bulk delete failed: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Bulk delete failed: ' . $e->getMessage());
        }
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file   = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        if (!$handle) {
            return back()->with('error', 'Unable to open uploaded CSV file.');
        }

        $header = fgetcsv($handle);
        $count  = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row[0])) continue;

                $name        = trim($row[0]);
                $description = trim($row[1] ?? '');
                $status      = in_array(trim($row[2] ?? 'active'), ['active', 'inactive']) ? trim($row[2]) : 'active';

                Category::firstOrCreate(['name' => $name], [
                    'description' => $description,
                    'status'      => $status,
                ]);
                $count++;
            }
            DB::commit();
            fclose($handle);
            return back()->with('success', "Bulk Import Successful! Added/found {$count} categories.");
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function sampleCsv()
    {
        $fileName = 'sample_category_import.csv';
        $headers  = [
            'Content-type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['name', 'description', 'status']);
            fputcsv($file, ['Tablet', 'Solid oral dosage forms', 'active']);
            fputcsv($file, ['Syrup', 'Liquid oral formulations', 'active']);
            fputcsv($file, ['Injection', 'Injectable medicines', 'active']);
            fputcsv($file, ['Cream', 'Topical cream formulations', 'active']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'categories_' . date('Y_m_d_His') . '.csv';
        $query    = Category::with('category');
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $categories = $query->get();

        $headers = [
            'Content-type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($categories) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['SL', 'Name', 'Parent Category', 'Description', 'Status']);
            foreach ($categories as $i => $cat) {
                fputcsv($file, [
                    $i + 1,
                    $cat->name,
                    $cat->category->name ?? '-',
                    $cat->description ?? '',
                    $cat->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Category::with('category');
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        $categories = $query->get();
        return view('admin.categories.pdf', compact('categories'));
    }
}
