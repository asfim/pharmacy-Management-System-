@extends('admin.layouts.app')
@php $header = 'Discount Coupons'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Coupons & Discounts</h2>
        <p class="text-sm text-slate-500 mt-1">Manage promo codes and discount vouchers</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Code</th>
                    <th class="px-5 py-4">Type</th>
                    <th class="px-5 py-4">Value</th>
                    <th class="px-5 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($coupons as $c)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono font-bold text-slate-800">{{ $c->code }}</td>
                    <td class="px-5 py-3.5 text-slate-600 capitalize">{{ $c->type ?? 'fixed' }}</td>
                    <td class="px-5 py-3.5 text-slate-800 font-semibold">৳{{ number_format($c->value ?? 0, 2) }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                            {{ $c->status ?? 'active' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-ticket text-3xl mb-2 block"></i>
                        No discount coupons created yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $coupons->links() }}</div>
    @endif
</div>
@endsection
