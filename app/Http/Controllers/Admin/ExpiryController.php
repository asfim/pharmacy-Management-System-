<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Carbon\Carbon;

class ExpiryController extends Controller
{
    public function index()
    {
        $today   = Carbon::today();
        $expired = Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->with('product')->latest('expiry_date')->paginate(15, ['*'], 'expired_page');
        $near90  = Batch::whereBetween('expiry_date', [$today, $today->copy()->addDays(90)])->where('quantity', '>', 0)->with('product')->orderBy('expiry_date')->paginate(15, ['*'], 'near_page');
        return view('admin.stock.expiry', compact('expired', 'near90'));
    }
}
