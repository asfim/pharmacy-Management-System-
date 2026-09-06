<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = OnlineOrder::with('customer')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(OnlineOrder $order)
    {
        $order->load('customer', 'items.product', 'shippingAddress');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, OnlineOrder $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,processing,ready,shipped,delivered,cancelled,returned,refunded']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }

    public function invoice(OnlineOrder $order)
    {
        $order->load('customer', 'items.product');
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
