@extends('admin.layouts.app')
@php $header = 'Add Branch'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Add Branch</h2>
    <a href="{{ route('admin.branches.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-2xl">
    <form action="{{ route('admin.branches.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Branch Name *</label>
            <input type="text" name="name" required placeholder="e.g. Main Branch / Dhanmondi Branch" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Phone</label>
            <input type="text" name="phone" placeholder="e.g. +8801700000000" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
            <textarea name="address" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"></textarea>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">Save Branch</button>
        </div>
    </form>
</div>
@endsection
