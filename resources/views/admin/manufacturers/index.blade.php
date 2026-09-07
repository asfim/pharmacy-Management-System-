@extends('admin.layouts.app')
@php $header = 'Manufacturers'; @endphp

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Manufacturers</h2>
        <p class="text-sm text-slate-500">Manage, export, and bulk upload pharmaceutical manufacturers</p>
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

        <a id="exportCsvBtn" href="{{ route('admin.manufacturers.export-csv', request()->query()) }}"
           class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export CSV
        </a>

        <a id="exportPdfBtn" href="{{ route('admin.manufacturers.export-pdf', request()->query()) }}" target="_blank"
           class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Export PDF
        </a>

        <button onclick="document.getElementById('bulkUploadModal').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Bulk Upload CSV
        </button>

        <a href="{{ route('admin.manufacturers.create') }}"
           class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Manufacturer
        </a>
    </div>
</div>

@include('admin.layouts.alerts')

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
            <input type="text" id="manufacturerSearchInput" value="{{ request('search') }}"
                   placeholder="Search manufacturers..." autocomplete="off"
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
        <table id="manufacturersTable" class="w-full text-left">
            <thead class="bg-slate-100 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3.5 w-10">
                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)"
                               class="w-4 h-4 rounded text-teal-600 border-slate-300 focus:ring-teal-500 cursor-pointer" title="Select All">
                    </th>
                    <th class="px-4 py-3.5 sortable">SL</th>
                    <th class="px-4 py-3.5 sortable">Company Name</th>
                    <th class="px-4 py-3.5 sortable">Contact Person</th>
                    <th class="px-4 py-3.5 sortable">Phone</th>
                    <th class="px-4 py-3.5 sortable">Email</th>
                    <th class="px-4 py-3.5 sortable">Status</th>
                    <th class="px-4 py-3.5">Actions</th>
                </tr>
            </thead>
            <tbody id="manufacturerTableBody" class="divide-y divide-slate-200 text-sm transition-opacity duration-150">
                @include('admin.manufacturers.partials.table_rows')
            </tbody>
        </table>
    </div>

    {{-- Load More Footer --}}
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-slate-600 font-medium">
            Showing <span id="currentLoadedCount">{{ $manufacturers->count() }}</span>
            of <span id="totalManufacturersCount">{{ $manufacturers->total() }}</span> manufacturers
        </div>
        <div id="loadMoreActionContainer">
            @if($manufacturers->hasMorePages())
                <button id="loadMoreBtn" onclick="loadMoreManufacturers()"
                        class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
                    <span id="loadMoreText">Load More</span>
                    <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            @else
                <div class="text-xs text-slate-400 font-medium">All manufacturers loaded</div>
            @endif
        </div>
    </div>
</div>

{{-- Bulk Upload Modal --}}
<div id="bulkUploadModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Bulk Import Manufacturers (CSV)</h3>
            <button onclick="document.getElementById('bulkUploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.manufacturers.import-csv') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-700">Download Sample CSV</p>
                    <p class="text-[11px] text-slate-500">View the required format before importing</p>
                </div>
                <a href="{{ route('admin.manufacturers.sample-csv') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-2 px-3 rounded-lg flex items-center transition shadow-sm flex-shrink-0 ml-2">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Demo CSV
                </a>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-xs text-blue-700 space-y-1">
                <p class="font-semibold">Required CSV columns:</p>
                <code class="block bg-blue-100 rounded px-2 py-1 text-blue-800 font-mono">company_name, contact_person, phone, email, website, address, license_info, status</code>
                <p>Existing manufacturers (by company_name) will be updated.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Select CSV File</label>
                <input type="file" name="csv_file" accept=".csv,.txt" required
                       class="w-full text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('bulkUploadModal').classList.add('hidden')"
                        class="px-5 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg">Cancel</button>
                <button type="submit" onclick="this.disabled=true;this.innerText='Uploading...';this.form.submit();"
                        class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm">Upload & Import</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<style>
#manufacturersTable thead th.sortable { cursor:pointer; user-select:none; white-space:nowrap; }
#manufacturersTable thead th.sortable:hover { background:#e2e8f0; }
#manufacturersTable thead th .sort-icon { display:inline-block; margin-left:4px; font-size:10px; opacity:0.4; }
#manufacturersTable thead th.sort-asc .sort-icon,
#manufacturersTable thead th.sort-desc .sort-icon { opacity:1; color:#0d9488; }
</style>
<script>
let nextPage      = {{ $manufacturers->currentPage() + 1 }};
let perPage       = '{{ $perPageRaw }}';
let currentSearch = '{{ request('search') }}';
let sortCol = -1, sortDir = 'asc';

document.querySelectorAll('#manufacturersTable thead th.sortable').forEach(th => {
    const colIndex = Array.from(th.parentNode.children).indexOf(th);
    th.innerHTML += '<span class="sort-icon">⇅</span>';
    th.addEventListener('click', () => {
        sortCol === colIndex ? (sortDir = sortDir === 'asc' ? 'desc' : 'asc') : (sortCol = colIndex, sortDir = 'asc');
        document.querySelectorAll('#manufacturersTable thead th').forEach(h => {
            h.classList.remove('sort-asc','sort-desc');
            const ic = h.querySelector('.sort-icon'); if(ic) ic.textContent='⇅';
        });
        th.classList.add(sortDir==='asc'?'sort-asc':'sort-desc');
        const icon = th.querySelector('.sort-icon'); if(icon) icon.textContent = sortDir==='asc'?'▲':'▼';
        sortTable(colIndex, sortDir);
    });
});

function sortTable(colIdx, dir) {
    const tbody = document.getElementById('manufacturerTableBody');
    const rows  = Array.from(tbody.querySelectorAll('tr.manufacturer-row'));
    rows.sort((a,b) => {
        const aT = (a.cells[colIdx]?.innerText||'').trim().toLowerCase();
        const bT = (b.cells[colIdx]?.innerText||'').trim().toLowerCase();
        const aN = parseFloat(aT), bN = parseFloat(bT);
        if(!isNaN(aN)&&!isNaN(bN)) return dir==='asc'?aN-bN:bN-aN;
        return dir==='asc'?aT.localeCompare(bT):bT.localeCompare(aT);
    });
    rows.forEach(r => tbody.appendChild(r));
}

function updateExportUrls() {
    const q = `?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`;
    document.getElementById('exportCsvBtn').href = `{{ route('admin.manufacturers.export-csv') }}${q}`;
    document.getElementById('exportPdfBtn').href = `{{ route('admin.manufacturers.export-pdf') }}${q}`;
}

function changePerPage(size) {
    perPage = size;
    document.querySelectorAll('.per-page-pill').forEach(btn => { btn.className='per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition text-slate-600 hover:bg-slate-100'; });
    const active = document.getElementById(`per-page-btn-${size}`);
    if(active) active.className='per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition bg-teal-600 text-white shadow-sm';
    performSearch();
}

let searchTimer;
document.getElementById('manufacturerSearchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimer); currentSearch = e.target.value;
    document.getElementById('searchSpinner').classList.remove('hidden');
    searchTimer = setTimeout(() => performSearch(), 250);
});

function performSearch() {
    const tbody = document.getElementById('manufacturerTableBody');
    tbody.classList.add('opacity-40');
    document.getElementById('searchSpinner').classList.remove('hidden');
    updateExportUrls();
    fetch(`{{ route('admin.manufacturers.index') }}?page=1&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        tbody.innerHTML = data.html;
        tbody.classList.remove('opacity-40');
        document.getElementById('searchSpinner').classList.add('hidden');
        document.getElementById('currentLoadedCount').textContent = data.count;
        document.getElementById('totalManufacturersCount').textContent = data.total;
        nextPage = 2; sortCol = -1; sortDir = 'asc';
        renderLoadMore(data.has_more_pages);
        history.pushState(null,'',`{{ route('admin.manufacturers.index') }}?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`);
    })
    .catch(() => { tbody.classList.remove('opacity-40'); document.getElementById('searchSpinner').classList.add('hidden'); });
}

function renderLoadMore(hasMore) {
    const c = document.getElementById('loadMoreActionContainer');
    if(hasMore) {
        c.innerHTML = `<button id="loadMoreBtn" onclick="loadMoreManufacturers()"
            class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
            <span id="loadMoreText">Load More</span>
            <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg></button>`;
    } else {
        c.innerHTML = '<div class="text-xs text-slate-400 font-medium">All manufacturers loaded</div>';
    }
}

function loadMoreManufacturers() {
    const btn=document.getElementById('loadMoreBtn'), text=document.getElementById('loadMoreText'), spin=document.getElementById('loadMoreSpinner');
    if(!btn) return;
    btn.disabled=true; if(text) text.textContent='Loading...'; if(spin) spin.classList.remove('hidden');
    fetch(`{{ route('admin.manufacturers.index') }}?page=${nextPage}&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`,{
        headers:{'X-Requested-With':'XMLHttpRequest'}
    })
    .then(r=>r.json())
    .then(data=>{
        if(data.html){
            document.getElementById('manufacturerTableBody').insertAdjacentHTML('beforeend',data.html);
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
    if(!confirm(`Delete ${ids.length} selected manufacturer(s)? This cannot be undone.`)) return;
    const btn=document.getElementById('bulkDeleteBtn'); btn.disabled=true;
    const orig=btn.innerHTML; btn.innerHTML='Deleting...';
    fetch(`{{ route('admin.manufacturers.bulk-delete') }}`,{
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
