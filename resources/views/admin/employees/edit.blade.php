@extends('admin.layouts.app')
@php $header = 'Edit Employee'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Edit: {{ $employee->name }}</h2>
    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-3xl">
    <form action="{{ route('admin.employees.update', $employee) }}" method="POST" class="p-6 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $employee->name) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Role *</label>
                <select name="role" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    @foreach($roles as $r)
                    <option value="{{ $r }}" {{ old('role', $employee->role) === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Salary (৳/month) *</label>
                <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}" min="0" step="0.01" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="active" {{ old('status', $employee->status)==='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status', $employee->status)==='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">Update Employee</button>
        </div>
    </form>
</div>
@endsection
