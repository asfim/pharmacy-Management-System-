<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($header) ? $header . ' — ' : '' }}{{ config('app.name', 'PharmaSys') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 10px; }
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
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 shadow-2xl flex flex-col transition-transform duration-300 ease-in-out"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           x-cloak>

        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-4 bg-slate-950 border-b border-slate-800 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-pills text-white" style="font-size:14px;"></i>
                </div>
                <span class="text-white font-bold text-base tracking-wide">Pharma<span class="text-teal-400">Sys</span></span>
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

            <a href="{{ route('admin.medicines.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.medicines*') ? 'active' : '' }}">
                <i class="fas fa-capsules"></i>
                <span>Medicines</span>
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.sub-categories.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.sub-categories*') ? 'active' : '' }}">
                <i class="fas fa-sitemap"></i>
                <span>Sub-Categories</span>
            </a>
            <a href="{{ route('admin.generics.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.generics*') ? 'active' : '' }}">
                <i class="fas fa-dna"></i>
                <span>Generics</span>
            </a>
            <a href="{{ route('admin.brands.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.brands*') ? 'active' : '' }}">
                <i class="fas fa-certificate"></i>
                <span>Brands</span>
            </a>
            <a href="{{ route('admin.manufacturers.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.manufacturers*') ? 'active' : '' }}">
                <i class="fas fa-industry"></i>
                <span>Manufacturers</span>
            </a>

            <!-- INVENTORY -->
            <p class="sidebar-section">Inventory</p>

            <a href="{{ route('admin.batches.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.batches*') ? 'active' : '' }}">
                <i class="fas fa-boxes-stacked"></i>
                <span>Batches & Expiry</span>
            </a>
            <a href="{{ route('admin.stock.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.stock*') ? 'active' : '' }}">
                <i class="fas fa-warehouse"></i>
                <span>Stock & Inventory</span>
            </a>

            <!-- SALES & POS -->
            <p class="sidebar-section">Sales & POS</p>

            <a href="{{ route('admin.pos.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pos*') ? 'active' : '' }}">
                <i class="fas fa-cash-register"></i>
                <span>POS System</span>
            </a>
            <a href="{{ route('admin.sales.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.sales*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Sales Invoices</span>
            </a>
            <a href="{{ route('admin.sale-returns.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.sale-returns*') ? 'active' : '' }}">
                <i class="fas fa-rotate-left"></i>
                <span>Sales Returns</span>
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <i class="fas fa-bag-shopping"></i>
                <span>Online Orders</span>
            </a>

            <!-- PROCUREMENT -->
            <p class="sidebar-section">Procurement</p>

            <a href="{{ route('admin.purchases.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.purchases*') ? 'active' : '' }}">
                <i class="fas fa-cart-flatbed"></i>
                <span>Purchases</span>
            </a>
            <a href="{{ route('admin.suppliers.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.suppliers*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                <span>Suppliers</span>
            </a>

            <!-- MANAGEMENT -->
            <p class="sidebar-section">Management</p>

            <a href="{{ route('admin.customers.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('admin.doctors.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.doctors*') ? 'active' : '' }}">
                <i class="fas fa-user-doctor"></i>
                <span>Doctors</span>
            </a>
            <a href="{{ route('admin.employees.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                <span>HRM & Payroll</span>
            </a>
            <a href="{{ route('admin.accounts.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.accounts*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Accounts & Finance</span>
            </a>
            <a href="{{ route('admin.expenses.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.expenses*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>Expenses</span>
            </a>
            <a href="{{ route('admin.branches.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.branches*') ? 'active' : '' }}">
                <i class="fas fa-code-branch"></i>
                <span>Branches</span>
            </a>

            <!-- REPORTS -->
            <p class="sidebar-section">Reports</p>

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

            <!-- ADMIN -->
            <p class="sidebar-section">Admin</p>

            <a href="{{ route('admin.settings.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="fas fa-gear"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-shield-halved"></i>
                <span>Roles & Users</span>
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
    <div class="flex flex-col flex-1 min-w-0 transition-all duration-300"
         :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">

        <!-- TOP HEADER -->
        <header class="sticky top-0 z-30 flex items-center h-16 px-4 sm:px-6 bg-white border-b border-slate-200 shadow-sm flex-shrink-0">

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

                <!-- Notification -->
                <button class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition">
                    <i class="fas fa-bell" style="font-size:17px;"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-slate-100 transition">
                        <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
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
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition">
                            <i class="fas fa-user text-slate-400 w-4 text-center"></i> My Profile
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition">
                            <i class="fas fa-gear text-slate-400 w-4 text-center"></i> Settings
                        </a>
                        <hr class="my-1 border-slate-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
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

@stack('scripts')
</body>
</html>
