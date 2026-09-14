@extends('frontend.layouts.app')

@push('styles')
<style>
/* ─── Product Detail Page ─── */
.pd-breadcrumb {
    padding: 16px 0;
    font-size: 13px;
    color: #94a3b8;
}
.pd-breadcrumb a { color: #64748b; text-decoration: none; }
.pd-breadcrumb a:hover { color: #10b981; }

.pd-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: start;
}
@media (max-width: 768px) {
    .pd-main { grid-template-columns: 1fr; gap: 24px; }
}

/* Image Gallery */
.pd-gallery {
    position: sticky;
    top: 100px;
}
.pd-img-main {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 20px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    margin-bottom: 12px;
}
.pd-img-main img {
    width: 100%; height: 100%; object-fit: contain; padding: 20px;
}
.pd-img-thumbs {
    display: flex;
    gap: 10px;
    overflow-x: auto;
}
.pd-img-thumb {
    width: 72px; height: 72px;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    overflow: hidden;
    cursor: pointer;
    transition: all .2s;
    flex-shrink: 0;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pd-img-thumb.active, .pd-img-thumb:hover {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,.15);
}
.pd-img-thumb img { width: 100%; height: 100%; object-fit: cover; }

/* Info Section */
.pd-brand {
    display: inline-flex; align-items: center; gap: 6px;
    background: #f0fdf4; color: #059669;
    font-size: 12px; font-weight: 700;
    padding: 4px 12px; border-radius: 20px;
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: 10px;
}
.pd-title {
    font-size: 28px; font-weight: 800; color: #0f172a;
    line-height: 1.3; margin-bottom: 6px;
}
.pd-generic {
    font-size: 15px; color: #64748b; margin-bottom: 16px;
}
.pd-meta-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 10px; margin-bottom: 20px;
}
.pd-meta-item {
    background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 12px; padding: 12px 14px; text-align: center;
}
.pd-meta-item .label {
    font-size: 10px; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .8px;
}
.pd-meta-item .val {
    font-size: 14px; font-weight: 700; color: #0f172a; margin-top: 2px;
}

/* Price Section */
.pd-price-box {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
    border-radius: 16px; padding: 24px; margin-bottom: 20px;
    display: flex; align-items: center; justify-content: space-between;
}
.pd-price-now {
    font-size: 36px; font-weight: 900; color: #10b981;
}
.pd-price-old {
    font-size: 18px; color: #94a3b8; text-decoration: line-through; margin-left: 12px;
}
.pd-discount-tag {
    background: linear-gradient(135deg, #ef4444, #f43f5e);
    color: #fff; font-size: 14px; font-weight: 800;
    padding: 6px 16px; border-radius: 10px;
}

/* Quantity & Buy */
.pd-qty-row {
    display: flex; align-items: center; gap: 12px; margin-bottom: 24px;
}
.pd-qty-wrap {
    display: flex; align-items: center; border: 2px solid #e2e8f0;
    border-radius: 12px; overflow: hidden;
}
.pd-qty-btn {
    width: 42px; height: 42px; border: none; background: #f8fafc;
    font-size: 18px; font-weight: 700; color: #334155;
    cursor: pointer; transition: all .2s;
}
.pd-qty-btn:hover { background: #e2e8f0; }
.pd-qty-input {
    width: 50px; height: 42px; border: none; text-align: center;
    font-size: 16px; font-weight: 700; color: #0f172a;
    outline: none; background: #fff;
}
.pd-buy-btn {
    flex: 1; display: flex; align-items: center; justify-content: center;
    gap: 8px; padding: 14px 32px; border-radius: 14px; border: none;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; font-size: 16px; font-weight: 700;
    cursor: pointer; transition: all .3s; text-decoration: none;
}
.pd-buy-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(16,185,129,.35);
}

/* Tags */
.pd-tags {
    display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
}
.pd-tag {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: 10px;
    background: #f8fafc; border: 1px solid #e2e8f0;
    font-size: 12px; font-weight: 600; color: #475569;
}
.pd-tag svg { width: 14px; height: 14px; }
.pd-tag.rx { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }

/* Description */
.pd-desc-section {
    margin-top: 40px;
}
.pd-desc-card {
    background: #fff; border-radius: 16px;
    border: 1px solid #e2e8f0; padding: 28px;
}
.pd-desc-title {
    font-size: 18px; font-weight: 800; color: #0f172a; margin-bottom: 14px;
    display: flex; align-items: center; gap: 8px;
}
.pd-desc-content {
    font-size: 14px; color: #475569; line-height: 1.8;
}

/* Related */
.pd-related {
    margin-top: 50px; padding-top: 40px;
    border-top: 1px solid #e2e8f0;
}
.pd-related-title {
    font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<section class="bg-white py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <div class="pd-breadcrumb">
            <a href="{{ route('home') }}">Home</a> ›
            @if($product->category)
                <a href="{{ route('category.products', $product->category->id) }}">{{ $product->category->name }}</a> ›
            @endif
            <span class="text-slate-800 font-semibold">{{ $product->name }}</span>
        </div>

        {{-- Main Product --}}
        <div class="pd-main">

            {{-- Gallery --}}
            <div class="pd-gallery">
                @php
                    $images = $product->product_images;
                    $primaryImg = $images->where('is_primary', 1)->first() ?? $images->first();
                @endphp

                <div class="pd-img-main" id="mainImage">
                    @if($primaryImg)
                        <img src="{{ asset('storage/'.$primaryImg->image_url) }}" alt="{{ $product->name }}" id="mainImgEl">
                    @else
                        <svg class="w-32 h-32 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    @endif
                </div>

                @if($images->count() > 1)
                <div class="pd-img-thumbs">
                    @foreach($images as $i => $img)
                    <div class="pd-img-thumb {{ $img->id == optional($primaryImg)->id ? 'active' : '' }}"
                         onclick="changeImage('{{ asset('storage/'.$img->image_url) }}', this)">
                        <img src="{{ asset('storage/'.$img->image_url) }}" alt="">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div>
                @if($product->manufacturer)
                    <div class="pd-brand">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $product->manufacturer->name }}
                    </div>
                @endif

                <h1 class="pd-title">{{ $product->name }}</h1>
                <p class="pd-generic">
                    {{ $product->generic->name ?? '' }}
                    @if($product->strength) • {{ $product->strength }} @endif
                </p>

                {{-- Meta Grid --}}
                <div class="pd-meta-grid">
                    @if($product->dosage_form)
                    <div class="pd-meta-item">
                        <div class="label">Form</div>
                        <div class="val">{{ $product->dosage_form }}</div>
                    </div>
                    @endif
                    @if($product->pack_size)
                    <div class="pd-meta-item">
                        <div class="label">Pack Size</div>
                        <div class="val">{{ $product->pack_size }}</div>
                    </div>
                    @endif
                    @if($product->medicine_type)
                    <div class="pd-meta-item">
                        <div class="label">Type</div>
                        <div class="val">{{ $product->medicine_type }}</div>
                    </div>
                    @endif
                </div>

                {{-- Tags --}}
                <div class="pd-tags">
                    @if($product->category)
                        <span class="pd-tag">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            {{ $product->category->name }}
                        </span>
                    @endif
                    @if($product->prescription_required)
                        <span class="pd-tag rx">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Prescription Required
                        </span>
                    @endif
                    @if($product->brand)
                        <span class="pd-tag">{{ $product->brand->name }}</span>
                    @endif
                </div>

                {{-- Price Box --}}
                <div class="pd-price-box">
                    <div>
                        <span class="pd-price-now">৳{{ number_format($product->sale_price, 2) }}</span>
                        @if($product->discount > 0 && $product->mrp > $product->sale_price)
                            <span class="pd-price-old">৳{{ number_format($product->mrp, 2) }}</span>
                        @endif
                    </div>
                    @if($product->discount > 0)
                        <div class="pd-discount-tag">{{ (int)$product->discount }}% OFF</div>
                    @endif
                </div>

                {{-- Quantity + Buy --}}
                <div class="pd-qty-row">
                    <div class="pd-qty-wrap">
                        <button type="button" class="pd-qty-btn" onclick="changeQty(-1)">−</button>
                        <input type="number" class="pd-qty-input" id="qty" value="1" min="1">
                        <button type="button" class="pd-qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                    <div class="flex flex-1 gap-3">
                        <button type="button" class="pd-buy-btn" style="flex:1;" onclick="addToCart(event, {{ $product->id }}, document.getElementById('qty').value, this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Add to Cart
                        </button>
                        <button type="button" class="pd-buy-btn" style="flex:1; background: linear-gradient(135deg, #0f172a, #334155);" onclick="buyNow(event, {{ $product->id }})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            Checkout Now
                        </button>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div class="grid grid-cols-3 gap-3 mt-4">
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        100% Genuine
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Fast Delivery
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Best Price
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        @if($product->description)
        <div class="pd-desc-section">
            <div class="pd-desc-card">
                <div class="pd-desc-title">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Product Description
                </div>
                <div class="pd-desc-content">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
        </div>
        @endif

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <div class="pd-related">
            <h2 class="pd-related-title">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($relatedProducts as $rp)
                @php
                    $rpImg = $rp->product_images->where('is_primary', 1)->first() ?? $rp->product_images->first();
                @endphp
                <a href="{{ route('product.detail', $rp->id) }}" class="cp-product block" style="text-decoration:none;">
                    <div class="cp-product-img">
                        @if($rpImg)
                            <img src="{{ asset('storage/'.$rpImg->image_url) }}" alt="{{ $rp->name }}">
                        @else
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        @endif
                        @if($rp->discount > 0)
                            <div class="cp-discount-tag">-{{ (int)$rp->discount }}%</div>
                        @endif
                    </div>
                    <div class="cp-product-body">
                        <div class="cp-product-brand">{{ $rp->manufacturer->name ?? '' }}</div>
                        <div class="cp-product-name">{{ $rp->name }}</div>
                        <div class="cp-price-row" style="margin-top:8px;">
                            <span class="cp-price">৳{{ number_format($rp->sale_price, 2) }}</span>
                            @if($rp->discount > 0 && $rp->mrp > $rp->sale_price)
                                <span class="cp-price-old">৳{{ number_format($rp->mrp, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const el = document.getElementById('qty');
    let val = parseInt(el.value) + delta;
    if (val < 1) val = 1;
    el.value = val;
}

function changeImage(src, thumbEl) {
    const mainImg = document.getElementById('mainImgEl');
    if (mainImg) mainImg.src = src;
    document.querySelectorAll('.pd-img-thumb').forEach(t => t.classList.remove('active'));
    if (thumbEl) thumbEl.classList.add('active');
}
</script>
@endpush
