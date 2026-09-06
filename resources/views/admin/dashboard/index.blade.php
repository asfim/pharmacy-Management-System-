@extends('admin.layouts.app')
@php $header = 'Dashboard'; @endphp

@section('content')

{{-- ==================== STAT CARDS ROW 1 ==================== --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    {{-- Today Sales --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Today's Sales</p>
            <div class="w-9 h-9 bg-teal-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-teal-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($todaySales, 0) }}</p>
        <p class="text-xs text-teal-600 mt-1 font-medium"><i class="fas fa-arrow-up mr-1"></i>Today's revenue</p>
    </div>

    {{-- Today Purchase --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Today's Purchase</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-cart-flatbed text-blue-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($todayPurchase, 0) }}</p>
        <p class="text-xs text-blue-600 mt-1 font-medium">Purchase cost today</p>
    </div>

    {{-- Today Profit --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Today's Profit</p>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-green-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold {{ $todayProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">৳{{ number_format($todayProfit, 0) }}</p>
        <p class="text-xs text-slate-500 mt-1">Sales - Purchase</p>
    </div>

    {{-- Monthly Sales --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Month Sales</p>
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-purple-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($monthSales, 0) }}</p>
        <p class="text-xs text-purple-600 mt-1 font-medium">This month's total</p>
    </div>
</div>

{{-- STAT CARDS ROW 2 --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Medicines</p>
            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-capsules text-indigo-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($totalMedicines) }}</p>
        <a href="{{ route('admin.medicines.index') }}" class="text-xs text-indigo-600 mt-1 font-medium hover:underline">View all →</a>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Stock Value</p>
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-warehouse text-amber-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($stockValue, 0) }}</p>
        <p class="text-xs text-slate-500 mt-1">Total inventory value</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Today Expense</p>
            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-red-500 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($todayExpense, 0) }}</p>
        <a href="{{ route('admin.expenses.index') }}" class="text-xs text-red-500 mt-1 font-medium hover:underline">View expenses →</a>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Customers Due</p>
            <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-hand-holding-dollar text-orange-600 text-sm"></i>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">৳{{ number_format($customerDue, 0) }}</p>
        <a href="{{ route('admin.customers.index') }}" class="text-xs text-orange-600 mt-1 font-medium hover:underline">Collect dues →</a>
    </div>
</div>

{{-- ALERT CARDS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <a href="{{ route('admin.stock.low') }}" class="bg-orange-50 border border-orange-200 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-box-open text-orange-600 text-lg"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-orange-700">{{ $lowStockCount }}</p>
            <p class="text-xs text-orange-600 font-medium">Low Stock Items</p>
        </div>
    </a>

    <a href="{{ route('admin.stock.expiry') }}" class="bg-red-50 border border-red-200 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-triangle-exclamation text-red-600 text-lg"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-red-700">{{ $expiredCount }}</p>
            <p class="text-xs text-red-600 font-medium">Expired Medicines</p>
        </div>
    </a>

    <a href="{{ route('admin.stock.expiry') }}" class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-clock text-yellow-600 text-lg"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-yellow-700">{{ $nearExpiryCount }}</p>
            <p class="text-xs text-yellow-600 font-medium">Near Expiry (90d)</p>
        </div>
    </a>

    <a href="{{ route('admin.orders.index') }}" class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
            <i class="fas fa-bag-shopping text-blue-600 text-lg"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-blue-700">{{ $pendingOrders }}</p>
            <p class="text-xs text-blue-600 font-medium">Pending Orders</p>
        </div>
    </a>
</div>

{{-- CHARTS ROW --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Daily Sales Chart --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-slate-800">Daily Sales (Last 7 Days)</h3>
            <span class="text-xs bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full font-medium">৳ Sales</span>
        </div>
        <canvas id="dailySalesChart" height="120"></canvas>
    </div>

    {{-- Monthly Sales vs Purchase --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-slate-800">Sales vs Purchase (6 Months)</h3>
            <div class="flex items-center gap-3 text-xs">
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-teal-500 inline-block"></span> Sales</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span> Purchase</span>
            </div>
        </div>
        <canvas id="monthlyChart" height="120"></canvas>
    </div>
</div>

{{-- ORDER STATUS + TOP MEDS + RECENT --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Order Status Card --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-800 mb-4">Online Orders Status</h3>
        <canvas id="orderStatusChart" height="200"></canvas>
        <div class="grid grid-cols-2 gap-3 mt-4">
            <div class="text-center bg-yellow-50 rounded-xl p-3">
                <p class="text-xl font-bold text-yellow-700">{{ $pendingOrders }}</p>
                <p class="text-xs text-yellow-600">Pending</p>
            </div>
            <div class="text-center bg-blue-50 rounded-xl p-3">
                <p class="text-xl font-bold text-blue-700">{{ $processingOrders }}</p>
                <p class="text-xs text-blue-600">Processing</p>
            </div>
            <div class="text-center bg-green-50 rounded-xl p-3">
                <p class="text-xl font-bold text-green-700">{{ $deliveredOrders }}</p>
                <p class="text-xs text-green-600">Delivered</p>
            </div>
            <div class="text-center bg-slate-50 rounded-xl p-3">
                <p class="text-xl font-bold text-slate-700">{{ $totalOnlineOrders }}</p>
                <p class="text-xs text-slate-600">Total</p>
            </div>
        </div>
    </div>

    {{-- Top Selling Medicines --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-800 mb-4">Top Selling Medicines</h3>
        @forelse($topMedicines as $medicine)
        <div class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-0">
            <div class="flex items-center gap-3">
                <span class="w-7 h-7 bg-teal-50 text-teal-700 rounded-lg flex items-center justify-center text-xs font-bold shrink-0">
                    {{ $loop->iteration }}
                </span>
                <span class="text-sm font-medium text-slate-700 truncate max-w-[120px]">{{ $medicine->name }}</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-slate-800">{{ number_format($medicine->total_qty) }} pcs</p>
                <p class="text-xs text-slate-400">৳{{ number_format($medicine->total_revenue, 0) }}</p>
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-8 text-slate-400">
            <i class="fas fa-chart-bar text-3xl mb-2 text-slate-200"></i>
            <p class="text-sm">No sales data yet</p>
            <a href="{{ route('admin.pos.index') }}" class="mt-2 text-xs text-teal-600 hover:underline">Create a sale →</a>
        </div>
        @endforelse
    </div>

    {{-- Quick Stats --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-800 mb-4">Quick Overview</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between py-2 border-b border-slate-50">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-users text-blue-500 w-4"></i> Total Customers
                </div>
                <span class="font-bold text-slate-800">{{ number_format($totalCustomers) }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-slate-50">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-truck text-green-500 w-4"></i> Total Suppliers
                </div>
                <span class="font-bold text-slate-800">{{ number_format($totalSuppliers) }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-slate-50">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-id-badge text-purple-500 w-4"></i> Total Employees
                </div>
                <span class="font-bold text-slate-800">{{ number_format($totalEmployees) }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-slate-50">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-box text-orange-500 w-4"></i> Out of Stock
                </div>
                <span class="font-bold text-red-600">{{ number_format($outOfStock) }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center gap-2 text-sm text-slate-600">
                    <i class="fas fa-hand-holding-dollar text-teal-500 w-4"></i> Supplier Due
                </div>
                <span class="font-bold text-slate-800">৳{{ number_format(abs($supplierDue), 0) }}</span>
            </div>
        </div>

        {{-- Quick Action Buttons --}}
        <div class="mt-5 grid grid-cols-2 gap-2">
            <a href="{{ route('admin.pos.index') }}" class="flex items-center justify-center gap-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold py-2.5 rounded-xl transition">
                <i class="fas fa-cash-register"></i> New Sale
            </a>
            <a href="{{ route('admin.purchases.create') }}" class="flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2.5 rounded-xl transition">
                <i class="fas fa-cart-flatbed"></i> Purchase
            </a>
            <a href="{{ route('admin.customers.create') }}" class="flex items-center justify-center gap-1.5 bg-slate-600 hover:bg-slate-700 text-white text-xs font-semibold py-2.5 rounded-xl transition">
                <i class="fas fa-user-plus"></i> Customer
            </a>
            <a href="{{ route('admin.medicines.create') }}" class="flex items-center justify-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-2.5 rounded-xl transition">
                <i class="fas fa-plus"></i> Medicine
            </a>
        </div>
    </div>
</div>

{{-- RECENT SALES TABLE --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">Recent Sales</h3>
            <a href="{{ route('admin.sales.index') }}" class="text-xs text-teal-600 hover:underline font-medium">View all →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Invoice</th>
                        <th class="px-5 py-3 text-left">Customer</th>
                        <th class="px-5 py-3 text-right">Amount</th>
                        <th class="px-5 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentSales as $sale)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3 font-mono text-slate-700">{{ $sale->invoice_no }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $sale->customer->name ?? 'Walk-in' }}</td>
                        <td class="px-5 py-3 text-right font-bold text-slate-800">৳{{ number_format($sale->total, 0) }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Paid</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400 text-xs">No sales yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">Recent Online Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-teal-600 hover:underline font-medium">View all →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Order #</th>
                        <th class="px-5 py-3 text-left">Customer</th>
                        <th class="px-5 py-3 text-right">Amount</th>
                        <th class="px-5 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-3 font-mono text-slate-700">{{ $order->order_no }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ $order->customer->name ?? 'Guest' }}</td>
                        <td class="px-5 py-3 text-right font-bold text-slate-800">৳{{ number_format($order->total, 0) }}</td>
                        <td class="px-5 py-3 text-center">
                            @php
                                $colors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'indigo','shipped'=>'purple','delivered'=>'green','cancelled'=>'red'];
                                $c = $colors[$order->status] ?? 'slate';
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700 capitalize">{{ $order->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400 text-xs">No online orders yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
const teal = '#14b8a6';
const blue = '#3b82f6';
const slate = '#64748b';

// Daily Sales Chart
new Chart(document.getElementById('dailySalesChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailyLabels->values()) !!},
        datasets: [{
            label: 'Sales (৳)',
            data: {!! json_encode($dailySalesData->values()) !!},
            backgroundColor: 'rgba(20,184,166,0.15)',
            borderColor: teal,
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => '৳'+v.toLocaleString() } },
            x: { grid: { display: false } }
        }
    }
});

// Monthly Sales vs Purchase
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyLabels->values()) !!},
        datasets: [
            {
                label: 'Sales',
                data: {!! json_encode($monthlySales->values()) !!},
                borderColor: teal, backgroundColor: 'rgba(20,184,166,0.1)',
                borderWidth: 2.5, fill: true, tension: 0.4, pointBackgroundColor: teal, pointRadius: 4
            },
            {
                label: 'Purchase',
                data: {!! json_encode($monthlyPurchase->values()) !!},
                borderColor: blue, backgroundColor: 'rgba(59,130,246,0.08)',
                borderWidth: 2.5, fill: true, tension: 0.4, pointBackgroundColor: blue, pointRadius: 4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => '৳'+v.toLocaleString() } },
            x: { grid: { display: false } }
        }
    }
});

// Order Doughnut Chart
new Chart(document.getElementById('orderStatusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Processing', 'Delivered'],
        datasets: [{
            data: [{{ $pendingOrders }}, {{ $processingOrders }}, {{ $deliveredOrders }}],
            backgroundColor: ['#fbbf24', '#3b82f6', '#10b981'],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        cutout: '70%',
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
