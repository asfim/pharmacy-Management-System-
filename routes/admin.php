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
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupplierPaymentController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SaleReturnController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerPaymentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\StockTransferController;
use App\Http\Controllers\Admin\DamageController;
use App\Http\Controllers\Admin\ExpiryController;
use App\Http\Controllers\Admin\LowStockController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BranchController;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== PRODUCTS ====================
    Route::get('categories/sample-csv', [CategoryController::class, 'sampleCsv'])->name('categories.sample-csv');
    Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');
    Route::post('categories/import-csv', [CategoryController::class, 'importCsv'])->name('categories.import-csv');
    Route::get('categories/export-csv', [CategoryController::class, 'exportCsv'])->name('categories.export-csv');
    Route::get('categories/export-pdf', [CategoryController::class, 'exportPdf'])->name('categories.export-pdf');
    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::get('generics/sample-csv', [GenericController::class, 'sampleCsv'])->name('generics.sample-csv');
    Route::post('generics/bulk-delete', [GenericController::class, 'bulkDelete'])->name('generics.bulk-delete');
    Route::post('generics/import-csv', [GenericController::class, 'importCsv'])->name('generics.import-csv');
    Route::get('generics/export-csv', [GenericController::class, 'exportCsv'])->name('generics.export-csv');
    Route::get('generics/export-pdf', [GenericController::class, 'exportPdf'])->name('generics.export-pdf');
    Route::resource('generics', GenericController::class);
    Route::resource('brands', BrandController::class);
    Route::get('manufacturers/sample-csv', [ManufacturerController::class, 'sampleCsv'])->name('manufacturers.sample-csv');
    Route::post('manufacturers/bulk-delete', [ManufacturerController::class, 'bulkDelete'])->name('manufacturers.bulk-delete');
    Route::post('manufacturers/import-csv', [ManufacturerController::class, 'importCsv'])->name('manufacturers.import-csv');
    Route::get('manufacturers/export-csv', [ManufacturerController::class, 'exportCsv'])->name('manufacturers.export-csv');
    Route::get('manufacturers/export-pdf', [ManufacturerController::class, 'exportPdf'])->name('manufacturers.export-pdf');
    Route::resource('manufacturers', ManufacturerController::class);
    Route::get('medicines/sample-csv', [MedicineController::class, 'sampleCsv'])->name('medicines.sample-csv');
    Route::post('medicines/bulk-delete', [MedicineController::class, 'bulkDelete'])->name('medicines.bulk-delete');
    Route::post('medicines/import-csv', [MedicineController::class, 'importCsv'])->name('medicines.import-csv');
    Route::get('medicines/export-csv', [MedicineController::class, 'exportCsv'])->name('medicines.export-csv');
    Route::get('medicines/export-pdf', [MedicineController::class, 'exportPdf'])->name('medicines.export-pdf');
    Route::resource('medicines', MedicineController::class);
    Route::post('batches/bulk-delete', [BatchController::class, 'bulkDelete'])->name('batches.bulk-delete');
    Route::get('batches/export-csv', [BatchController::class, 'exportCsv'])->name('batches.export-csv');
    Route::get('batches/export-pdf', [BatchController::class, 'exportPdf'])->name('batches.export-pdf');
    Route::resource('batches', BatchController::class);

    // ==================== PURCHASE ====================
    Route::resource('suppliers', SupplierController::class);
    Route::resource('supplier-payments', SupplierPaymentController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases/{purchase}/invoice', [PurchaseController::class, 'invoice'])->name('purchases.invoice');

    // ==================== SALES & POS ====================
    Route::get('pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('pos/store', [PosController::class, 'store'])->name('pos.store');
    Route::get('pos/search-medicine', [PosController::class, 'searchMedicine'])->name('pos.search');
    Route::resource('sales', SaleController::class);
    Route::get('sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    Route::resource('sale-returns', SaleReturnController::class);

    // ==================== CUSTOMERS ====================
    Route::resource('customers', CustomerController::class);
    Route::resource('customer-payments', CustomerPaymentController::class);
    Route::get('customers/{customer}/ledger', [CustomerController::class, 'ledger'])->name('customers.ledger');

    // ==================== DOCTORS & PRESCRIPTIONS ====================
    Route::resource('doctors', DoctorController::class);
    Route::resource('prescriptions', PrescriptionController::class);
    Route::post('prescriptions/{prescription}/verify', [PrescriptionController::class, 'verify'])->name('prescriptions.verify');

    // ==================== INVENTORY ====================
    Route::get('stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('stock/low', [LowStockController::class, 'index'])->name('stock.low');
    Route::get('stock/expiry', [ExpiryController::class, 'index'])->name('stock.expiry');
    Route::resource('stock-adjustments', StockAdjustmentController::class);
    Route::resource('stock-transfers', StockTransferController::class);
    Route::post('stock-transfers/{transfer}/approve', [StockTransferController::class, 'approve'])->name('stock-transfers.approve');
    Route::resource('damages', DamageController::class);

    // ==================== ACCOUNTING ====================
    Route::resource('expenses', ExpenseController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('accounts', AccountController::class);
    Route::get('accounts/{account}/statement', [AccountController::class, 'statement'])->name('accounts.statement');

    // ==================== HRM ====================
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::get('attendances/daily', [AttendanceController::class, 'daily'])->name('attendances.daily');
    Route::resource('payrolls', PayrollController::class);
    Route::get('payrolls/{payroll}/slip', [PayrollController::class, 'slip'])->name('payrolls.slip');

    // ==================== BRANCHES ====================
    Route::resource('branches', BranchController::class);

    // ==================== E-COMMERCE ORDERS ====================
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::resource('coupons', CouponController::class);

    // ==================== REPORTS ====================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('purchase', [ReportController::class, 'purchase'])->name('purchase');
        Route::get('profit', [ReportController::class, 'profit'])->name('profit');
        Route::get('stock', [ReportController::class, 'stock'])->name('stock');
        Route::get('customers', [ReportController::class, 'customers'])->name('customers');
        Route::get('expiry', [ReportController::class, 'expiry'])->name('expiry');
        Route::get('financial', [ReportController::class, 'financial'])->name('financial');
    });

    // ==================== USERS & ROLES ====================
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    // ==================== SETTINGS ====================
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/invoice', [SettingController::class, 'invoice'])->name('settings.invoice');
    Route::get('settings/pos', [SettingController::class, 'pos'])->name('settings.pos');

    // AJAX endpoints
    Route::get('ajax/subcategories', function () {
        return \App\Models\SubCategory::where('category_id', request('category_id'))->get(['id', 'name']);
    })->name('ajax.subcategories');
    Route::get('ajax/batches', function () {
        return \App\Models\Batch::where('product_id', request('product_id'))->get(['id', 'batch_no', 'expiry_date', 'quantity', 'sale_price']);
    })->name('ajax.batches');
});
