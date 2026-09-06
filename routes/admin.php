<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\GenericController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\BatchController;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products & Inventory Foundations (Phase 3)
    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('generics', GenericController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('manufacturers', ManufacturerController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('batches', BatchController::class);
});
