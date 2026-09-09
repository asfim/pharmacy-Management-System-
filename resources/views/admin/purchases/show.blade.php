@extends('admin.layouts.app')
@php $header = 'Purchase Details'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Purchase #{{ $purchase->invoice_no }}</h2>
    <div class="flex gap-2">
        <a href="{{ route('admin.purchases.invoice', $purchase->id) }}" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-print"></i> Print Invoice</a>
        <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="p-6 grid grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Supplier Info</h3>
            <p class="text-slate-800 font-medium text-lg">{{ $purchase->supplier->company_name ?? 'N/A' }}</p>
            <p class="text-slate-600 text-sm">{{ $purchase->supplier->phone ?? '' }}</p>
        </div>
        <div class="text-right">
            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Invoice Info</h3>
            <p class="text-slate-800 font-medium">Invoice: <span class="font-mono">{{ $purchase->invoice_no }}</span></p>
            <p class="text-slate-600 text-sm">Date: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M, Y') }}</p>
            <p class="text-slate-600 text-sm">Status: <span class="uppercase text-xs font-bold">{{ $purchase->status }}</span></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Product</th>
                    <th class="px-5 py-4">Batch</th>
                    <th class="px-5 py-4 text-right">Qty</th>
                    <th class="px-5 py-4 text-right">Price</th>
                    <th class="px-5 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($purchase->items as $item)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $item->product->name ?? 'Unknown' }}</td>
                    <td class="px-5 py-3.5 font-mono text-slate-600">{{ $item->batch_id }}</td>
                    <td class="px-5 py-3.5 text-right">{{ $item->quantity }}</td>
                    <td class="px-5 py-3.5 text-right">৳{{ number_format($item->purchase_price, 2) }}</td>
                    <td class="px-5 py-3.5 text-right font-bold">৳{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 border-t border-slate-200 text-right">
                <tr>
                    <td colspan="4" class="px-5 py-3 font-semibold text-slate-700">Subtotal:</td>
                    <td class="px-5 py-3 font-bold text-slate-800">৳{{ number_format($purchase->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-5 py-3 font-semibold text-slate-700">Discount:</td>
                    <td class="px-5 py-3 font-bold text-slate-800">৳{{ number_format($purchase->discount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-5 py-3 font-semibold text-slate-700">Total:</td>
                    <td class="px-5 py-3 font-bold text-teal-700 text-lg">৳{{ number_format($purchase->total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-5 py-3 font-semibold text-slate-700">Paid:</td>
                    <td class="px-5 py-3 font-bold text-green-600">৳{{ number_format($purchase->paid, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="px-5 py-3 font-semibold text-slate-700">Due:</td>
                    <td class="px-5 py-3 font-bold text-red-600">৳{{ number_format($purchase->due, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
