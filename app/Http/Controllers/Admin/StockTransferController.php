<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockTransfer;
use Illuminate\Http\Request;

class StockTransferController extends Controller
{
    public function index()
    {
        $transfers = StockTransfer::latest()->paginate(20);
        return view('admin.stock.transfers', compact('transfers'));
    }

    public function approve(StockTransfer $transfer)
    {
        return redirect()->back()->with('success', 'Transfer approved.');
    }
}
