<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Batch;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $siteSettings = Setting::pluck('value', 'key')->toArray();
                View::share('siteSettings', $siteSettings);
            }
        } catch (\Exception $e) {
            // Do nothing if db is not ready
        }

        View::composer('frontend.layouts.navbar', function ($view) {
            $view->with('navCategories', \App\Models\Category::where('status', 'active')->get());
        });

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Share stock alert & notification metrics with admin layout header
        View::composer('admin.layouts.app', function ($view) {
            if (!Auth::check()) {
                return;
            }

            try {
                $today = Carbon::today();

                // 1. Expired Batches (already expired)
                $expiredBatches = Batch::with('product')
                    ->where('expiry_date', '<', $today)
                    ->where('quantity', '>', 0)
                    ->latest('expiry_date')
                    ->take(4)
                    ->get();
                $expiredCount = Batch::where('expiry_date', '<', $today)->where('quantity', '>', 0)->count();

                // 2. Near Expiry Batches (within 60 days)
                $nearExpiryBatches = Batch::with('product')
                    ->whereBetween('expiry_date', [$today, $today->copy()->addDays(60)])
                    ->where('quantity', '>', 0)
                    ->orderBy('expiry_date')
                    ->take(4)
                    ->get();
                $nearExpiryCount = Batch::whereBetween('expiry_date', [$today, $today->copy()->addDays(60)])->where('quantity', '>', 0)->count();

                // 3. Low Stock Medicines (where total stock <= min_stock or no stock)
                $lowStockProducts = Product::where('status', 'active')
                    ->where(function($q) {
                        $q->whereColumn('min_stock', '>=', DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM batches WHERE batches.product_id = products.id)'))
                          ->orWhereDoesntHave('batches', fn($b) => $b->where('quantity', '>', 0));
                    })
                    ->take(4)
                    ->get();

                $lowStockCount = Product::where('status', 'active')
                    ->where(function($q) {
                        $q->whereColumn('min_stock', '>=', DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM batches WHERE batches.product_id = products.id)'))
                          ->orWhereDoesntHave('batches', fn($b) => $b->where('quantity', '>', 0));
                    })
                    ->count();

                $totalAlertCount = $expiredCount + $nearExpiryCount + $lowStockCount;

                $view->with(compact(
                    'expiredBatches',
                    'expiredCount',
                    'nearExpiryBatches',
                    'nearExpiryCount',
                    'lowStockProducts',
                    'lowStockCount',
                    'totalAlertCount'
                ));
            } catch (\Exception $e) {
                // Safeguard against missing DB tables during setup
            }
        });
    }
}
