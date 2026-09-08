@extends('admin.layouts.app')
@php $header = 'Customer Ledger'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Ledger: {{ $customer->name }}</h2>
        <p class="text-sm text-slate-500">{{ $customer->phone }}</p>
    </div>
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Sales History</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Invoice</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-right">Due</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customer->sales as $sale)
                    <tr>
                        <td class="px-4 py-3">{{ $sale->created_at->format('d M, Y') }}</td>
                        <td class="px-4 py-3 font-medium text-slate-700">{{ $sale->invoice_no }}</td>
                        <td class="px-4 py-3 text-right">৳{{ number_format($sale->total, 2) }}</td>
                        <td class="px-4 py-3 text-right text-red-500">৳{{ number_format($sale->due, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-slate-400">No sales found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Payment History</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Method</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customer->customerPayments as $payment)
                    <tr>
                        <td class="px-4 py-3">{{ $payment->created_at->format('d M, Y') }}</td>
                        <td class="px-4 py-3">{{ ucfirst($payment->method ?? 'Cash') }}</td>
                        <td class="px-4 py-3 text-right text-green-600 font-medium">৳{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-slate-400">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
