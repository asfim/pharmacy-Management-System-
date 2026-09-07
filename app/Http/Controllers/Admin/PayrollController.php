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

    public function slip(Payroll $payroll)
    {
        return view('admin.payrolls.index', compact('payroll'));
    }
}
