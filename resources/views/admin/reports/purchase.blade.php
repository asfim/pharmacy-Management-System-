@extends('admin.layouts.app')
@php $header = 'Purchase Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Purchase Report</h2>
    <p class="text-sm text-slate-500">Analyze purchases from suppliers by date range</p>
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
        <a href="{{ route('admin.reports.purchase') }}" class="border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-semibold px-5 py-2 rounded-xl transition">Reset</a>
    </form>
</div>

<!-- Summary Card -->
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-6 max-w-sm">
    <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Total Purchases</p>
    <p class="text-3xl font-bold text-blue-600">৳{{ number_format($totalPurchase, 2) }}</p>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Invoice No</th>
                    <th class="px-5 py-4 text-left">Supplier</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Total</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                    <th class="px-5 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($purchases as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-700">{{ $p->invoice_no }}</td>
                    <td class="px-5 py-3.5">{{ $p->supplier->company_name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ \Carbon\Carbon::parse($p->purchase_date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($p->total, 2) }}</td>
                    <td class="px-5 py-3.5 text-right text-green-600">৳{{ number_format($p->paid, 2) }}</td>
                    <td class="px-5 py-3.5 text-right {{ $p->due > 0 ? 'text-red-600 font-semibold' : 'text-slate-400' }}">৳{{ number_format($p->due, 2) }}</td>
                    <td class="px-5 py-3.5 text-center text-xs">
                        <span class="px-2 py-1 rounded bg-{{ $p->status == 'received' ? 'green' : 'yellow' }}-100 text-{{ $p->status == 'received' ? 'green' : 'yellow' }}-700 capitalize">{{ $p->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">No purchases found for selected period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($purchases->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $purchases->links() }}</div>
    @endif
</div>
@endsection
