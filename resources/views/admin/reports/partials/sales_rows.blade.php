@forelse($sales as $s)
<tr class="hover:bg-slate-50 transition">
    <td class="px-5 py-3.5 font-mono text-slate-700">{{ $s->invoice_no }}</td>
    <td class="px-5 py-3.5">{{ $s->customer->name ?? 'Walk-in' }}</td>
    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $s->created_at->format('d M Y') }}</td>
    <td class="px-5 py-3.5 text-right">৳{{ number_format($s->subtotal, 2) }}</td>
    <td class="px-5 py-3.5 text-right text-red-500">৳{{ number_format($s->discount, 2) }}</td>
    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($s->total, 2) }}</td>
    <td class="px-5 py-3.5 text-right text-green-600">৳{{ number_format($s->paid, 2) }}</td>
    <td class="px-5 py-3.5 text-right {{ $s->due > 0 ? 'text-red-600 font-semibold' : 'text-slate-400' }}">৳{{ number_format($s->due, 2) }}</td>
</tr>
@empty
@if(!request()->ajax())
<tr><td colspan="8" class="px-5 py-10 text-center text-slate-400">No sales found for selected period.</td></tr>
@endif
@endforelse
