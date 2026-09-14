@if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-5">
        @foreach($products as $product)
        <div class="cp-product">
            <div class="cp-product-img">
                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                @else
                    💊
                @endif

                @if($product->discount > 0)
                    <div class="cp-discount-tag">-{{ (int)$product->discount }}%</div>
                @endif

                @if($product->prescription_required)
                    <div class="cp-rx-tag">Rx</div>
                @endif
            </div>
            <div class="cp-product-body">
                <div class="cp-product-brand">
                    {{ $product->manufacturer->name ?? ($product->brand->name ?? 'N/A') }}
                </div>
                <div class="cp-product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                <div class="cp-product-generic">{{ $product->generic->name ?? '' }}</div>

                <div class="cp-product-meta">
                    @if($product->strength)
                        <span>{{ $product->strength }}</span>
                    @endif
                    @if($product->dosage_form)
                        <span>{{ $product->dosage_form }}</span>
                    @endif
                    @if($product->pack_size)
                        <span>{{ $product->pack_size }}</span>
                    @endif
                </div>

                <div class="cp-price-row">
                    <div>
                        <span class="cp-price">৳{{ number_format($product->sale_price, 2) }}</span>
                        @if($product->discount > 0 && $product->mrp > $product->sale_price)
                            <span class="cp-price-old">৳{{ number_format($product->mrp, 2) }}</span>
                        @endif
                    </div>
                    <button class="cp-add-btn" title="Add to Cart">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </button>
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
