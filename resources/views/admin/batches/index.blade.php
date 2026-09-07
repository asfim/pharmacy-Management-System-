@extends('admin.layouts.app')
@php $header = 'Batches'; @endphp

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Batch Management</h2>
        <p class="text-sm text-slate-500">Track medicine batches, expiry dates and stock levels</p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        <button id="bulkDeleteBtn" onclick="executeBulkDelete()"
                class="hidden bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete (<span id="bulkDeleteCount">0</span>)
        </button>

        <a id="exportCsvBtn" href="{{ route('admin.batches.export-csv', request()->query()) }}"
           class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export CSV
        </a>

        <a id="exportPdfBtn" href="{{ route('admin.batches.export-pdf', request()->query()) }}" target="_blank"
           class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Export PDF
        </a>

        <a href="{{ route('admin.batches.create') }}"
           class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Batch
        </a>
    </div>
</div>

@include('admin.layouts.alerts')

{{-- Legend --}}
<div class="mb-4 flex items-center gap-4 text-xs">
    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-red-100 inline-block border border-red-300"></span> Expired</span>
    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm bg-orange-100 inline-block border border-orange-300"></span> Near Expiry (≤ 90 days)</span>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">

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
            <input type="text" id="batchSearchInput" value="{{ request('search') }}"
                   placeholder="Search medicine or batch no..." autocomplete="off"
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
    <div class="overflow-x-auto relative">
        <table id="batchesTable" class="w-full text-left">
            <thead class="bg-slate-100 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3.5 w-10">
                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)"
                               class="w-4 h-4 rounded text-teal-600 border-slate-300 focus:ring-teal-500 cursor-pointer" title="Select All">
                    </th>
                    <th class="px-4 py-3.5 sortable">SL</th>
                    <th class="px-4 py-3.5 sortable">Medicine</th>
                    <th class="px-4 py-3.5 sortable">Batch No</th>
                    <th class="px-4 py-3.5 sortable">Mfg Date</th>
                    <th class="px-4 py-3.5 sortable">Expiry Date</th>
                    <th class="px-4 py-3.5 sortable">Qty</th>
                    <th class="px-4 py-3.5 sortable">Sale Price</th>
                    <th class="px-4 py-3.5">Actions</th>
                </tr>
            </thead>
            <tbody id="batchTableBody" class="divide-y divide-slate-200 text-sm transition-opacity duration-150">
                @include('admin.batches.partials.table_rows')
            </tbody>
        </table>
    </div>

    {{-- Load More Footer --}}
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-slate-600 font-medium">
            Showing <span id="currentLoadedCount">{{ $batches->count() }}</span>
            of <span id="totalBatchesCount">{{ $batches->total() }}</span> batches
        </div>
        <div id="loadMoreActionContainer">
            @if($batches->hasMorePages())
                <button id="loadMoreBtn" onclick="loadMoreBatches()"
                        class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
                    <span id="loadMoreText">Load More</span>
                    <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            @else
                <div class="text-xs text-slate-400 font-medium">All batches loaded</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
#batchesTable thead th.sortable { cursor:pointer; user-select:none; white-space:nowrap; }
#batchesTable thead th.sortable:hover { background:#e2e8f0; }
#batchesTable thead th .sort-icon { display:inline-block; margin-left:4px; font-size:10px; opacity:0.4; }
#batchesTable thead th.sort-asc .sort-icon,
#batchesTable thead th.sort-desc .sort-icon { opacity:1; color:#0d9488; }
</style>
<script>
let nextPage      = {{ $batches->currentPage() + 1 }};
let perPage       = '{{ $perPageRaw }}';
let currentSearch = '{{ request('search') }}';
let sortCol = -1, sortDir = 'asc';

document.querySelectorAll('#batchesTable thead th.sortable').forEach(th => {
    const colIndex = Array.from(th.parentNode.children).indexOf(th);
    th.innerHTML += '<span class="sort-icon">⇅</span>';
    th.addEventListener('click', () => {
        sortCol === colIndex ? (sortDir = sortDir === 'asc' ? 'desc' : 'asc') : (sortCol = colIndex, sortDir = 'asc');
        document.querySelectorAll('#batchesTable thead th').forEach(h => {
            h.classList.remove('sort-asc','sort-desc');
            const ic = h.querySelector('.sort-icon'); if(ic) ic.textContent='⇅';
        });
        th.classList.add(sortDir==='asc'?'sort-asc':'sort-desc');
        const icon = th.querySelector('.sort-icon'); if(icon) icon.textContent = sortDir==='asc'?'▲':'▼';
        sortTable(colIndex, sortDir);
    });
});

function sortTable(colIdx, dir) {
    const tbody = document.getElementById('batchTableBody');
    const rows  = Array.from(tbody.querySelectorAll('tr.batch-row'));
    rows.sort((a,b) => {
        const aT = (a.cells[colIdx]?.innerText||'').trim().toLowerCase();
        const bT = (b.cells[colIdx]?.innerText||'').trim().toLowerCase();
        const aN = parseFloat(aT.replace(/[^0-9.]/g,'')), bN = parseFloat(bT.replace(/[^0-9.]/g,''));
        if(!isNaN(aN)&&!isNaN(bN)) return dir==='asc'?aN-bN:bN-aN;
        return dir==='asc'?aT.localeCompare(bT):bT.localeCompare(aT);
    });
    rows.forEach(r => tbody.appendChild(r));
}

function updateExportUrls() {
    const q = `?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`;
    document.getElementById('exportCsvBtn').href = `{{ route('admin.batches.export-csv') }}${q}`;
    document.getElementById('exportPdfBtn').href = `{{ route('admin.batches.export-pdf') }}${q}`;
}

function changePerPage(size) {
    perPage = size;
    document.querySelectorAll('.per-page-pill').forEach(btn => { btn.className='per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition text-slate-600 hover:bg-slate-100'; });
    const active = document.getElementById(`per-page-btn-${size}`);
    if(active) active.className='per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition bg-teal-600 text-white shadow-sm';
    performSearch();
}

let searchTimer;
document.getElementById('batchSearchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimer); currentSearch = e.target.value;
    document.getElementById('searchSpinner').classList.remove('hidden');
    searchTimer = setTimeout(() => performSearch(), 250);
});

function performSearch() {
    const tbody = document.getElementById('batchTableBody');
    tbody.classList.add('opacity-40');
    document.getElementById('searchSpinner').classList.remove('hidden');
    updateExportUrls();
    fetch(`{{ route('admin.batches.index') }}?page=1&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        tbody.innerHTML = data.html;
        tbody.classList.remove('opacity-40');
        document.getElementById('searchSpinner').classList.add('hidden');
        document.getElementById('currentLoadedCount').textContent = data.count;
        document.getElementById('totalBatchesCount').textContent = data.total;
        nextPage = 2; sortCol = -1; sortDir = 'asc';
        renderLoadMore(data.has_more_pages);
        history.pushState(null,'',`{{ route('admin.batches.index') }}?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`);
    })
    .catch(() => { tbody.classList.remove('opacity-40'); document.getElementById('searchSpinner').classList.add('hidden'); });
}

function renderLoadMore(hasMore) {
    const c = document.getElementById('loadMoreActionContainer');
    if(hasMore) {
        c.innerHTML = `<button id="loadMoreBtn" onclick="loadMoreBatches()"
            class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
            <span id="loadMoreText">Load More</span>
            <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg></button>`;
    } else {
        c.innerHTML = '<div class="text-xs text-slate-400 font-medium">All batches loaded</div>';
    }
}

function loadMoreBatches() {
    const btn=document.getElementById('loadMoreBtn'), text=document.getElementById('loadMoreText'), spin=document.getElementById('loadMoreSpinner');
    if(!btn) return;
    btn.disabled=true; if(text) text.textContent='Loading...'; if(spin) spin.classList.remove('hidden');
    fetch(`{{ route('admin.batches.index') }}?page=${nextPage}&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`,{
        headers:{'X-Requested-With':'XMLHttpRequest'}
    })
    .then(r=>r.json())
    .then(data=>{
        if(data.html){
            document.getElementById('batchTableBody').insertAdjacentHTML('beforeend',data.html);
            const el=document.getElementById('currentLoadedCount');
            if(el) el.textContent=parseInt(el.textContent||0)+data.count;
            data.has_more_pages?(nextPage=data.next_page,renderLoadMore(true)):renderLoadMore(false);
        }
    })
    .catch(()=>{if(text)text.textContent='Load More';if(spin)spin.classList.add('hidden');if(btn)btn.disabled=false;});
}

function toggleSelectAll(master) {
    document.querySelectorAll('.row-check').forEach(cb=>cb.checked=master.checked);
    onCheckboxChange();
}
document.addEventListener('change', e => { if(e.target.classList.contains('row-check')) onCheckboxChange(); });
function onCheckboxChange() {
    const selected=document.querySelectorAll('.row-check:checked');
    const btn=document.getElementById('bulkDeleteBtn');
    document.getElementById('bulkDeleteCount').textContent=selected.length;
    selected.length>0?btn.classList.remove('hidden'):btn.classList.add('hidden');
    const sa=document.getElementById('selectAllCheckbox'), all=document.querySelectorAll('.row-check');
    if(sa&&all.length>0) sa.checked=selected.length===all.length;
}

function executeBulkDelete() {
    const ids=Array.from(document.querySelectorAll('.row-check:checked')).map(cb=>cb.value);
    if(!ids.length) return;
    if(!confirm(`Delete ${ids.length} selected batch(es)? This cannot be undone.`)) return;
    const btn=document.getElementById('bulkDeleteBtn'); btn.disabled=true;
    const orig=btn.innerHTML; btn.innerHTML='Deleting...';
    fetch(`{{ route('admin.batches.bulk-delete') }}`,{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest'},
        body:JSON.stringify({ids})
    })
    .then(r=>r.json())
    .then(data=>{ if(data.success){performSearch();const sa=document.getElementById('selectAllCheckbox');if(sa)sa.checked=false;}else{alert(data.message||'Failed.');} })
    .catch(()=>alert('An error occurred.'))
    .finally(()=>{btn.disabled=false;btn.innerHTML=orig;});
}
</script>
@endpush
