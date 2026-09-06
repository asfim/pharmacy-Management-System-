@extends('admin.layouts.app')
@php $header = 'Medicines'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Medicines</h2>
        <p class="text-sm text-slate-500">Manage all medicine products</p>
    </div>
    <a href="{{ route('admin.medicines.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Add Medicine
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm">
                <tr>
                    <th class="px-4 py-4 font-semibold">#</th>
                    <th class="px-4 py-4 font-semibold">Name</th>
                    <th class="px-4 py-4 font-semibold">Generic</th>
                    <th class="px-4 py-4 font-semibold">Brand</th>
                    <th class="px-4 py-4 font-semibold">Category</th>
                    <th class="px-4 py-4 font-semibold">Sale Price</th>
                    <th class="px-4 py-4 font-semibold">Rx</th>
                    <th class="px-4 py-4 font-semibold">Status</th>
                    <th class="px-4 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm">
                @forelse($medicines as $item)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 text-slate-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-slate-900">{{ $item->name }}</p>
                        <p class="text-xs text-slate-400">{{ $item->strength }} {{ $item->dosage_form }}</p>
                    </td>
                    <td class="px-4 py-3 text-slate-600">{{ $item->generic->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-slate-600">{{ $item->brand->name ?? '-' }}</td>
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
                    <td class="px-4 py-3 text-right flex justify-end space-x-2">
                        <a href="{{ route('admin.medicines.edit', $item) }}" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('admin.medicines.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this medicine?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-6 py-10 text-center text-slate-400">No medicines found. <a href="{{ route('admin.medicines.create') }}" class="text-teal-600 underline">Add one now</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($medicines->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">{{ $medicines->links() }}</div>
    @endif
</div>
@endsection
