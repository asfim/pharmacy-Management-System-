@extends('admin.layouts.app')
@php $header = 'Branches'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Pharmacy Branches</h2>
        <p class="text-sm text-slate-500 mt-1">Manage pharmacy outlets & branch locations</p>
    </div>
    <a href="{{ route('admin.branches.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Add Branch
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Branch Name</th>
                    <th class="px-5 py-4">Phone</th>
                    <th class="px-5 py-4">Email</th>
                    <th class="px-5 py-4">Address</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($branches as $b)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $b->name }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $b->phone ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $b->email ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $b->address ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                            {{ $b->status ?? 'active' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <form action="{{ route('admin.branches.destroy', $b) }}" method="POST" onsubmit="return confirm('Delete this branch?')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-code-branch text-3xl mb-2 block"></i>
                        No branches configured yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($branches->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $branches->links() }}</div>
    @endif
</div>
@endsection
