<!-- Top Announcement Bar -->
<div class="bg-teal-600 text-white text-sm py-2 px-4 sm:px-6 lg:px-8 flex justify-between items-center hidden sm:flex">
    <div>
        <span>Free delivery on orders over ৳1000!</span>
    </div>
    <div class="flex space-x-4">
        <a href="#" class="hover:text-teal-200">Track Order</a>
        <a href="#" class="hover:text-teal-200">Support</a>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white border-b border-slate-200 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-teal-600 tracking-wider">
                    PHARMA<span class="text-slate-800">SYS</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-lg mx-8">
                <div class="relative w-full">
                    <input type="text" class="w-full py-2.5 pl-4 pr-12 bg-slate-50 border border-slate-300 rounded-full text-sm focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500" placeholder="Search for medicines, generics, brands...">
                    <button class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-teal-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Actions (Account, Wishlist, Cart) -->
            <div class="flex items-center space-x-6">
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-slate-500 hover:text-teal-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-xs mt-1 font-medium hidden sm:block">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center text-slate-500 hover:text-teal-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-xs mt-1 font-medium hidden sm:block">Account</span>
                    </a>
                @endauth

                <a href="#" class="flex flex-col items-center text-slate-500 hover:text-teal-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <span class="text-xs mt-1 font-medium hidden sm:block">Wishlist</span>
                    <span class="absolute -top-1 -right-2 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-teal-500 rounded-full">0</span>
                </a>

                <a href="#" class="flex flex-col items-center text-slate-500 hover:text-teal-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-xs mt-1 font-medium hidden sm:block">Cart</span>
                    <span class="absolute -top-1 -right-2 flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-500 rounded-full">2</span>
                </a>
            </div>
        </div>
    </div>
</header>
