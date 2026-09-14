@if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($products as $product)
        @php
            $primaryImage = $product->product_images->where('is_primary', 1)->first()
                         ?? $product->product_images->first();
        @endphp
        <div class="cp-product">
            <a href="{{ route('product.detail', $product->id) }}" class="block">
                <div class="cp-product-img">
                    @if($primaryImage && $primaryImage->image_url)
                        <img src="{{ asset('storage/'.$primaryImage->image_url) }}" alt="{{ $product->name }}">
                    @else
                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    @endif

                    @if($product->discount > 0)
                        <div class="cp-discount-tag">-{{ (int)$product->discount }}%</div>
                    @endif
                    @if($product->prescription_required)
                        <div class="cp-rx-tag">Rx</div>
                    @endif
                </div>
            </a>
            <div class="cp-product-body">
                <div class="cp-product-brand">
                    {{ $product->manufacturer->name ?? ($product->brand->name ?? '') }}
                </div>
                <a href="{{ route('product.detail', $product->id) }}" class="block hover:text-emerald-600 transition-colors">
                    <div class="cp-product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                </a>
                <div class="cp-product-generic">{{ $product->generic->name ?? '' }} {{ $product->strength ?? '' }}</div>

                <div class="cp-price-row">
                    <div>
                        <span class="cp-price">৳{{ number_format($product->sale_price, 2) }}</span>
                        @if($product->discount > 0 && $product->mrp > $product->sale_price)
                            <span class="cp-price-old">৳{{ number_format($product->mrp, 2) }}</span>
                        @endif
                    </div>
                    <a href="{{ route('product.detail', $product->id) }}" class="cp-buy-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Buy Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="cp-empty">
        <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        <p class="text-lg font-semibold text-slate-500">No products found</p>
        <p class="text-sm text-slate-400 mt-1">Try a different search term or browse another category.</p>
    </div>
@endif
