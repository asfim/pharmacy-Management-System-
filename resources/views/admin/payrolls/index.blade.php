@extends('admin.layouts.app')
@php $header = 'Payroll & Salaries'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Payroll & Salary Sheets</h2>
        <p class="text-sm text-slate-500 mt-1">Employee monthly salary disbursements</p>
    </div>
    <a href="{{ route('admin.payrolls.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
        <i class="fas fa-plus"></i> Pay Salary
    </a>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Employee</th>
                    <th class="px-5 py-4">Month / Year</th>
                    <th class="px-5 py-4 text-right">Net Salary</th>
                    <th class="px-5 py-4">Payment Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payrolls as $pay)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $pay->employee->name ?? 'Staff' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $pay->month ?? '' }} {{ $pay->year ?? '' }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($pay->net_salary ?? 0, 2) }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                            {{ $pay->status ?? 'paid' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-400">
                        <i class="fas fa-file-invoice-dollar text-3xl mb-2 block"></i>
                        No payroll records generated yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($payrolls, 'hasPages') && $payrolls->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $payrolls->links() }}</div>
    @endif
</div>
@endsection
