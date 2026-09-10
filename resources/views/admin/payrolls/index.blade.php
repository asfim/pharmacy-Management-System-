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

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 mb-1">Total Salary (Gross)</p>
        <h4 class="text-xl font-bold text-slate-800">৳{{ number_format($totalGross, 2) }}</h4>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 mb-1">Total Deduction</p>
        <h4 class="text-xl font-bold text-red-600">৳{{ number_format($totalDeduction, 2) }}</h4>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 mb-1">Total Paid</p>
        <h4 class="text-xl font-bold text-emerald-600">৳{{ number_format($totalPaid, 2) }}</h4>
    </div>
    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 mb-1">Total Due</p>
        <h4 class="text-xl font-bold text-amber-600">৳{{ number_format($totalDue, 2) }}</h4>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4">Employee</th>
                    <th class="px-5 py-4">Month / Year</th>
                    <th class="px-5 py-4 text-right">Gross</th>
                    <th class="px-5 py-4 text-right">Deduction</th>
                    <th class="px-5 py-4 text-right">Net Salary</th>
                    <th class="px-5 py-4 text-right">Paid</th>
                    <th class="px-5 py-4 text-right">Due</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payrolls as $pay)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $pay->employee->name ?? 'Staff' }}</td>
                    <td class="px-5 py-3.5 text-slate-600">{{ $pay->month ?? '' }}</td>
                    <td class="px-5 py-3.5 text-right font-medium text-slate-700">৳{{ number_format(($pay->basic_salary + $pay->allowance + $pay->bonus), 2) }}</td>
                    <td class="px-5 py-3.5 text-right font-medium text-red-600">৳{{ number_format($pay->deductions, 2) }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($pay->net_salary ?? 0, 2) }}</td>
                    @php
                        $paidAmount = $pay->salary_payments->sum('amount');
                        $dueAmount = $pay->net_salary - $paidAmount;
                    @endphp
                    <td class="px-5 py-3.5 text-right font-medium text-emerald-600">৳{{ number_format($paidAmount, 2) }}</td>
                    <td class="px-5 py-3.5 text-right font-medium text-amber-600">৳{{ number_format($dueAmount, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $pay->status == 'paid' ? 'bg-green-100 text-green-800' : ($pay->status == 'partial' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                            {{ $pay->status ?? 'paid' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        @if($dueAmount > 0)
                        <button onclick="openPayModal({{ $pay->id }}, {{ $dueAmount }})" class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            <i class="fas fa-money-bill-wave"></i> Pay Due
                        </button>
                        @else
                        <span class="text-xs text-slate-400">Settled</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-5 py-12 text-center text-slate-400">
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

<!-- Pay Due Modal -->
<div id="payModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Pay Payroll Due</h3>
            <button onclick="closePayModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.payrolls.payDue') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="payroll_id" id="modal_payroll_id">
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Account *</label>
                <select name="account_id" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Select Account --</option>
                    @foreach(\App\Models\Account::where('status', 'active')->get() as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->name }} (Bal: ৳{{ $acc->current_balance }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Additional Deduction (৳)</label>
                <input type="number" step="0.01" name="additional_deduction" id="modal_deduction" value="0" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 text-red-600">
                <p class="text-xs text-slate-500 mt-1">Leave 0 if no extra deduction.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pay Amount (৳) *</label>
                <input type="number" step="0.01" name="amount" id="modal_amount" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 font-bold text-emerald-600">
                <p class="text-xs text-slate-500 mt-1">Maximum payable: ৳<span id="max_due_display"></span></p>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closePayModal()" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 border border-slate-200 rounded-xl transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 rounded-xl transition shadow-sm">Confirm Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentDue = 0;
    
    function openPayModal(id, due) {
        document.getElementById('modal_payroll_id').value = id;
        document.getElementById('modal_amount').value = due;
        document.getElementById('modal_amount').max = due;
        document.getElementById('modal_deduction').value = 0;
        document.getElementById('max_due_display').innerText = parseFloat(due).toFixed(2);
        currentDue = due;
        
        document.getElementById('payModal').classList.remove('hidden');
    }

    function closePayModal() {
        document.getElementById('payModal').classList.add('hidden');
    }

    document.getElementById('modal_deduction').addEventListener('input', function() {
        const ded = parseFloat(this.value) || 0;
        let newMax = currentDue - ded;
        if(newMax < 0) newMax = 0;
        
        document.getElementById('max_due_display').innerText = newMax.toFixed(2);
        document.getElementById('modal_amount').max = newMax;
        if(parseFloat(document.getElementById('modal_amount').value) > newMax) {
            document.getElementById('modal_amount').value = newMax;
        }
    });
</script>
@endpush
