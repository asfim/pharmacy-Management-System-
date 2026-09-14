@extends('frontend.layouts.app')

@push('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
@endpush

@section('content')

<!-- ============================================
     HERO SECTION — Dynamic Single Hero
     ============================================ -->
@if(isset($sliders) && $sliders->count() > 0)
@php $hero = $sliders->first(); @endphp
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 animate-gradient min-h-[600px] flex items-center">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-400/20 rounded-full blur-3xl animate-blob delay-300"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-teal-300/15 rounded-full blur-3xl animate-blob delay-700"></div>
        <div class="absolute top-20 right-[15%] text-4xl animate-float opacity-20">💊</div>
        <div class="absolute top-40 right-[35%] text-3xl animate-float-slow delay-200 opacity-15">🩺</div>
        <div class="absolute bottom-32 left-[10%] text-4xl animate-float-reverse delay-500 opacity-20">🧬</div>
        <div class="absolute top-28 left-[20%] text-3xl animate-float delay-700 opacity-15">🩹</div>
        <div class="absolute bottom-20 right-[25%] text-3xl animate-float-slow delay-1000 opacity-15">💉</div>
        <div class="absolute top-1/2 right-[8%] text-5xl animate-float-reverse opacity-10">🔬</div>
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-white">
                @if($hero->title)
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 animate-slide-up">
                    {{ $hero->title }}
                    @if($hero->highlight_title)
                    <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 via-white to-cyan-200">{{ $hero->highlight_title }}</span>
                    @endif
                </h1>
                @endif

                @if($hero->description)
                <p class="text-lg md:text-xl text-emerald-100/90 mb-10 max-w-lg leading-relaxed animate-slide-up" style="animation-delay: 200ms">
                    {{ $hero->description }}
                </p>
                @endif

                @if($hero->button_text && $hero->button_link)
                <div class="flex flex-wrap gap-4 animate-slide-up" style="animation-delay: 300ms">
                    <a href="{{ $hero->button_link }}" class="btn-glow inline-flex items-center space-x-2 bg-white text-emerald-700 font-bold py-3.5 px-8 rounded-full shadow-xl shadow-black/10 hover:bg-emerald-50 transition-all duration-300 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>{{ $hero->button_text }}</span>
                    </a>
                </div>
                @endif
            </div>

            <!-- Right Side — Hero Image -->
            <div class="hidden lg:block relative">
                <div class="relative z-10">
                    @if($hero->image)
                        @if(str_starts_with($hero->image, 'assets/'))
                            <img src="{{ asset($hero->image) }}" alt="{{ $hero->title ?? 'Hero' }}" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl">
                        @else
                            <img src="{{ asset('storage/' . $hero->image) }}" alt="{{ $hero->title ?? 'Hero' }}" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl">
                        @endif
                    @endif
                </div>
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
@else
{{-- Fallback: Original static hero section when no sliders exist --}}
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 animate-gradient min-h-[600px] flex items-center">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-400/20 rounded-full blur-3xl animate-blob delay-300"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-teal-300/15 rounded-full blur-3xl animate-blob delay-700"></div>
        <div class="absolute top-20 right-[15%] text-4xl animate-float opacity-20">💊</div>
        <div class="absolute top-40 right-[35%] text-3xl animate-float-slow delay-200 opacity-15">🩺</div>
        <div class="absolute bottom-32 left-[10%] text-4xl animate-float-reverse delay-500 opacity-20">🧬</div>
        <div class="absolute top-28 left-[20%] text-3xl animate-float delay-700 opacity-15">🩹</div>
        <div class="absolute bottom-20 right-[25%] text-3xl animate-float-slow delay-1000 opacity-15">💉</div>
        <div class="absolute top-1/2 right-[8%] text-5xl animate-float-reverse opacity-10">🔬</div>
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <div class="inline-flex items-center space-x-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 mb-6 text-sm font-medium animate-slide-up">
                    <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                    <span>{{ $siteSettings['hero_badge_text'] ?? '🎉 Trusted by 50,000+ customers' }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 animate-slide-up" style="animation-delay: 100ms">
                    {{ $siteSettings['hero_title'] ?? 'Your Health,' }}<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 via-white to-cyan-200">{{ $siteSettings['hero_highlight'] ?? 'Delivered Fast!' }}</span>
                </h1>
                <p class="text-lg md:text-xl text-emerald-100/90 mb-10 max-w-lg animate-slide-up leading-relaxed" style="animation-delay: 200ms">
                    {{ $siteSettings['hero_desc'] ?? 'Order 100% genuine medicines online and get them delivered to your doorstep within 24 hours, securely & hassle-free.' }}
                </p>
                <div class="flex flex-wrap gap-4 animate-slide-up" style="animation-delay: 300ms">
                    <a href="{{ $siteSettings['hero_btn1_link'] ?? route('products') }}" class="btn-glow inline-flex items-center space-x-2 bg-white text-emerald-700 font-bold py-3.5 px-8 rounded-full shadow-xl shadow-black/10 hover:bg-emerald-50 transition-all duration-300 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>{{ $siteSettings['hero_btn1_text'] ?? 'Order Now' }}</span>
                    </a>
                    <a href="{{ $siteSettings['hero_btn2_link'] ?? '#' }}" class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white font-bold py-3.5 px-8 rounded-full hover:bg-white/20 transition-all duration-300 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <span>{{ $siteSettings['hero_btn2_text'] ?? 'Upload Prescription' }}</span>
                    </a>
                </div>
                <div class="flex flex-wrap gap-8 mt-12 animate-slide-up" style="animation-delay: 400ms">
                    <div class="text-center">
                        <div class="text-2xl font-extrabold" data-counter data-target="{{ $siteSettings['hero_stat1_num'] ?? '10000' }}" data-suffix="+">0</div>
                        <div class="text-emerald-200/70 text-xs font-medium mt-1">{{ $siteSettings['hero_stat1_label'] ?? 'Products' }}</div>
                    </div>
                    <div class="w-px bg-white/20 self-stretch"></div>
                    <div class="text-center">
                        <div class="text-2xl font-extrabold" data-counter data-target="{{ $siteSettings['hero_stat2_num'] ?? '50000' }}" data-suffix="+">0</div>
                        <div class="text-emerald-200/70 text-xs font-medium mt-1">{{ $siteSettings['hero_stat2_label'] ?? 'Happy Customers' }}</div>
                    </div>
                    <div class="w-px bg-white/20 self-stretch"></div>
                    <div class="text-center">
                        <div class="text-2xl font-extrabold" data-counter data-target="{{ $siteSettings['hero_stat3_num'] ?? '30' }}" data-suffix="+">0</div>
                        <div class="text-emerald-200/70 text-xs font-medium mt-1">{{ $siteSettings['hero_stat3_label'] ?? 'Branches' }}</div>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <div class="relative z-10">
                    @if(isset($siteSettings['hero_image']) && $siteSettings['hero_image'])
                        <img src="{{ asset('storage/' . $siteSettings['hero_image']) }}" alt="Hero Illustration" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl">
                    @else
                        <img src="{{ asset('assets/images/hero_illustration.jpg') }}" alt="PharmaSys App Illustration" class="w-full max-w-lg mx-auto rounded-3xl shadow-2xl">
                    @endif
                </div>
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-400 to-teal-400 rounded-full blur-3xl opacity-30 -z-10"></div>
            </div>
        </div>
    </div>

    <div class="wave-divider">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-white">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C57.1,88.13,125.63,68.46,190.7,58.75,242.93,51.24,279.59,61.11,321.39,56.44Z"></path>
        </svg>
    </div>
</section>
@endif

<!-- ============================================
     FEATURES STRIP — Glassmorphic Cards
     ============================================ -->
<section class="py-14 bg-white relative -mt-1">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach($cmsFeatures as $i => $f)
            <div class="card-hover reveal bg-white rounded-2xl p-5 md:p-6 border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow hover:shadow-xl text-center group" style="animation-delay: {{ $i * 100 }}ms">
                <div class="w-14 h-14 mx-auto bg-{{ $f->color }}-100 rounded-2xl flex items-center justify-center text-{{ $f->color }}-600 mb-4 group-hover:bg-gradient-to-br group-hover:from-{{ $f->color }}-500 group-hover:to-{{ $f->color }}-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 group-hover:shadow-lg">
                    {!! $f->icon !!}
                </div>
                <h3 class="font-bold text-slate-800 text-sm md:text-base">{{ $f->title }}</h3>
                <p class="text-xs md:text-sm text-slate-500 mt-1.5">{{ $f->description }}</p>
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
                    <a href="{{ route('category.products', $cat->id) }}" class="category-card reveal bg-white rounded-2xl p-5 text-center border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow group block h-full" style="animation-delay: {{ ($i % 6) * 80 }}ms">
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
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-2">Flash Sale — Up to {{ (int)$maxDiscount }}% OFF!</h2>
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

            <!-- Flash Sale Swiper Carousel -->
            @if(isset($discountedProducts) && $discountedProducts->count() > 0)
            <div class="relative z-10 mt-12">
                <div class="swiper flashSaleSwiper relative px-2">
                    <div class="swiper-wrapper py-4">
                        @foreach($discountedProducts as $product)
                        @php
                            $primaryImage = $product->product_images->where('is_primary', 1)->first() ?? $product->product_images->first();
                        @endphp
                        <div class="swiper-slide h-auto">
                            <div class="bg-white/20 backdrop-blur-xl border border-white/40 rounded-2xl overflow-hidden flex flex-col h-full shadow-[0_8px_32px_0_rgba(31,38,135,0.15)] hover:shadow-[0_8px_32px_0_rgba(31,38,135,0.25)] transition-all duration-300 transform hover:-translate-y-1">
                                <a href="{{ route('product.detail', $product->id) }}" class="block relative h-48 bg-white/50 flex items-center justify-center p-2">
                                    @if($primaryImage && $primaryImage->image_url)
                                        <img src="{{ asset('storage/'.$primaryImage->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply">
                                    @else
                                        <svg class="w-12 h-12 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    @endif
                                    <div class="absolute top-2 left-2 bg-gradient-to-br from-rose-500 to-pink-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-md shadow-sm">-{{ (int)$product->discount }}%</div>
                                </a>
                                <div class="p-4 flex-1 flex flex-col">
                                    <div class="text-[10px] font-bold text-emerald-200 uppercase tracking-wide mb-1">{{ $product->manufacturer->name ?? ($product->brand->name ?? '') }}</div>
                                    <a href="{{ route('product.detail', $product->id) }}" class="font-bold text-white text-sm line-clamp-1 mb-1 hover:text-rose-200 transition-colors">{{ $product->name }}</a>
                                    <div class="text-xs text-white/80 mb-3 line-clamp-1">{{ $product->generic->name ?? '' }} {{ $product->strength ?? '' }}</div>
                                    <div class="mt-auto flex items-center justify-between pt-3 border-t border-white/20">
                                        @php
                                            $originalPrice = $product->mrp > $product->sale_price ? $product->mrp : $product->sale_price;
                                            $finalPrice = $product->sale_price;
                                            if($product->discount > 0) {
                                                $finalPrice = $originalPrice - ($originalPrice * $product->discount / 100);
                                            }
                                        @endphp
                                        <div class="flex items-baseline space-x-2">
                                            <div class="font-black text-white text-lg">৳{{ number_format($finalPrice, 2) }}</div>
                                            @if($originalPrice > $finalPrice)
                                                <div class="text-xs text-white/70 line-through">৳{{ number_format($originalPrice, 2) }}</div>
                                            @endif
                                        </div>
                                        <a href="{{ route('product.detail', $product->id) }}" class="w-8 h-8 rounded-lg bg-white/20 text-white hover:bg-white hover:text-rose-600 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Flash Sale Navigation Arrows -->
                    <div class="swiper-button-prev flash-prev !text-rose-600 !bg-white/90 backdrop-blur-sm !w-10 !h-10 !rounded-full shadow-lg hover:shadow-xl after:!text-sm border border-white/50 flex !-left-2"></div>
                    <div class="swiper-button-next flash-next !text-rose-600 !bg-white/90 backdrop-blur-sm !w-10 !h-10 !rounded-full shadow-lg hover:shadow-xl after:!text-sm border border-white/50 flex !-right-2"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- ============================================
     CATEGORY PRODUCTS
     ============================================ -->
@foreach($categories as $category)
    @if(isset($category->home_products) && $category->home_products->count() > 0)
    <section class="py-12 {{ $loop->iteration % 2 == 0 ? 'bg-white' : 'bg-slate-50' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8 reveal">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 section-title-line">{{ $category->name }}</h2>
                    <p class="text-slate-500 mt-2">Explore our collection of {{ strtolower($category->name) }}</p>
                </div>
                <a href="{{ route('category.products', $category->id) }}" class="hidden md:inline-flex items-center space-x-2 text-emerald-600 font-semibold hover:text-emerald-700 transition group">
                    <span>View Category</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 md:gap-6" id="category-grid-{{ $category->id }}">
                @include('frontend.home._product_cards', ['products' => $category->home_products])
            </div>

            <!-- Load More Button -->
            @if($category->products_count > 8)
            <div class="mt-10 text-center reveal">
                <button type="button" class="btn-load-more inline-flex items-center space-x-2 text-emerald-600 font-semibold border-2 border-emerald-200 px-8 py-3 rounded-full hover:bg-emerald-50 hover:border-emerald-300 transition-all shadow-sm hover:shadow-md" data-category-id="{{ $category->id }}" data-skip="8">
                    <span>Load More</span>
                    <svg class="w-4 h-4 animate-bounce-y" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </div>
            @endif
        </div>
    </section>
    @endif
@endforeach

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
            <div class="testimonial-card reveal bg-white rounded-2xl p-7 border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow" style="animation-delay: {{ $i * 150 }}ms">
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
                loop: false,
                preventClicks: false,
                preventClicksPropagation: false
            });

            var flashSaleSwiper = new Swiper('.flashSaleSwiper', {
                slidesPerView: 2,
                spaceBetween: 16,
                navigation: {
                    nextEl: '.flashSaleSwiper .flash-next',
                    prevEl: '.flashSaleSwiper .flash-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 3, spaceBetween: 20 },
                    768: { slidesPerView: 4, spaceBetween: 20 },
                    1024: { slidesPerView: 4, spaceBetween: 24 },
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
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

    // Category Load More Products
    document.querySelectorAll('.btn-load-more').forEach(button => {
        button.addEventListener('click', async function() {
            const btn = this;
            const categoryId = btn.getAttribute('data-category-id');
            const skip = parseInt(btn.getAttribute('data-skip'));
            
            // Add loading state
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span>Loading...</span><svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
            btn.disabled = true;

            try {
                const response = await fetch(`/ajax/category-products/${categoryId}?skip=${skip}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                
                if (data.html) {
                    const grid = document.getElementById(`category-grid-${categoryId}`);
                    grid.insertAdjacentHTML('beforeend', data.html);
                    
                    // Update skip
                    btn.setAttribute('data-skip', skip + 8);
                    
                    // Hide button if less than 8 items returned
                    if (data.count < 8) {
                        btn.parentElement.style.display = 'none';
                    }
                }
            } catch (error) {
                console.error("Failed to load more products:", error);
            } finally {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        });
    });
</script>
@endpush
