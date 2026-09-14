@extends('frontend.layouts.app')

@push('styles')
<style>
/* ─── Category Products Page ─── */
.cp-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #065f46 100%);
    padding: 60px 0 80px;
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
.cp-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: 20%;
    width: 200px; height: 200px;
    background: rgba(99,102,241,.08);
    border-radius: 50%;
}

/* Search Box */
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
.cp-search-input::placeholder {
    color: rgba(255,255,255,.45);
}
.cp-search-input:focus {
    border-color: #10b981;
    background: rgba(255,255,255,.12);
    box-shadow: 0 0 0 4px rgba(16,185,129,.15);
}
.cp-search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,.4);
    pointer-events: none;
}
.cp-search-spinner {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    display: none;
}
.cp-search-spinner.active { display: block; }

/* Sidebar Category List */
.cp-cat-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    color: #475569;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all .2s;
}
.cp-cat-item:hover {
    background: #f0fdf4;
    color: #059669;
    text-decoration: none;
}
.cp-cat-item.active {
    background: linear-gradient(135deg, rgba(16,185,129,.1), rgba(16,185,129,.05));
    color: #059669;
    font-weight: 700;
    box-shadow: inset 3px 0 0 #10b981;
}
.cp-cat-count {
    margin-left: auto;
    font-size: 11px;
    font-weight: 700;
    background: #f1f5f9;
    color: #64748b;
    padding: 2px 8px;
    border-radius: 20px;
}
.cp-cat-item.active .cp-cat-count {
    background: #d1fae5;
    color: #059669;
}

/* Product Card */
.cp-product {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all .3s;
    position: relative;
}
.cp-product:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,.08);
    border-color: #10b981;
}
.cp-product-img {
    height: 170px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    position: relative;
    overflow: hidden;
}
.cp-product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cp-discount-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #ef4444, #f43f5e);
    color: #fff;
    font-size: 11px;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 8px;
}
.cp-rx-tag {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(99,102,241,.9);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    backdrop-filter: blur(4px);
}
.cp-product-body {
    padding: 16px;
}
.cp-product-brand {
    font-size: 11px;
    font-weight: 600;
    color: #10b981;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.cp-product-name {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin: 4px 0 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.cp-product-generic {
    font-size: 12px;
    color: #94a3b8;
    margin-bottom: 6px;
}
.cp-product-meta {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 10px;
}
.cp-product-meta span {
    font-size: 10px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 6px;
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}
.cp-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}
.cp-price {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
}
.cp-price-old {
    font-size: 12px;
    color: #94a3b8;
    text-decoration: line-through;
    margin-left: 6px;
}
.cp-add-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .25s;
}
.cp-add-btn:hover {
    transform: scale(1.15);
    box-shadow: 0 4px 12px rgba(16,185,129,.4);
}

/* Results Counter */
.cp-results-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 12px 16px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

/* Empty State */
.cp-empty {
    text-align: center;
    padding: 60px 20px;
    color: #94a3b8;
}

/* Pagination */
.cp-pagination {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}
.cp-pagination nav span, .cp-pagination nav a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    margin: 0 3px;
    border: 1px solid #e2e8f0;
    color: #64748b;
    text-decoration: none;
    transition: all .2s;
}
.cp-pagination nav span[aria-current] {
    background: #10b981;
    color: #fff;
    border-color: #10b981;
}
.cp-pagination nav a:hover {
    background: #f0fdf4;
    border-color: #10b981;
    color: #10b981;
}

/* Breadcrumb */
.cp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    margin-bottom: 12px;
}
.cp-breadcrumb a {
    color: rgba(255,255,255,.6);
    text-decoration: none;
}
.cp-breadcrumb a:hover { color: #fff; }
.cp-breadcrumb .sep { color: rgba(255,255,255,.3); }
.cp-breadcrumb .current { color: #10b981; font-weight: 600; }

@media (max-width: 768px) {
    .cp-sidebar { display: none; }
    .cp-main-col { grid-column: span 4 !important; }
}
</style>
@endpush

@section('content')

{{-- ════════ HERO BANNER ════════ --}}
<div class="cp-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="cp-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">›</span>
            <span class="current">{{ $category->name }}</span>
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">{{ $category->name }}</h1>
        <p class="text-slate-400 text-sm mb-6">{{ $products->total() }} products found in this category</p>

        {{-- Live Search --}}
        <div class="cp-search-wrap">
            <div class="cp-search-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="liveSearch" class="cp-search-input" placeholder="Search medicines in {{ $category->name }}..." autocomplete="off">
            <div class="cp-search-spinner" id="searchSpinner">
                <svg class="animate-spin w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none" class="fill-slate-50 w-full" style="height:40px">
            <path d="M0,40 C300,80 900,0 1200,40 L1200,80 L0,80Z"></path>
        </svg>
    </div>
</div>

{{-- ════════ MAIN CONTENT ════════ --}}
<section class="py-10 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-4 gap-8">

            {{-- Sidebar --}}
            <div class="col-span-1 cp-sidebar">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm sticky top-24">
                    <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4">Categories</h3>
                    <div class="space-y-1">
                        @foreach($allCategories as $cat)
                        <a href="{{ route('category.products', $cat->id) }}" class="cp-cat-item {{ $cat->id == $category->id ? 'active' : '' }}">
                            @if($cat->image && file_exists(public_path('storage/' . $cat->image)))
                                <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" class="w-7 h-7 rounded-lg object-cover">
                            @else
                                <span class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center text-sm">💊</span>
                            @endif
                            <span class="truncate">{{ $cat->name }}</span>
                            <span class="cp-cat-count">{{ $cat->products_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="col-span-3 cp-main-col">
                {{-- Results Bar --}}
                <div class="cp-results-bar">
                    <span class="text-sm text-slate-600" id="resultCount">
                        Showing <strong>{{ $products->count() }}</strong> of <strong>{{ $products->total() }}</strong> products
                    </span>
                    <span class="text-xs text-slate-400" id="searchHint">Type to search instantly...</span>
                </div>

                {{-- Product Grid --}}
                <div id="productGrid">
                    @include('frontend.category._product_grid', ['products' => $products])
                </div>

                {{-- Pagination --}}
                <div class="cp-pagination" id="paginationWrap">
                    {{ $products->links() }}
                </div>
            </div>

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
    const paginationWrap = document.getElementById('paginationWrap');
    let debounceTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length === 0) {
            // Reload original page
            window.location.reload();
            return;
        }

        if (query.length < 2) return;

        spinner.classList.add('active');
        searchHint.textContent = 'Searching...';

        debounceTimer = setTimeout(function () {
            fetch(`{{ route('category.products', $category->id) }}?search=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                grid.innerHTML = data.html;
                resultCount.innerHTML = `Found <strong>${data.count}</strong> product(s) for "<strong>${query}</strong>"`;
                searchHint.textContent = data.count > 0 ? 'Results updated' : 'No products found';
                paginationWrap.style.display = 'none';
                spinner.classList.remove('active');
            })
            .catch(() => {
                spinner.classList.remove('active');
                searchHint.textContent = 'Error searching, try again';
            });
        }, 350);
    });
});
</script>
@endpush
