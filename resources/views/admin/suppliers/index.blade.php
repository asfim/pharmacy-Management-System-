@extends('admin.layouts.app')
@php $header = 'Suppliers'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Suppliers</h2><p class="text-sm text-slate-500">Manage your medicine suppliers</p></div>
    <a href="{{ route('admin.suppliers.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Add Supplier
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-4 text-left">#</th>
                    <th class="px-5 py-4 text-left">Company</th>
                    <th class="px-5 py-4 text-left">Contact</th>
                    <th class="px-5 py-4 text-left">Phone</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($suppliers as $s)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 text-slate-400">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-slate-800">{{ $s->company_name }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $s->contact_person ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $s->phone ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $s->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($s->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.suppliers.show', $s) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition" title="View"><i class="fas fa-eye text-xs"></i></a>
                            <a href="{{ route('admin.suppliers.edit', $s) }}" class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition" title="Edit"><i class="fas fa-pen text-xs"></i></a>
                            <form action="{{ route('admin.suppliers.destroy', $s) }}" method="POST" onsubmit="return confirm('Delete supplier?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">No suppliers found. <a href="{{ route('admin.suppliers.create') }}" class="text-teal-600 hover:underline">Add one →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suppliers->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $suppliers->links() }}</div>
    @endif
</div>
@endsection
