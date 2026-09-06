<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Product::where('status', 'active')
            ->with('batches')
            ->withSum('batches', 'quantity')
            ->orderBy('name')
            ->paginate(25);
        return view('admin.stock.index', compact('stocks'));
    }
}

class LowStockController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->withSum('batches', 'quantity')
            ->havingRaw('COALESCE(batches_sum_quantity, 0) <= min_stock')
            ->orderBy('name')
            ->paginate(25);
        return view('admin.stock.low', compact('products'));
    }
}

class ExpiryController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $expired = Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->with('product')->latest('expiry_date')->paginate(15, ['*'], 'expired_page');
        $near90  = Batch::whereBetween('expiry_date', [$today, $today->copy()->addDays(90)])->where('quantity', '>', 0)->with('product')->orderBy('expiry_date')->paginate(15, ['*'], 'near_page');
        return view('admin.stock.expiry', compact('expired', 'near90'));
    }
}
