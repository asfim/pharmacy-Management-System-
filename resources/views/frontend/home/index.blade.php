@extends('frontend.layouts.app')

@push('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@section('content')

<!-- ============================================
     HERO SECTION — Full Gradient with Floating Elements
     ============================================ -->
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 animate-gradient min-h-[600px] flex items-center">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Blobs -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-400/20 rounded-full blur-3xl animate-blob delay-300"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-teal-300/15 rounded-full blur-3xl animate-blob delay-700"></div>
        
        <!-- Floating Medicine Icons -->
        <div class="absolute top-20 right-[15%] text-4xl animate-float opacity-20">💊</div>
        <div class="absolute top-40 right-[35%] text-3xl animate-float-slow delay-200 opacity-15">🩺</div>
        <div class="absolute bottom-32 left-[10%] text-4xl animate-float-reverse delay-500 opacity-20">🧬</div>
        <div class="absolute top-28 left-[20%] text-3xl animate-float delay-700 opacity-15">🩹</div>
        <div class="absolute bottom-20 right-[25%] text-3xl animate-float-slow delay-1000 opacity-15">💉</div>
        <div class="absolute top-1/2 right-[8%] text-5xl animate-float-reverse opacity-10">🔬</div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-white">
                <div class="inline-flex items-center space-x-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 mb-6 text-sm font-medium animate-slide-up">
                    <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                    <span>🎉 Trusted by 50,000+ customers</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 animate-slide-up" style="animation-delay: 100ms">
                    Your Health,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 via-white to-cyan-200">Delivered Fast!</span>
                </h1>
                
                <p class="text-lg md:text-xl text-emerald-100/90 mb-10 max-w-lg animate-slide-up leading-relaxed" style="animation-delay: 200ms">
                    Order 100% genuine medicines online and get them delivered to your doorstep within 24 hours, securely & hassle-free.
                </p>
                
                <div class="flex flex-wrap gap-4 animate-slide-up" style="animation-delay: 300ms">
                    <a href="#" class="btn-glow inline-flex items-center space-x-2 bg-white text-emerald-700 font-bold py-3.5 px-8 rounded-full shadow-xl shadow-black/10 hover:bg-emerald-50 transition-all duration-300 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Order Now</span>
                    </a>
                    <a href="#" class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white font-bold py-3.5 px-8 rounded-full hover:bg-white/20 transition-all duration-300 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <span>Upload Prescription</span>
                    </a>
                </div>

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-8 mt-12 animate-slide-up" style="animation-delay: 400ms">
                    <div class="text-center">
                        <div class="text-2xl font-extrabold" data-counter data-target="10000" data-suffix="+">0</div>
                        <div class="text-emerald-200/70 text-xs font-medium mt-1">Products</div>
                    </div>
                    <div class="w-px bg-white/20 self-stretch"></div>
                    <div class="text-center">
                        <div class="text-2xl font-extrabold" data-counter data-target="50000" data-suffix="+">0</div>
                        <div class="text-emerald-200/70 text-xs font-medium mt-1">Happy Customers</div>
                    </div>
                    <div class="w-px bg-white/20 self-stretch"></div>
                    <div class="text-center">
                        <div class="text-2xl font-extrabold" data-counter data-target="30" data-suffix="+">0</div>
                        <div class="text-emerald-200/70 text-xs font-medium mt-1">Branches</div>
                    </div>
                </div>
            </div>

            <!-- Right Side — Hero Image -->
            <div class="hidden lg:block relative">
                <div class="relative z-10">
                    <img src="{{ asset('assets/images/hero_illustration.jpg') }}" alt="PharmaSys App Illustration" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl">
                </div>
                
                <!-- Floating decorative glow behind the image -->
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-400 to-teal-400 rounded-full blur-3xl opacity-30 -z-10"></div>
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="wave-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-white">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C57.1,88.13,125.63,68.46,190.7,58.75,242.93,51.24,279.59,61.11,321.39,56.44Z"></path>
        </svg>
    </div>
</section>

<!-- ============================================
     FEATURES STRIP — Glassmorphic Cards
     ============================================ -->
<section class="py-14 bg-white relative -mt-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @php
                $features = [
                    ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'title' => 'Genuine Medicines', 'desc' => '100% authentic products', 'color' => 'emerald'],
                    ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>', 'title' => 'Fast Delivery', 'desc' => 'Within 24 hours', 'color' => 'blue'],
                    ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>', 'title' => 'Secure Payments', 'desc' => 'bKash, Nagad, Card', 'color' => 'violet'],
                    ['icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'title' => '30+ Branches', 'desc' => 'All over the country', 'color' => 'amber'],
                ];
            @endphp

            @foreach($features as $i => $f)
            <div class="card-hover reveal bg-white rounded-2xl p-5 md:p-6 border border-slate-100 shadow-sm hover:shadow-xl text-center group" style="animation-delay: {{ $i * 100 }}ms">
                <div class="w-14 h-14 mx-auto bg-{{ $f['color'] }}-100 rounded-2xl flex items-center justify-center text-{{ $f['color'] }}-600 mb-4 group-hover:bg-gradient-to-br group-hover:from-{{ $f['color'] }}-500 group-hover:to-{{ $f['color'] }}-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 group-hover:shadow-lg">
                    {!! $f['icon'] !!}
                </div>
                <h3 class="font-bold text-slate-800 text-sm md:text-base">{{ $f['title'] }}</h3>
                <p class="text-xs md:text-sm text-slate-500 mt-1.5">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================
     CATEGORIES GRID
     ============================================ -->
<section class="py-16 bg-gradient-to-b from-white to-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 section-title-line inline-block">Shop by Category</h2>
            <p class="text-slate-500 mt-4 max-w-xl mx-auto">Browse through our wide range of healthcare categories to find exactly what you need.</p>
        </div>

        <div class="swiper categorySwiper relative px-4 py-2" style="padding-left: 2rem; padding-right: 2rem;">
            <div class="swiper-wrapper">
                @foreach($categories as $i => $cat)
                <div class="swiper-slide h-auto">
                    <a href="#" class="category-card reveal bg-white rounded-2xl p-5 text-center border border-slate-100 shadow-sm group block h-full" style="animation-delay: {{ ($i % 6) * 80 }}ms">
                        <div class="category-icon w-16 h-16 mx-auto bg-slate-50 rounded-2xl flex items-center justify-center text-3xl mb-3 border border-slate-100 overflow-hidden">
                            @if($cat->image && file_exists(public_path('storage/' . $cat->image)))
                                <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                            @else
                                💊
                            @endif
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm">{{ $cat->name }}</h3>
                        <p class="text-xs text-slate-400 mt-1">{{ $cat->products_count }} items</p>
                        <div class="mt-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <span class="inline-block text-xs font-bold bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-3 py-1 rounded-full">Browse →</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <!-- Swiper Navigation -->
            <div class="swiper-button-prev !text-emerald-600 !bg-white !w-10 !h-10 !rounded-full shadow-md after:!text-sm border border-slate-100 hidden md:flex !-left-2"></div>
            <div class="swiper-button-next !text-emerald-600 !bg-white !w-10 !h-10 !rounded-full shadow-md after:!text-sm border border-slate-100 hidden md:flex !-right-2"></div>
        </div>
    </div>
</section>

<!-- ============================================
     FLASH SALE BANNER — With Countdown Timer
     ============================================ -->
<section class="py-12 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-rose-600 via-pink-600 to-fuchsia-600 rounded-3xl p-8 md:p-12 relative overflow-hidden reveal">
            <!-- Background decoration -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute top-10 right-[20%] text-6xl opacity-10 animate-float">⚡</div>
                <div class="absolute bottom-5 left-[15%] text-4xl opacity-10 animate-float-reverse">🔥</div>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-white text-center md:text-left">
                    <div class="inline-flex items-center space-x-2 bg-white/15 rounded-full px-4 py-1.5 text-sm font-medium mb-4 backdrop-blur-sm">
                        <svg class="w-4 h-4 animate-pulse text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                        <span>Limited Time Offer</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-2">Flash Sale — Up to 40% OFF!</h2>
                    <p class="text-rose-100 text-lg">Get incredible deals on top medicines & health products.</p>
                </div>
                
                <!-- Countdown Timer -->
                <div class="flex items-center space-x-3" id="flashCountdown">
                    <div class="countdown-box">
                        <div class="text-2xl md:text-3xl font-extrabold text-white" id="countHours">12</div>
                        <div class="text-[10px] text-rose-200 font-medium uppercase tracking-wider mt-1">Hours</div>
                    </div>
                    <span class="text-white text-2xl font-bold animate-pulse">:</span>
                    <div class="countdown-box">
                        <div class="text-2xl md:text-3xl font-extrabold text-white" id="countMinutes">45</div>
                        <div class="text-[10px] text-rose-200 font-medium uppercase tracking-wider mt-1">Mins</div>
                    </div>
                    <span class="text-white text-2xl font-bold animate-pulse">:</span>
                    <div class="countdown-box">
                        <div class="text-2xl md:text-3xl font-extrabold text-white" id="countSeconds">30</div>
                        <div class="text-[10px] text-rose-200 font-medium uppercase tracking-wider mt-1">Secs</div>
                    </div>
                </div>
            </div>

            <!-- Shop Now CTA -->
            <div class="relative z-10 mt-8 text-center md:text-left">
                <a href="#" class="inline-flex items-center space-x-2 bg-white text-rose-600 font-bold py-3 px-8 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 text-sm">
                    <span>Shop Flash Sale</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     FEATURED PRODUCTS
     ============================================ -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-10 reveal">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 section-title-line">Featured Medicines</h2>
                <p class="text-slate-500 mt-4">Top rated and highly recommended products</p>
            </div>
            <a href="#" class="hidden md:inline-flex items-center space-x-2 text-emerald-600 font-semibold hover:text-emerald-700 transition group">
                <span>View All</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            @php
                $products = [
                    ['name' => 'Napa Extra 500mg', 'generic' => 'Paracetamol', 'company' => 'Square Pharma', 'price' => '5.50', 'oldPrice' => '7.00', 'discount' => '21', 'emoji' => '💊'],
                    ['name' => 'Sergel 20mg', 'generic' => 'Omeprazole', 'company' => 'Healthcare Pharma', 'price' => '6.00', 'oldPrice' => null, 'discount' => null, 'emoji' => '💛'],
                    ['name' => 'Seclo 20mg', 'generic' => 'Omeprazole', 'company' => 'Square Pharma', 'price' => '4.50', 'oldPrice' => '6.00', 'discount' => '25', 'emoji' => '🩹'],
                    ['name' => 'Losectil 20mg', 'generic' => 'Omeprazole', 'company' => 'Incepta Pharma', 'price' => '5.00', 'oldPrice' => null, 'discount' => null, 'emoji' => '💊'],
                    ['name' => 'Ace Plus 500mg', 'generic' => 'Paracetamol+Caffeine', 'company' => 'Square Pharma', 'price' => '2.50', 'oldPrice' => '3.50', 'discount' => '29', 'emoji' => '🩺'],
                ];
            @endphp

            @foreach($products as $i => $p)
            <div class="product-card card-hover reveal bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group relative" style="animation-delay: {{ $i * 100 }}ms">
                @if($p['discount'])
                <div class="ribbon bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-lg">
                    -{{ $p['discount'] }}%
                </div>
                @endif

                <!-- Image Area -->
                <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100 h-44 flex items-center justify-center">
                    <div class="product-image text-6xl">{{ $p['emoji'] }}</div>
                    
                    <!-- Overlay Actions -->
                    <div class="product-overlay absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent flex items-end justify-center pb-4">
                        <div class="flex space-x-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <button class="w-9 h-9 rounded-full bg-white text-slate-700 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-lg text-sm" title="Add to Cart">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                            <button class="w-9 h-9 rounded-full bg-white text-slate-700 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg text-sm" title="Add to Wishlist">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                            <button class="w-9 h-9 rounded-full bg-white text-slate-700 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-lg text-sm" title="Quick View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <div class="text-xs font-semibold text-emerald-600 mb-1">{{ $p['company'] }}</div>
                    <h3 class="font-bold text-slate-800 text-sm truncate mb-0.5 group-hover:text-emerald-600 transition-colors">{{ $p['name'] }}</h3>
                    <p class="text-xs text-slate-400 mb-3">{{ $p['generic'] }}</p>
                    
                    <!-- Rating -->
                    <div class="flex items-center space-x-1 mb-3">
                        <div class="flex text-amber-400 text-xs">★★★★<span class="text-slate-300">★</span></div>
                        <span class="text-[10px] text-slate-400">(4.0)</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-lg font-extrabold text-slate-900">৳{{ $p['price'] }}</span>
                            @if($p['oldPrice'])
                            <span class="text-xs text-slate-400 line-through ml-1">৳{{ $p['oldPrice'] }}</span>
                            @endif
                        </div>
                        <button class="w-9 h-9 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white flex items-center justify-center hover:shadow-lg hover:shadow-emerald-500/30 hover:scale-110 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Mobile View All -->
        <div class="mt-8 text-center md:hidden reveal">
            <a href="#" class="inline-flex items-center space-x-2 text-emerald-600 font-semibold border-2 border-emerald-200 px-6 py-2.5 rounded-full hover:bg-emerald-50 transition">
                <span>View All Products</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- ============================================
     WHY CHOOSE US — Infographic Style
     ============================================ -->
<section class="py-20 bg-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle at 1px 1px, #059669 1px, transparent 0); background-size: 30px 30px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left: Content -->
            <div class="reveal-left">
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-emerald-700 rounded-full px-4 py-1.5 text-sm font-semibold mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>Why Choose PharmaSys</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 leading-tight">
                    Your Trusted Partner in <span class="gradient-text">Healthcare</span>
                </h2>
                <p class="text-slate-500 text-lg mb-10 leading-relaxed">
                    We're committed to making healthcare accessible, affordable, and convenient for everyone across Bangladesh.
                </p>

                <div class="space-y-6">
                    @php
                        $reasons = [
                            ['icon' => '🔒', 'title' => 'Licensed & Certified', 'desc' => 'Government-approved pharmacy with all valid licenses and certifications.'],
                            ['icon' => '🚚', 'title' => 'Same-Day Delivery', 'desc' => 'Order before 2 PM and receive your medicines on the same day within Dhaka.'],
                            ['icon' => '👨‍⚕️', 'title' => 'Expert Pharmacists', 'desc' => 'Our team of qualified pharmacists ensures you get the right medicines every time.'],
                            ['icon' => '💰', 'title' => 'Best Price Guarantee', 'desc' => 'We match competitor prices and offer exclusive discounts on top brands.'],
                        ];
                    @endphp

                    @foreach($reasons as $i => $r)
                    <div class="flex items-start space-x-4 group">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-2xl border border-slate-100 group-hover:bg-gradient-to-br group-hover:from-emerald-500 group-hover:to-teal-500 group-hover:border-transparent transition-all duration-300 shrink-0 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-emerald-500/20">
                            <span class="group-hover:scale-110 transition-transform">{{ $r['icon'] }}</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base mb-1 group-hover:text-emerald-600 transition-colors">{{ $r['title'] }}</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $r['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Stats Cards -->
            <div class="reveal-right relative">
                <div class="grid grid-cols-2 gap-5">
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-xl shadow-emerald-500/20 card-hover">
                        <div class="text-4xl mb-3">💊</div>
                        <div class="text-3xl font-extrabold" data-counter data-target="10000" data-suffix="+">0</div>
                        <div class="text-emerald-200 text-sm font-medium mt-1">Products Available</div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-blue-500/20 card-hover mt-8">
                        <div class="text-4xl mb-3">🤝</div>
                        <div class="text-3xl font-extrabold" data-counter data-target="50000" data-suffix="+">0</div>
                        <div class="text-blue-200 text-sm font-medium mt-1">Happy Customers</div>
                    </div>
                    <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-6 text-white shadow-xl shadow-amber-500/20 card-hover">
                        <div class="text-4xl mb-3">🏥</div>
                        <div class="text-3xl font-extrabold" data-counter data-target="30" data-suffix="+">0</div>
                        <div class="text-amber-200 text-sm font-medium mt-1">Branches</div>
                    </div>
                    <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-3xl p-6 text-white shadow-xl shadow-violet-500/20 card-hover mt-8">
                        <div class="text-4xl mb-3">⭐</div>
                        <div class="text-3xl font-extrabold">4.9</div>
                        <div class="text-violet-200 text-sm font-medium mt-1">Average Rating</div>
                    </div>
                </div>
                <!-- Decorative blob -->
                <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-emerald-100 rounded-full blur-3xl opacity-40"></div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     CUSTOMER TESTIMONIALS
     ============================================ -->
<section class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 reveal">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 section-title-line inline-block">What Our Customers Say</h2>
            <p class="text-slate-500 mt-4 max-w-xl mx-auto">Real experiences from real customers who trust PharmaSys for their healthcare needs.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $testimonials = [
                    ['name' => 'Rahim Ahmed', 'role' => 'Regular Customer', 'text' => 'Amazing service! I ordered my prescription medicines and received them within 3 hours. The prices were much lower than local pharmacies. Highly recommended!', 'rating' => 5, 'initial' => 'R', 'gradient' => 'from-emerald-500 to-teal-500'],
                    ['name' => 'Fatima Khatun', 'role' => 'Verified Buyer', 'text' => 'I was hesitant to order medicines online, but PharmaSys exceeded my expectations. All medicines were genuine with proper packaging and expiry dates clearly visible.', 'rating' => 5, 'initial' => 'F', 'gradient' => 'from-rose-500 to-pink-500'],
                    ['name' => 'Kamal Hossain', 'role' => 'Loyal Customer', 'text' => 'The prescription upload feature is a game-changer! I just upload my prescription and the team prepares everything. Delivery is always on time. Best pharmacy experience!', 'rating' => 4, 'initial' => 'K', 'gradient' => 'from-blue-500 to-indigo-500'],
                ];
            @endphp

            @foreach($testimonials as $i => $t)
            <div class="testimonial-card reveal bg-white rounded-2xl p-7 border border-slate-100 shadow-sm" style="animation-delay: {{ $i * 150 }}ms">
                <!-- Stars -->
                <div class="flex text-amber-400 mb-4">
                    @for($s = 0; $s < 5; $s++)
                        @if($s < $t['rating'])
                            <span class="text-sm">★</span>
                        @else
                            <span class="text-sm text-slate-300">★</span>
                        @endif
                    @endfor
                </div>
                
                <p class="text-slate-600 text-sm leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                
                <div class="flex items-center space-x-3 pt-4 border-t border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r {{ $t['gradient'] }} flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ $t['initial'] }}
                    </div>
                    <div>
                        <div class="font-bold text-slate-800 text-sm">{{ $t['name'] }}</div>
                        <div class="text-xs text-slate-400">{{ $t['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================
     NEWSLETTER SIGNUP
     ============================================ -->
<section class="py-16 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 rounded-3xl p-10 md:p-16 text-center relative overflow-hidden reveal">
            <!-- Background -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 right-0 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>
                <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 30px 30px;"></div>
            </div>

            <div class="relative z-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/15 rounded-2xl backdrop-blur-sm mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Stay Updated with Health Tips</h2>
                <p class="text-emerald-100 text-lg mb-8 max-w-xl mx-auto">Subscribe to our newsletter and get exclusive deals, health tips, and early access to flash sales.</p>
                
                <div class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                    <input type="email" class="flex-1 py-3.5 px-6 rounded-full bg-white/15 border border-white/25 text-white placeholder-emerald-200/60 focus:outline-none focus:border-white/50 focus:bg-white/20 backdrop-blur-sm transition text-sm" placeholder="Enter your email address...">
                    <button class="bg-white text-emerald-700 font-bold py-3.5 px-8 rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 text-sm whitespace-nowrap">
                        Subscribe Now ✨
                    </button>
                </div>
                <p class="text-emerald-200/50 text-xs mt-4">No spam, unsubscribe anytime. We respect your privacy.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     BRAND PARTNERS
     ============================================ -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 reveal">
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">Trusted Pharma Partners</h2>
            <p class="text-slate-500 mt-2">We partner with Bangladesh's leading pharmaceutical companies</p>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-6 gap-6 reveal">
            @php
                $brands = ['Square Pharma', 'Beximco', 'Incepta', 'Healthcare', 'Renata', 'ACI'];
            @endphp
            @foreach($brands as $brand)
            <div class="flex items-center justify-center p-6 bg-slate-50 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 hover:shadow-md transition-all duration-300 group cursor-pointer">
                <span class="text-sm font-bold text-slate-400 group-hover:text-emerald-600 transition-colors">{{ $brand }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var categorySwiper = new Swiper('.categorySwiper', {
                slidesPerView: 2,
                spaceBetween: 16,
                navigation: {
                    nextEl: '.categorySwiper .swiper-button-next',
                    prevEl: '.categorySwiper .swiper-button-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 3, spaceBetween: 20 },
                    768: { slidesPerView: 4, spaceBetween: 20 },
                    1024: { slidesPerView: 6, spaceBetween: 20 },
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                loop: false
            });
        });
    </script>
@endpush

@push('scripts')
<script>
    // Flash Sale Countdown Timer
    function startCountdown() {
        // Set countdown for 12 hours from now
        let totalSeconds = 12 * 3600 + 45 * 60 + 30;
        
        function updateTimer() {
            if (totalSeconds <= 0) return;
            totalSeconds--;
            
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            const hEl = document.getElementById('countHours');
            const mEl = document.getElementById('countMinutes');
            const sEl = document.getElementById('countSeconds');
            
            if (hEl) hEl.textContent = String(hours).padStart(2, '0');
            if (mEl) mEl.textContent = String(minutes).padStart(2, '0');
            if (sEl) sEl.textContent = String(seconds).padStart(2, '0');
        }
        
        setInterval(updateTimer, 1000);
    }
    
    startCountdown();
</script>
@endpush
