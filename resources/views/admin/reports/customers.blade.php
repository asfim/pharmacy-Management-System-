@extends('admin.layouts.app')
@php $header = 'Customer Report'; @endphp
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Customer Report</h2>
    <p class="text-sm text-slate-500">Top customers by total sales volume</p>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Rank</th>
                    <th class="px-5 py-4 text-left">Customer Name</th>
                    <th class="px-5 py-4 text-left">Phone</th>
                    <th class="px-5 py-4 text-left">Type</th>
                    <th class="px-5 py-4 text-right">Total Lifetime Sales</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($customers as $c)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 text-slate-400 font-bold">#{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $c->name }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $c->phone }}</td>
                    <td class="px-5 py-3.5 text-slate-500 capitalize">{{ $c->customer_type ?? 'Regular' }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-teal-600">৳{{ number_format($c->sales_sum_total ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">No customers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
