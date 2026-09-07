@extends('admin.layouts.app')
@php $header = 'Damage & Wastage'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Damaged & Expired Medicine Log</h2>
        <p class="text-sm text-slate-500 mt-1">Stock write-offs and damaged product records</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Medicine</th>
                    <th class="px-5 py-4 text-right">Quantity</th>
                    <th class="px-5 py-4">Reason</th>
                    <th class="px-5 py-4">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($damages as $d)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $d->product->name ?? 'Medicine' }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-red-600">{{ $d->quantity ?? 0 }}</td>
                    <td class="px-5 py-3.5 text-slate-600 text-xs">{{ $d->reason ?? 'Damaged' }}</td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $d->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-trash-can text-3xl mb-2 block"></i>
                        No damaged stock logged.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($damages->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $damages->links() }}</div>
    @endif
</div>
@endsection
