@extends('admin.layouts.app')
@php $header = 'Manufacturers'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Manufacturers</h2>
        <p class="text-sm text-slate-500">Manage pharmaceutical manufacturers</p>
    </div>
    <a href="{{ route('admin.manufacturers.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Add Manufacturer
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm">
                <tr>
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">Company Name</th>
                    <th class="px-6 py-4 font-semibold">Contact Person</th>
                    <th class="px-6 py-4 font-semibold">Phone</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm">
                @forelse($manufacturers as $item)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $item->company_name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $item->contact_person ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $item->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $item->email ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end space-x-2">
                        <a href="{{ route('admin.manufacturers.edit', $item) }}" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('admin.manufacturers.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this manufacturer?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">No manufacturers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($manufacturers->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">{{ $manufacturers->links() }}</div>
    @endif
</div>
@endsection
