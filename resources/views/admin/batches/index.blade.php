@extends('admin.layouts.app')
@php $header = 'Batches'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div><h2 class="text-2xl font-bold text-slate-800">Batches</h2><p class="text-sm text-slate-500">Track medicine batches and expiry</p></div>
    <a href="{{ route('admin.batches.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>Add Batch
    </a>
</div>
@include('admin.layouts.alerts')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 text-sm">
                <tr>
                    <th class="px-6 py-4 font-semibold">Medicine</th>
                    <th class="px-6 py-4 font-semibold">Batch No</th>
                    <th class="px-6 py-4 font-semibold">Mfg Date</th>
                    <th class="px-6 py-4 font-semibold">Expiry Date</th>
                    <th class="px-6 py-4 font-semibold">Quantity</th>
                    <th class="px-6 py-4 font-semibold">Sale Price</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm">
                @forelse($batches as $item)
                @php
                    $isExpired = $item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->isPast();
                    $isNearExpiry = $item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->diffInDays(now()) <= 90 && !$isExpired;
                @endphp
                <tr class="hover:bg-slate-50 transition {{ $isExpired ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4 font-medium text-slate-900">{{ $item->product->name ?? '-' }}</td>
                    <td class="px-6 py-4 font-mono text-slate-700">{{ $item->batch_no }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $item->manufacturing_date ? \Carbon\Carbon::parse($item->manufacturing_date)->format('d M Y') : '-' }}</td>
                    <td class="px-6 py-4">
                        @if($item->expiry_date)
                            <span class="{{ $isExpired ? 'text-red-700 font-semibold' : ($isNearExpiry ? 'text-orange-600 font-medium' : 'text-slate-600') }}">
                                {{ \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') }}
                                @if($isExpired) <span class="ml-1 text-xs bg-red-100 text-red-700 px-1.5 py-0.5 rounded">Expired</span>
                                @elseif($isNearExpiry) <span class="ml-1 text-xs bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded">Near Expiry</span>
                                @endif
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-slate-700">৳ {{ number_format($item->sale_price, 2) }}</td>
                    <td class="px-6 py-4 text-right flex justify-end space-x-2">
                        <a href="{{ route('admin.batches.edit', $item) }}" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('admin.batches.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this batch?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-slate-400">No batches found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($batches->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">{{ $batches->links() }}</div>
    @endif
</div>
@endsection
