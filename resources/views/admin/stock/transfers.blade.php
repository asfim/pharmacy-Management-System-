@extends('admin.layouts.app')
@php $header = 'Stock Transfers'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Inter-Branch Stock Transfers</h2>
        <p class="text-sm text-slate-500 mt-1">Stock movement between pharmacy branches</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Transfer ID</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transfers as $tr)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-600">#{{ $tr->id }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $tr->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                            {{ $tr->status ?? 'pending' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-right-left text-3xl mb-2 block"></i>
                        No inter-branch transfers logged.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($transfers, 'hasPages') && $transfers->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $transfers->links() }}</div>
    @endif
</div>
@endsection
