@extends('admin.layouts.app')
@php $header = 'Stock Adjustments'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Inventory Stock Adjustments</h2>
        <p class="text-sm text-slate-500 mt-1">Manual stock count corrections and audit entries</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Adjustment ID</th>
                    <th class="px-5 py-4">Type</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4">Notes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($adjustments as $adj)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-600">#{{ $adj->id }}</td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800 capitalize">{{ $adj->type ?? 'Manual' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $adj->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $adj->notes ?? 'Stock Audit' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-boxes-stacked text-3xl mb-2 block"></i>
                        No stock adjustments logged.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($adjustments, 'hasPages') && $adjustments->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $adjustments->links() }}</div>
    @endif
</div>
@endsection
