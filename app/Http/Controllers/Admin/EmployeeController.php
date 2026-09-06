<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $roles = ['Pharmacist','Salesman','Cashier','Manager','Accountant','Delivery Staff','Store Keeper','Branch Manager'];

    public function index()
    {
        $employees = Employee::latest()->paginate(20);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = $this->roles;
        return view('admin.employees.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'role'         => 'required|string',
            'joining_date' => 'required|date',
            'salary'       => 'required|numeric|min:0',
            'status'       => 'required|in:active,inactive',
        ]);
        Employee::create($request->all());
        return redirect()->route('admin.employees.index')->with('success', 'Employee added.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $roles = $this->roles;
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate(['name' => 'required', 'phone' => 'required', 'salary' => 'required|numeric']);
        $employee->update($request->all());
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted.');
    }
}
