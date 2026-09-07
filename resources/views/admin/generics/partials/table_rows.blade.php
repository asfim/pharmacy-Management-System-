@forelse($generics as $item)
<tr class="hover:bg-slate-50 transition generic-row" data-id="{{ $item->id }}">
    <td class="px-4 py-3 text-center">
        <input type="checkbox" class="row-check w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500" value="{{ $item->id }}">
    </td>
    <td class="px-4 py-3 text-center text-slate-500 text-sm">
        {{ ($generics->currentPage() - 1) * $generics->perPage() + $loop->iteration }}
    </td>
    <td class="px-4 py-3 font-medium text-slate-900 text-sm">{{ $item->name }}</td>
    <td class="px-4 py-3 text-slate-500 text-sm">{{ $item->dosage ?? '-' }}</td>
    <td class="px-4 py-3 text-slate-500 text-sm max-w-xs truncate">{{ $item->description ?? '-' }}</td>
    <td class="px-4 py-3">
        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ ucfirst($item->status) }}
        </span>
    </td>
    <td class="px-4 py-3">
        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admin.generics.edit', $item) }}"
               class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <form action="{{ route('admin.generics.destroy', $item) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Delete this generic?');">
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
    <td colspan="7" class="px-6 py-10 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        No generics found.
    </td>
</tr>
@endforelse
