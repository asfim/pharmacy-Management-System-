@forelse($stocks as $product)
@php $qty = $product->batches_sum_quantity ?? 0; @endphp
<tr class="hover:bg-slate-50 transition stock-row">
    <td class="px-4 py-3 text-center text-slate-500 text-sm">
        {{ ($stocks->currentPage() - 1) * $stocks->perPage() + $loop->iteration }}
    </td>
    <td class="px-4 py-3">
        <p class="font-semibold text-slate-800 text-sm">{{ $product->name }}</p>
        <p class="text-xs text-slate-400">{{ $product->strength }} {{ $product->dosage_form }}</p>
    </td>
    <td class="px-4 py-3 text-slate-600 text-sm">{{ $product->category->name ?? '-' }}</td>
    <td class="px-4 py-3 text-right">
        <span class="font-bold text-base {{ $qty == 0 ? 'text-red-600' : ($qty <= $product->min_stock ? 'text-orange-600' : 'text-green-600') }}">
            {{ number_format($qty) }}
        </span>
    </td>
    <td class="px-4 py-3 text-right text-slate-500 text-sm">{{ $product->min_stock }}</td>
    <td class="px-4 py-3 text-right font-semibold text-slate-700 text-sm">৳{{ number_format($product->sale_price, 2) }}</td>
    <td class="px-4 py-3 text-center">
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
<tr>
    <td colspan="7" class="px-5 py-10 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        No stock records found.
    </td>
</tr>
@endforelse
