@extends('admin.layouts.app')
@php $header = 'Sales Returns'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Sales Returns</h2>
        <p class="text-sm text-slate-500 mt-1">Manage customer returned items and refunds</p>
    </div>
    <a href="{{ route('admin.sale-returns.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> New Sale Return
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">ID</th>
                    <th class="px-5 py-4">Invoice</th>
                    <th class="px-5 py-4">Customer</th>
                    <th class="px-5 py-4">Return Date</th>
                    <th class="px-5 py-4 text-right">Refund Amount</th>
                    <th class="px-5 py-4">Reason</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($returns as $r)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono text-slate-600">#{{ $r->id }}</td>
                    <td class="px-5 py-3.5 font-mono font-semibold text-slate-700">
                        {{ $r->sale->invoice_no ?? ('Sale #' . $r->sale_id) }}
                    </td>
                    <td class="px-5 py-3.5 text-slate-700">
                        {{ $r->customer->name ?? 'Walk-in Customer' }}
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">
                        {{ $r->return_date ? $r->return_date->format('d M Y h:i A') : $r->created_at->format('d M Y h:i A') }}
                    </td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">
                        ৳{{ number_format($r->refund_amount, 2) }}
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs truncate max-w-xs">
                        {{ $r->reason ?? 'N/A' }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                            {{ $r->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <form action="{{ route('admin.sale-returns.destroy', $r) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sale return?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-rotate-left text-3xl mb-2 block"></i>
                        No sale returns recorded yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($returns->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">
        {{ $returns->links() }}
    </div>
    @endif
</div>
@endsection
