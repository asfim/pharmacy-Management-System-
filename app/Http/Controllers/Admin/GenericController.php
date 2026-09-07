<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGenericRequest;
use App\Http\Requests\Admin\UpdateGenericRequest;
use App\Models\Generic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GenericController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->get('search', '');
        $perPageRaw = $request->get('per_page', 50);
        $perPage    = $perPageRaw === 'all' ? PHP_INT_MAX : (int) $perPageRaw;

        $query = Generic::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"))
            ->latest();

        $generics = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            $html = view('admin.generics.partials.table_rows', compact('generics'))->render();
            return response()->json([
                'html'           => $html,
                'count'          => $generics->count(),
                'total'          => $generics->total(),
                'has_more_pages' => $generics->hasMorePages(),
                'next_page'      => $generics->currentPage() + 1,
            ]);
        }

        return view('admin.generics.index', compact('generics', 'perPageRaw'));
    }

    public function create()
    {
        return view('admin.generics.create');
    }

    public function store(StoreGenericRequest $request)
    {
        Generic::create($request->validated());
        return redirect()->route('admin.generics.index')->with('success', 'Generic created successfully.');
    }

    public function show(Generic $generic)
    {
        return view('admin.generics.show', compact('generic'));
    }

    public function edit(Generic $generic)
    {
        return view('admin.generics.edit', compact('generic'));
    }

    public function update(UpdateGenericRequest $request, Generic $generic)
    {
        $generic->update($request->validated());
        return redirect()->route('admin.generics.index')->with('success', 'Generic updated successfully.');
    }

    public function destroy(Generic $generic)
    {
        $generic->delete();
        return redirect()->route('admin.generics.index')->with('success', 'Generic deleted successfully.');
    }

    // ── Bulk Delete ────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No items selected.']);
        }
        Generic::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' generic(s) deleted.']);
    }

    // ── Export CSV ─────────────────────────────────────────
    public function exportCsv(Request $request)
    {
        $search   = $request->get('search', '');
        $generics = Generic::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()->get();

        $filename = 'generics_' . now()->format('Ymd_His') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];

        $callback = function () use ($generics) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($out, ['ID', 'Name', 'Description', 'Dosage', 'Status', 'Created At']);
            foreach ($generics as $g) {
                fputcsv($out, [$g->id, $g->name, $g->description, $g->dosage, $g->status, $g->created_at]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Export PDF ─────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $search   = $request->get('search', '');
        $generics = Generic::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()->get();

        $pdf = Pdf::loadView('admin.generics.pdf', compact('generics'))->setPaper('a4', 'portrait');
        return $pdf->stream('generics.pdf');
    }

    // ── Sample CSV ─────────────────────────────────────────
    public function sampleCsv()
    {
        $filename = 'generics_sample.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['name', 'description', 'dosage', 'status']);
            fputcsv($out, ['Amoxicillin', 'Broad-spectrum antibiotic', '500mg', 'active']);
            fputcsv($out, ['Paracetamol', 'Pain reliever and antipyretic', '500mg', 'active']);
            fputcsv($out, ['Metformin', 'Type 2 diabetes medication', '850mg', 'active']);
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Import CSV ─────────────────────────────────────────
    public function importCsv(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:10240']);

        $file    = $request->file('csv_file');
        $handle  = fopen($file->getPathname(), 'r');
        $header  = null;
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            // Skip BOM on first row
            if ($header === null) {
                $row[0] = ltrim($row[0], "\xEF\xBB\xBF");
                $header = array_map('trim', $row);
                continue;
            }
            $data = array_combine($header, array_map('trim', $row));
            if (empty($data['name'])) continue;

            Generic::updateOrCreate(
                ['name' => $data['name']],
                [
                    'description' => $data['description'] ?? null,
                    'dosage'      => $data['dosage']      ?? null,
                    'status'      => in_array($data['status'] ?? '', ['active', 'inactive']) ? $data['status'] : 'active',
                ]
            );
            $imported++;
        }
        fclose($handle);

        return redirect()->route('admin.generics.index')
            ->with('success', "{$imported} generic(s) imported successfully.");
    }
}
