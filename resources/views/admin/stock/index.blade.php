@extends('admin.layouts.app')
@php $header = 'Current Stock'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Stock Overview</h2><p class="text-sm text-slate-500">Current inventory levels for all medicines</p></div>
    <div class="flex gap-2">
        <a href="{{ route('admin.stock.low') }}" class="inline-flex items-center gap-2 bg-orange-100 hover:bg-orange-200 text-orange-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-exclamation-triangle"></i> Low Stock
        </a>
        <a href="{{ route('admin.stock.expiry') }}" class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition">
            <i class="fas fa-clock"></i> Expiry Alert
        </a>
    </div>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-left">Category</th>
                    <th class="px-5 py-4 text-right">Current Stock</th>
                    <th class="px-5 py-4 text-right">Min Stock</th>
                    <th class="px-5 py-4 text-right">Sale Price</th>
                    <th class="px-5 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($stocks as $product)
                @php $qty = $product->batches_sum_quantity ?? 0; @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-slate-800">{{ $product->name }}</p>
                        <p class="text-xs text-slate-400">{{ $product->strength }} {{ $product->dosage_form }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-right">
                        <span class="font-bold text-lg {{ $qty == 0 ? 'text-red-600' : ($qty <= $product->min_stock ? 'text-orange-600' : 'text-green-600') }}">
                            {{ number_format($qty) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right text-slate-500">{{ $product->min_stock }}</td>
                    <td class="px-5 py-3.5 text-right font-semibold text-slate-700">৳{{ number_format($product->sale_price, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($qty == 0)
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Out of Stock</span>
                        @elseif($qty <= $product->min_stock)
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">Low Stock</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">In Stock</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($stocks->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $stocks->links() }}</div>
    @endif
</div>
@endsection
