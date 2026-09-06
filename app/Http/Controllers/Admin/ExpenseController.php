<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Account;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function index()
    {
        $expenses = Expense::latest()->paginate(20);
        $total = Expense::sum('amount');
        return view('admin.expenses.index', compact('expenses', 'total'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        $accounts = Account::where('status', 'active')->get();
        return view('admin.expenses.create', compact('categories', 'accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:expense_categories,id',
            'account_id'     => 'required|exists:accounts,id',
            'amount'         => 'required|numeric|min:0',
            'expense_date'   => 'required|date',
            'description'    => 'nullable|string',
        ]);
        Expense::create($request->all());
        return redirect()->route('admin.expenses.index')->with('success', 'Expense recorded.');
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::where('status', 'active')->get();
        $accounts = Account::where('status', 'active')->get();
        return view('admin.expenses.edit', compact('expense', 'categories', 'accounts'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id'    => 'required|exists:expense_categories,id',
            'account_id'     => 'required|exists:accounts,id',
            'amount'         => 'required|numeric|min:0',
            'expense_date'   => 'required|date',
            'description'    => 'nullable|string',
        ]);
        $expense->update($request->all());
        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted.');
    }

    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }
}
