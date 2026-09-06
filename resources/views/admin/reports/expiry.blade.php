@extends('admin.layouts.app')
@php $header = 'Expiry Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Expiry Report</h2>
    <p class="text-sm text-slate-500">Batches expiring within selected timeframe</p>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Timeframe</label>
            <select name="days" class="px-4 py-2.5 border border-slate-300 rounded-xl text-sm w-48">
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>Next 30 Days</option>
                <option value="60" {{ $days == 60 ? 'selected' : '' }}>Next 60 Days</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>Next 90 Days</option>
                <option value="180" {{ $days == 180 ? 'selected' : '' }}>Next 6 Months</option>
            </select>
        </div>
        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">Apply</button>
    </form>
</div>

<div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 mb-5 flex items-center gap-3">
    <i class="fas fa-exclamation-triangle text-orange-600 text-xl"></i>
    <p class="text-orange-800 font-medium text-sm">Total value at risk: <span class="font-bold text-lg">৳{{ number_format($totalValue, 2) }}</span></p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Medicine</th>
                    <th class="px-5 py-4 text-left">Batch No</th>
                    <th class="px-5 py-4 text-left">Expiry Date</th>
                    <th class="px-5 py-4 text-right">Quantity Left</th>
                    <th class="px-5 py-4 text-right">Value (Buy Price)</th>
                    <th class="px-5 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($batches as $b)
                @php $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($b->expiry_date), false); @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $b->product->name ?? '-' }}</td>
                    <td class="px-5 py-3.5 font-mono text-slate-600">{{ $b->batch_no }}</td>
                    <td class="px-5 py-3.5 font-semibold {{ $daysLeft < 0 ? 'text-red-600' : 'text-orange-600' }}">{{ \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-700">{{ $b->quantity }}</td>
                    <td class="px-5 py-3.5 text-right text-slate-600">৳{{ number_format($b->quantity * $b->purchase_price, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($daysLeft < 0)
                            <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Expired</span>
                        @elseif($daysLeft <= 30)
                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">{{ floor($daysLeft) }} Days</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">{{ floor($daysLeft) }} Days</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No batches expiring in this timeframe.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($batches->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $batches->links() }}</div>
    @endif
</div>
@endsection
