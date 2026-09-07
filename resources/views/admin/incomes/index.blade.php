@extends('admin.layouts.app')
@php $header = 'Other Income'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Other Incomes</h2>
        <p class="text-sm text-slate-500 mt-1">Non-sales revenue and extra earnings log</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Category</th>
                    <th class="px-5 py-4">Description</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4 text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($incomes as $inc)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800 capitalize">{{ $inc->category ?? 'General' }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $inc->description ?? 'N/A' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $inc->income_date ?? $inc->created_at->format('Y-m-d') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-green-600">৳{{ number_format($inc->amount ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-coins text-3xl mb-2 block"></i>
                        No other income records recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($incomes->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $incomes->links() }}</div>
    @endif
</div>
@endsection
