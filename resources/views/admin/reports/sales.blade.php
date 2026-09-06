@extends('admin.layouts.app')
@php $header = 'Sales Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Sales Report</h2>
    <p class="text-sm text-slate-500">Filter and analyze sales by date range</p>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Apply Filter</button>
        <a href="{{ route('admin.reports.sales') }}" class="border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-semibold px-5 py-2 rounded-xl transition">Reset</a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Sales</p>
        <p class="text-2xl font-bold text-teal-600">৳{{ number_format($totalSales, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Discount</p>
        <p class="text-2xl font-bold text-red-500">৳{{ number_format($totalDiscount, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Due</p>
        <p class="text-2xl font-bold text-orange-500">৳{{ number_format($totalDue, 2) }}</p>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Invoice</th>
                    <th class="px-5 py-4 text-left">Customer</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Subtotal</th>
                    <th class="px-5 py-4 text-right">Discount</th>
                    <th class="px-5 py-4 text-right">Total</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sales as $s)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-700">{{ $s->invoice_no }}</td>
                    <td class="px-5 py-3.5">{{ $s->customer->name ?? 'Walk-in' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $s->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right">৳{{ number_format($s->subtotal, 2) }}</td>
                    <td class="px-5 py-3.5 text-right text-red-500">৳{{ number_format($s->discount, 2) }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($s->total, 2) }}</td>
                    <td class="px-5 py-3.5 text-right text-green-600">৳{{ number_format($s->paid, 2) }}</td>
                    <td class="px-5 py-3.5 text-right {{ $s->due > 0 ? 'text-red-600 font-semibold' : 'text-slate-400' }}">৳{{ number_format($s->due, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-10 text-center text-slate-400">No sales found for selected period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $sales->links() }}</div>
    @endif
</div>
@endsection
