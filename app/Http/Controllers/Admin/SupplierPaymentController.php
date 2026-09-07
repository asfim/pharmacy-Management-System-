<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $payments = SupplierPayment::with('supplier')->latest()->paginate(20);
        return view('admin.suppliers.payments', compact('payments'));
    }
}
