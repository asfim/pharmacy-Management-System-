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
        $sales = Sale::where('status', '!=', 'returned')
            ->with(['customer', 'items.product', 'items.batch'])
            ->latest()
            ->limit(50)
            ->get();

        $salesData = $sales->map(function ($s) {
            return [
                'id'         => $s->id,
                'invoice_no' => $s->invoice_no,
                'total'      => $s->total,
                'customer'   => $s->customer->name ?? 'Walk-in',
                'items'      => $s->items->map(function ($i) {
                    return [
                        'id'       => $i->id,
                        'name'     => $i->product->name ?? 'Medicine',
                        'sold_qty' => $i->quantity,
                        'price'    => (float) $i->price,
                    ];
                }),
            ];
        });

        return view('admin.sale_returns.create', compact('sales', 'salesData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id'        => 'required|exists:sales,id',
            'refund_amount'  => 'required|numeric|min:0',
            'reason'         => 'nullable|string',
            'return_items'   => 'nullable|array',
            'return_items.*' => 'nullable|integer|min:0',
        ]);

        $sale = Sale::with('items.product')->findOrFail($request->sale_id);

        DB::transaction(function () use ($request, $sale) {
            $salesReturn = SalesReturn::create([
                'sale_id'       => $sale->id,
                'customer_id'   => $sale->customer_id,
                'branch_id'     => $sale->branch_id ?? 1,
                'return_date'   => now(),
                'refund_amount' => $request->refund_amount,
                'reason'        => $request->reason,
                'status'        => 'completed',
            ]);

            // Mark the sale invoice status as returned
            $sale->update(['status' => 'returned']);

            foreach ($sale->items as $item) {
                // If specific return quantity is submitted, use it; otherwise return full item quantity
                $qtyToReturn = isset($request->return_items[$item->id]) 
                    ? max(0, (int)$request->return_items[$item->id])
                    : $item->quantity;

                if ($qtyToReturn > 0) {
                    // Record returned item
                    \App\Models\SalesReturnItem::create([
                        'return_id'     => $salesReturn->id,
                        'product_id'    => $item->product_id,
                        'batch_id'      => $item->batch_id,
                        'quantity'      => $qtyToReturn,
                        'refund_amount' => $item->price * $qtyToReturn,
                    ]);

                    // Increase Batch Quantity
                    if ($item->batch_id) {
                        \App\Models\Batch::where('id', $item->batch_id)->increment('quantity', $qtyToReturn);
                    }

                    // Increase Branch Stock Balance
                    $stockBalance = \App\Models\StockBalance::withoutGlobalScopes()->firstOrNew([
                        'branch_id'  => $sale->branch_id,
                        'product_id' => $item->product_id,
                        'batch_id'   => $item->batch_id,
                    ]);
                    $stockBalance->qty_on_hand = ($stockBalance->qty_on_hand ?? 0) + $qtyToReturn;
                    $stockBalance->save();
                }
            }
        });

        return redirect()->route('admin.sale-returns.index')->with('success', 'Sale return processed successfully. Branch stock has been restored.');
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
