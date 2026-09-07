@forelse($categories as $category)
<tr class="hover:bg-slate-50 transition cat-row" data-id="{{ $category->id }}">
    <td class="px-4 py-3 text-center">
        <input type="checkbox" class="row-check w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500" value="{{ $category->id }}">
    </td>
    <td class="px-4 py-3 text-center text-slate-500 text-sm">
        {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
    </td>
    <td class="px-4 py-3">
        @if($category->image)
            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}"
                 class="w-10 h-10 object-cover rounded-lg border border-slate-200 cursor-pointer lightbox-img"
                 data-src="{{ asset('storage/'.$category->image) }}">
        @else
            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
    </td>
    <td class="px-4 py-3 font-medium text-slate-900 text-sm">{{ $category->name }}</td>
    <td class="px-4 py-3 text-slate-500 text-sm max-w-xs truncate">{{ $category->description ?? '-' }}</td>
    <td class="px-4 py-3">
        @if($category->status === 'active')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
        @else
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
        @endif
    </td>
    <td class="px-4 py-3">
        <div class="flex items-center justify-end space-x-2">
            <a href="{{ route('admin.categories.edit', $category) }}"
               class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Delete this category?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Delete">
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
    <td colspan="7" class="px-6 py-10 text-center text-slate-500">
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>No categories found.</p>
        </div>
    </td>
</tr>
@endforelse
