@extends('admin.layouts.app')
@php $header = 'Add Batch'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div><h2 class="text-2xl font-bold text-slate-800">Add Batch</h2></div>
    <a href="{{ route('admin.batches.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 rounded-lg flex items-center transition border border-slate-300 bg-white shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back
    </a>
</div>
<div class="bg-white rounded-xl border border-slate-200 shadow-sm max-w-2xl">
    <form action="{{ route('admin.batches.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Medicine *</label>
            <select name="product_id" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('product_id') border-red-500 @enderror">
                <option value="">-- Select Medicine --</option>
                @foreach($medicines as $m)<option value="{{ $m->id }}" {{ old('product_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>@endforeach
            </select>
            @error('product_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Batch Number *</label>
                <input type="text" name="batch_no" value="{{ old('batch_no') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('batch_no') border-red-500 @enderror">
                @error('batch_no')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Quantity *</label>
                <input type="number" name="quantity" value="{{ old('quantity', 0) }}" min="0" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('quantity') border-red-500 @enderror">
                @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Manufacturing Date</label>
                <input type="date" name="manufacturing_date" value="{{ old('manufacturing_date') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Price *</label>
                <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                <input type="number" name="purchase_price" value="{{ old('purchase_price', 0) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Sale Price *</label>
                <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 px-6 rounded-lg transition shadow-sm">Save Batch</button>
        </div>
    </form>
</div>
@endsection
