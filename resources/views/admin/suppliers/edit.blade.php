@extends('admin.layouts.app')
@php $header = 'Edit Supplier'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Edit: {{ $supplier->company_name }}</h2>
    <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-3xl">
    <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" class="p-6 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Company Name *</label>
                <input type="text" name="company_name" value="{{ old('company_name', $supplier->company_name) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contact Person</label>
                <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Opening Balance</label>
                <input type="number" name="opening_balance" value="{{ old('opening_balance', $supplier->opening_balance) }}" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Credit Limit</label>
                <input type="number" name="credit_limit" value="{{ old('credit_limit', $supplier->credit_limit) }}" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Terms</label>
                <input type="text" name="payment_terms" value="{{ old('payment_terms', $supplier->payment_terms) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="active" {{ old('status',$supplier->status)==='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status',$supplier->status)==='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">{{ old('address', $supplier->address) }}</textarea>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">Update Supplier</button>
        </div>
    </form>
</div>
@endsection
