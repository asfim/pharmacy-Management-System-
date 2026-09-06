<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

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
