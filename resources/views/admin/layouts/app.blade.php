<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($header) ? $header . ' — ' : '' }}{{ isset($siteSettings['site_title']) && $siteSettings['site_title'] ? $siteSettings['site_title'] : config('app.name', 'PharmaSys') }}</title>

    <!-- Favicon -->
    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E💊%3C/text%3E%3C/svg%3E">
    @endif

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.15s ease;
            margin-bottom: 2px;
            color: #94a3b8;
            text-decoration: none;
            gap: 0.75rem;
        }

        .sidebar-link:hover {
            background-color: #1e293b;
            color: #fff;
        }

        .sidebar-link.active {
            background-color: #0d9488;
            color: #fff;
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            flex-shrink: 0;
            font-size: 0.875rem;
        }

        .sidebar-section {
            padding: 1.25rem 1rem 0.375rem;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #475569;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-100 antialiased" x-data="{ sidebarOpen: true, dropdownOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ==================== SIDEBAR ==================== -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 shadow-2xl flex flex-col transition-transform duration-300 ease-in-out"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo -->
            <div
                class="flex items-center justify-between h-16 px-4 bg-slate-950 border-b border-slate-800 flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-pills text-white" style="font-size:14px;"></i>
                    </div>
                    <span class="text-white font-bold text-base tracking-wide">Pharma<span
                            class="text-teal-400">Sys</span></span>
                </a>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-3 px-3">

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-gauge-high"></i>
                    <span>Dashboard</span>
                </a>

                <!-- PRODUCTS -->
                <p class="sidebar-section">Products</p>

                @can('view medicines')
                    <a href="{{ route('admin.medicines.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.medicines*') ? 'active' : '' }}">
                        <i class="fas fa-capsules"></i>
                        <span>Medicines</span>
                    </a>
                @endcan
                @can('view categories')
                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group"></i>
                        <span>Categories</span>
                    </a>
                @endcan
                @can('view generics')
                    <a href="{{ route('admin.generics.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.generics*') ? 'active' : '' }}">
                        <i class="fas fa-dna"></i>
                        <span>Generics</span>
                    </a>
                @endcan
                @can('view manufacturers')
                    <a href="{{ route('admin.manufacturers.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.manufacturers*') ? 'active' : '' }}">
                        <i class="fas fa-industry"></i>
                        <span>Manufacturers</span>
                    </a>
                @endcan

                <!-- INVENTORY -->
                <p class="sidebar-section">Inventory</p>

                @can('view batches')
                    <a href="{{ route('admin.batches.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.batches*') ? 'active' : '' }}">
                        <i class="fas fa-boxes-stacked"></i>
                        <span>Batches & Expiry</span>
                    </a>
                @endcan
                @can('view stock')
                    <a href="{{ route('admin.stock.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.stock*') ? 'active' : '' }}">
                        <i class="fas fa-warehouse"></i>
                        <span>Stock & Inventory</span>
                    </a>
                @endcan

                <!-- SALES & POS -->
                <p class="sidebar-section">Sales & POS</p>

                @can('view pos')
                    <a href="{{ route('admin.pos.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.pos*') ? 'active' : '' }}">
                        <i class="fas fa-cash-register"></i>
                        <span>POS System</span>
                    </a>
                @endcan
                @can('view sales')
                    <a href="{{ route('admin.sales.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.sales*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Sales Invoices</span>
                    </a>
                @endcan
                @can('view sale_returns')
                    <a href="{{ route('admin.sale-returns.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.sale-returns*') ? 'active' : '' }}">
                        <i class="fas fa-rotate-left"></i>
                        <span>Sales Returns</span>
                    </a>
                @endcan
                @can('view orders')
                    <a href="{{ route('admin.orders.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        <i class="fas fa-bag-shopping"></i>
                        <span>Online Orders</span>
                    </a>
                @endcan

                <!-- PROCUREMENT -->
                <p class="sidebar-section">Procurement</p>

                @can('view purchases')
                    <a href="{{ route('admin.purchases.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.purchases*') ? 'active' : '' }}">
                        <i class="fas fa-cart-flatbed"></i>
                        <span>Purchases</span>
                    </a>
                @endcan
                @can('view suppliers')
                    <a href="{{ route('admin.suppliers.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.suppliers*') ? 'active' : '' }}">
                        <i class="fas fa-truck"></i>
                        <span>Suppliers</span>
                    </a>
                @endcan

                <!-- MANAGEMENT -->
                <p class="sidebar-section">Management</p>

                @can('view customers')
                    <a href="{{ route('admin.customers.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Customers</span>
                    </a>
                @endcan
                @can('view doctors')
                    <a href="{{ route('admin.doctors.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.doctors*') ? 'active' : '' }}">
                        <i class="fas fa-user-doctor"></i>
                        <span>Doctors</span>
                    </a>
                @endcan
                @can('view employees')
                    <a href="{{ route('admin.employees.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                        <i class="fas fa-id-card"></i>
                        <span>Employees</span>
                    </a>
                @endcan
                @can('view employees')
                    <a href="{{ route('admin.payrolls.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.payrolls*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Payroll</span>
                    </a>
                @endcan
                @can('view accounts')
                    <a href="{{ route('admin.accounts.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.accounts*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Accounts & Finance</span>
                    </a>
                @endcan
                @can('view expenses')
                    <a href="{{ route('admin.expenses.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.expenses*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Expenses</span>
                    </a>
                @endcan
                @can('view branches')
                    <a href="{{ route('admin.branches.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.branches*') ? 'active' : '' }}">
                        <i class="fas fa-code-branch"></i>
                        <span>Branches</span>
                    </a>
                @endcan

                <!-- REPORTS -->
                <p class="sidebar-section">Reports</p>

                @can('view reports')
                    <a href="{{ route('admin.reports.sales') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Sales Report</span>
                    </a>
                    <a href="{{ route('admin.reports.profit') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reports.profit') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-trend-up"></i>
                        <span>Profit & Loss</span>
                    </a>
                    <a href="{{ route('admin.reports.expiry') }}"
                        class="sidebar-link {{ request()->routeIs('admin.reports.expiry') ? 'active' : '' }}">
                        <i class="fas fa-calendar-xmark"></i>
                        <span>Expiry Report</span>
                    </a>
                @endcan

                <!-- ADMIN -->
                <p class="sidebar-section">Admin</p>

                @can('view users')
                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users-gear"></i>
                        <span>Users Management</span>
                    </a>
                @endcan
                @can('view roles')
                    <a href="{{ route('admin.roles.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Roles & Permissions</span>
                    </a>
                @endcan
                @can('view settings')
                    <a href="{{ route('admin.settings.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="fas fa-gear"></i>
                        <span>Settings</span>
                    </a>
                @endcan
                <a href="{{ route('admin.sliders.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span>Sliders (CMS)</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="px-3 py-3 border-t border-slate-800 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full" style="color:#f87171;">
                        <i class="fas fa-arrow-right-from-bracket" style="color:#f87171;"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black bg-opacity-60 lg:hidden" x-cloak></div>

        <!-- ==================== MAIN ==================== -->
        <div class="flex flex-col flex-1 min-w-0 transition-all duration-300 lg:ml-64"
            :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">

            <!-- TOP HEADER -->
            <header
                class="sticky top-0 z-30 flex items-center h-16 px-4 sm:px-6 bg-white border-b border-slate-200 shadow-sm flex-shrink-0">

                <!-- Hamburger -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition mr-3">
                    <i class="fas fa-bars" style="font-size:18px;"></i>
                </button>

                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="text-slate-800 font-semibold">{{ $header ?? 'Dashboard' }}</span>
                </div>

                <div class="flex-1"></div>

                <!-- Right side -->
                <div class="flex items-center gap-2">

                    <!-- Real-Time Notification & Stock/Expiry Alerts Dropdown -->
                    <div class="relative" x-data="{ 
                        notificationOpen: false, 
                        unreadCount: {{ $totalAlertCount ?? 0 }},
                        isRead: false,
                        markAsRead() {
                            this.isRead = true;
                            this.unreadCount = 0;
                            localStorage.setItem('pharmacy_alerts_read_count', '{{ $totalAlertCount ?? 0 }}');
                        },
                        init() {
                            const lastRead = localStorage.getItem('pharmacy_alerts_read_count');
                            if (lastRead && parseInt(lastRead) >= {{ $totalAlertCount ?? 0 }}) {
                                this.isRead = true;
                                this.unreadCount = 0;
                            }
                        }
                    }">
                        <button @click="notificationOpen = !notificationOpen; if(notificationOpen) markAsRead();" 
                                class="relative p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition focus:outline-none"
                                title="Notifications & Stock Alerts">
                            <i class="fas fa-bell text-lg"></i>
                            <template x-if="!isRead && unreadCount > 0">
                                <span class="absolute top-1.5 right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-rose-600 text-[10px] font-extrabold text-white shadow-sm ring-2 ring-white animate-pulse"
                                      x-text="unreadCount > 99 ? '99+' : unreadCount">
                                </span>
                            </template>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="notificationOpen" 
                             @click.outside="notificationOpen = false" 
                             x-cloak 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-200/90 z-50 overflow-hidden">

                            <!-- Header -->
                            <div class="px-5 py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-sm font-bold border border-rose-500/30">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white">System Notifications</h4>
                                        <p class="text-[11px] text-slate-400">Stock & Expiry Alerts</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="markAsRead()" class="text-[11px] font-bold text-teal-400 hover:text-teal-300 transition flex items-center gap-1">
                                        <i class="fas fa-check-double text-[10px]"></i> Mark Read
                                    </button>
                                    <span class="px-2.5 py-1 rounded-full bg-rose-500/20 text-rose-300 text-xs font-bold border border-rose-500/30">
                                        {{ $totalAlertCount ?? 0 }} Alerts
                                    </span>
                                </div>
                            </div>

                            <!-- List Container -->
                            <div class="max-h-96 overflow-y-auto divide-y divide-slate-100">
                                @if(($totalAlertCount ?? 0) === 0)
                                    <div class="p-8 text-center bg-slate-50/50">
                                        <div class="w-12 h-12 mx-auto mb-2 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shadow-xs">
                                            <i class="fas fa-shield-check"></i>
                                        </div>
                                        <h5 class="text-xs font-bold text-slate-700">All Systems Normal!</h5>
                                        <p class="text-[11px] text-slate-400 mt-0.5">No low stock items or expired medicine batches found.</p>
                                    </div>
                                @else
                                     <!-- 1. Expired Medicine Alerts -->
                                    @foreach($expiredBatches ?? [] as $b)
                                        <a href="{{ $b->product_id ? route('admin.medicines.show', $b->product_id) : route('admin.stock.expiry') }}" class="p-3.5 hover:bg-rose-50/70 transition flex items-start gap-3 group">
                                            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 text-xs mt-0.5 group-hover:bg-rose-600 group-hover:text-white transition">
                                                <i class="fas fa-calendar-xmark"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-2">
                                                    <p class="text-xs font-extrabold text-slate-800 truncate group-hover:text-rose-700 transition">
                                                        {{ $b->product->name ?? 'Unknown Medicine' }}
                                                    </p>
                                                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-rose-100 text-rose-800 uppercase flex-shrink-0">Expired</span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 mt-0.5">
                                                    Batch: <strong class="font-mono text-slate-700">{{ $b->batch_no }}</strong> • Expired {{ \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach

                                    <!-- 2. Low Stock Alerts -->
                                    @foreach($lowStockProducts ?? [] as $p)
                                        <a href="{{ route('admin.medicines.show', $p->id) }}" class="p-3.5 hover:bg-amber-50/70 transition flex items-start gap-3 group">
                                            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 text-xs mt-0.5 group-hover:bg-amber-600 group-hover:text-white transition">
                                                <i class="fas fa-triangle-exclamation"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-2">
                                                    <p class="text-xs font-extrabold text-slate-800 truncate group-hover:text-amber-800 transition">
                                                        {{ $p->name }}
                                                    </p>
                                                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 uppercase flex-shrink-0">Low Stock</span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 mt-0.5">
                                                    Stock running out! Minimum required: <strong class="text-slate-700">{{ $p->min_stock }} Pcs</strong>
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach

                                    <!-- 3. Near Expiry Alerts -->
                                    @foreach($nearExpiryBatches ?? [] as $b)
                                        <a href="{{ $b->product_id ? route('admin.medicines.show', $b->product_id) : route('admin.stock.expiry') }}" class="p-3.5 hover:bg-orange-50/70 transition flex items-start gap-3 group">
                                            <div class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center flex-shrink-0 text-xs mt-0.5 group-hover:bg-orange-600 group-hover:text-white transition">
                                                <i class="fas fa-hourglass-half"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-2">
                                                    <p class="text-xs font-extrabold text-slate-800 truncate group-hover:text-orange-700 transition">
                                                        {{ $b->product->name ?? 'Unknown Medicine' }}
                                                    </p>
                                                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-orange-100 text-orange-800 uppercase flex-shrink-0">Near Expiry</span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 mt-0.5">
                                                    Batch: <strong class="font-mono text-slate-700">{{ $b->batch_no }}</strong> • Expiring {{ \Carbon\Carbon::parse($b->expiry_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Footer Links -->
                            <div class="p-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs font-bold">
                                <a href="{{ route('admin.stock.low') }}" class="text-amber-700 hover:text-amber-900 transition flex items-center gap-1">
                                    <i class="fas fa-boxes-stacked text-[11px]"></i> Low Stock Page
                                </a>
                                <a href="{{ route('admin.stock.expiry') }}" class="text-rose-600 hover:text-rose-800 transition flex items-center gap-1">
                                    <i class="fas fa-clock-rotate-left text-[11px]"></i> Expiry Alerts Page
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (auth()->check() && auth()->user()->hasRole('Super Admin'))
                        <!-- Branch Switcher -->
                        <div class="relative" x-data="{ branchOpen: false }">
                            <button @click="branchOpen = !branchOpen"
                                class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                                @php
                                    $selectedBranchId = session('selected_branch_id');
                                    $selectedBranch =
                                        $selectedBranchId && $selectedBranchId !== 'all'
                                            ? \App\Models\Branch::find($selectedBranchId)
                                            : null;
                                @endphp
                                <i class="fas fa-code-branch text-teal-500" style="font-size:14px;"></i>
                                <div class="hidden sm:block text-left leading-tight">
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">Branch</p>
                                    <p class="text-xs font-bold text-teal-600">
                                        {{ $selectedBranch ? $selectedBranch->name : 'All Branches' }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                            </button>

                            <div x-show="branchOpen" @click.away="branchOpen = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-50"
                                x-cloak>
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Switch
                                        Branch</p>
                                </div>
                                <form method="POST" action="{{ route('admin.branches.switch') }}">
                                    @csrf
                                    <input type="hidden" name="branch_id" value="all">
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50 transition {{ !$selectedBranchId || $selectedBranchId === 'all' ? 'text-teal-600 font-bold bg-teal-50' : 'text-slate-600' }}">
                                        <i class="fas fa-globe" style="font-size:13px;"></i> All Branches
                                    </button>
                                </form>
                                <div class="border-t border-slate-100"></div>
                                @foreach (\App\Models\Branch::all() as $branch)
                                    <form method="POST" action="{{ route('admin.branches.switch') }}">
                                        @csrf
                                        <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                        <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50 transition {{ $selectedBranchId == $branch->id ? 'text-teal-600 font-bold bg-teal-50' : 'text-slate-600' }}">
                                            <i class="fas fa-store" style="font-size:13px;"></i> {{ $branch->name }}
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-slate-100 transition">
                            <div
                                class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span
                                    class="text-white text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="hidden sm:block text-left leading-tight">
                                <p class="text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-400">Administrator</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-slate-400 hidden sm:block"></i>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-50"
                            x-cloak>
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition">
                                <i class="fas fa-user text-slate-400 w-4 text-center"></i> My Profile
                            </a>
                            <a href="{{ route('admin.settings.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition">
                                <i class="fas fa-gear text-slate-400 w-4 text-center"></i> Settings
                            </a>
                            <hr class="my-1 border-slate-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-arrow-right-from-bracket w-4 text-center"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>

    </div>

    <!-- Global Image Lightbox Preview Modal -->
    <div id="globalImagePreviewModal"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/80 backdrop-blur-md hidden p-4 transition-all duration-200"
        onclick="closeGlobalImagePreview(event)">
        <div class="relative max-w-4xl w-full bg-slate-900 rounded-2xl shadow-2xl overflow-hidden border border-slate-800 animate-in fade-in zoom-in duration-150"
            onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-slate-950 text-white flex justify-between items-center border-b border-slate-800">
                <h3 class="font-bold text-base text-white flex items-center gap-2.5">
                    <i class="fas fa-image text-teal-400"></i>
                    <span id="globalPreviewTitleText">Medicine Image Preview</span>
                </h3>
                <button onclick="closeGlobalImagePreview()"
                    class="text-slate-400 hover:text-white p-1.5 rounded-lg transition hover:bg-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal Body (Image Display) -->
            <div class="p-6 bg-slate-950 flex justify-center items-center min-h-[320px] max-h-[75vh] overflow-hidden">
                <img id="globalPreviewSrc" src="" alt="Preview"
                    class="max-h-[68vh] max-w-full object-contain rounded-xl shadow-2xl border border-slate-800 transition-all duration-200">
            </div>
        </div>
    </div>

    <script>
        function openImagePreview(src, title = 'Medicine Image') {
            const modal = document.getElementById('globalImagePreviewModal');
            const img = document.getElementById('globalPreviewSrc');
            const titleElem = document.getElementById('globalPreviewTitleText');

            if (img && modal) {
                img.src = src;
                if (titleElem) titleElem.textContent = title;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeGlobalImagePreview(e) {
            const modal = document.getElementById('globalImagePreviewModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGlobalImagePreview();
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
