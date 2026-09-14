<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CustomerDashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category}', [HomeController::class, 'categoryProducts'])->name('category.products');
Route::get('/product/{product}', [HomeController::class, 'productDetail'])->name('product.detail');

// Cart & Checkout
Route::post('/cart/add', [\App\Http\Controllers\Frontend\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [\App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [\App\Http\Controllers\Frontend\CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [\App\Http\Controllers\Frontend\CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place-order', [\App\Http\Controllers\Frontend\CartController::class, 'placeOrder'])->name('checkout.place');
Route::get('/order-success/{order}', [\App\Http\Controllers\Frontend\CartController::class, 'orderSuccess'])->name('order.success');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/customer/orders', [CustomerDashboardController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/prescriptions', [CustomerDashboardController::class, 'prescriptions'])->name('customer.prescriptions');
    Route::get('/customer/profile', [CustomerDashboardController::class, 'profile'])->name('customer.profile');
    Route::get('/customer/addresses', [CustomerDashboardController::class, 'addresses'])->name('customer.addresses');
    Route::get('/customer/security', [CustomerDashboardController::class, 'security'])->name('customer.security');
});
