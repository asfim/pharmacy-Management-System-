@extends('admin.layouts.app')
@php $header = 'Purchases'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Purchase History</h2></div>
    <a href="{{ route('admin.purchases.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> New Purchase
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-4 text-left">Invoice No</th>
                    <th class="px-5 py-4 text-left">Supplier</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Total</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($purchases as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono font-semibold text-slate-700">{{ $p->invoice_no }}</td>
                    <td class="px-5 py-3.5 text-slate-700">{{ $p->supplier->company_name ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-slate-500">{{ \Carbon\Carbon::parse($p->purchase_date)->format('d M Y') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($p->total, 2) }}</td>
                    <td class="px-5 py-3.5 text-right text-green-600 font-semibold">৳{{ number_format($p->paid, 2) }}</td>
                    <td class="px-5 py-3.5 text-right {{ $p->due > 0 ? 'text-red-600' : 'text-slate-400' }} font-semibold">৳{{ number_format($p->due, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $p->status === 'received' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.purchases.show', $p) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg" title="View"><i class="fas fa-eye text-xs"></i></a>
                            <a href="{{ route('admin.purchases.invoice', $p) }}" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg" title="Invoice"><i class="fas fa-print text-xs"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-10 text-center text-slate-400">No purchases found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($purchases->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $purchases->links() }}</div>
    @endif
</div>
@endsection
