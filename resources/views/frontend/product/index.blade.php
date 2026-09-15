@extends('frontend.layouts.app')

@push('styles')
<style>
.cp-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #065f46 100%);
    padding: 40px 0;
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
.filter-sidebar {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 20px 4px 20px 20px;
}
.filter-section {
    margin-bottom: 24px;
}
.filter-section:last-child {
    margin-bottom: 0;
}
.filter-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 12px;
    padding-right: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.filter-list {
    max-height: 200px;
    overflow-y: auto;
    padding-right: 12px;
}
.filter-list::-webkit-scrollbar {
    width: 6px;
}
.filter-list::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 6px;
}
.filter-list::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 6px;
}
.filter-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 14px;
    color: #475569;
    cursor: pointer;
}
.filter-label:last-child { margin-bottom: 0; }
.filter-checkbox {
    width: 16px; height: 16px;
    border-radius: 4px;
    border: 2px solid #cbd5e1;
    accent-color: #10b981;
    cursor: pointer;
}
.search-wrapper {
    position: relative;
    margin-bottom: 24px;
}
.search-input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    outline: none;
    transition: all 0.3s;
}
.search-input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16,185,129,.1);
}
.search-icon {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}
</style>
@endpush

@section('content')
<div class="cp-hero">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2">{{ isset($isFlashSale) && $isFlashSale ? 'Flash Sale — Special Discounts' : 'All Products' }}</h1>
        <p class="text-slate-300 text-sm">{{ isset($isFlashSale) && $isFlashSale ? 'Grab the best deals on your favorite medicines before they are gone!' : 'Discover our complete collection of medicines and health products' }}</p>
    </div>
</div>

<section class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <div class="w-full lg:w-[280px] flex-shrink-0">
                <div class="filter-sidebar lg:sticky lg:top-24 max-h-[calc(100vh-7rem)] overflow-y-auto custom-scrollbar">
                    <div class="filter-section">
                        <h3 class="filter-title">Categories</h3>
                        <div class="filter-list custom-scrollbar">
                            @foreach($categories as $cat)
                            <label class="filter-label">
                                <input type="checkbox" class="filter-checkbox filter-category" value="{{ $cat->id }}">
                                {{ $cat->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="filter-section">
                        <h3 class="filter-title">Generics</h3>
                        <div class="filter-list custom-scrollbar">
                            @foreach($generics as $gen)
                            <label class="filter-label">
                                <input type="checkbox" class="filter-checkbox filter-generic" value="{{ $gen->id }}">
                                {{ $gen->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3 class="filter-title">Manufacturers</h3>
                        <div class="filter-list custom-scrollbar">
                            @foreach($manufacturers as $man)
                            <label class="filter-label">
                                <input type="checkbox" class="filter-checkbox filter-manufacturer" value="{{ $man->id }}">
                                {{ $man->company_name }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full lg:flex-1 min-w-0">
                <!-- Search & Status -->
                <div class="search-wrapper">
                    <svg class="w-5 h-5 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="liveSearch" class="search-input" placeholder="Search products by name...">
                    <div id="searchSpinner" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
                        <svg class="animate-spin w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    </div>
                </div>

                <div class="mb-6 flex justify-between items-center text-sm text-slate-500">
                    <span id="resultCount">Showing <strong>{{ $products->count() }}</strong> products</span>
                </div>

                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6" id="productGrid">
                    @include('frontend.home._product_cards', ['products' => $products])
                </div>
                
                <div id="noProductsFound" class="text-center py-16" style="{{ $products->count() == 0 ? '' : 'display: none;' }}">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-slate-500 font-medium">No products found matching your criteria.</p>
                </div>

                <!-- Infinite Scroll Sentinel -->
                <div id="loadMoreSentinel" class="py-12 flex justify-center items-center {{ $products->count() < 16 ? 'hidden' : '' }}">
                    <svg class="animate-spin w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                </div>
                <div id="noMoreProducts" class="text-center py-8 text-slate-400 font-medium hidden">
                    You have reached the end of the list.
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
    const sentinel = document.getElementById('loadMoreSentinel');
    const noMore = document.getElementById('noMoreProducts');
    const noProductsFound = document.getElementById('noProductsFound');
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    
    let debounceTimer;
    let skip = 16;
    let isFetching = false;
    let hasMore = true; // Assuming initially true if 16 items were loaded, will adjust below
    let currentCount = {{ $products->count() }};

    if (currentCount < 16) {
        hasMore = false;
        if(currentCount > 0) noMore.classList.remove('hidden');
    }

    function getFilterData() {
        const categories = Array.from(document.querySelectorAll('.filter-category:checked')).map(cb => cb.value);
        const generics = Array.from(document.querySelectorAll('.filter-generic:checked')).map(cb => cb.value);
        const manufacturers = Array.from(document.querySelectorAll('.filter-manufacturer:checked')).map(cb => cb.value);
        const search = searchInput.value.trim();

        const params = new URLSearchParams();
        if (search) params.append('search', search);
        categories.forEach(id => params.append('category[]', id));
        generics.forEach(id => params.append('generic[]', id));
        manufacturers.forEach(id => params.append('manufacturer[]', id));
        
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('discount')) {
            params.append('discount', urlParams.get('discount'));
        }
        
        return params;
    }

    function fetchProducts(isNewFilter = false) {
        if (isFetching) return;
        isFetching = true;

        if (isNewFilter) {
            skip = 0;
            grid.innerHTML = '';
            spinner.classList.remove('hidden');
            noProductsFound.style.display = 'none';
        }

        const params = getFilterData();
        params.append('skip', skip);
        params.append('take', isNewFilter ? 16 : 8);

        fetch(`{{ route('ajax.products.fetch') }}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (isNewFilter) {
                grid.innerHTML = data.html;
                currentCount = data.count;
            } else {
                grid.insertAdjacentHTML('beforeend', data.html);
                currentCount += data.count;
            }
            
            resultCount.innerHTML = `Showing <strong>${currentCount}</strong> products`;
            
            if (currentCount === 0) {
                noProductsFound.style.display = 'block';
            } else {
                noProductsFound.style.display = 'none';
            }

            hasMore = data.count === (isNewFilter ? 16 : 8);
            
            if (isNewFilter) {
                skip = 16;
            } else {
                skip += 8;
            }

            updateLoadMoreUI();
            isFetching = false;
            if (isNewFilter) spinner.classList.add('hidden');
        })
        .catch(err => {
            console.error('Failed to load products:', err);
            isFetching = false;
            if (isNewFilter) spinner.classList.add('hidden');
        });
    }

    function updateLoadMoreUI() {
        if (hasMore && currentCount > 0) {
            sentinel.classList.remove('hidden');
            noMore.classList.add('hidden');
        } else {
            sentinel.classList.add('hidden');
            if (currentCount > 0) noMore.classList.remove('hidden');
        }
    }

    // Live Search
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchProducts(true), 400);
    });

    // Checkbox Filters
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => fetchProducts(true));
    });

    // Infinite Scroll
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && hasMore && !isFetching) {
            fetchProducts(false);
        }
    }, { rootMargin: '0px 0px 200px 0px' });

    if (sentinel) {
        observer.observe(sentinel);
    }
});
</script>
@endpush
