@extends('admin.layouts.app')
@php $header = 'Edit Customer'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Edit: {{ $customer->name }}</h2>
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-3xl">
    <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="p-6 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gender</label>
                <select name="gender" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender', $customer->gender)==='male'?'selected':'' }}>Male</option>
                    <option value="female" {{ old('gender', $customer->gender)==='female'?'selected':'' }}>Female</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Customer Type</label>
                <select name="customer_type" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    <option value="regular" {{ old('customer_type', $customer->customer_type)==='regular'?'selected':'' }}>Regular</option>
                    <option value="wholesale" {{ old('customer_type', $customer->customer_type)==='wholesale'?'selected':'' }}>Wholesale</option>
                    <option value="vip" {{ old('customer_type', $customer->customer_type)==='vip'?'selected':'' }}>VIP</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    <option value="active" {{ old('status', $customer->status)==='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status', $customer->status)==='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Credit Limit (৳)</label>
                <input type="number" name="credit_limit" value="{{ old('credit_limit', $customer->credit_limit) }}" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">{{ old('address', $customer->address) }}</textarea>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">Update Customer</button>
        </div>
    </form>
</div>
@endsection
