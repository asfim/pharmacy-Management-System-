@foreach($products as $product)
@php
    $primaryImage = $product->product_images->where('is_primary', 1)->first() ?? $product->product_images->first();
    $originalPrice = $product->mrp > $product->sale_price ? $product->mrp : $product->sale_price;
    $finalPrice = $product->sale_price;
    if($product->discount > 0) {
        $finalPrice = $originalPrice - ($originalPrice * $product->discount / 100);
    }
@endphp
<div class="product-card card-hover bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow overflow-hidden group relative flex flex-col h-full">
    @if($product->discount > 0)
    <div class="ribbon bg-gradient-to-r from-rose-500 to-pink-500 text-white shadow-lg">
        -{{ (int)$product->discount }}%
    </div>
    @endif

    <!-- Image Area -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100 h-36 sm:h-44 flex items-center justify-center">
        @if($primaryImage && $primaryImage->image_url)
            @if(str_starts_with($primaryImage->image_url, 'http'))
                <img src="{{ $primaryImage->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply p-4">
            @else
                <img src="{{ asset('storage/'.$primaryImage->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply p-4">
            @endif
        @else
            <div class="product-image text-6xl">💊</div>
        @endif

        <!-- Overlay Actions -->
        <div class="product-overlay absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100 transition-opacity">
            <div class="flex space-x-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                <button type="button" onclick="addToCart(event, {{ $product->id }}, 1, this)" class="w-9 h-9 rounded-full bg-white text-slate-700 flex items-center justify-center hover:bg-emerald-500 hover:text-white transition-all shadow-lg text-sm" title="Add to Cart">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </button>
                <button type="button" class="w-9 h-9 rounded-full bg-white text-slate-700 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg text-sm" title="Add to Wishlist">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </button>
                <a href="{{ route('product.detail', $product->id) }}" class="w-9 h-9 rounded-full bg-white text-slate-700 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-lg text-sm" title="Quick View">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="p-2.5 sm:p-4 flex-1 flex flex-col">
        <div class="text-xs font-semibold text-emerald-600 mb-1">{{ $product->manufacturer->name ?? ($product->brand->name ?? '') }}</div>
        <a href="{{ route('product.detail', $product->id) }}">
            <h3 class="font-bold text-slate-800 text-sm truncate mb-0.5 group-hover:text-emerald-600 transition-colors">{{ $product->name }}</h3>
        </a>
        <p class="text-xs text-slate-400 mb-3">{{ $product->generic->name ?? '' }} {{ $product->strength ?? '' }}</p>

        <!-- Rating -->
        <div class="flex items-center space-x-1 mb-3">
            <div class="flex text-amber-400 text-xs">★★★★<span class="text-slate-300">★</span></div>
            <span class="text-[10px] text-slate-400">(4.0)</span>
        </div>

        <!-- Price -->
        <div class="flex items-center justify-between mt-auto">
            <div class="flex flex-col sm:flex-row sm:items-baseline sm:space-x-2">
                <span class="text-base sm:text-lg font-extrabold text-slate-900">৳{{ number_format($finalPrice, 2) }}</span>
                @if($originalPrice > $finalPrice)
                <span class="text-[10px] sm:text-xs text-slate-400 line-through mt-0.5 sm:mt-0">৳{{ number_format($originalPrice, 2) }}</span>
                @endif
            </div>
            <button type="button" onclick="buyNow(event, {{ $product->id }})" class="w-9 h-9 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white flex items-center justify-center hover:shadow-lg hover:shadow-emerald-500/30 hover:scale-110 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </button>
        </div>
    </div>
</div>
@endforeach
