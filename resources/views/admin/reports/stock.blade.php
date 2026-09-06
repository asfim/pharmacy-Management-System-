@extends('admin.layouts.app')
@php $header = 'Stock Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Stock Report</h2>
    <p class="text-sm text-slate-500">Current inventory valuation and stock levels</p>
</div>

<!-- Summary Card -->
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-6 max-w-sm">
    <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Stock Value (Buy Price)</p>
    <p class="text-3xl font-bold text-teal-600">৳{{ number_format($totalValue, 2) }}</p>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-left">Category</th>
                    <th class="px-5 py-4 text-right">Current Stock</th>
                    <th class="px-5 py-4 text-right">Buy Price (Avg)</th>
                    <th class="px-5 py-4 text-right">Sale Price</th>
                    <th class="px-5 py-4 text-right">Total Value</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $p)
                @php 
                    $qty = $p->batches_sum_quantity ?? 0;
                    $value = $p->batches->sum(fn($b) => $b->quantity * $b->purchase_price);
                    $avgBuy = $qty > 0 ? $value / $qty : 0;
                @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-slate-800">{{ $p->name }}</p>
                        <p class="text-xs text-slate-400">{{ $p->generic->name ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $p->category->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-right font-bold {{ $qty <= $p->min_stock ? 'text-red-600' : 'text-slate-800' }}">{{ number_format($qty) }}</td>
                    <td class="px-5 py-3.5 text-right text-slate-600">৳{{ number_format($avgBuy, 2) }}</td>
                    <td class="px-5 py-3.5 text-right text-slate-600">৳{{ number_format($p->sale_price, 2) }}</td>
                    <td class="px-5 py-3.5 text-right font-semibold text-teal-700">৳{{ number_format($value, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No stock data available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $products->links() }}</div>
    @endif
</div>
@endsection
