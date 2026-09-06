@extends('admin.layouts.app')
@php $header = 'Add Expense'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Add Expense</h2>
    <a href="{{ route('admin.expenses.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-xl">
    <form action="{{ route('admin.expenses.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category *</label>
            <select name="category" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Amount (৳) *</label>
            <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Date *</label>
            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Method *</label>
            <select name="payment_method" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                <option value="cash">Cash</option>
                <option value="bkash">bKash</option>
                <option value="nagad">Nagad</option>
                <option value="bank">Bank</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">{{ old('description') }}</textarea>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">Save Expense</button>
        </div>
    </form>
</div>
@endsection
