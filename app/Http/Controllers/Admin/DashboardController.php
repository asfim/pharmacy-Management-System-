<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Batch;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\PurchaseInvoice;
use App\Models\OnlineOrder;
use App\Models\Expense;
use App\Models\Employee;
use App\Models\StockBalance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Sales Stats
        $todaySales     = Sale::whereDate('created_at', $today)->sum('total') ?? 0;
        $todayPurchase  = PurchaseInvoice::whereDate('created_at', $today)->sum('total') ?? 0;
        $todayProfit    = $todaySales - $todayPurchase;
        $monthSales     = Sale::where('created_at', '>=', $thisMonth)->sum('total') ?? 0;

        // Counts
        $totalMedicines  = Product::where('status', 'active')->count();
        $totalCustomers  = Customer::count();
        $totalSuppliers  = Supplier::count();
        $totalEmployees  = Employee::count();

        // Due amounts
        $customerDue    = Customer::sum('opening_balance') ?? 0;
        $supplierDue    = Supplier::where('opening_balance', '<', 0)->sum('opening_balance') ?? 0;
        $todayExpense   = Expense::whereDate('expense_date', $today)->sum('amount') ?? 0;

        // Inventory alerts
        $lowStockCount  = Product::whereColumn('min_stock', '>', DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM batches WHERE batches.product_id = products.id)'))->count();
        $outOfStock     = Product::where('status', 'active')
                            ->whereDoesntHave('batches', fn($q) => $q->where('quantity', '>', 0))
                            ->count();

        // Expiry alerts
        $expiredCount   = Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->count();
        $nearExpiryCount = Batch::whereBetween('expiry_date', [$today, $today->copy()->addDays(90)])->where('quantity', '>', 0)->count();

        // Online Orders
        $pendingOrders  = OnlineOrder::where('status', 'pending')->count();
        $processingOrders = OnlineOrder::where('status', 'processing')->count();
        $deliveredOrders = OnlineOrder::where('status', 'delivered')->count();
        $totalOnlineOrders = OnlineOrder::count();

        // Stock Value
        $stockValue     = Batch::sum(DB::raw('quantity * purchase_price')) ?? 0;

        // Chart: Last 7 days sales
        $last7Days      = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i)->format('Y-m-d'));
        $dailySalesData = $last7Days->map(function ($date) {
            return Sale::whereDate('created_at', $date)->sum('total') ?? 0;
        });
        $dailyLabels    = $last7Days->map(fn($d) => Carbon::parse($d)->format('d M'));

        // Chart: Last 6 months
        $last6Months    = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i));
        $monthlySales   = $last6Months->map(fn($m) => Sale::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->sum('total') ?? 0);
        $monthlyPurchase = $last6Months->map(fn($m) => PurchaseInvoice::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->sum('total') ?? 0);
        $monthlyLabels  = $last6Months->map(fn($m) => $m->format('M Y'));

        // Top 5 selling medicines
        $topMedicines = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_qty'), DB::raw('SUM(sale_items.total) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Recent sales
        $recentSales = Sale::with('customer')->latest()->limit(5)->get();

        // Recent online orders
        $recentOrders = OnlineOrder::with('customer')->latest()->limit(5)->get();

        return view('admin.dashboard.index', compact(
            'todaySales', 'todayPurchase', 'todayProfit', 'monthSales',
            'totalMedicines', 'totalCustomers', 'totalSuppliers', 'totalEmployees',
            'customerDue', 'supplierDue', 'todayExpense',
            'lowStockCount', 'outOfStock', 'expiredCount', 'nearExpiryCount',
            'pendingOrders', 'processingOrders', 'deliveredOrders', 'totalOnlineOrders',
            'stockValue',
            'dailySalesData', 'dailyLabels',
            'monthlySales', 'monthlyPurchase', 'monthlyLabels',
            'topMedicines', 'recentSales', 'recentOrders'
        ));
    }
}
