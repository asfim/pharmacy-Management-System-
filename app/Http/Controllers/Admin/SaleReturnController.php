<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesReturn;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReturnController extends Controller
{
    public function index()
    {
        $returns = SalesReturn::with(['sale', 'customer'])->latest()->paginate(20);
        return view('admin.sale_returns.index', compact('returns'));
    }

    public function create()
    {
        $sales = Sale::with('customer')->latest()->limit(50)->get();
        return view('admin.sale_returns.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id'       => 'required|exists:sales,id',
            'refund_amount' => 'required|numeric|min:0',
            'reason'        => 'nullable|string',
        ]);

        $sale = Sale::findOrFail($request->sale_id);

        SalesReturn::create([
            'sale_id'       => $sale->id,
            'customer_id'   => $sale->customer_id,
            'branch_id'     => $sale->branch_id ?? 1,
            'return_date'   => now(),
            'refund_amount' => $request->refund_amount,
            'reason'        => $request->reason,
            'status'        => 'completed',
        ]);

        return redirect()->route('admin.sale-returns.index')->with('success', 'Sale return created successfully.');
    }

    public function show(SalesReturn $saleReturn)
    {
        $saleReturn->load(['sale', 'customer', 'sales_return_items.product']);
        return view('admin.sale_returns.show', compact('saleReturn'));
    }

    public function destroy(SalesReturn $saleReturn)
    {
        $saleReturn->delete();
        return redirect()->route('admin.sale-returns.index')->with('success', 'Sale return deleted successfully.');
    }
}
