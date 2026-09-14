@extends('admin.layouts.app')
@php $header = 'Create User'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Create User</h2>
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow max-w-2xl">
    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name *</label>
            <input type="text" name="name" required value="{{ old('name') }}" placeholder="Full Name" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address *</label>
            <input type="email" name="email" required value="{{ old('email') }}" placeholder="email@example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password *</label>
            <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Assign Branch</label>
            <select name="branch_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                <option value="">-- All / Global Branch (Super Admin) --</option>
                @foreach($branches as $b)
                <option value="{{ $b->id }}" {{ old('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->code }})</option>
                @endforeach
            </select>
            <p class="text-xs text-slate-400 mt-1">When logged in, this user will be restricted to sales, stock, and expenses of this branch.</p>
            @error('branch_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role(s)</label>
            <div class="grid grid-cols-2 gap-2 mt-2 p-3 border border-slate-200 rounded-xl bg-slate-50">
                @foreach($roles as $r)
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 cursor-pointer capitalize">
                    <input type="checkbox" name="roles[]" value="{{ $r->name }}" class="rounded text-teal-600 focus:ring-teal-500">
                    <span>{{ $r->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">Save User</button>
        </div>
    </form>
</div>
@endsection
