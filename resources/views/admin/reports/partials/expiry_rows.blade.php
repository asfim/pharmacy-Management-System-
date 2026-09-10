@forelse($batches as $b)
@php $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($b->expiry_date), false); @endphp
<tr class="hover:bg-slate-50 transition">
    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $b->product->name ?? '-' }}</td>
    <td class="px-5 py-3.5 font-mono text-slate-600">{{ $b->batch_no }}</td>
    <td class="px-5 py-3.5 font-semibold {{ $daysLeft < 0 ? 'text-red-600' : 'text-orange-600' }}">{{ \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') }}</td>
    <td class="px-5 py-3.5 text-right font-bold text-slate-700">{{ $b->quantity }}</td>
    <td class="px-5 py-3.5 text-right text-slate-600">৳{{ number_format($b->quantity * $b->purchase_price, 2) }}</td>
    <td class="px-5 py-3.5 text-center">
        @if($daysLeft < 0)
            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Expired</span>
        @elseif($daysLeft <= 30)
            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">{{ floor($daysLeft) }} Days</span>
        @else
            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">{{ floor($daysLeft) }} Days</span>
        @endif
    </td>
</tr>
@empty
@if(!request()->ajax())
<tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No batches expiring in this timeframe.</td></tr>
@endif
@endforelse
