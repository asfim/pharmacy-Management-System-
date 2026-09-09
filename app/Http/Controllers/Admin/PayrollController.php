<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->paginate(20);
        return view('admin.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = \App\Models\Employee::where('status', 'active')->get();
        $accounts = \App\Models\Account::where('status', 'active')->get();
        return view('admin.payrolls.create', compact('employees', 'accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string',
            'account_id' => 'required|exists:accounts,id',
            'basic_salary' => 'required|numeric',
            'allowance' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
        ]);

        $employee = \App\Models\Employee::find($request->employee_id);
        
        $basic = $request->basic_salary;
        $allowance = $request->allowance ?? 0;
        $bonus = $request->bonus ?? 0;
        $deductions = $request->deductions ?? 0;
        $net_salary = ($basic + $allowance + $bonus) - $deductions;

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $employee, $net_salary) {
            $payroll = Payroll::create([
                'employee_id' => $request->employee_id,
                'branch_id' => $employee->branch_id,
                'month' => $request->month,
                'basic_salary' => $request->basic_salary,
                'allowance' => $request->allowance ?? 0,
                'bonus' => $request->bonus ?? 0,
                'deductions' => $request->deductions ?? 0,
                'net_salary' => $net_salary,
                'status' => 'paid',
            ]);

            \App\Models\SalaryPayment::create([
                'payroll_id' => $payroll->id,
                'account_id' => $request->account_id,
                'amount' => $net_salary,
                'payment_date' => now(),
            ]);

            // Auto-create or find Salary expense category
            $salaryCategory = \App\Models\ExpenseCategory::firstOrCreate(
                ['name' => 'Salary'],
                ['status' => 'active']
            );

            // Record as an Expense
            \App\Models\Expense::create([
                'branch_id' => $employee->branch_id,
                'category_id' => $salaryCategory->id,
                'account_id' => $request->account_id,
                'amount' => $net_salary,
                'expense_date' => now(),
                'description' => "Salary payment for {$employee->name} (Month: {$request->month})",
            ]);

            $account = \App\Models\Account::find($request->account_id);
            $account->current_balance -= $net_salary;
            $account->save();
        });

        return redirect()->route('admin.payrolls.index')->with('success', 'Salary payment recorded successfully.');
    }
}
