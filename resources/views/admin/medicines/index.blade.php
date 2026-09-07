@extends('admin.layouts.app')
@php $header = 'Medicines'; @endphp
@section('content')

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Medicine Directory</h2>
        <p class="text-sm text-slate-500">Manage, export, and bulk upload pharmacy medicines</p>
    </div>
    
    <div class="flex flex-wrap items-center gap-2">
        <!-- CSV Export -->
        <a href="{{ route('admin.medicines.export-csv', request()->query()) }}" 
           class="bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export CSV
        </a>

        <!-- PDF Export -->
        <a href="{{ route('admin.medicines.export-pdf', request()->query()) }}" target="_blank"
           class="bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Export PDF
        </a>

        <!-- Bulk Upload CSV Modal Trigger -->
        <button onclick="document.getElementById('bulkUploadModal').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-3 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Bulk Upload CSV
        </button>

        <!-- Add Medicine -->
        <a href="{{ route('admin.medicines.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg flex items-center transition text-sm shadow-xs">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Medicine
        </a>
    </div>
</div>

@include('admin.layouts.alerts')

<!-- Datatable Control Toolbar Header -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Per Page Selector Pills -->
        <div class="flex items-center space-x-2 text-sm text-slate-600">
            <span class="font-medium text-slate-700">Show per page:</span>
            <div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-2xs">
                @foreach([50, 100, 200, 500, 'all'] as $size)
                    <button type="button" 
                            onclick="changePerPage('{{ $size }}')"
                            id="per-page-btn-{{ $size }}"
                            class="px-3 py-1 text-xs font-semibold rounded-md transition {{ (request('per_page', 50) == $size) ? 'bg-teal-600 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ strtoupper($size) }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Search Box -->
        <div class="relative w-full md:w-80">
            <input type="text" 
                   id="medicineSearchInput"
                   value="{{ request('search') }}"
                   placeholder="Search medicine, generic, brand..." 
                   class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-white">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Medicine Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-100 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider font-semibold">
                <tr>
                    <th class="px-4 py-3.5">SL</th>
                    <th class="px-4 py-3.5">Image</th>
                    <th class="px-4 py-3.5">Name</th>
                    <th class="px-4 py-3.5">Generic</th>
                    <th class="px-4 py-3.5">Manufacturer</th>
                    <th class="px-4 py-3.5">Category</th>
                    <th class="px-4 py-3.5">Sale Price</th>
                    <th class="px-4 py-3.5">Rx</th>
                    <th class="px-4 py-3.5">Status</th>
                    <th class="px-4 py-3.5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="medicineTableBody" class="divide-y divide-slate-200 text-sm">
                @include('admin.medicines.partials.table_rows')
            </tbody>
        </table>
    </div>

    <!-- Load More Footer Section (Replacing Standard Pagination) -->
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col md:flex-row items-center justify-between gap-4">
        <div id="medicineCountInfo" class="text-sm text-slate-600 font-medium">
            Showing <span id="currentLoadedCount">{{ $medicines->count() }}</span> of <span id="totalMedicinesCount">{{ $medicines->total() }}</span> medicines
        </div>

        @if($medicines->hasMorePages())
            <button id="loadMoreBtn" 
                    onclick="loadMoreMedicines()"
                    class="bg-white hover:bg-slate-100 text-teal-700 font-semibold py-2.5 px-6 rounded-lg border border-teal-200 transition shadow-xs flex items-center justify-center min-w-[160px]">
                <span id="loadMoreText">Load More</span>
                <svg id="loadMoreSpinner" class="w-5 h-5 ml-2 animate-spin hidden text-teal-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        @else
            <div id="noMoreMedicinesMsg" class="text-xs text-slate-400 font-medium">All medicines loaded</div>
        @endif
    </div>
</div>

<!-- Bulk CSV Upload Modal -->
<div id="bulkUploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs hidden p-4">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-150">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Bulk Medicine CSV Uploader</h3>
            </div>
            <button onclick="document.getElementById('bulkUploadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form action="{{ route('admin.medicines.import-csv') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Select CSV File</label>
                <div class="border-2 border-dashed border-slate-300 hover:border-indigo-500 rounded-xl p-6 text-center cursor-pointer transition bg-slate-50 hover:bg-indigo-50/30"
                     onclick="document.getElementById('csvFileInput').click()">
                    <svg class="w-10 h-10 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p id="csvFileNameText" class="text-sm font-medium text-slate-700">Click to choose `.csv` file</p>
                    <p class="text-xs text-slate-400 mt-1">Supports up to 50MB (medicine_name, category_name, slug, generic_name, strength, manufacturer_name, unit, unit_size, price)</p>
                    <input type="file" id="csvFileInput" name="csv_file" accept=".csv, .txt" class="hidden" required onchange="document.getElementById('csvFileNameText').textContent = this.files[0] ? this.files[0].name : 'Click to choose .csv file'">
                </div>
            </div>

            <div class="bg-indigo-50/60 border border-indigo-100 rounded-xl p-3 text-xs text-indigo-900 flex items-start space-x-2">
                <svg class="w-4 h-4 text-indigo-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>The system will automatically link related categories, generics, manufacturers, and attach images from <strong>Medicine_data</strong> to all imported products.</span>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button" onclick="document.getElementById('bulkUploadModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-lg">Cancel</button>
                <button type="submit" onclick="this.disabled=true; this.innerText='Uploading & Processing...'; this.form.submit();" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm">
                    Upload & Import
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let nextPage = {{ $medicines->currentPage() + 1 }};
    let perPage = '{{ request("per_page", 50) }}';
    let currentSearch = '{{ request("search") }}';

    function changePerPage(size) {
        perPage = size;
        window.location.href = `{{ route('admin.medicines.index') }}?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`;
    }

    // Live search debounced
    let searchTimeout;
    document.getElementById('medicineSearchInput').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        currentSearch = e.target.value;
        searchTimeout = setTimeout(() => {
            window.location.href = `{{ route('admin.medicines.index') }}?per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`;
        }, 600);
    });

    // Load More Ajax Function
    function loadMoreMedicines() {
        const btn = document.getElementById('loadMoreBtn');
        const spinner = document.getElementById('loadMoreSpinner');
        const btnText = document.getElementById('loadMoreText');

        if(!btn) return;

        btn.disabled = true;
        btnText.textContent = 'Loading...';
        spinner.classList.remove('hidden');

        fetch(`{{ route('admin.medicines.index') }}?page=${nextPage}&per_page=${perPage}&search=${encodeURIComponent(currentSearch)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.html) {
                document.getElementById('medicineTableBody').insertAdjacentHTML('beforeend', data.html);
                
                const loadedElem = document.getElementById('currentLoadedCount');
                if(loadedElem) {
                    const currentCount = parseInt(loadedElem.textContent) || 0;
                    loadedElem.textContent = currentCount + data.count;
                }

                if(data.has_more_pages) {
                    nextPage = data.next_page;
                    btn.disabled = false;
                    btnText.textContent = 'Load More';
                    spinner.classList.add('hidden');
                } else {
                    btn.parentElement.innerHTML = '<div class="text-xs text-slate-400 font-medium">All medicines loaded</div>';
                }
            }
        })
        .catch(err => {
            console.error('Load more error:', err);
            btn.disabled = false;
            btnText.textContent = 'Load More';
            spinner.classList.add('hidden');
        });
    }
</script>
@endsection
