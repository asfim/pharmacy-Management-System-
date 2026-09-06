<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = PurchaseInvoice::with('supplier')->latest()->paginate(20);
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'active')->orderBy('company_name')->get();
        $medicines = Product::where('status', 'active')->orderBy('name')->get();
        return view('admin.purchases.create', compact('suppliers', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'    => 'required|exists:suppliers,id',
            'invoice_no'     => 'required|string|max:100',
            'purchase_date'  => 'required|date',
            'items'          => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.batch_no'     => 'required|string',
            'items.*.expiry_date'  => 'nullable|date',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
            'items.*.sale_price'   => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += ($item['quantity'] + ($item['free_quantity'] ?? 0)) * $item['purchase_price'];
            }
            $discount = $request->discount ?? 0;
            $tax      = $request->tax ?? 0;
            $total    = $subtotal - $discount + $tax;
            $paid     = $request->paid ?? 0;

            $purchase = PurchaseInvoice::create([
                'supplier_id'    => $request->supplier_id,
                'invoice_no'     => $request->invoice_no,
                'purchase_date'  => $request->purchase_date,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'tax'            => $tax,
                'total'          => $total,
                'paid'           => $paid,
                'due'            => $total - $paid,
                'payment_method' => $request->payment_method ?? 'cash',
                'note'           => $request->note,
                'status'         => 'received',
            ]);

            foreach ($request->items as $item) {
                $freeQty = $item['free_quantity'] ?? 0;
                $totalQty = $item['quantity'] + $freeQty;

                PurchaseItem::create([
                    'purchase_invoice_id' => $purchase->id,
                    'product_id'          => $item['product_id'],
                    'batch_no'            => $item['batch_no'],
                    'manufacturing_date'  => $item['manufacturing_date'] ?? null,
                    'expiry_date'         => $item['expiry_date'] ?? null,
                    'quantity'            => $item['quantity'],
                    'free_quantity'       => $freeQty,
                    'purchase_price'      => $item['purchase_price'],
                    'sale_price'          => $item['sale_price'],
                    'discount'            => $item['discount'] ?? 0,
                    'total'               => $item['quantity'] * $item['purchase_price'],
                ]);

                // Auto create/update batch stock
                $batch = Batch::firstOrNew([
                    'product_id' => $item['product_id'],
                    'batch_no'   => $item['batch_no'],
                ]);
                $batch->manufacturing_date = $item['manufacturing_date'] ?? null;
                $batch->expiry_date        = $item['expiry_date'] ?? null;
                $batch->purchase_price     = $item['purchase_price'];
                $batch->sale_price         = $item['sale_price'];
                $batch->quantity           = ($batch->quantity ?? 0) + $totalQty;
                $batch->supplier_id        = $request->supplier_id;
                $batch->save();
            }
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Purchase recorded successfully. Stock updated.');
    }

    public function show(PurchaseInvoice $purchase)
    {
        $purchase->load('supplier', 'items.product');
        return view('admin.purchases.show', compact('purchase'));
    }

    public function invoice(PurchaseInvoice $purchase)
    {
        $purchase->load('supplier', 'items.product');
        return view('admin.purchases.invoice', compact('purchase'));
    }

    public function edit(PurchaseInvoice $purchase)
    {
        $suppliers = Supplier::where('status', 'active')->get();
        $medicines = Product::where('status', 'active')->get();
        $purchase->load('items.product');
        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'medicines'));
    }

    public function update(Request $request, PurchaseInvoice $purchase)
    {
        $purchase->update($request->only(['note', 'status', 'paid']));
        $purchase->due = $purchase->total - $purchase->paid;
        $purchase->save();
        return redirect()->route('admin.purchases.index')->with('success', 'Purchase updated.');
    }

    public function destroy(PurchaseInvoice $purchase)
    {
        $purchase->delete();
        return redirect()->route('admin.purchases.index')->with('success', 'Purchase deleted.');
    }
}
