@extends('admin.layouts.app')
@php $header = 'Stock Transfer Details'; @endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-12 print:max-w-none print:m-0 print:p-0">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 print:hidden">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Transfer #{{ $transfer->transfer_no }}</h2>
            <p class="text-sm text-slate-500 mt-1">Inter-branch stock movement details</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.stock-transfers.index') }}" 
               class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition">
                <i class="fas fa-arrow-left mr-2 text-slate-400"></i> Back to Transfers
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2.5 rounded-xl bg-slate-800 text-white font-semibold text-sm hover:bg-slate-900 shadow-sm transition">
                <i class="fas fa-print mr-2"></i> Print Receipt
            </button>
        </div>
    </div>

    @include('admin.layouts.alerts')

    <!-- Printable Receipt Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 print:shadow-none print:border-none print:p-0">
        <!-- Header Info -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-slate-100 pb-6 mb-6 gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-2">
                    <i class="fas fa-check-circle mr-1.5"></i> {{ $transfer->status }}
                </span>
                <h1 class="text-2xl font-black text-slate-900 font-mono">{{ $transfer->transfer_no }}</h1>
                <p class="text-xs text-slate-500 mt-1">Date: {{ $transfer->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="text-left md:text-right">
                <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Pharmacy System</p>
                <p class="text-sm font-bold text-slate-700 mt-0.5">Inter-Branch Transfer Note</p>
            </div>
        </div>

        <!-- Branch Routing Box -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/70 rounded-xl p-5 border border-slate-100 mb-8">
            <div class="space-y-1">
                <p class="text-xs font-bold uppercase tracking-wider text-rose-600">Source Branch (থেকে)</p>
                <p class="text-base font-bold text-slate-800">{{ $transfer->sourceBranch?->name ?? 'N/A' }}</p>
                <p class="text-xs text-slate-500">{{ $transfer->sourceBranch?->address ?? '' }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600">Destination Branch (কোথায়)</p>
                <p class="text-base font-bold text-slate-800">{{ $transfer->destinationBranch?->name ?? 'N/A' }}</p>
                <p class="text-xs text-slate-500">{{ $transfer->destinationBranch?->address ?? '' }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-y border-slate-200 text-xs text-slate-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Medicine</th>
                        <th class="px-4 py-3">Batch No</th>
                        <th class="px-4 py-3">Expiry Date</th>
                        <th class="px-4 py-3 text-right">Quantity</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($transfer->items as $index => $item)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-4 py-3.5 text-xs text-slate-400 font-mono">{{ $index + 1 }}</td>
                        <td class="px-4 py-3.5 font-bold text-slate-800">
                            {{ $item->product?->name ?? 'N/A' }}
                            <span class="text-xs font-normal text-slate-500">({{ $item->product?->unit ?? 'Pcs' }})</span>
                        </td>
                        <td class="px-4 py-3.5 font-mono text-slate-600 text-xs">
                            {{ $item->batch?->batch_no ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3.5 text-xs text-slate-600">
                            {{ $item->batch?->expiry_date ? $item->batch->expiry_date->format('d M Y') : 'N/A' }}
                        </td>
                        <td class="px-4 py-3.5 text-right font-bold text-emerald-700">
                            {{ $item->quantity }} Pcs
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="grid grid-cols-2 gap-8 pt-12 mt-8 border-t border-slate-100 text-center text-xs text-slate-500">
            <div>
                <div class="border-b border-slate-300 w-36 mx-auto mb-2"></div>
                <p class="font-semibold text-slate-700">Dispatched By</p>
                <p class="text-[11px] text-slate-400">({{ $transfer->sourceBranch?->name }})</p>
            </div>
            <div>
                <div class="border-b border-slate-300 w-36 mx-auto mb-2"></div>
                <p class="font-semibold text-slate-700">Received By</p>
                <p class="text-[11px] text-slate-400">({{ $transfer->destinationBranch?->name }})</p>
            </div>
        </div>
    </div>
</div>
@endsection
