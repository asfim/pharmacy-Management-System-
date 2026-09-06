<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $categories = ['Shop Rent','Electricity','Internet','Salary','Transport','Delivery','Maintenance','Marketing','Others'];

    public function index()
    {
        $expenses = Expense::latest()->paginate(20);
        $total = Expense::sum('amount');
        return view('admin.expenses.index', compact('expenses', 'total'));
    }

    public function create()
    {
        $categories = $this->categories;
        return view('admin.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'       => 'required|string',
            'amount'         => 'required|numeric|min:0',
            'expense_date'   => 'required|date',
            'payment_method' => 'required|string',
            'description'    => 'nullable|string',
        ]);
        Expense::create($request->all());
        return redirect()->route('admin.expenses.index')->with('success', 'Expense recorded.');
    }

    public function edit(Expense $expense)
    {
        $categories = $this->categories;
        return view('admin.expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
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
