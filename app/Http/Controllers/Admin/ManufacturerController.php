<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreManufacturerRequest;
use App\Http\Requests\Admin\UpdateManufacturerRequest;
use App\Models\Manufacturer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->get('search', '');
        $perPageRaw = $request->get('per_page', 50);
        $perPage    = $perPageRaw === 'all' ? PHP_INT_MAX : (int) $perPageRaw;

        $query = Manufacturer::query()
            ->when($search, fn($q) => $q->where('company_name', 'like', "%{$search}%")
                ->orWhere('contact_person', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->latest();

        $manufacturers = $query->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            $html = view('admin.manufacturers.partials.table_rows', compact('manufacturers'))->render();
            return response()->json([
                'html'           => $html,
                'count'          => $manufacturers->count(),
                'total'          => $manufacturers->total(),
                'has_more_pages' => $manufacturers->hasMorePages(),
                'next_page'      => $manufacturers->currentPage() + 1,
            ]);
        }

        return view('admin.manufacturers.index', compact('manufacturers', 'perPageRaw'));
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(StoreManufacturerRequest $request)
    {
        $data = $request->validated();
        if (isset($data['registration_no'])) { $data['license_info'] = $data['registration_no']; unset($data['registration_no']); }
        if (isset($data['name']))             { $data['company_name'] = $data['name'];            unset($data['name']); }
        Manufacturer::create($data);
        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer created successfully.');
    }

    public function show(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.show', compact('manufacturer'));
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }

    public function update(UpdateManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $data = $request->validated();
        if (isset($data['registration_no'])) { $data['license_info'] = $data['registration_no']; unset($data['registration_no']); }
        if (isset($data['name']))             { $data['company_name'] = $data['name'];            unset($data['name']); }
        $manufacturer->update($data);
        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer updated successfully.');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect()->route('admin.manufacturers.index')->with('success', 'Manufacturer deleted successfully.');
    }

    // ── Bulk Delete ─────────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) return response()->json(['success' => false, 'message' => 'No items selected.']);
        Manufacturer::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => count($ids) . ' manufacturer(s) deleted.']);
    }

    // ── Export CSV ──────────────────────────────────────────
    public function exportCsv(Request $request)
    {
        $search = $request->get('search', '');
        $manufacturers = Manufacturer::query()
            ->when($search, fn($q) => $q->where('company_name', 'like', "%{$search}%"))
            ->latest()->get();

        $filename = 'manufacturers_' . now()->format('Ymd_His') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];

        $callback = function () use ($manufacturers) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['ID', 'Company Name', 'Contact Person', 'Phone', 'Email', 'Website', 'Address', 'License Info', 'Status']);
            foreach ($manufacturers as $m) {
                fputcsv($out, [$m->id, $m->company_name, $m->contact_person, $m->phone, $m->email, $m->website, $m->address, $m->license_info, $m->status]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Export PDF ──────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $search = $request->get('search', '');
        $manufacturers = Manufacturer::query()
            ->when($search, fn($q) => $q->where('company_name', 'like', "%{$search}%"))
            ->latest()->get();

        $pdf = Pdf::loadView('admin.manufacturers.pdf', compact('manufacturers'))->setPaper('a4', 'landscape');
        return $pdf->stream('manufacturers.pdf');
    }

    // ── Sample CSV ──────────────────────────────────────────
    public function sampleCsv()
    {
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="manufacturers_sample.csv"'];
        $callback = function () {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['company_name', 'contact_person', 'phone', 'email', 'website', 'address', 'license_info', 'status']);
            fputcsv($out, ['Square Pharma', 'Mr. Rahim', '01700000001', 'info@square.com', 'www.squarepharma.com.bd', 'Dhaka', 'LIC-001', 'active']);
            fputcsv($out, ['Beximco Pharma', 'Mr. Karim', '01700000002', 'info@beximco.com', 'www.beximcopharma.com', 'Dhaka', 'LIC-002', 'active']);
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }

    // ── Import CSV ──────────────────────────────────────────
    public function importCsv(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:10240']);

        $handle   = fopen($request->file('csv_file')->getPathname(), 'r');
        $header   = null;
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if ($header === null) {
                $row[0] = ltrim($row[0], "\xEF\xBB\xBF");
                $header = array_map('trim', $row);
                continue;
            }
            $data = array_combine($header, array_map('trim', $row));
            if (empty($data['company_name'])) continue;

            Manufacturer::updateOrCreate(
                ['company_name' => $data['company_name']],
                [
                    'contact_person' => $data['contact_person'] ?? null,
                    'phone'          => $data['phone']          ?? null,
                    'email'          => $data['email']          ?? null,
                    'website'        => $data['website']        ?? null,
                    'address'        => $data['address']        ?? null,
                    'license_info'   => $data['license_info']   ?? null,
                    'status'         => in_array($data['status'] ?? '', ['active','inactive']) ? $data['status'] : 'active',
                ]
            );
            $imported++;
        }
        fclose($handle);

        return redirect()->route('admin.manufacturers.index')
            ->with('success', "{$imported} manufacturer(s) imported successfully.");
    }
}
