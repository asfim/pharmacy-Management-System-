<!-- Top Announcement Bar -->
<div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 animate-gradient text-white text-sm py-2.5 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="hidden sm:flex items-center space-x-2 text-emerald-100">
            <svg class="w-4 h-4 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span class="font-medium">Free delivery on orders over <strong class="text-white">৳1,000!</strong></span>
        </div>
        <div class="sm:hidden flex-1 overflow-hidden">
            <div class="animate-marquee whitespace-nowrap">
                <span>🚚 Free delivery on orders over ৳1,000! &nbsp;&nbsp;|&nbsp;&nbsp; 💊 100% Genuine Medicines &nbsp;&nbsp;|&nbsp;&nbsp; ⚡ Fast 24h Delivery</span>
            </div>
        </div>
        <div class="hidden sm:flex items-center space-x-5 text-sm">
            <a href="#" class="flex items-center space-x-1.5 hover:text-white text-emerald-100 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Track Order</span>
            </a>
            <span class="text-emerald-400">|</span>
            <a href="#" class="flex items-center space-x-1.5 hover:text-white text-emerald-100 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>24/7 Support</span>
            </a>
            <span class="text-emerald-400">|</span>
            <a href="#" class="flex items-center space-x-1.5 hover:text-white text-emerald-100 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span>+880 1234 567890</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white/95 backdrop-blur-md border-b border-slate-100 py-4 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center gap-6">
            
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold tracking-tight">
                            <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">PHARMA</span><span class="text-slate-800">SYS</span>
                        </span>
                        <p class="text-[10px] text-slate-400 font-medium -mt-1 tracking-widest uppercase">Online Pharmacy</p>
                    </div>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-2xl">
                <div class="relative w-full group">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 blur-sm -z-10"></div>
                    <div class="flex">
                        <div class="relative flex-1">
                            <input type="text" id="frontendSearch" class="w-full py-3 pl-5 pr-4 bg-slate-50 border-2 border-slate-200 rounded-l-2xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-300 placeholder:text-slate-400" placeholder="Search medicines, generics, brands...">
                        </div>
                        <button type="button" class="px-6 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-r-2xl font-medium text-sm transition-all duration-300 flex items-center space-x-2 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="hidden lg:inline">Search</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Actions (Account, Wishlist, Cart) -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                
                <!-- Mobile Search Toggle -->
                <button class="md:hidden p-2.5 rounded-xl text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all" id="mobileSearchToggle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>

                @auth
                    <a href="{{ auth()->user()->hasRole('Customer') ? route('customer.dashboard') : route('admin.dashboard') }}" class="flex flex-col items-center p-2 rounded-xl text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-300 group">
                        <div class="relative">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span class="text-[10px] mt-0.5 font-semibold hidden sm:block">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex flex-col items-center p-2 rounded-xl text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-300 group">
                        <div class="relative">
                            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span class="text-[10px] mt-0.5 font-semibold hidden sm:block">Account</span>
                    </a>
                @endauth

                <a href="#" class="flex flex-col items-center p-2 rounded-xl text-slate-500 hover:text-rose-500 hover:bg-rose-50 transition-all duration-300 relative group">
                    <div class="relative">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center w-4.5 h-4.5 text-[9px] font-bold text-white bg-rose-500 rounded-full min-w-[18px] h-[18px] shadow-sm">0</span>
                    </div>
                    <span class="text-[10px] mt-0.5 font-semibold hidden sm:block">Wishlist</span>
                </a>

                <div class="flex items-center space-x-2">
                    <!-- Cart Dropdown Container -->
                    <div class="relative group">
                        <a href="javascript:void(0)" class="flex flex-col items-center p-2 rounded-xl text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-300">
                            <div class="relative">
                                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span id="cartCountBadge" class="absolute -top-1.5 -right-1.5 flex items-center justify-center text-[9px] font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full min-w-[18px] h-[18px] shadow-sm {{ session()->has('cart') && count(session('cart')) > 0 ? 'animate-pulse-badge' : 'hidden' }}">
                                    {{ session()->has('cart') ? collect(session('cart'))->sum('quantity') : 0 }}
                                </span>
                            </div>
                            <span class="text-[10px] mt-0.5 font-semibold hidden sm:block">Cart</span>
                        </a>

                        <!-- Mini Cart Dropdown -->
                        <div class="absolute right-0 top-full mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform origin-top-right scale-95 group-hover:scale-100">
                            <div class="p-4 border-b border-slate-100">
                                <h3 class="font-bold text-slate-800 text-sm">Your Cart</h3>
                            </div>
                            
                            <div class="max-h-64 overflow-y-auto p-2" id="miniCartItems">
                                @if(session()->has('cart') && count(session('cart')) > 0)
                                    @foreach(session('cart') as $id => $item)
                                    <div class="flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl transition-colors cart-item-row">
                                        <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                            @if($item['image'])
                                                <img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-cover">
                                            @else
                                                💊
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-800 truncate">{{ $item['name'] }}</p>
                                            <p class="text-xs text-slate-500">{{ $item['quantity'] }} × ৳{{ number_format($item['price'], 2) }}</p>
                                        </div>
                                        <button type="button" onclick="removeFromCart({{ $id }}, this)" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors ml-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-6 text-slate-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p class="text-sm">Your cart is empty.</p>
                                    </div>
                                @endif
                            </div>

                            @if(session()->has('cart') && count(session('cart')) > 0)
                            <div class="p-4 border-t border-slate-100 bg-slate-50 rounded-b-2xl" id="miniCartFooter">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-sm font-semibold text-slate-500">Subtotal</span>
                                    <span class="font-bold text-emerald-600" id="miniCartSubtotal">৳{{ number_format(collect(session('cart'))->sum(fn($i) => $i['price'] * $i['quantity']), 2) }}</span>
                                </div>
                                <a href="{{ route('checkout') }}" class="block w-full py-2.5 px-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white text-center font-bold rounded-xl shadow-md transition-all">
                                    Proceed to Checkout
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition-all duration-300 ml-2 text-sm">
                        <span>Checkout</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="lg:hidden p-2.5 rounded-xl text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all" id="mobileMenuToggle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Search Bar (hidden by default) -->
        <div class="md:hidden mt-3 hidden" id="mobileSearchBar">
            <div class="flex">
                <input type="text" class="w-full py-2.5 pl-4 pr-4 bg-slate-50 border-2 border-slate-200 rounded-l-xl text-sm focus:outline-none focus:border-emerald-500" placeholder="Search medicines...">
                <button class="px-5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-r-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </div>
    </div>
</header>

<script>
    // Mobile search toggle
    document.getElementById('mobileSearchToggle')?.addEventListener('click', () => {
        document.getElementById('mobileSearchBar')?.classList.toggle('hidden');
    });
</script>
