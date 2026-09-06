@extends('admin.layouts.app')
@php $header = 'Low Stock Alert'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Low Stock Medicines</h2><p class="text-sm text-slate-500">Medicines below minimum stock level — reorder required</p></div>
    <a href="{{ route('admin.purchases.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
        <i class="fas fa-cart-flatbed"></i> Create Purchase Order
    </a>
</div>

@if(!$products->count())
<div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
    <i class="fas fa-check-circle text-green-600 text-4xl mb-3 block"></i>
    <h3 class="font-semibold text-green-800">All Stock Levels are Sufficient!</h3>
    <p class="text-green-600 text-sm mt-1">No medicines are below minimum stock levels.</p>
</div>
@else
<div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 mb-5 flex items-center gap-3">
    <i class="fas fa-triangle-exclamation text-orange-600 text-xl"></i>
    <p class="text-orange-800 font-medium text-sm">{{ $products->total() }} medicine(s) need immediate restocking.</p>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-right">Current Stock</th>
                    <th class="px-5 py-4 text-right">Min Stock</th>
                    <th class="px-5 py-4 text-right">Reorder Qty</th>
                    <th class="px-5 py-4 text-center">Urgency</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($products as $p)
                @php $qty = $p->batches_sum_quantity ?? 0; @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-slate-800">{{ $p->name }}</p>
                        <p class="text-xs text-slate-400">{{ $p->generic->name ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-right font-bold {{ $qty == 0 ? 'text-red-600' : 'text-orange-600' }} text-lg">{{ $qty }}</td>
                    <td class="px-5 py-3.5 text-right text-slate-600">{{ $p->min_stock }}</td>
                    <td class="px-5 py-3.5 text-right font-semibold text-blue-600">{{ max(0, $p->min_stock * 2 - $qty) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($qty == 0)
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">🔴 Critical</span>
                        @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">🟠 Low</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $products->links() }}</div>
    @endif
</div>
@endif
@endsection
