<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
{
    public function index()
    {
        $payments = CustomerPayment::with('customer')->latest()->paginate(20);
        return view('admin.customers.payments', compact('payments'));
    }
}
