@extends('admin.layouts.app')
@php $header = 'Pay Salary'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Pay Employee Salary</h2>
        <p class="text-sm text-slate-500 mt-1">Record a monthly salary payment for an employee</p>
    </div>
    <a href="{{ route('admin.payrolls.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition"><i class="fas fa-arrow-left"></i> Back to Payrolls</a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <form action="{{ route('admin.payrolls.store') }}" method="POST" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Employee *</label>
                <select name="employee_id" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Select Employee --</option>
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->name }} (৳{{ $emp->salary }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Month/Year *</label>
                <input type="month" name="month" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Account *</label>
                <select name="account_id" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Select Account --</option>
                    @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->name }} (Balance: ৳{{ $acc->current_balance }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Basic Salary (৳) *</label>
                <input type="number" step="0.01" name="basic_salary" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Allowances (৳)</label>
                <input type="number" step="0.01" name="allowance" value="0" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Bonus (৳)</label>
                <input type="number" step="0.01" name="bonus" value="0" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deductions (৳)</label>
                <input type="number" step="0.01" name="deductions" value="0" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 text-red-600">
            </div>
        </div>

        <div class="border-t border-slate-100 pt-6 flex justify-end">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm"><i class="fas fa-check-circle mr-2"></i> Pay Salary</button>
        </div>
    </form>
</div>
@endsection
