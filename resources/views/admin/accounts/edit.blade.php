@extends('admin.layouts.app')
@php $header = 'Edit Account'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Edit Account</h2>
    <a href="{{ route('admin.accounts.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-2xl">
    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST" class="p-6 space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Account Name *</label>
            <input type="text" name="name" value="{{ old('name', $account->name) }}" required placeholder="e.g. Main Cash / DBBL Bank" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Account Number</label>
            <input type="text" name="account_number" value="{{ old('account_number', $account->account_number) }}" placeholder="e.g. 1234567890" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Bank Name</label>
            <input type="text" name="bank_name" value="{{ old('bank_name', $account->bank_name) }}" placeholder="e.g. Dutch Bangla Bank" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Opening Balance (৳)</label>
            <input type="number" name="opening_balance" step="0.01" value="{{ old('opening_balance', $account->opening_balance) }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">Update Account</button>
        </div>
    </form>
</div>
@endsection
