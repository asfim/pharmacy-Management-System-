<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\PurchaseInvoice;
use App\Models\Product;
use App\Models\Batch;
use App\Models\Customer;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();

        $sales = Sale::with('customer')
            ->whereBetween('created_at', [$from, $to])
            ->latest()->paginate(10);

        if ($request->ajax()) {
            return view('admin.reports.partials.sales_rows', compact('sales'))->render();
        }

        $totalSales    = Sale::whereBetween('created_at', [$from, $to])->sum('total');
        $totalDiscount = Sale::whereBetween('created_at', [$from, $to])->sum('discount');
        $totalDue      = Sale::whereBetween('created_at', [$from, $to])->sum('due');

        return view('admin.reports.sales', compact('sales', 'totalSales', 'totalDiscount', 'totalDue', 'from', 'to'));
    }

    public function purchase(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();

        $purchases = PurchaseInvoice::with('supplier')
            ->whereBetween('created_at', [$from, $to])
            ->latest()->paginate(20);

        $totalPurchase = PurchaseInvoice::whereBetween('created_at', [$from, $to])->sum('total');

        return view('admin.reports.purchase', compact('purchases', 'totalPurchase', 'from', 'to'));
    }

    public function profit(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();

        $totalSales    = Sale::whereBetween('created_at', [$from, $to])->sum('total');
        $totalPurchase = PurchaseInvoice::whereBetween('created_at', [$from, $to])->sum('total');
        $totalExpense  = Expense::whereBetween('expense_date', [$from->format('Y-m-d'), $to->format('Y-m-d')])->sum('amount');
        $grossProfit   = $totalSales - $totalPurchase;
        $netProfit     = $grossProfit - $totalExpense;

        // Monthly profit data for chart
        $months = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i));
        $monthlyData = $months->map(function ($m) {
            $s = Sale::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->sum('total');
            $p = PurchaseInvoice::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->sum('total');
            $e = Expense::whereYear('expense_date', $m->year)->whereMonth('expense_date', $m->month)->sum('amount');
            return ['month' => $m->format('M Y'), 'profit' => $s - $p - $e];
        });

        return view('admin.reports.profit', compact('totalSales', 'totalPurchase', 'totalExpense', 'grossProfit', 'netProfit', 'monthlyData', 'from', 'to'));
    }

    public function stock(Request $request)
    {
        $products = Product::with('batches')->withSum('batches', 'quantity')->orderBy('name')->paginate(25);
        $totalValue = Batch::sum(DB::raw('quantity * purchase_price'));
        return view('admin.reports.stock', compact('products', 'totalValue'));
    }

    public function customers(Request $request)
    {
        $customers = Customer::withSum('sales', 'total')->orderByDesc('sales_sum_total')->paginate(20);
        return view('admin.reports.customers', compact('customers'));
    }

    public function expiry(Request $request)
    {
        $days = $request->days ?? 90;
        $batchesQuery = Batch::where('expiry_date', '<=', Carbon::now()->addDays($days))
            ->where('quantity', '>', 0);
            
        $batches = (clone $batchesQuery)
            ->with('product')
            ->orderBy('expiry_date')
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.reports.partials.expiry_rows', compact('batches'))->render();
        }

        $totalValue = $batchesQuery->sum(DB::raw('quantity * purchase_price'));
        return view('admin.reports.expiry', compact('batches', 'days', 'totalValue'));
    }

    public function financial(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->startOfMonth();
        $to   = $request->to   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();

        $totalSales    = Sale::whereBetween('created_at', [$from, $to])->sum('total');
        $totalPurchase = PurchaseInvoice::whereBetween('created_at', [$from, $to])->sum('total');
        $totalExpense  = Expense::whereBetween('expense_date', [$from->format('Y-m-d'), $to->format('Y-m-d')])->sum('amount');

        $expenseByCategory = Expense::whereBetween('expense_date', [$from->format('Y-m-d'), $to->format('Y-m-d')])
            ->join('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
            ->select('expense_categories.name as category', DB::raw('SUM(amount) as total'))
            ->groupBy('expense_categories.name')
            ->get();

        return view('admin.reports.financial', compact('totalSales', 'totalPurchase', 'totalExpense', 'expenseByCategory', 'from', 'to'));
    }
}
