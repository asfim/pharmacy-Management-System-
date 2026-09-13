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

        $query = Product::where('status', 'active')
            ->with(['category', 'brand', 'generic', 'unit'])
            ->withSum('batches', 'quantity');

        if ($activeBranchId) {
            $query->where(function ($q) use ($activeBranchId) {
                $q->whereColumn('min_stock', '>=', DB::raw("(SELECT COALESCE(SUM(qty_on_hand), 0) FROM stock_balances WHERE stock_balances.product_id = products.id AND stock_balances.branch_id = {$activeBranchId})"))
                  ->orWhereDoesntHave('batches', fn($b) => $b->where('quantity', '>', 0));
            });
        } else {
            $query->where(function ($q) {
                $q->whereColumn('min_stock', '>=', DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM batches WHERE batches.product_id = products.id)'))
                  ->orWhereDoesntHave('batches', fn($b) => $b->where('quantity', '>', 0));
            });
        }

        $products = $query->orderBy('name')->paginate(25);

        return view('admin.stock.low', compact('products'));
    }
}
