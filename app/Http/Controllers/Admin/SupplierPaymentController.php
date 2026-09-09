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

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_id' => 'nullable|exists:purchase_invoices,id',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date'
        ]);

        SupplierPayment::create($request->all());

        if ($request->purchase_id) {
            $purchase = \App\Models\PurchaseInvoice::find($request->purchase_id);
            $purchase->paid += $request->amount;
            $purchase->due = $purchase->total - $purchase->paid;
            if ($purchase->due <= 0) {
                $purchase->status = 'received'; // or paid
            }
            $purchase->save();
        }

        // Also update account balance
        $account = \App\Models\Account::find($request->account_id);
        $account->current_balance -= $request->amount;
        $account->save();

        return back()->with('success', 'Payment recorded successfully.');
    }
}
