<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::latest()->paginate(20);
        return view('admin.stock.adjustments', compact('adjustments'));
    }
}
