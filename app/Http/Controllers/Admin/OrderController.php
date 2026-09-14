<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OnlineOrder::with(['customer', 'order_prescriptions.prescription'])->when(request('status'), function($q) {
            $q->where('status', request('status'));
        })->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(OnlineOrder $order)
    {
        $order->load('customer', 'order_items.product', 'customer_address');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, OnlineOrder $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,delivered,cancelled,returned,refunded']);
        
        $oldStatus = $order->status;
        $newStatus = $request->status;

        $activeStatuses = ['confirmed', 'delivered'];
        $wasActive = in_array($oldStatus, $activeStatuses);
        $isActive = in_array($newStatus, $activeStatuses);

        if (!$wasActive && $isActive) {
            // Deduce Stock
            foreach ($order->order_items as $item) {
                // Find branch with highest stock
                $stock = \App\Models\StockBalance::withoutGlobalScopes()->where('product_id', $item->product_id)->where('qty_on_hand', '>=', $item->quantity)->orderBy('qty_on_hand', 'desc')->first();
                if (!$stock) {
                    $stock = \App\Models\StockBalance::withoutGlobalScopes()->where('product_id', $item->product_id)->where('qty_on_hand', '>', 0)->orderBy('qty_on_hand', 'desc')->first();
                }
                if (!$stock) {
                    $stock = \App\Models\StockBalance::withoutGlobalScopes()->where('product_id', $item->product_id)->orderBy('id', 'asc')->first();
                }

                if ($stock) {
                    $stock->decrement('qty_on_hand', $item->quantity);
                    if ($stock->batch_id) {
                        \App\Models\Batch::where('id', $stock->batch_id)->decrement('quantity', $item->quantity);
                    }
                }
            }
        } elseif ($wasActive && !$isActive) {
            // Restore Stock
            foreach ($order->order_items as $item) {
                // Restore to the branch with highest stock to keep things centralized, or main stock
                $stock = \App\Models\StockBalance::withoutGlobalScopes()->where('product_id', $item->product_id)->orderBy('qty_on_hand', 'desc')->first();
                if (!$stock) {
                    $stock = \App\Models\StockBalance::withoutGlobalScopes()->where('product_id', $item->product_id)->orderBy('id', 'asc')->first();
                }

                if ($stock) {
                    $stock->increment('qty_on_hand', $item->quantity);
                    if ($stock->batch_id) {
                        \App\Models\Batch::where('id', $stock->batch_id)->increment('quantity', $item->quantity);
                    }
                }
            }
        }

        $order->update(['status' => $newStatus]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Order status updated to ' . ucfirst($request->status)]);
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }

    public function invoice(OnlineOrder $order)
    {
        $order->load('customer', 'order_items.product', 'customer_address');
        return view('admin.orders.invoice', compact('order'));
    }

    public function edit(OnlineOrder $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, OnlineOrder $order)
    {
        $order->update($request->only(['note', 'status']));
        return redirect()->route('admin.orders.show', $order)->with('success', 'Order updated.');
    }

    public function destroy(OnlineOrder $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

    public function create() { return redirect()->route('admin.orders.index'); }
    public function store(Request $request) { return redirect()->route('admin.orders.index'); }
}
