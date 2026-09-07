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

        $stocks = Product::where('status', 'active')
            ->withSum('batches', 'quantity')
            ->with('category')
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
