@extends('admin.layouts.app')
@php $header = 'Current Stock'; @endphp

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Stock Overview</h2>
        <p class="text-sm text-slate-500">Current inventory levels for all active medicines</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.stock.low') }}"
           class="inline-flex items-center gap-2 bg-orange-100 hover:bg-orange-200 text-orange-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            Low Stock
        </a>
        <a href="{{ route('admin.stock.expiry') }}"
           class="inline-flex items-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Expiry Alert
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    {{-- Toolbar --}}
    <div class="px-4 py-3 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row items-start md:items-center justify-between gap-3">
        <div class="flex items-center gap-2 flex-wrap">
            <span class="font-medium text-slate-700 text-sm">Show per page:</span>
            <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm">
                @foreach([50, 100, 200, 500, 'all'] as $size)
                    <button type="button" onclick="changePerPage('{{ $size }}')"
                            id="per-page-btn-{{ $size }}"
                            class="per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition {{ (request('per_page', 50) == $size) ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ strtoupper($size) }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="relative w-full md:w-72">
            <input type="text" id="stockSearchInput" value="{{ request('search') }}"
                   placeholder="Search medicine or category..." autocomplete="off"
                   class="w-full pl-9 pr-8 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white transition">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <svg id="searchSpinner" class="w-4 h-4 text-teal-500 absolute right-3 top-3 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table id="stockTable" class="w-full text-sm">
            <thead class="bg-slate-100 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3.5 sortable">SL</th>
                    <th class="px-4 py-3.5 sortable">Medicine</th>
                    <th class="px-4 py-3.5 sortable">Category</th>
                    <th class="px-4 py-3.5 text-right sortable">Current Stock</th>
                    <th class="px-4 py-3.5 text-right sortable">Min Stock</th>
                    <th class="px-4 py-3.5 text-right sortable">Sale Price</th>
                    <th class="px-4 py-3.5 text-center sortable">Status</th>
                </tr>
            </thead>
            <tbody id="stockTableBody" class="divide-y divide-slate-100 transition-opacity duration-150">
                @include('admin.stock.partials.table_rows')
            </tbody>
        </table>
    </div>

    {{-- Load More Footer --}}
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-slate-600 font-medium">
            Showing <span id="currentLoadedCount">{{ $stocks->count() }}</span>
            of <span id="totalStockCount">{{ $stocks->total() }}</span> medicines
        </div>
        <div id="loadMoreActionContainer">
            @if($stocks->hasMorePages())
                <button id="loadMoreBtn" onclick="loadMoreStock()"
                        class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
                    <span id="loadMoreText">Load More</span>
                    <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            @else
                <div class="text-xs text-slate-400 font-medium">All records loaded</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
#stockTable thead th.sortable { cursor:pointer; user-select:none; white-space:nowrap; }
#stockTable thead th.sortable:hover { background:#e2e8f0; }
#stockTable thead th .sort-icon { display:inline-block; margin-left:4px; font-size:10px; opacity:0.4; }
#stockTable thead th.sort-asc .sort-icon,
#stockTable thead th.sort-desc .sort-icon { opacity:1; color:#0d9488; }
</style>
<script>
let nextPage      = {{ $stocks->currentPage() + 1 }};
let perPage       = '{{ $perPageRaw }}';
let currentSearch = '{{ request('search') }}';
let sortCol = -1, sortDir = 'asc';

// ─── Vanilla JS Sort ──────────────────────────────────────
document.querySelectorAll('#stockTable thead th.sortable').forEach(th => {
    const colIndex = Array.from(th.parentNode.children).indexOf(th);
    th.innerHTML += '<span class="sort-icon">⇅</span>';
    th.addEventListener('click', () => {
        sortCol === colIndex ? (sortDir = sortDir === 'asc' ? 'desc' : 'asc') : (sortCol = colIndex, sortDir = 'asc');
        document.querySelectorAll('#stockTable thead th').forEach(h => {
            h.classList.remove('sort-asc','sort-desc');
            const ic = h.querySelector('.sort-icon'); if(ic) ic.textContent='⇅';
        });
        th.classList.add(sortDir==='asc'?'sort-asc':'sort-desc');
        const icon = th.querySelector('.sort-icon'); if(icon) icon.textContent = sortDir==='asc'?'▲':'▼';
        sortTable(colIndex, sortDir);
    });
});

function sortTable(colIdx, dir) {
    const tbody = document.getElementById('stockTableBody');
    const rows  = Array.from(tbody.querySelectorAll('tr.stock-row'));
    rows.sort((a,b) => {
        const aT = (a.cells[colIdx]?.innerText||'').trim().toLowerCase();
        const bT = (b.cells[colIdx]?.innerText||'').trim().toLowerCase();
        const aN = parseFloat(aT.replace(/[^0-9.]/g,'')), bN = parseFloat(bT.replace(/[^0-9.]/g,''));
        if(!isNaN(aN)&&!isNaN(bN)) return dir==='asc'?aN-bN:bN-aN;
        return dir==='asc'?aT.localeCompare(bT):bT.localeCompare(aT);
    });
    rows.forEach(r => tbody.appendChild(r));
}

// ─── Per Page ─────────────────────────────────────────────
function changePerPage(size) {
    perPage = size;
    document.querySelectorAll('.per-page-pill').forEach(b => { b.className='per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition text-slate-600 hover:bg-slate-100'; });
    const a = document.getElementById(`per-page-btn-${size}`);
    if(a) a.className='per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition bg-teal-600 text-white shadow-sm';
    performSearch();
}

// ─── Live Search ──────────────────────────────────────────
let searchTimer;
document.getElementById('stockSearchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimer); currentSearch = e.target.value;
    document.getElementById('searchSpinner').classList.remove('hidden');
    searchTimer = setTimeout(() => performSearch(), 250);
});

function performSearch() {
    const tbody = document.getElementById('stockTableBody');
    tbody.classList.add('opacity-40');
    document.getElementById('searchSpinner').classList.remove('hidden');
    fetch(`{{ route('admin.stock.index') }}?page=1&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        tbody.innerHTML = data.html;
        tbody.classList.remove('opacity-40');
        document.getElementById('searchSpinner').classList.add('hidden');
        document.getElementById('currentLoadedCount').textContent = data.count;
        document.getElementById('totalStockCount').textContent = data.total;
        nextPage = 2; sortCol = -1; sortDir = 'asc';
        renderLoadMore(data.has_more_pages);
        history.pushState(null,'',`{{ route('admin.stock.index') }}?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`);
    })
    .catch(() => { tbody.classList.remove('opacity-40'); document.getElementById('searchSpinner').classList.add('hidden'); });
}

// ─── Load More ────────────────────────────────────────────
function renderLoadMore(hasMore) {
    const c = document.getElementById('loadMoreActionContainer');
    if(hasMore) {
        c.innerHTML = `<button id="loadMoreBtn" onclick="loadMoreStock()"
            class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
            <span id="loadMoreText">Load More</span>
            <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg></button>`;
    } else {
        c.innerHTML = '<div class="text-xs text-slate-400 font-medium">All records loaded</div>';
    }
}

function loadMoreStock() {
    const btn=document.getElementById('loadMoreBtn'), text=document.getElementById('loadMoreText'), spin=document.getElementById('loadMoreSpinner');
    if(!btn) return;
    btn.disabled=true; if(text) text.textContent='Loading...'; if(spin) spin.classList.remove('hidden');
    fetch(`{{ route('admin.stock.index') }}?page=${nextPage}&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`,{
        headers:{'X-Requested-With':'XMLHttpRequest'}
    })
    .then(r=>r.json())
    .then(data=>{
        if(data.html){
            document.getElementById('stockTableBody').insertAdjacentHTML('beforeend',data.html);
            const el=document.getElementById('currentLoadedCount');
            if(el) el.textContent=parseInt(el.textContent||0)+data.count;
            data.has_more_pages?(nextPage=data.next_page,renderLoadMore(true)):renderLoadMore(false);
        }
    })
    .catch(()=>{if(text)text.textContent='Load More';if(spin)spin.classList.add('hidden');if(btn)btn.disabled=false;});
}
</script>
@endpush
