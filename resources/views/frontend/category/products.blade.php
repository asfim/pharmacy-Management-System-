@extends('frontend.layouts.app')

@push('styles')
<style>
.cp-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #065f46 100%);
    padding: 50px 0 70px;
    position: relative;
    overflow: hidden;
}
.cp-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 300px; height: 300px;
    background: rgba(16,185,129,.12);
    border-radius: 50%;
}
.cp-search-wrap {
    position: relative;
    max-width: 560px;
}
.cp-search-input {
    width: 100%;
    padding: 14px 20px 14px 52px;
    border: 2px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.08);
    backdrop-filter: blur(12px);
    border-radius: 16px;
    color: #fff;
    font-size: 15px;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: all .3s;
}
.cp-search-input::placeholder { color: rgba(255,255,255,.45); }
.cp-search-input:focus {
    border-color: #10b981;
    background: rgba(255,255,255,.12);
    box-shadow: 0 0 0 4px rgba(16,185,129,.15);
}
.cp-search-icon {
    position: absolute; left: 18px; top: 50%; transform: translateY(-50%);
    color: rgba(255,255,255,.4); pointer-events: none;
}
.cp-search-spinner {
    position: absolute; right: 16px; top: 50%; transform: translateY(-50%); display: none;
}
.cp-search-spinner.active { display: block; }
.cp-breadcrumb {
    display: flex; align-items: center; gap: 8px; font-size: 13px; margin-bottom: 12px;
}
.cp-breadcrumb a { color: rgba(255,255,255,.6); text-decoration: none; }
.cp-breadcrumb a:hover { color: #fff; }
.cp-breadcrumb .sep { color: rgba(255,255,255,.3); }
.cp-breadcrumb .current { color: #10b981; font-weight: 600; }

/* Product Card */
.cp-product {
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.cp-product:hover {
    border-color: #cbd5e1;
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
.cp-product-img {
    height: 220px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 52px;
    position: relative;
    overflow: hidden;
    padding: 10px;
}
.cp-product-img img {
    width: 100%; height: 100%; object-fit: contain;
}
.cp-discount-tag {
    position: absolute; top: 10px; left: 10px;
    background: linear-gradient(135deg, #ef4444, #f43f5e);
    color: #fff; font-size: 11px; font-weight: 800;
    padding: 3px 10px; border-radius: 8px;
}
.cp-rx-tag {
    position: absolute; top: 10px; right: 10px;
    background: rgba(99,102,241,.9);
    color: #fff; font-size: 10px; font-weight: 700;
    padding: 3px 8px; border-radius: 6px;
}
.cp-product-body { padding: 16px; }
.cp-product-brand {
    font-size: 11px; font-weight: 600; color: #10b981;
    text-transform: uppercase; letter-spacing: .5px;
}
.cp-product-name {
    font-size: 14px; font-weight: 700; color: #0f172a;
    margin: 4px 0 2px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.cp-product-generic {
    font-size: 12px; color: #94a3b8; margin-bottom: 10px;
}
.cp-price-row {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 10px; border-top: 1px solid #f1f5f9;
}
.cp-price { font-size: 18px; font-weight: 800; color: #0f172a; }
.cp-price-old {
    font-size: 12px; color: #94a3b8; text-decoration: line-through; margin-left: 6px;
}
.cp-buy-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 10px; border: none;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; font-size: 13px; font-weight: 700;
    cursor: pointer; transition: all .25s; text-decoration: none;
}
.cp-buy-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 16px rgba(16,185,129,.4);
    text-decoration: none; color: #fff;
}
.cp-results-bar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; padding: 12px 16px;
    background: #fff; border-radius: 12px; border: 1px solid #e2e8f0;
}
.cp-empty {
    text-align: center; padding: 60px 20px; color: #94a3b8;
}
.cp-pagination { margin-top: 30px; display: flex; justify-content: center; }

/* Responsive adjustments */
@media (max-width: 640px) {
    .cp-product-img { height: 150px; }
    .cp-product-body { padding: 12px; }
    .cp-price-row { 
        flex-direction: column; 
        align-items: flex-start; 
        gap: 8px; 
    }
    .cp-buy-btn { 
        width: 100%; 
        justify-content: center; 
        padding: 6px 12px;
    }
    .cp-price { font-size: 16px; }
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="cp-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="cp-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">›</span>
            <span class="current">{{ $category->name }}</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">{{ $category->name }}</h1>
        <p class="text-slate-400 text-sm mb-6">{{ $products->total() }} products found</p>
        <div class="cp-search-wrap">
            <div class="cp-search-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="liveSearch" class="cp-search-input" placeholder="Search in {{ $category->name }}..." autocomplete="off">
            <div class="cp-search-spinner" id="searchSpinner">
                <svg class="animate-spin w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none" class="fill-slate-50 w-full" style="height:40px"><path d="M0,40 C300,80 900,0 1200,40 L1200,80 L0,80Z"></path></svg>
    </div>
</div>

{{-- PRODUCTS --}}
<section class="py-10 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cp-results-bar">
            <span class="text-sm text-slate-600" id="resultCount">
                Showing <strong>{{ $products->count() }}</strong> of <strong>{{ $products->total() }}</strong> products
            </span>
            <span class="text-xs text-slate-400" id="searchHint">Type to search instantly...</span>
        </div>

        <div id="productGrid">
            @include('frontend.category._product_grid', ['products' => $products])
        </div>

        <div id="loadMoreSentinel" class="py-8 flex justify-center items-center" style="display: {{ $products->hasMorePages() ? 'flex' : 'none' }};">
            <svg class="animate-spin w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
        </div>
        <div id="noMoreProducts" class="text-center py-8 text-slate-400 font-medium" style="display: {{ $products->hasMorePages() ? 'none' : 'block' }};">
            You have reached the end of the list.
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('liveSearch');
    const spinner = document.getElementById('searchSpinner');
    const grid = document.getElementById('productGrid');
    const resultCount = document.getElementById('resultCount');
    const searchHint = document.getElementById('searchHint');
    const sentinel = document.getElementById('loadMoreSentinel');
    const noMore = document.getElementById('noMoreProducts');
    
    let debounceTimer;
    let currentPage = 1;
    let isFetching = false;
    let hasMore = {{ $products->hasMorePages() ? 'true' : 'false' }};
    let currentQuery = '';

    // Live Search
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        currentQuery = this.value.trim();
        
        if (currentQuery.length === 0) { 
            window.location.reload(); 
            return; 
        }
        if (currentQuery.length < 2) return;
        
        spinner.classList.add('active');
        searchHint.textContent = 'Searching...';
        
        debounceTimer = setTimeout(function () {
            currentPage = 1; // Reset page on new search
            fetch(`{{ route('category.products', $category->id) }}?search=${encodeURIComponent(currentQuery)}&page=${currentPage}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                grid.innerHTML = data.html;
                resultCount.innerHTML = `Found <strong>${data.count}</strong> product(s) for "<strong>${currentQuery}</strong>"`;
                searchHint.textContent = data.count > 0 ? 'Results updated' : 'No products found';
                spinner.classList.remove('active');
                
                // Assuming 8 per page as per controller
                hasMore = data.count > (currentPage * 8);
                updateLoadMoreUI();
            })
            .catch(() => { spinner.classList.remove('active'); searchHint.textContent = 'Error, try again'; });
        }, 350);
    });

    // Infinite Scroll
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && hasMore && !isFetching) {
            loadNextPage();
        }
    }, { rootMargin: '0px 0px 200px 0px' });

    if (sentinel) {
        observer.observe(sentinel);
    }

    function loadNextPage() {
        isFetching = true;
        currentPage++;
        
        let url = `{{ route('category.products', $category->id) }}?page=${currentPage}`;
        if (currentQuery.length >= 2) {
            url += `&search=${encodeURIComponent(currentQuery)}`;
        }

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.html) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data.html, 'text/html');
                const newItems = doc.querySelectorAll('.cp-product');
                
                const gridContainer = grid.querySelector('.grid');
                if (gridContainer && newItems.length > 0) {
                    newItems.forEach(item => gridContainer.appendChild(item));
                } else if (newItems.length > 0) {
                    // Fallback if grid container not found
                    grid.insertAdjacentHTML('beforeend', data.html);
                }
                
                hasMore = data.count > (currentPage * 8);
                updateLoadMoreUI();
            }
            isFetching = false;
        })
        .catch(err => {
            console.error('Failed to load more products:', err);
            isFetching = false;
        });
    }

    function updateLoadMoreUI() {
        if (hasMore) {
            sentinel.style.display = 'flex';
            noMore.style.display = 'none';
        } else {
            sentinel.style.display = 'none';
            noMore.style.display = 'block';
        }
    }
});
</script>
@endpush
