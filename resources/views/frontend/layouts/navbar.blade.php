<!-- Main Navigation -->
<nav class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white shadow-xl relative z-30 hidden lg:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-12">
            <div class="flex items-center space-x-1 h-full">
                <!-- Categories Mega Menu -->
                <div class="relative group h-full">
                    <button class="flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 px-5 font-semibold hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 h-full text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <span>All Categories</span>
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:rotate-180 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute left-0 top-full w-[750px] bg-white border border-slate-100 rounded-b-2xl shadow-2xl text-slate-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                        <div class="p-4">
                            <div class="grid grid-cols-3 gap-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                @if(isset($navCategories) && $navCategories->count() > 0)
                                    @foreach($navCategories as $cat)
                                    <a href="{{ route('category.products', $cat->id) }}" class="flex items-center space-x-3 px-4 py-3 hover:bg-emerald-50 rounded-xl hover:text-emerald-600 transition-all duration-200 group/item">
                                        <span class="w-10 h-10 rounded-lg bg-emerald-100/50 text-emerald-600 flex items-center justify-center group-hover/item:bg-emerald-500 group-hover/item:text-white transition-all text-lg shrink-0">
                                            {!! $cat->icon ?? '💊' !!}
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <span class="font-bold text-sm block truncate">{{ $cat->name }}</span>
                                            <p class="text-[11px] text-slate-400 truncate">{{ $cat->description ?? 'Explore ' . $cat->name }}</p>
                                        </div>
                                    </a>
                                    @endforeach
                                @else
                                    <div class="col-span-3 px-5 py-4 text-sm text-slate-500 text-center">No categories found</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Nav Links -->
                <div class="flex items-center h-full ml-2">
                    <a href="{{ route('home') }}" class="nav-link-effect px-4 py-2 font-medium text-sm hover:text-emerald-400 transition-colors duration-200">Home</a>
                    <a href="{{ route('products') }}" class="nav-link-effect px-4 py-2 font-medium text-sm hover:text-emerald-400 transition-colors duration-200">Products</a>
                    <a href="{{ route('products', ['discount' => 'true']) }}" class="nav-link-effect px-4 py-2 font-medium text-sm text-amber-400 hover:text-amber-300 transition-colors duration-200 flex items-center space-x-1.5">
                        <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                        <span>Flash Sale</span>
                    </a>
                    <a href="#" class="nav-link-effect px-4 py-2 font-medium text-sm hover:text-emerald-400 transition-colors duration-200">Brands</a>
                    <a href="#" class="nav-link-effect px-4 py-2 font-medium text-sm hover:text-emerald-400 transition-colors duration-200">Generics</a>
                </div>
            </div>
            
            <!-- Upload Prescription CTA -->
            <div class="flex items-center">
                <a href="#" class="btn-glow flex items-center space-x-2 bg-gradient-to-r from-rose-500 to-pink-500 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 shadow-lg shadow-rose-500/20 hover:shadow-rose-500/40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span>Upload Prescription</span>
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Slide-in Menu -->
<div id="mobileMenu" class="mobile-menu fixed inset-0 z-[60] lg:hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="mobileMenuOverlay"></div>
    <!-- Menu Panel -->
    <div class="absolute left-0 top-0 bottom-0 w-80 bg-white shadow-2xl overflow-y-auto">
        <div class="p-5">
            <!-- Close Button -->
            <div class="flex justify-between items-center mb-6">
                <span class="text-xl font-extrabold">
                    <span class="text-emerald-600">PHARMA</span><span class="text-slate-800">SYS</span>
                </span>
                <button id="mobileMenuClose" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Mobile Nav Links -->
            <nav class="space-y-1">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('products') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Products</span>
                </a>
                <a href="{{ route('products', ['discount' => 'true']) }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-amber-600 bg-amber-50 hover:bg-amber-100 transition font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                    <span>Flash Sale</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <span>Brands</span>
                </a>
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span>Generics</span>
                </a>
            </nav>

            <!-- Mobile Upload Prescription -->
            <div class="mt-6 pt-6 border-t border-slate-100">
                <a href="#" class="flex items-center justify-center space-x-2 w-full bg-gradient-to-r from-rose-500 to-pink-500 text-white py-3 rounded-xl font-semibold shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span>Upload Prescription</span>
                </a>
            </div>

            <!-- Categories -->
            <div class="mt-6 pt-6 border-t border-slate-100">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Categories</h4>
                <div class="space-y-1">
                    @if(isset($navCategories) && $navCategories->count() > 0)
                        @foreach($navCategories as $cat)
                        <a href="{{ route('category.products', $cat->id) }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50 transition text-sm">
                            <span>{!! $cat->icon ?? '💊' !!}</span><span>{{ $cat->name }}</span>
                        </a>
                        @endforeach
                    @else
                        <div class="px-3 py-2 text-sm text-slate-400">No categories found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mobile menu toggle
    const mobileMenu = document.getElementById('mobileMenu');
    document.getElementById('mobileMenuToggle')?.addEventListener('click', () => {
        mobileMenu.style.display = 'block';
        requestAnimationFrame(() => {
            mobileMenu.querySelector('.mobile-menu')?.classList.add('open');
            mobileMenu.classList.remove('mobile-menu');
        });
    });
    
    function closeMobileMenu() {
        const panel = mobileMenu.querySelector('div:last-child');
        if (panel) panel.style.transform = 'translateX(-100%)';
        setTimeout(() => { mobileMenu.style.display = 'none'; }, 300);
    }
    
    document.getElementById('mobileMenuClose')?.addEventListener('click', closeMobileMenu);
    document.getElementById('mobileMenuOverlay')?.addEventListener('click', closeMobileMenu);
    
    // Initially hide mobile menu
    if (mobileMenu) mobileMenu.style.display = 'none';
</script>
