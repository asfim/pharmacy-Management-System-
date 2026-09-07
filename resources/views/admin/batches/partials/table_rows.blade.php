@forelse($batches as $item)
@php
    $isExpired    = $item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->isPast();
    $isNearExpiry = $item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->diffInDays(now()) <= 90 && !$isExpired;
@endphp
<tr class="hover:bg-slate-50 transition batch-row {{ $isExpired ? 'bg-red-50' : '' }}" data-id="{{ $item->id }}">
    <td class="px-4 py-3 text-center">
        <input type="checkbox" class="row-check w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500" value="{{ $item->id }}">
    </td>
    <td class="px-4 py-3 text-center text-slate-500 text-sm">
        {{ ($batches->currentPage() - 1) * $batches->perPage() + $loop->iteration }}
    </td>
    <td class="px-4 py-3 font-medium text-slate-900 text-sm">{{ $item->product->name ?? '-' }}</td>
    <td class="px-4 py-3 font-mono text-slate-700 text-sm">{{ $item->batch_no }}</td>
    <td class="px-4 py-3 text-slate-600 text-sm">
        {{ $item->manufacturing_date ? \Carbon\Carbon::parse($item->manufacturing_date)->format('d M Y') : '-' }}
    </td>
    <td class="px-4 py-3 text-sm">
        @if($item->expiry_date)
            <span class="{{ $isExpired ? 'text-red-700 font-semibold' : ($isNearExpiry ? 'text-orange-600 font-medium' : 'text-slate-600') }}">
                {{ \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') }}
                @if($isExpired)
                    <span class="ml-1 text-xs bg-red-100 text-red-700 px-1.5 py-0.5 rounded">Expired</span>
                @elseif($isNearExpiry)
                    <span class="ml-1 text-xs bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded">Near Expiry</span>
                @endif
            </span>
        @else
            -
        @endif
    </td>
    <td class="px-4 py-3 font-semibold text-slate-800 text-sm">{{ number_format($item->quantity) }}</td>
    <td class="px-4 py-3 text-slate-700 text-sm">৳ {{ number_format($item->sale_price, 2) }}</td>
    <td class="px-4 py-3">
        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admin.batches.edit', $item) }}"
               class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <form action="{{ route('admin.batches.destroy', $item) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Delete this batch?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="9" class="px-6 py-10 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        No batches found.
    </td>
</tr>
@endforelse
