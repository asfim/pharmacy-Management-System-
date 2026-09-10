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

        // Summaries
        $totalGross = Payroll::sum('basic_salary') + Payroll::sum('allowance') + Payroll::sum('bonus');
        $totalDeduction = Payroll::sum('deductions');
        $totalNetSalary = Payroll::sum('net_salary');
        $totalPaid = \App\Models\SalaryPayment::sum('amount');
        $totalDue = $totalNetSalary - $totalPaid;

        return view('admin.payrolls.index', compact('payrolls', 'totalGross', 'totalDeduction', 'totalNetSalary', 'totalPaid', 'totalDue'));
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
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $employee = \App\Models\Employee::find($request->employee_id);
        
        $basic = $request->basic_salary;
        $allowance = $request->allowance ?? 0;
        $bonus = $request->bonus ?? 0;
        $deductions = $request->deductions ?? 0;
        $net_salary = ($basic + $allowance + $bonus) - $deductions;
        $paid_amount = $request->paid_amount;

        $status = 'paid';
        if ($paid_amount == 0) {
            $status = 'pending';
        } elseif ($paid_amount < $net_salary) {
            $status = 'partial';
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $employee, $net_salary, $paid_amount, $status) {
            $payroll = Payroll::create([
                'employee_id' => $request->employee_id,
                'branch_id' => $employee->branch_id,
                'month' => $request->month,
                'basic_salary' => $request->basic_salary,
                'allowance' => $request->allowance ?? 0,
                'bonus' => $request->bonus ?? 0,
                'deductions' => $request->deductions ?? 0,
                'net_salary' => $net_salary,
                'status' => $status,
            ]);

            if ($paid_amount > 0) {
                \App\Models\SalaryPayment::create([
                    'payroll_id' => $payroll->id,
                    'account_id' => $request->account_id,
                    'amount' => $paid_amount,
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
                    'amount' => $paid_amount,
                    'expense_date' => now(),
                    'description' => "Salary payment for {$employee->name} (Month: {$request->month})",
                ]);

                $account = \App\Models\Account::find($request->account_id);
                $account->current_balance -= $paid_amount;
                $account->save();
            }
        });

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll recorded successfully.');
    }

    public function payDue(Request $request)
    {
        $request->validate([
            'payroll_id' => 'required|exists:payroll,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'additional_deduction' => 'nullable|numeric|min:0',
        ]);

        $payroll = Payroll::with('employee')->findOrFail($request->payroll_id);
        $paid_so_far = \App\Models\SalaryPayment::where('payroll_id', $payroll->id)->sum('amount');
        
        $additional_deduction = $request->additional_deduction ?? 0;
        $amount_to_pay = $request->amount;

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $payroll, $paid_so_far, $additional_deduction, $amount_to_pay) {
            
            // If there's an additional deduction, update the payroll's net_salary and deductions
            if ($additional_deduction > 0) {
                $payroll->deductions += $additional_deduction;
                $payroll->net_salary -= $additional_deduction;
            }

            // Create Salary Payment
            \App\Models\SalaryPayment::create([
                'payroll_id' => $payroll->id,
                'account_id' => $request->account_id,
                'amount' => $amount_to_pay,
                'payment_date' => now(),
            ]);

            // Auto-create or find Salary expense category
            $salaryCategory = \App\Models\ExpenseCategory::firstOrCreate(
                ['name' => 'Salary'],
                ['status' => 'active']
            );

            // Record as an Expense
            \App\Models\Expense::create([
                'branch_id' => $payroll->branch_id,
                'category_id' => $salaryCategory->id,
                'account_id' => $request->account_id,
                'amount' => $amount_to_pay,
                'expense_date' => now(),
                'description' => "Due Salary payment for {$payroll->employee->name} (Month: {$payroll->month})",
            ]);

            // Deduct from Account
            $account = \App\Models\Account::find($request->account_id);
            $account->current_balance -= $amount_to_pay;
            $account->save();

            // Update Payroll Status
            $new_paid_total = $paid_so_far + $amount_to_pay;
            if ($new_paid_total >= $payroll->net_salary) {
                $payroll->status = 'paid';
            } else {
                $payroll->status = 'partial';
            }
            $payroll->save();
        });

        return redirect()->route('admin.payrolls.index')->with('success', 'Due payment recorded successfully.');
    }
}
