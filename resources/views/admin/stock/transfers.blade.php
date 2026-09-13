@extends('admin.layouts.app')
@php $header = 'Stock Transfers'; @endphp

@section('content')
<div class="space-y-6 pb-12">
    <!-- Top Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Inter-Branch Stock Transfers</h2>
            <p class="text-sm text-slate-500 mt-1">Stock movement and transfer history between pharmacy branches</p>
        </div>
        <a href="{{ route('admin.stock-transfers.create') }}" 
           class="inline-flex items-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-md shadow-emerald-200 transition">
            <i class="fas fa-right-left mr-2"></i> New Stock Transfer
        </a>
    </div>

    @include('admin.layouts.alerts')

    <!-- Transfers Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-4">Transfer No</th>
                        <th class="px-5 py-4">Date</th>
                        <th class="px-5 py-4">Source Branch (থেকে)</th>
                        <th class="px-5 py-4">Destination Branch (কোথায়)</th>
                        <th class="px-5 py-4 text-center">Items</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transfers as $tr)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-5 py-4 font-mono font-bold text-slate-900">
                            <a href="{{ route('admin.stock-transfers.show', $tr->id) }}" class="hover:text-emerald-600 transition">
                                {{ $tr->transfer_no }}
                            </a>
                        </td>
                        <td class="px-5 py-4 text-slate-500 text-xs">
                            {{ $tr->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-700">
                            <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-md bg-slate-100 text-slate-700">
                                <i class="fas fa-store text-slate-400 mr-1.5"></i>
                                {{ $tr->sourceBranch?->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-700">
                            <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-800">
                                <i class="fas fa-location-dot text-emerald-500 mr-1.5"></i>
                                {{ $tr->destinationBranch?->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center font-bold text-slate-700">
                            {{ $tr->items->count() }}
                        </td>
                        <td class="px-5 py-4">
                            @if(($tr->status ?? 'pending') === 'completed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 capitalize">
                                    <i class="fas fa-check-circle mr-1"></i> Completed
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 capitalize">
                                    <i class="fas fa-clock mr-1"></i> {{ $tr->status ?? 'Pending' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right space-x-2">
                            <a href="{{ route('admin.stock-transfers.show', $tr->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                                <i class="fas fa-eye mr-1"></i> Details
                            </a>
                            @if(($tr->status ?? 'pending') !== 'completed')
                            <form action="{{ route('admin.stock-transfers.approve', $tr->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition"
                                        onclick="return confirm('Approve this transfer and update branch stock?')">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3 text-xl">
                                <i class="fas fa-right-left"></i>
                            </div>
                            <p class="font-bold text-slate-600 text-base">No inter-branch transfers logged</p>
                            <p class="text-xs text-slate-400 mt-1">Click "New Stock Transfer" above to initiate a stock movement.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($transfers, 'hasPages') && $transfers->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $transfers->links() }}</div>
        @endif
    </div>
</div>
@endsection
