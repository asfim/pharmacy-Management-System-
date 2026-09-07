@extends('admin.layouts.app')
@php $header = 'Categories Management'; @endphp
@section('content')

{{-- Page Header --}}
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Categories</h2>
        <p class="text-sm text-slate-500">Manage, export, and bulk upload pharmacy categories</p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        {{-- Bulk Delete Action (hidden until rows selected) --}}
        <button id="bulkDeleteBtn"
                onclick="executeBulkDelete()"
                class="hidden bg-rose-600 hover:bg-rose-700 text-white font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Selected (<span id="bulkDeleteCount">0</span>)
        </button>

        {{-- Export CSV --}}
        <a id="exportCsvBtn" href="{{ route('admin.categories.export-csv', request()->query()) }}"
           class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export CSV
        </a>

        {{-- Export PDF --}}
        <a id="exportPdfBtn" href="{{ route('admin.categories.export-pdf', request()->query()) }}" target="_blank"
           class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Export PDF
        </a>

        {{-- Bulk Upload CSV --}}
        <button onclick="document.getElementById('bulkUploadModal').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Bulk Upload CSV
        </button>

        {{-- Add Category --}}
        <a href="{{ route('admin.categories.create') }}"
           class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition text-sm shadow-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Category
        </a>
    </div>
</div>

@include('admin.layouts.alerts')

{{-- Datatable Control Toolbar --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        {{-- Per Page Selector Pills --}}
        <div class="flex items-center space-x-2 text-sm text-slate-600">
            <span class="font-medium text-slate-700">Show per page:</span>
            <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm">
                @foreach([50, 100, 200, 500, 'all'] as $size)
                    <button type="button"
                            onclick="changePerPage('{{ $size }}')"
                            id="per-page-btn-{{ $size }}"
                            class="per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition {{ (string)$perPageRaw === (string)$size ? 'bg-teal-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ strtoupper($size) }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Live Search --}}
        <div class="relative w-full md:w-80">
            <input type="text"
                   id="categorySearchInput"
                   value="{{ request('search') }}"
                   placeholder="Instant search category..."
                   autocomplete="off"
                   class="w-full pl-9 pr-8 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white transition">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <div id="searchSpinner" class="hidden absolute right-2.5 top-2.5">
                <svg class="w-4 h-4 animate-spin text-teal-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Category Table --}}
    <div class="overflow-x-auto relative">
        <table id="categoriesDataTable" class="w-full text-left" style="width:100%">
            <thead class="bg-slate-100 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3.5 w-10 no-sort">
                        <input type="checkbox" id="selectAllCheckbox" onclick="toggleSelectAll(this)"
                               class="w-4 h-4 rounded text-teal-600 border-slate-300 focus:ring-teal-500 cursor-pointer" title="Select All">
                    </th>
                    <th class="px-4 py-3.5">SL</th>
                    <th class="px-4 py-3.5 no-sort">Image</th>
                    <th class="px-4 py-3.5">Name</th>
                    <th class="px-4 py-3.5">Parent Category</th>
                    <th class="px-4 py-3.5">Description</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 no-sort">Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody" class="divide-y divide-slate-200 text-sm transition-opacity duration-150">
                @include('admin.categories.partials.table_rows')
            </tbody>
        </table>
    </div>

    {{-- Load More Footer --}}
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div id="categoryCountInfo" class="text-sm text-slate-600 font-medium">
            Showing <span id="currentLoadedCount">{{ $categories->count() }}</span>
            of <span id="totalCategoriesCount">{{ $categories->total() }}</span> categories
        </div>
        <div id="loadMoreActionContainer">
            @if($categories->hasMorePages())
                <button id="loadMoreBtn"
                        onclick="loadMoreCategories()"
                        class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
                    <span id="loadMoreText">Load More</span>
                    <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            @else
                <div class="text-xs text-slate-400 font-medium">All categories loaded</div>
            @endif
        </div>
    </div>
</div>

{{-- Bulk CSV Upload Modal --}}
<div id="bulkUploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Bulk Category CSV Uploader</h3>
            </div>
            <button onclick="document.getElementById('bulkUploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.categories.import-csv') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            {{-- Demo CSV Banner --}}
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-800">Need the required CSV format?</p>
                    <p class="text-[11px] text-slate-500">Download the sample CSV to view structure & sample rows</p>
                </div>
                <a href="{{ route('admin.categories.sample-csv') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-2 px-3 rounded-lg flex items-center transition shadow-sm flex-shrink-0 ml-2">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Demo CSV
                </a>
            </div>

            {{-- Required Columns --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3">
                <p class="text-xs font-semibold text-amber-900 mb-1 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Required CSV Column Pattern (Headers):
                </p>
                <div class="bg-white border border-amber-200 rounded-md p-2 text-[11px] font-mono text-slate-700 overflow-x-auto select-all">
                    name, description, status
                </div>
            </div>

            {{-- File Input --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Select CSV File</label>
                <div class="border-2 border-dashed border-slate-300 hover:border-indigo-500 rounded-xl p-5 text-center cursor-pointer transition bg-slate-50 hover:bg-indigo-50/30"
                     onclick="document.getElementById('csvFileInput').click()">
                    <svg class="w-9 h-9 mx-auto text-slate-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p id="csvFileNameText" class="text-sm font-medium text-slate-700">Click to choose `.csv` file</p>
                    <p class="text-xs text-slate-400 mt-0.5">Supports up to 10MB CSV files</p>
                    <input type="file" id="csvFileInput" name="csv_file" accept=".csv,.txt" class="hidden" required
                           onchange="document.getElementById('csvFileNameText').textContent = this.files[0] ? this.files[0].name : 'Click to choose .csv file'">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button" onclick="document.getElementById('bulkUploadModal').classList.add('hidden')"
                        class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg">Cancel</button>
                <button type="submit"
                        onclick="this.disabled=true; this.innerText='Uploading...'; this.form.submit();"
                        class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm">
                    Upload & Import
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<style>
#categoriesDataTable_wrapper .dataTables_filter,
#categoriesDataTable_wrapper .dataTables_length,
#categoriesDataTable_wrapper .dataTables_info,
#categoriesDataTable_wrapper .dataTables_paginate { display: none !important; }
table#categoriesDataTable thead th {
    background: #f1f5f9 !important;
    color: #475569 !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    padding: 12px 16px !important;
    border-bottom: 1px solid #e2e8f0 !important;
    border-top: none !important;
    cursor: pointer;
    white-space: nowrap;
    user-select: none;
}
table#categoriesDataTable thead th.sorting_asc:after  { content: ' ▲'; opacity: 1; color: #0d9488; }
table#categoriesDataTable thead th.sorting_desc:after { content: ' ▼'; opacity: 1; color: #0d9488; }
table#categoriesDataTable thead th.sorting:after       { content: ' ⇅'; font-size:10px; margin-left:4px; opacity:0.6; }
table#categoriesDataTable thead th.no-sort { cursor: default !important; }
table#categoriesDataTable thead th.no-sort:after,
table#categoriesDataTable thead th.sorting_asc.no-sort:after,
table#categoriesDataTable thead th.sorting_desc.no-sort:after { content: '' !important; }
table#categoriesDataTable { border-collapse: collapse !important; }
table#categoriesDataTable tbody tr:hover { background: #f8fafc !important; }
</style>

<script>
let categoriesDT = null;
let nextPage = {{ $categories->currentPage() + 1 }};
let perPage   = '{{ $perPageRaw }}';
let currentSearch = '{{ request('search') }}';

$(document).ready(function () {
    initDT();
});

function initDT() {
    if (categoriesDT) { categoriesDT.destroy(); categoriesDT = null; }
    categoriesDT = $('#categoriesDataTable').DataTable({
        paging:    false,
        searching: false,
        info:      false,
        ordering:  true,
        autoWidth: false,
        columnDefs: [{ orderable: false, targets: [0, 2, 7] }],
        order: []
    });
}

function updateExportUrls() {
    const q = `?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`;
    document.getElementById('exportCsvBtn').href = `{{ route('admin.categories.export-csv') }}${q}`;
    document.getElementById('exportPdfBtn').href = `{{ route('admin.categories.export-pdf') }}${q}`;
}

function changePerPage(size) {
    perPage = size;
    document.querySelectorAll('.per-page-pill').forEach(btn => {
        btn.className = 'per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition text-slate-600 hover:bg-slate-100';
    });
    const active = document.getElementById(`per-page-btn-${size}`);
    if (active) active.className = 'per-page-pill px-3 py-1 text-xs font-semibold rounded-md transition bg-teal-600 text-white shadow-sm';
    performSearch();
}

// Live Search
let searchTimer;
document.getElementById('categorySearchInput').addEventListener('input', function (e) {
    clearTimeout(searchTimer);
    currentSearch = e.target.value;
    document.getElementById('searchSpinner').classList.remove('hidden');
    searchTimer = setTimeout(() => performSearch(), 250);
});

function performSearch() {
    const tbody = document.getElementById('categoryTableBody');
    tbody.classList.add('opacity-40');
    document.getElementById('searchSpinner').classList.remove('hidden');
    updateExportUrls();

    fetch(`{{ route('admin.categories.index') }}?page=1&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        tbody.innerHTML = data.html;
        tbody.classList.remove('opacity-40');
        document.getElementById('searchSpinner').classList.add('hidden');
        document.getElementById('currentLoadedCount').textContent = data.count;
        document.getElementById('totalCategoriesCount').textContent = data.total;
        nextPage = 2;
        renderLoadMore(data.has_more_pages);
        history.pushState(null, '', `{{ route('admin.categories.index') }}?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`);
        initDT();
    })
    .catch(() => {
        tbody.classList.remove('opacity-40');
        document.getElementById('searchSpinner').classList.add('hidden');
    });
}

function renderLoadMore(hasMore) {
    const c = document.getElementById('loadMoreActionContainer');
    if (hasMore) {
        c.innerHTML = `<button id="loadMoreBtn" onclick="loadMoreCategories()"
            class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2 px-6 rounded-lg border border-teal-200 transition shadow-sm flex items-center justify-center min-w-[150px]">
            <span id="loadMoreText">Load More</span>
            <svg id="loadMoreSpinner" class="w-4 h-4 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </button>`;
    } else {
        c.innerHTML = '<div class="text-xs text-slate-400 font-medium">All categories loaded</div>';
    }
}

function loadMoreCategories() {
    const btn     = document.getElementById('loadMoreBtn');
    const spinner = document.getElementById('loadMoreSpinner');
    const text    = document.getElementById('loadMoreText');
    if (!btn) return;

    btn.disabled = true;
    text.textContent = 'Loading...';
    spinner.classList.remove('hidden');

    fetch(`{{ route('admin.categories.index') }}?page=${nextPage}&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.html) {
            if (categoriesDT) categoriesDT.destroy();
            document.getElementById('categoryTableBody').insertAdjacentHTML('beforeend', data.html);
            const el = document.getElementById('currentLoadedCount');
            if (el) el.textContent = parseInt(el.textContent || 0) + data.count;
            if (data.has_more_pages) {
                nextPage = data.next_page;
                btn.disabled = false;
                text.textContent = 'Load More';
                spinner.classList.add('hidden');
            } else {
                renderLoadMore(false);
            }
            initDT();
        }
    })
    .catch(() => {
        btn.disabled = false;
        text.textContent = 'Load More';
        spinner.classList.add('hidden');
    });
}

// Select All
function toggleSelectAll(master) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
    onCheckboxChange();
}

document.addEventListener('change', function (e) {
    if (e.target.classList.contains('row-check')) onCheckboxChange();
});

function onCheckboxChange() {
    const selected = document.querySelectorAll('.row-check:checked');
    const btn = document.getElementById('bulkDeleteBtn');
    document.getElementById('bulkDeleteCount').textContent = selected.length;
    selected.length > 0 ? btn.classList.remove('hidden') : btn.classList.add('hidden');
    const sa = document.getElementById('selectAllCheckbox');
    const all = document.querySelectorAll('.row-check');
    if (sa && all.length > 0) sa.checked = selected.length === all.length;
}

// Bulk Delete
function executeBulkDelete() {
    const ids = Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
    if (!ids.length) return;
    if (!confirm(`Delete ${ids.length} selected categories? This cannot be undone.`)) return;

    const btn = document.getElementById('bulkDeleteBtn');
    btn.disabled = true;
    const orig = btn.innerHTML;
    btn.innerHTML = 'Deleting...';

    fetch(`{{ route('admin.categories.bulk-delete') }}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ ids })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            performSearch();
            const sa = document.getElementById('selectAllCheckbox');
            if (sa) sa.checked = false;
        } else {
            alert(data.message || 'Bulk delete failed.');
        }
    })
    .catch(() => alert('An error occurred.'))
    .finally(() => { btn.disabled = false; btn.innerHTML = orig; });
}
</script>
@endpush
