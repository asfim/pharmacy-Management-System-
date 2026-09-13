<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->get('search', '');
        $perPageRaw = $request->get('per_page', 50);
        $perPage    = $perPageRaw === 'all' ? PHP_INT_MAX : (int) $perPageRaw;

        $selectedBranchId = session('selected_branch_id');
        $userBranchId = auth()->user()->branch_id ?? (auth()->user()->employee->branch_id ?? null);
        $activeBranchId = (!empty($userBranchId) && !auth()->user()->hasRole('Super Admin')) 
            ? $userBranchId 
            : (($selectedBranchId && $selectedBranchId !== 'all') ? $selectedBranchId : null);

        $subQuery = \Illuminate\Support\Facades\DB::table('stock_balances')
            ->selectRaw('COALESCE(SUM(qty_on_hand), 0)')
            ->whereColumn('stock_balances.product_id', 'products.id');

        if ($activeBranchId) {
            $subQuery->where('stock_balances.branch_id', $activeBranchId);
        }

        $stocks = Product::where('status', 'active')
            ->with('category')
            ->select('products.*')
            ->selectSub($subQuery, 'batches_sum_quantity')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('strength', 'like', "%{$search}%")
                ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$search}%")))
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

        if ($request->ajax()) {
            $html = view('admin.stock.partials.table_rows', compact('stocks'))->render();
            return response()->json([
                'html'           => $html,
                'count'          => $stocks->count(),
                'total'          => $stocks->total(),
                'has_more_pages' => $stocks->hasMorePages(),
                'next_page'      => $stocks->currentPage() + 1,
            ]);
        }

        return view('admin.stock.index', compact('stocks', 'perPageRaw'));
    }
}
