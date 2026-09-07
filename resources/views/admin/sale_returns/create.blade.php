@extends('admin.layouts.app')
@php $header = 'New Sale Return'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Create Sale Return</h2>
    </div>
    <a href="{{ route('admin.sale-returns.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-2xl">
    <form action="{{ route('admin.sale-returns.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Select Invoice / Sale *</label>
            <select name="sale_id" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                <option value="">-- Select Sale Invoice --</option>
                @foreach($sales as $s)
                <option value="{{ $s->id }}">
                    Invoice: {{ $s->invoice_no }} (Customer: {{ $s->customer->name ?? 'Walk-in' }} | Total: ৳{{ number_format($s->total, 2) }})
                </option>
                @endforeach
            </select>
            @error('sale_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Refund Amount (৳) *</label>
            <input type="number" name="refund_amount" step="0.01" value="{{ old('refund_amount', 0) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            @error('refund_amount')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Reason / Note</label>
            <textarea name="reason" rows="3" placeholder="Reason for return..." class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">{{ old('reason') }}</textarea>
            @error('reason')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                Process Return
            </button>
        </div>
    </form>
</div>
@endsection
