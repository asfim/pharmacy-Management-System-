<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Batch;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(20);
        return view('admin.sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product', 'items.batch');
        return view('admin.sales.show', compact('sale'));
    }

    public function invoice(Sale $sale)
    {
        $sale->load('customer', 'items.product', 'items.batch');
        return view('admin.sales.invoice', compact('sale'));
    }

    public function print(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('admin.sales.print', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Restore stock
            foreach ($sale->items as $item) {
                $batch = Batch::find($item->batch_id);
                if ($batch) {
                    $batch->increment('quantity', $item->quantity);
                }
            }
            $sale->items()->delete();
            $sale->delete();
        });
        return redirect()->route('admin.sales.index')->with('success', 'Sale deleted and stock restored.');
    }

    public function create()
    {
        // Redirect to POS
        return redirect()->route('admin.pos.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.pos.index');
    }

    public function edit(Sale $sale)
    {
        return view('admin.sales.show', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        return redirect()->route('admin.sales.show', $sale);
    }
}
