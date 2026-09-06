@extends('admin.layouts.app')
@php $header = 'Profit & Loss Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Profit & Loss Report</h2>
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
    </form>
</div>
<!-- Summary -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs text-slate-500 uppercase mb-1">Total Sales</p>
        <p class="text-xl font-bold text-teal-600">৳{{ number_format($totalSales, 0) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs text-slate-500 uppercase mb-1">Total Purchase</p>
        <p class="text-xl font-bold text-blue-600">৳{{ number_format($totalPurchase, 0) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs text-slate-500 uppercase mb-1">Gross Profit</p>
        <p class="text-xl font-bold {{ $grossProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">৳{{ number_format($grossProfit, 0) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <p class="text-xs text-slate-500 uppercase mb-1">Total Expense</p>
        <p class="text-xl font-bold text-orange-600">৳{{ number_format($totalExpense, 0) }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 {{ $netProfit >= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
        <p class="text-xs text-slate-500 uppercase mb-1">Net Profit</p>
        <p class="text-xl font-bold {{ $netProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">৳{{ number_format($netProfit, 0) }}</p>
    </div>
</div>

<!-- Monthly Chart -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
    <h3 class="font-semibold text-slate-800 mb-4">Monthly Profit Trend</h3>
    <canvas id="profitChart" height="80"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
new Chart(document.getElementById('profitChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyData->pluck('month')->values()) !!},
        datasets: [{
            label: 'Net Profit (৳)',
            data: {!! json_encode($monthlyData->pluck('profit')->values()) !!},
            backgroundColor: context => context.raw >= 0 ? 'rgba(20,184,166,0.2)' : 'rgba(239,68,68,0.2)',
            borderColor: context => context.raw >= 0 ? '#14b8a6' : '#ef4444',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => '৳'+v.toLocaleString() } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
@endsection
