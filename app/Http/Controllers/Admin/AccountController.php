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
            'account_name' => 'required|string|max:255',
            'opening_balance' => 'nullable|numeric',
        ]);
        Account::create($request->all());
        return redirect()->route('admin.accounts.index')->with('success', 'Account created successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account deleted successfully.');
    }
}
