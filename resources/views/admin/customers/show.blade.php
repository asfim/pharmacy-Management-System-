@extends('admin.layouts.app')
@php $header = 'Customer Details'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">{{ $customer->name }}</h2>
        <p class="text-sm text-slate-500">Customer Details and History</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
            <i class="fas fa-pen"></i> Edit
        </a>
        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Profile</h3>
        <p class="mb-2"><strong class="text-slate-600">Phone:</strong> {{ $customer->phone }}</p>
        <p class="mb-2"><strong class="text-slate-600">Email:</strong> {{ $customer->email ?? 'N/A' }}</p>
        <p class="mb-2"><strong class="text-slate-600">Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
        <p class="mb-2"><strong class="text-slate-600">Status:</strong> <span class="px-2 py-0.5 rounded text-xs font-medium {{ $customer->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($customer->status ?? 'active') }}</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:col-span-2">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Financial Overview</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-slate-500 mb-1">Total Due Balance</p>
                <p class="text-2xl font-bold {{ ($customer->opening_balance ?? 0) > 0 ? 'text-red-600' : 'text-slate-700' }}">
                    ৳{{ number_format(abs($customer->opening_balance ?? 0), 2) }}
                </p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Total Sales</p>
                <p class="text-2xl font-bold text-slate-700">{{ $customer->sales ? $customer->sales->count() : 0 }}</p>
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.customers.ledger', $customer) }}" class="inline-flex items-center gap-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-semibold px-4 py-2 rounded-lg transition">
                <i class="fas fa-book"></i> View Ledger
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800">Recent Sales</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Invoice No</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Total</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                    <th class="px-5 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @if($customer->sales)
                    @forelse($customer->sales->sortByDesc('created_at')->take(10) as $sale)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3.5 font-mono text-slate-700">{{ $sale->invoice_no }}</td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $sale->created_at->format('d M Y, h:i A') }}</td>
                        <td class="px-5 py-3.5 text-right font-semibold">৳{{ number_format($sale->total, 2) }}</td>
                        <td class="px-5 py-3.5 text-right text-green-600">৳{{ number_format($sale->paid, 2) }}</td>
                        <td class="px-5 py-3.5 text-right {{ $sale->due > 0 ? 'text-red-600' : 'text-slate-400' }}">৳{{ number_format($sale->due, 2) }}</td>
                        <td class="px-5 py-3.5 text-center">
                            <a href="{{ route('admin.sales.invoice', $sale) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg" title="View Invoice"><i class="fas fa-file-invoice text-xs"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">No recent sales found for this customer.</td></tr>
                    @endforelse
                @else
                    <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">No recent sales found for this customer.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
