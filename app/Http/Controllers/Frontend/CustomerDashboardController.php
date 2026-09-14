<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OnlineOrder;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Find linked customer record by email
        $customer = Customer::where('email', $user->email)->first();

        $totalOrders     = 0;
        $totalSpent      = 0;
        $pendingOrders   = 0;
        $deliveredOrders = 0;
        $recentOrders    = collect();
        $monthlySpending = [];

        if ($customer) {
            $totalOrders     = OnlineOrder::where('customer_id', $customer->id)->count();
            $totalSpent      = OnlineOrder::where('customer_id', $customer->id)->sum('total');
            $pendingOrders   = OnlineOrder::where('customer_id', $customer->id)->where('status', 'pending')->count();
            $deliveredOrders = OnlineOrder::where('customer_id', $customer->id)->where('status', 'delivered')->count();

            $recentOrders = OnlineOrder::where('customer_id', $customer->id)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            // Last 6 months spending for chart
            $monthlySpending = OnlineOrder::where('customer_id', $customer->id)
                ->where('created_at', '>=', Carbon::now()->subMonths(6))
                ->selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, SUM(total) as total")
                ->groupBy('month')
                ->orderBy('created_at')
                ->pluck('total', 'month');
        }

        // Build last 6 months labels
        $labels  = [];
        $amounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M Y');
            $labels[]  = $month;
            $amounts[] = $monthlySpending[$month] ?? 0;
        }

        return view('frontend.customer.dashboard', compact(
            'user', 'customer', 'totalOrders', 'totalSpent',
            'pendingOrders', 'deliveredOrders', 'recentOrders',
            'labels', 'amounts'
        ));
    }
}
