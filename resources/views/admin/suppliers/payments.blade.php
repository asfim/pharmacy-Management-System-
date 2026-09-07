@extends('admin.layouts.app')
@php $header = 'Supplier Payments'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Supplier Payment Disbursements</h2>
        <p class="text-sm text-slate-500 mt-1">Vendor payment receipts and account payouts</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Voucher</th>
                    <th class="px-5 py-4">Supplier</th>
                    <th class="px-5 py-4">Date</th>
                    <th class="px-5 py-4 text-right">Amount Paid</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payments as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-600">#{{ $p->id }}</td>
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $p->supplier->company_name ?? 'Vendor' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $p->created_at->format('d M Y h:i A') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($p->amount ?? 0, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-truck text-3xl mb-2 block"></i>
                        No supplier payments recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
