@extends('admin.layouts.app')
@php $header = 'Purchase Invoice'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Print Invoice #{{ $purchase->invoice_no }}</h2>
    <div class="flex gap-2">
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-print"></i> Print Now</button>
        <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="bg-white p-8 max-w-4xl mx-auto shadow-sm border border-slate-200">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold text-teal-600 mb-1">Pharmacy MS</h1>
            <p class="text-slate-500">123 Pharmacy Avenue, Dhaka, Bangladesh</p>
            <p class="text-slate-500">Phone: +880123456789</p>
        </div>
        <div class="text-right">
            <h2 class="text-2xl font-bold text-slate-800 mb-1">PURCHASE INVOICE</h2>
            <p class="text-slate-600 font-medium">Invoice: {{ $purchase->invoice_no }}</p>
            <p class="text-slate-600">Date: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M, Y') }}</p>
        </div>
    </div>
    
    <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100 inline-block min-w-[300px]">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Supplier Details</h3>
        <p class="text-slate-800 font-bold text-lg">{{ $purchase->supplier->company_name ?? 'N/A' }}</p>
        <p class="text-slate-600">{{ $purchase->supplier->phone ?? '' }}</p>
    </div>

    <table class="w-full text-sm text-left mb-8 border-collapse">
        <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 border border-slate-200">Product</th>
                <th class="px-4 py-3 border border-slate-200">Batch</th>
                <th class="px-4 py-3 border border-slate-200 text-right">Qty</th>
                <th class="px-4 py-3 border border-slate-200 text-right">Price</th>
                <th class="px-4 py-3 border border-slate-200 text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->items as $item)
            <tr>
                <td class="px-4 py-3 border border-slate-200 font-medium text-slate-800">{{ $item->product->name ?? 'Unknown' }}</td>
                <td class="px-4 py-3 border border-slate-200 font-mono text-slate-600">{{ $item->batch_id }}</td>
                <td class="px-4 py-3 border border-slate-200 text-right">{{ $item->quantity }}</td>
                <td class="px-4 py-3 border border-slate-200 text-right">৳{{ number_format($item->purchase_price, 2) }}</td>
                <td class="px-4 py-3 border border-slate-200 text-right font-bold text-slate-800">৳{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="flex justify-end">
        <div class="w-64">
            <div class="flex justify-between py-2 text-slate-600 border-b border-slate-100">
                <span>Subtotal:</span>
                <span class="font-medium text-slate-800">৳{{ number_format($purchase->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between py-2 text-slate-600 border-b border-slate-100">
                <span>Discount:</span>
                <span class="font-medium text-slate-800">৳{{ number_format($purchase->discount, 2) }}</span>
            </div>
            <div class="flex justify-between py-3 text-lg border-b border-slate-200">
                <span class="font-bold text-slate-800">Total:</span>
                <span class="font-bold text-teal-700">৳{{ number_format($purchase->total, 2) }}</span>
            </div>
            <div class="flex justify-between py-2 text-slate-600 border-b border-slate-100">
                <span>Paid:</span>
                <span class="font-medium text-green-600">৳{{ number_format($purchase->paid, 2) }}</span>
            </div>
            <div class="flex justify-between py-2 text-slate-600">
                <span>Due:</span>
                <span class="font-bold text-red-600">৳{{ number_format($purchase->due, 2) }}</span>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .max-w-4xl, .max-w-4xl * { visibility: visible; }
    .max-w-4xl { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; }
}
</style>
@endsection
