@extends('admin.layouts.app')
@php $header = 'Sales History'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">Sales History</h2></div>
    <a href="{{ route('admin.pos.index') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-cash-register"></i> New Sale (POS)
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Invoice</th>
                    <th class="px-5 py-4 text-left">Customer</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Total</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                    <th class="px-5 py-4 text-left">Payment</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sales as $s)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono font-semibold text-slate-700">{{ $s->invoice_no }}</td>
                    <td class="px-5 py-3.5 text-slate-700">{{ $s->customer->name ?? 'Walk-in' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $s->created_at->format('d M Y h:i A') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($s->total, 2) }}</td>
                    <td class="px-5 py-3.5 text-right text-green-600">৳{{ number_format($s->paid, 2) }}</td>
                    <td class="px-5 py-3.5 text-right {{ $s->due > 0 ? 'text-red-600 font-semibold' : 'text-slate-400' }}">৳{{ number_format($s->due, 2) }}</td>
                    <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $s->sale_payments->first()->method ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.sales.invoice', $s) }}" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg" title="Invoice"><i class="fas fa-print text-xs"></i></a>
                            <form action="{{ route('admin.sales.destroy', $s) }}" method="POST" onsubmit="return confirm('Delete this sale?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-10 text-center text-slate-400">No sales yet. <a href="{{ route('admin.pos.index') }}" class="text-teal-600 hover:underline">Create a sale →</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $sales->links() }}</div>
    @endif
</div>
@endsection
