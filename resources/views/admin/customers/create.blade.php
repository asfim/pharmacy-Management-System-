@extends('admin.layouts.app')
@php $header = 'Add Customer'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Add Customer</h2>
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-3xl">
    <form action="{{ route('admin.customers.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 @error('phone') border-red-400 @enderror">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gender</label>
                <select name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender')==='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ old('gender')==='female'?'selected':'' }}>Female</option>
                    <option value="other" {{ old('gender')==='other'?'selected':'' }}>Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Customer Type</label>
                <select name="customer_type" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="regular" {{ old('customer_type','regular')==='regular'?'selected':'' }}>Regular</option>
                    <option value="wholesale" {{ old('customer_type')==='wholesale'?'selected':'' }}>Wholesale</option>
                    <option value="vip" {{ old('customer_type')==='vip'?'selected':'' }}>VIP</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Opening Due (৳)</label>
                <input type="number" name="opening_balance" value="{{ old('opening_balance', 0) }}" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Credit Limit (৳)</label>
                <input type="number" name="credit_limit" value="{{ old('credit_limit', 0) }}" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">{{ old('address') }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Notes</label>
                <textarea name="notes" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">Save Customer</button>
        </div>
    </form>
</div>
@endsection
