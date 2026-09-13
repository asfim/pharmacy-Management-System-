<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LowStockController extends Controller
{
    public function index()
    {
        $selectedBranchId = session('selected_branch_id');
        $userBranchId = auth()->user()->branch_id ?? null;
        $activeBranchId = (!empty($userBranchId) && !auth()->user()->hasRole('Super Admin'))
            ? $userBranchId
            : (($selectedBranchId && $selectedBranchId !== 'all') ? $selectedBranchId : null);

        if ($activeBranchId) {
            $stockSub = DB::table('stock_balances')
                ->selectRaw('COALESCE(SUM(qty_on_hand), 0)')
                ->whereColumn('stock_balances.product_id', 'products.id')
                ->where('stock_balances.branch_id', $activeBranchId);

            $query = Product::where('status', 'active')
                ->select('products.*')
                ->selectSub($stockSub, 'current_stock')
                ->with(['category', 'brand', 'generic', 'unit'])
                ->where(function ($q) use ($activeBranchId) {
                    $q->whereColumn('min_stock', '>', DB::raw("(SELECT COALESCE(SUM(qty_on_hand), 0) FROM stock_balances WHERE stock_balances.product_id = products.id AND stock_balances.branch_id = {$activeBranchId})"))
                      ->orWhereRaw("(SELECT COALESCE(SUM(qty_on_hand), 0) FROM stock_balances WHERE stock_balances.product_id = products.id AND stock_balances.branch_id = {$activeBranchId}) <= 0");
                });
        } else {
            $stockSub = DB::table('batches')
                ->selectRaw('COALESCE(SUM(quantity), 0)')
                ->whereColumn('batches.product_id', 'products.id');

            $query = Product::where('status', 'active')
                ->select('products.*')
                ->selectSub($stockSub, 'current_stock')
                ->with(['category', 'brand', 'generic', 'unit'])
                ->where(function ($q) {
                    $q->whereColumn('min_stock', '>', DB::raw("(SELECT COALESCE(SUM(quantity), 0) FROM batches WHERE batches.product_id = products.id)"))
                      ->orWhereRaw("(SELECT COALESCE(SUM(quantity), 0) FROM batches WHERE batches.product_id = products.id) <= 0");
                });
        }

        $products = $query->orderBy('name')->paginate(25);

        return view('admin.stock.low', compact('products'));
    }
}
