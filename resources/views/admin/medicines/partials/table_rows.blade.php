@forelse($medicines as $item)
<tr class="hover:bg-slate-50 transition border-b border-slate-100">
    <td class="px-4 py-3 text-slate-500 font-medium text-xs">
        {{ $loop->iteration + ($medicines->currentPage() - 1) * $medicines->perPage() }}
    </td>
    <td class="px-4 py-3">
        @php
            $imgUrl = $item->product_images->first()->image_url ?? $item->image ?? null;
            if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                $imgUrl = asset('storage/' . $imgUrl);
            }
        @endphp
        @if($imgUrl)
            <img src="{{ $imgUrl }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200 shadow-xs">
        @else
            <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-xs border border-teal-100">
                {{ strtoupper(substr($item->name, 0, 2)) }}
            </div>
        @endif
    </td>
    <td class="px-4 py-3">
        <p class="font-medium text-slate-900">{{ $item->name }}</p>
        <p class="text-xs text-slate-400">{{ $item->strength }} {{ $item->dosage_form }}</p>
    </td>
    <td class="px-4 py-3 text-slate-600">{{ $item->generic->name ?? '-' }}</td>
    <td class="px-4 py-3 text-slate-600">{{ $item->manufacturer->company_name ?? $item->brand->name ?? '-' }}</td>
    <td class="px-4 py-3 text-slate-600">{{ $item->category->name ?? '-' }}</td>
    <td class="px-4 py-3 font-semibold text-slate-800">৳ {{ number_format($item->sale_price, 2) }}</td>
    <td class="px-4 py-3">
        @if($item->prescription_required)
            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-orange-100 text-orange-700">Rx</span>
        @else
            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-500">OTC</span>
        @endif
    </td>
    <td class="px-4 py-3">
        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ ucfirst($item->status) }}
        </span>
    </td>
    <td class="px-4 py-3 text-right">
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.medicines.edit', $item) }}" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </a>
            <form action="{{ route('admin.medicines.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this medicine?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="10" class="px-6 py-10 text-center text-slate-400">
        No medicines found. <a href="{{ route('admin.medicines.create') }}" class="text-teal-600 underline">Add one now</a>.
    </td>
</tr>
@endforelse
