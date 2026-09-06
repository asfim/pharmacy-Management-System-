<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('purchaseInvoices')->latest()->paginate(20);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name'   => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string',
            'opening_balance'=> 'nullable|numeric',
            'credit_limit'   => 'nullable|numeric',
            'payment_terms'  => 'nullable|string|max:255',
            'status'         => 'required|in:active,inactive',
        ]);

        Supplier::create($data);
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier added successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'company_name'   => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string',
            'opening_balance'=> 'nullable|numeric',
            'credit_limit'   => 'nullable|numeric',
            'payment_terms'  => 'nullable|string|max:255',
            'status'         => 'required|in:active,inactive',
        ]);

        $supplier->update($data);
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('purchaseInvoices');
        return view('admin.suppliers.show', compact('supplier'));
    }
}
