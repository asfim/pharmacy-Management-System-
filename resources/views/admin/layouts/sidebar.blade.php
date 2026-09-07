<!-- Sidebar component -->
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out"
       :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'md:translate-x-0': true}">
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-slate-950 border-b border-slate-800">
        <span class="text-xl font-bold text-teal-400 tracking-wider">PHARMA<span class="text-white">SYS</span></span>
    </div>

    <!-- Navigation Links -->
    <nav class="p-3 h-[calc(100vh-4rem)] overflow-y-auto">
        
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-teal-600 hover:text-white mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        <!-- PRODUCTS -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Products</p>
        </div>
        <a href="{{ route('admin.medicines.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.medicines*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Medicines
        </a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.categories*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Categories
        </a>
        <a href="{{ route('admin.sub-categories.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.sub-categories*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Sub-Categories
        </a>
        <a href="{{ route('admin.generics.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.generics*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            Generics
        </a>
        <a href="{{ route('admin.brands.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.brands*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            Brands
        </a>
        <a href="{{ route('admin.manufacturers.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.manufacturers*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Manufacturers
        </a>

        <!-- INVENTORY -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Inventory</p>
        </div>
        <a href="{{ route('admin.batches.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.batches*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Batches & Expiry
        </a>
        <a href="{{ route('admin.stock.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.stock*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            Stock & Inventory
        </a>

        <!-- SALES & POS -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Sales & POS</p>
        </div>
        <a href="{{ route('admin.pos.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.pos*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
            POS System
        </a>
        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.orders*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            E-Commerce Orders
        </a>

        <!-- PURCHASE -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Purchase</p>
        </div>
        <a href="{{ route('admin.purchases.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.purchases*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            Purchases
        </a>
        <a href="{{ route('admin.suppliers.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.suppliers*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Suppliers
        </a>

        <!-- CLINICAL -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Clinical</p>
        </div>
        <a href="{{ route('admin.doctors.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.doctors*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Doctors
        </a>
        <a href="{{ route('admin.prescriptions.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.prescriptions*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Prescriptions
        </a>

        <!-- MANAGEMENT -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Management</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.customers*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Customers
        </a>
        <a href="{{ route('admin.employees.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.employees*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            HRM & Payroll
        </a>
        <a href="{{ route('admin.accounts.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.accounts*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Accounts & Finance
        </a>
        <a href="{{ route('admin.expenses.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.expenses*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Expenses
        </a>

        <!-- REPORTS -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reports</p>
        </div>
        <a href="{{ route('admin.reports.sales') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.reports.sales') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Sales Report
        </a>
        <a href="{{ route('admin.reports.profit') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.reports.profit') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            Profit & Loss Report
        </a>
        <a href="{{ route('admin.reports.expiry') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.reports.expiry') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Expiry Report
        </a>

        <!-- ADMIN -->
        <div class="pt-4 pb-1">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.users*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Users & Roles
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg hover:bg-slate-800 hover:text-white mb-1 {{ request()->routeIs('admin.settings*') ? 'bg-slate-800 text-white' : 'text-slate-300' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Settings
        </a>

        <!-- Logout -->
        <div class="pt-4 mt-2 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm font-medium text-slate-400 rounded-lg hover:bg-red-700 hover:text-white transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>
</aside>
