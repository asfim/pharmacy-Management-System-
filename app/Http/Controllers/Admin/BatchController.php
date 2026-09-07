<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBatchRequest;
use App\Http\Requests\Admin\UpdateBatchRequest;
use App\Models\Batch;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->get('search', '');
        $perPageRaw = $request->get('per_page', 50);
        $perPage    = $perPageRaw === 'all' ? PHP_INT_MAX : (int) $perPageRaw;

        $query = Batch::with('product')
            ->when($search, fn($q) => $q->where('batch_no', 'like', "%{$search}%")
                ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$search}%")))
            ->latest();

        $batches = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            $html = view('admin.batches.partials.table_rows', compact('batches'))->render();
            return response()->json([
                'html'           => $html,
                'count'          => $batches->count(),
                'total'          => $batches->total(),
                'has_more_pages' => $batches->hasMorePages(),
                'next_page'      => $batches->currentPage() + 1,
            ]);
        }

        return view('admin.batches.index', compact('batches', 'perPageRaw'));
    }

    public function create()
    {
        $medicines = Product::all();
        return view('admin.batches.create', compact('medicines'));
    }

    public function store(StoreBatchRequest $request)
    {
        Batch::create($request->validated());
        return redirect()->route('admin.batches.index')->with('success', 'Batch created successfully.');
    }

    public function show(Batch $batch)
    {
        $batch->load('product');
        return view('admin.batches.show', compact('batch'));
    }

    public function edit(Batch $batch)
    {
        $medicines = Product::all();
        return view('admin.batches.edit', compact('batch', 'medicines'));
    }

    public function update(UpdateBatchRequest $request, Batch $batch)
    {
        $batch->update($request->validated());
        return redirect()->route('admin.batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('admin.batches.index')->with('success', 'Batch deleted successfully.');
    }

    // ── Bulk Delete ─────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) return response()->json(['success' => false, 'message' => 'No items selected.']);
        Batch::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' batch(es) deleted.']);
    }

    // ── Export CSV ──────────────────────────────────────────
    public function exportCsv(Request $request)
    {
        $search  = $request->get('search', '');
        $batches = Batch::with('product')
            ->when($search, fn($q) => $q->where('batch_no', 'like', "%{$search}%")
                ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$search}%")))
            ->latest()->get();

        $filename = 'batches_' . now()->format('Ymd_His') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];

        $callback = function () use ($batches) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['ID', 'Medicine', 'Batch No', 'Mfg Date', 'Expiry Date', 'Qty', 'Purchase Price', 'Sale Price']);
            foreach ($batches as $b) {
                fputcsv($out, [
                    $b->id,
                    $b->product->name ?? '-',
                    $b->batch_no,
                    $b->manufacturing_date ? Carbon::parse($b->manufacturing_date)->format('Y-m-d') : '',
                    $b->expiry_date ? Carbon::parse($b->expiry_date)->format('Y-m-d') : '',
                    $b->quantity,
                    $b->purchase_price,
                    $b->sale_price,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Export PDF ──────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $search  = $request->get('search', '');
        $batches = Batch::with('product')
            ->when($search, fn($q) => $q->where('batch_no', 'like', "%{$search}%")
                ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$search}%")))
            ->latest()->get();

        $pdf = Pdf::loadView('admin.batches.pdf', compact('batches'))->setPaper('a4', 'landscape');
        return $pdf->stream('batches.pdf');
    }
}
