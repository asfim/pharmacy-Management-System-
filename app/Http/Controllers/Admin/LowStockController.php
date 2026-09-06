<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LowStockController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
            ->withSum('batches', 'quantity')
            ->havingRaw('COALESCE(batches_sum_quantity, 0) <= COALESCE(min_stock, 0)')
            ->orderBy('name')
            ->paginate(25);
        return view('admin.stock.low', compact('products'));
    }
}
