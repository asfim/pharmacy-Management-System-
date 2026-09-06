@extends('admin.layouts.app')
@php $header = 'Financial Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Financial Report</h2>
    <p class="text-sm text-slate-500">Summary of sales, purchases, and expenses</p>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">From</label>
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">To</label>
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="px-3 py-2 border border-slate-300 rounded-xl text-sm">
        </div>
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Apply</button>
        <a href="{{ route('admin.reports.financial') }}" class="border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-semibold px-5 py-2 rounded-xl transition">Reset</a>
    </form>
</div>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-teal-50 flex items-center justify-center">
                <i class="fas fa-shopping-cart text-teal-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500">Total Sales</p>
                <p class="text-2xl font-bold text-slate-800">৳{{ number_format($totalSales, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                <i class="fas fa-truck-loading text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500">Total Purchases</p>
                <p class="text-2xl font-bold text-slate-800">৳{{ number_format($totalPurchase, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center">
                <i class="fas fa-file-invoice-dollar text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-500">Total Expenses</p>
                <p class="text-2xl font-bold text-slate-800">৳{{ number_format($totalExpense, 2) }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Expenses Breakdown -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
    <div class="p-5 border-b border-slate-100">
        <h3 class="font-semibold text-slate-800">Expense Breakdown by Category</h3>
    </div>
    @if($expenseByCategory->isEmpty())
    <div class="p-8 text-center text-slate-400">No expenses recorded for this period.</div>
    @else
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Category</th>
                <th class="px-5 py-3 text-right">Total Amount</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @foreach($expenseByCategory as $e)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-5 py-3 font-semibold text-slate-700">{{ $e->category }}</td>
                <td class="px-5 py-3 text-right font-bold text-red-600">৳{{ number_format($e->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
