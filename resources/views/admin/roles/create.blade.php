@extends('admin.layouts.app')
@php $header = 'Create Role'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Create Role</h2>
    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-2xl">
    <form action="{{ route('admin.roles.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role Name *</label>
            <input type="text" name="name" required placeholder="e.g. Pharmacist / Manager" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Permissions</label>
            <div class="grid grid-cols-2 gap-2 mt-2 max-h-60 overflow-y-auto p-3 border border-slate-200 rounded-xl bg-slate-50">
                @foreach($permissions as $p)
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="rounded text-teal-600 focus:ring-teal-500">
                    <span>{{ $p->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">Save Role</button>
        </div>
    </form>
</div>
@endsection
