<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::latest()->paginate(20);
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'opening_balance' => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['branch_id'] = auth()->user()->branch_id ?? 1;
        $data['type'] = !empty($request->bank_name) ? 'bank' : 'cash';
        
        if (!empty($data['opening_balance'])) {
            $data['current_balance'] = $data['opening_balance'];
        }

        Account::create($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Account created successfully.');
    }

    public function edit(Account $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'opening_balance' => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['type'] = !empty($request->bank_name) ? 'bank' : 'cash';
        
        $account->update($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account deleted successfully.');
    }
}
