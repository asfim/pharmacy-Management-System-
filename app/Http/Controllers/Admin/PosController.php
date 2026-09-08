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

class PosController extends Controller
{
    public function index()
    {
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        return view('admin.pos.index', compact('customers'));
    }

    public function searchMedicine(Request $request)
    {
        $q = $request->q;
        $medicines = Product::where('status', 'active')
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('barcode', $q)
                      ->orWhere('sku', 'like', "%$q%");
            })
            ->with('activeBatches')
            ->limit(10)
            ->get()
            ->map(function($p) {
                return [
                    'id'         => $p->id,
                    'name'       => $p->name,
                    'sale_price' => $p->sale_price,
                    'barcode'    => $p->barcode,
                    'batches'    => $p->activeBatches->map(fn($b) => [
                        'id'          => $b->id,
                        'batch_no'    => $b->batch_no,
                        'expiry_date' => $b->expiry_date,
                        'quantity'    => $b->quantity,
                        'sale_price'  => $b->sale_price,
                    ])->values(),
                ];
            });
        return response()->json($medicines);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'          => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.batch_id'   => 'required|exists:batches,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'paid'           => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }
            $discount = $request->discount ?? 0;
            $tax      = $request->tax ?? 0;
            $total    = $subtotal - $discount + $tax;
            $paid     = $request->paid ?? 0;

            $sale = Sale::create([
                'invoice_no'     => 'INV-' . date('Ymd') . '-' . str_pad(Sale::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
                'branch_id'      => auth()->user()->branch_id ?? 1,
                'customer_id'    => $request->customer_id ?: null,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'tax'            => $tax,
                'total'          => $total,
                'paid'           => $paid,
                'due'            => $total - $paid,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
                'status'         => 'completed',
                'sale_date'      => now(),
            ]);

            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id'    => $sale->id,
                    'product_id' => $item['product_id'],
                    'batch_id'   => $item['batch_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'discount'   => $item['discount'] ?? 0,
                    'total'      => $item['quantity'] * $item['price'],
                ]);

                // Decrease batch stock
                $batch = Batch::find($item['batch_id']);
                if ($batch) {
                    $batch->decrement('quantity', $item['quantity']);
                }
            }

            // Update customer balance if due
            if ($request->customer_id && ($total - $paid) > 0) {
                $customer = Customer::find($request->customer_id);
                if ($customer) {
                    $customer->increment('opening_balance', $total - $paid);
                }
            }

            // Record the payment in customer_payments
            if ($request->customer_id && $paid > 0) {
                \App\Models\CustomerPayment::create([
                    'customer_id' => $request->customer_id,
                    'sale_id'     => $sale->id,
                    'account_id'  => 1, // Default cash account
                    'amount'      => $paid,
                    'method'      => $request->payment_method,
                    'date'        => now(),
                ]);
            }

            // Record the payment in sale_payments for the sales history view
            if ($paid > 0) {
                \App\Models\SalePayment::create([
                    'sale_id'     => $sale->id,
                    'account_id'  => 1,
                    'method'      => $request->payment_method,
                    'amount'      => $paid,
                    'paid_at'     => now(),
                ]);
            }

            session(['last_sale_id' => $sale->id]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Sale completed successfully!',
            'sale_id' => session('last_sale_id'),
            'invoice_url' => route('admin.sales.invoice', session('last_sale_id')),
        ]);
    }
}
