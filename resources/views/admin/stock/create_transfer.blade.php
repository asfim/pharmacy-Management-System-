@extends('admin.layouts.app')
@php $header = 'Create Stock Transfer'; @endphp

@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-16">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-6 rounded-3xl text-white shadow-xl">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold border border-emerald-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Inter-Branch Inventory Routing
            </div>
            <h2 class="text-2xl font-black tracking-tight text-white">Create Stock Transfer</h2>
            <p class="text-xs text-slate-300">Live search medicines, select available batches, and transfer inventory seamlessly</p>
        </div>
        <a href="{{ route('admin.stock-transfers.index') }}" 
           class="inline-flex items-center px-4 py-2.5 rounded-xl border border-slate-700/80 text-xs font-bold text-slate-200 bg-slate-800/80 hover:bg-slate-700 hover:text-white transition shadow-sm backdrop-blur-md">
            <i class="fas fa-arrow-left mr-2 text-slate-400"></i> Back to Transfers List
        </a>
    </div>

    @include('admin.layouts.alerts')

    <form action="{{ route('admin.stock-transfers.store') }}" method="POST" id="transferForm">
        @csrf

        <!-- Branch Selection Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-emerald-500/20">
                        <i class="fas fa-right-left"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Branch Routing</h3>
                        <p class="text-xs text-slate-500">Select source branch (where stock exists) and destination branch</p>
                    </div>
                </div>

                <div id="stockBadgeContainer" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200/60">
                    <i class="fas fa-cubes text-emerald-600"></i>
                    <span id="loadedProductsCount">0</span> Medicines Available
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                <!-- Source Branch -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                        Source Branch (থেকে) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="source_branch_id" id="source_branch_id" 
                                class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500/20 p-3.5 pl-11 transition shadow-xs" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('source_branch_id', $defaultSourceBranchId) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} {{ $branch->code ? '('.$branch->code.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-warehouse absolute left-4 top-4 text-slate-400 text-sm pointer-events-none"></i>
                    </div>
                </div>

                <!-- Destination Branch -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                        Destination Branch (কোথায়) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="destination_branch_id" id="destination_branch_id" 
                                class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-semibold focus:border-emerald-500 focus:ring-emerald-500/20 p-3.5 pl-11 transition shadow-xs" required>
                            <option value="">Select Destination Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('destination_branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }} {{ $branch->code ? '('.$branch->code.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-store absolute left-4 top-4 text-slate-400 text-sm pointer-events-none"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transfer Items Card -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 mt-6 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-indigo-500/20">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Transfer Items List</h3>
                        <p class="text-xs text-slate-500">Search by medicine name, generic, SKU or barcode</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden lg:flex items-center gap-2 text-[11px] font-semibold text-slate-400 bg-slate-100/80 px-3 py-1.5 rounded-xl">
                        <span><kbd class="bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-600">Ctrl+K</kbd> Search</span>
                        <span>•</span>
                        <span><kbd class="bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-600">Alt+A</kbd> Add Item</span>
                    </div>

                    <button type="button" id="addRowBtn" 
                            class="inline-flex items-center px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition shadow-md shadow-emerald-600/20">
                        <i class="fas fa-plus mr-2 text-xs"></i> Add Item Row
                    </button>
                </div>
            </div>

            <div class="overflow-visible">
                <table class="w-full text-sm text-left border-separate border-spacing-y-2" id="itemsTable">
                    <thead class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2 min-w-[360px]">Medicine (Live Search)</th>
                            <th class="px-4 py-2 min-w-[220px]">Batch & Expiry</th>
                            <th class="px-4 py-2 min-w-[140px]">Available Stock</th>
                            <th class="px-4 py-2 min-w-[150px]">Transfer Qty</th>
                            <th class="px-4 py-2 text-right w-12">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsTableBody">
                        <!-- Dynamic Rows Injected Here -->
                    </tbody>
                </table>
            </div>

            <div id="noItemsAlert" class="hidden text-center py-10 text-slate-400 bg-slate-50/60 rounded-2xl border border-dashed border-slate-200">
                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="text-sm font-bold text-slate-700">No items added to transfer list</h4>
                <p class="text-xs text-slate-400 mt-1">Click "Add Item Row" or press <kbd class="bg-white px-1.5 py-0.5 rounded border border-slate-200 text-slate-600">Alt + A</kbd> to add medicines.</p>
            </div>

            <!-- Transfer Summary Footer Bar -->
            <div id="transferSummaryBar" class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-slate-900 text-white shadow-inner">
                <div class="flex items-center gap-6 text-xs font-medium">
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400">Selected Items:</span>
                        <span id="summaryTotalItems" class="font-bold text-emerald-400 text-sm">0</span>
                    </div>
                    <div class="w-px h-4 bg-slate-700"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-400">Total Quantity:</span>
                        <span id="summaryTotalQty" class="font-bold text-emerald-400 text-sm">0 Pcs</span>
                    </div>
                </div>

                <div class="text-[11px] text-slate-400 italic">
                    <i class="fas fa-shield-halved text-emerald-400 mr-1"></i> Inventory will be updated automatically upon completion
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 mt-8">
            <a href="{{ route('admin.stock-transfers.index') }}" 
               class="px-6 py-3 rounded-2xl border border-slate-200 text-sm font-bold text-slate-600 bg-white hover:bg-slate-50 transition">
                Cancel
            </a>
            <button type="submit" id="submitBtn" 
                    class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm shadow-lg shadow-emerald-500/25 transition inline-flex items-center">
                <i class="fas fa-paper-plane mr-2 text-sm"></i> Submit & Complete Stock Transfer
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let rowIndex = 0;

    const sourceSelect = document.getElementById('source_branch_id');
    const destinationSelect = document.getElementById('destination_branch_id');
    const tableBody = document.getElementById('itemsTableBody');
    const noItemsAlert = document.getElementById('noItemsAlert');
    const stockBadgeContainer = document.getElementById('stockBadgeContainer');
    const loadedProductsCount = document.getElementById('loadedProductsCount');
    const summaryTotalItems = document.getElementById('summaryTotalItems');
    const summaryTotalQty = document.getElementById('summaryTotalQty');

    // Helper: Highlight matching substring in search results
    function highlightMatch(text, query) {
        if (!text) return '';
        if (!query) return text;
        const escaped = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escaped})`, 'gi');
        return text.replace(regex, '<mark class="bg-amber-200/90 text-amber-950 font-bold px-0.5 rounded">$1</mark>');
    }

    // Helper: Select icon based on dosage form or medicine type
    function getMedicineIcon(dosageForm) {
        const df = (dosageForm || '').toLowerCase();
        if (df.includes('syrup') || df.includes('liquid') || df.includes('suspension')) {
            return '<i class="fas fa-flask text-teal-600"></i>';
        } else if (df.includes('injection') || df.includes('ampoule')) {
            return '<i class="fas fa-syringe text-rose-500"></i>';
        } else if (df.includes('capsule')) {
            return '<i class="fas fa-capsules text-indigo-600"></i>';
        } else if (df.includes('cream') || df.includes('ointment') || df.includes('gel')) {
            return '<i class="fas fa-pump-soap text-amber-600"></i>';
        }
        return '<i class="fas fa-pills text-emerald-600"></i>';
    }

    // Fetch Stats Count for Selected Source Branch
    async function loadBranchProductsCount(branchId) {
        if (!branchId) {
            stockBadgeContainer.classList.add('hidden');
            return;
        }

        try {
            stockBadgeContainer.classList.remove('hidden');
            loadedProductsCount.textContent = 'Loading...';

            const res = await fetch(`{{ route('admin.stock-transfers.branch-products') }}?branch_id=${branchId}&stats=1`);
            const data = await res.json();

            loadedProductsCount.textContent = (data.total_products || 0).toLocaleString();

            // Reset existing rows on branch change
            const rows = tableBody.querySelectorAll('tr.row-item');
            rows.forEach(row => resetRow(row));
            updateSummary();
        } catch (e) {
            console.error('Error fetching branch stats:', e);
            loadedProductsCount.textContent = '0';
        }
    }

    // Add New Row to Table
    function addRow() {
        rowIndex++;
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50/80 transition row-item group bg-white rounded-2xl border border-slate-200/70 shadow-xs';
        tr.id = `row_${rowIndex}`;
        tr.dataset.rowIndex = rowIndex;

        tr.innerHTML = `
            <td class="px-4 py-3 relative align-top">
                <div class="relative search-wrapper">
                    <!-- Search Input Box -->
                    <div class="relative flex items-center">
                        <input type="text" 
                               class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-semibold focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 pl-10 pr-9 py-2.5 search-input transition placeholder:text-slate-400 placeholder:font-normal" 
                               placeholder="Search medicine, generic, SKU or barcode..." 
                               autocomplete="off"
                               spellcheck="false">
                        <i class="fas fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm pointer-events-none search-icon transition"></i>
                        <button type="button" class="hidden absolute right-3 text-slate-400 hover:text-rose-500 clear-btn transition p-1 rounded-full hover:bg-slate-100">
                            <i class="fas fa-circle-xmark text-sm"></i>
                        </button>
                    </div>
                    <input type="hidden" name="items[${rowIndex}][product_id]" class="product-id-input" required>

                    <!-- Live Search Results Dropdown -->
                    <div class="hidden absolute left-0 right-0 top-full mt-2 bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200/90 overflow-hidden z-50 max-h-80 overflow-y-auto search-results divide-y divide-slate-100 animate-in fade-in zoom-in-95 duration-100">
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 align-top">
                <select name="items[${rowIndex}][batch_id]" class="w-full rounded-2xl border-slate-200 bg-slate-50/50 text-slate-800 text-xs font-semibold focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 p-2.5 batch-select transition" required disabled>
                    <option value="">Select Batch</option>
                </select>
            </td>
            <td class="px-4 py-3 align-top pt-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-500 avail-badge transition">
                    <i class="fas fa-minus-circle text-[10px]"></i> - Pcs
                </span>
            </td>
            <td class="px-4 py-3 align-top">
                <div class="flex items-center gap-1">
                    <button type="button" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center transition qty-minus-btn disabled:opacity-40" disabled>-</button>
                    <input type="number" name="items[${rowIndex}][quantity]" class="w-20 text-center rounded-xl border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-bold focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 p-2 qty-input" min="1" value="1" required disabled>
                    <button type="button" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center transition qty-plus-btn disabled:opacity-40" disabled>+</button>
                </div>
            </td>
            <td class="px-4 py-3 text-right align-top pt-3.5">
                <button type="button" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white inline-flex items-center justify-center transition remove-row-btn shadow-xs">
                    <i class="fas fa-trash-can text-xs"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(tr);
        checkTableState();

        const searchInput = tr.querySelector('.search-input');
        const searchResults = tr.querySelector('.search-results');
        const clearBtn = tr.querySelector('.clear-btn');
        const searchIcon = tr.querySelector('.search-icon');
        const productIdInput = tr.querySelector('.product-id-input');
        const batchSelect = tr.querySelector('.batch-select');
        const qtyInput = tr.querySelector('.qty-input');
        const qtyMinusBtn = tr.querySelector('.qty-minus-btn');
        const qtyPlusBtn = tr.querySelector('.qty-plus-btn');
        const removeBtn = tr.querySelector('.remove-row-btn');

        let focusedIndex = -1;
        let debounceTimer = null;

        // Debounced On-Demand Server-Side Live Search Input Event
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            focusedIndex = -1;

            if (query.length === 0) {
                searchResults.classList.add('hidden');
                clearBtn.classList.add('hidden');
                return;
            }

            clearBtn.classList.remove('hidden');
            searchIcon.className = 'fas fa-spinner fa-spin absolute left-3.5 text-emerald-500 text-sm pointer-events-none search-icon transition';

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(async () => {
                const branchId = sourceSelect.value;
                if (!branchId) {
                    alert('Please select a Source Branch first.');
                    searchIcon.className = 'fas fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm pointer-events-none search-icon transition';
                    return;
                }

                try {
                    const res = await fetch(`{{ route('admin.stock-transfers.branch-products') }}?branch_id=${branchId}&q=${encodeURIComponent(query)}`);
                    const matches = await res.json();
                    renderSearchResults(searchResults, matches, query, tr);
                } catch (err) {
                    console.error('Search fetch error:', err);
                } finally {
                    searchIcon.className = 'fas fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm pointer-events-none search-icon transition';
                }
            }, 180);
        });

        // Keyboard Navigation (Arrow Keys & Enter)
        searchInput.addEventListener('keydown', function(e) {
            const items = searchResults.querySelectorAll('.search-item');
            if (searchResults.classList.contains('hidden') || items.length === 0) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                focusedIndex = (focusedIndex + 1) % items.length;
                updateFocusedItem(items, focusedIndex);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                focusedIndex = (focusedIndex - 1 + items.length) % items.length;
                updateFocusedItem(items, focusedIndex);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (focusedIndex >= 0 && focusedIndex < items.length) {
                    items[focusedIndex].click();
                } else if (items.length > 0) {
                    items[0].click();
                }
            } else if (e.key === 'Escape') {
                searchResults.classList.add('hidden');
            }
        });

        function updateFocusedItem(items, index) {
            items.forEach((item, i) => {
                if (i === index) {
                    item.classList.add('bg-emerald-50', 'border-l-4', 'border-emerald-600', 'scale-[1.01]', 'shadow-sm');
                    item.scrollIntoView({ block: 'nearest' });
                } else {
                    item.classList.remove('bg-emerald-50', 'border-l-4', 'border-emerald-600', 'scale-[1.01]', 'shadow-sm');
                }
            });
        }

        // Focus event
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length > 0 && !productIdInput.value) {
                this.dispatchEvent(new Event('input'));
            }
        });

        // Clear Button
        clearBtn.addEventListener('click', () => {
            resetRow(tr);
            searchInput.focus();
        });

        batchSelect.addEventListener('change', () => {
            triggerBatchChange(tr);
            updateSummary();
        });

        qtyInput.addEventListener('input', () => {
            validateRowQty(tr);
            updateSummary();
        });

        qtyMinusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) {
                qtyInput.value = val - 1;
                validateRowQty(tr);
                updateSummary();
            }
        });

        qtyPlusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value) || 0;
            let max = parseInt(qtyInput.max) || 9999;
            if (val < max) {
                qtyInput.value = val + 1;
                validateRowQty(tr);
                updateSummary();
            }
        });

        removeBtn.addEventListener('click', () => {
            tr.remove();
            checkTableState();
            updateSummary();
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!tr.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // Focus search input on newly added row
        setTimeout(() => searchInput.focus(), 50);
    }

    // Render Search Results
    function renderSearchResults(container, matches, query, tr) {
        container.innerHTML = '';

        if (matches.length === 0) {
            container.innerHTML = `
                <div class="p-6 text-center text-slate-400 bg-slate-50/50">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-lg">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <p class="text-xs font-bold text-slate-700">No stock found for "${query}"</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Check spelling or select a different source branch</p>
                </div>
            `;
        } else {
            // Header bar in dropdown
            const headerDiv = document.createElement('div');
            headerDiv.className = 'px-4 py-2 bg-slate-900 text-white flex items-center justify-between text-[11px] font-semibold uppercase tracking-wider sticky top-0 z-10';
            headerDiv.innerHTML = `
                <span>Found <strong class="text-emerald-400">${matches.length}</strong> matching medicines</span>
                <span class="text-slate-400 text-[10px] hidden sm:inline">Use <kbd class="bg-slate-800 px-1 py-0.5 rounded text-slate-300">↑</kbd> <kbd class="bg-slate-800 px-1 py-0.5 rounded text-slate-300">↓</kbd> <kbd class="bg-slate-800 px-1 py-0.5 rounded text-slate-300">↵</kbd></span>
            `;
            container.appendChild(headerDiv);

            matches.forEach(p => {
                const totalStock = p.batches.reduce((sum, b) => sum + b.qty_on_hand, 0);
                const itemDiv = document.createElement('div');
                itemDiv.className = 'p-3 hover:bg-emerald-50/90 cursor-pointer transition flex items-center justify-between group border-b border-slate-100 last:border-0 search-item';

                // Stock Badge Styling
                let stockBadgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200/80';
                let stockIcon = '<i class="fas fa-check-circle text-emerald-500 mr-1"></i>';
                if (totalStock <= 10) {
                    stockBadgeClass = 'bg-amber-50 text-amber-700 border-amber-200/80';
                    stockIcon = '<i class="fas fa-triangle-exclamation text-amber-500 mr-1"></i>';
                }

                itemDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-sm group-hover:bg-emerald-600 group-hover:text-white transition shadow-2xs">
                            ${getMedicineIcon(p.dosage_form)}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-extrabold text-slate-800 group-hover:text-emerald-700 transition">
                                    ${highlightMatch(p.name, query)}
                                </p>
                                ${p.strength ? `<span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">${highlightMatch(p.strength, query)}</span>` : ''}
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5 text-xs text-slate-500">
                                ${p.generic_name ? `<span class="text-indigo-600 font-medium"><i class="fas fa-flask text-[9px] mr-1 opacity-70"></i>${highlightMatch(p.generic_name, query)}</span>` : ''}
                                ${p.sku ? `<span class="font-mono text-[11px] text-slate-400">SKU: ${highlightMatch(p.sku, query)}</span>` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="text-right space-y-1">
                        <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-xl font-bold border ${stockBadgeClass} shadow-2xs">
                            ${stockIcon} ${totalStock} ${p.unit}
                        </span>
                        <div class="text-[10px] font-semibold text-slate-400">${p.batches.length} Batch${p.batches.length > 1 ? 'es' : ''}</div>
                    </div>
                `;

                itemDiv.addEventListener('click', () => {
                    selectProduct(tr, p);
                    container.classList.add('hidden');
                });

                container.appendChild(itemDiv);
            });
        }
        container.classList.remove('hidden');
    }

    // Product Selection
    function selectProduct(tr, product) {
        const searchInput = tr.querySelector('.search-input');
        const clearBtn = tr.querySelector('.clear-btn');
        const productIdInput = tr.querySelector('.product-id-input');
        const batchSelect = tr.querySelector('.batch-select');
        const availBadge = tr.querySelector('.avail-badge');

        const titleText = `${product.name} ${product.strength ? '(' + product.strength + ')' : ''}`;
        searchInput.value = titleText;
        searchInput.classList.remove('bg-slate-50/50', 'border-slate-200');
        searchInput.classList.add('bg-emerald-50/60', 'border-emerald-500', 'text-emerald-950', 'font-extrabold');
        productIdInput.value = product.id;
        clearBtn.classList.remove('hidden');

        // Populate batches
        batchSelect.innerHTML = '<option value="">Select Batch</option>';
        batchSelect.disabled = false;

        product.batches.forEach(b => {
            const opt = document.createElement('option');
            opt.value = b.batch_id;
            opt.dataset.qty = b.qty_on_hand;
            opt.textContent = `${b.batch_no} (Exp: ${b.expiry_date}) — ${b.qty_on_hand} ${product.unit} available`;
            batchSelect.appendChild(opt);
        });

        if (product.batches.length === 1) {
            batchSelect.selectedIndex = 1;
            triggerBatchChange(tr);
        } else {
            availBadge.innerHTML = `<i class="fas fa-cubes text-slate-400 text-[10px]"></i> Select Batch`;
            availBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 avail-badge';
        }

        updateSummary();
    }

    // Reset Row
    function resetRow(tr) {
        const searchInput = tr.querySelector('.search-input');
        const searchResults = tr.querySelector('.search-results');
        const clearBtn = tr.querySelector('.clear-btn');
        const productIdInput = tr.querySelector('.product-id-input');
        const batchSelect = tr.querySelector('.batch-select');
        const availBadge = tr.querySelector('.avail-badge');
        const qtyInput = tr.querySelector('.qty-input');
        const qtyMinusBtn = tr.querySelector('.qty-minus-btn');
        const qtyPlusBtn = tr.querySelector('.qty-plus-btn');

        searchInput.value = '';
        searchInput.classList.remove('bg-emerald-50/60', 'border-emerald-500', 'text-emerald-950', 'font-extrabold');
        searchInput.classList.add('bg-slate-50/50', 'border-slate-200');
        productIdInput.value = '';
        searchResults.classList.add('hidden');
        clearBtn.classList.add('hidden');

        batchSelect.innerHTML = '<option value="">Select Batch</option>';
        batchSelect.disabled = true;

        qtyInput.value = 1;
        qtyInput.disabled = true;
        qtyMinusBtn.disabled = true;
        qtyPlusBtn.disabled = true;

        availBadge.innerHTML = `<i class="fas fa-minus-circle text-[10px]"></i> - Pcs`;
        availBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-500 avail-badge';

        updateSummary();
    }

    // Trigger Batch Change
    function triggerBatchChange(tr) {
        const batchSelect = tr.querySelector('.batch-select');
        const availBadge = tr.querySelector('.avail-badge');
        const qtyInput = tr.querySelector('.qty-input');
        const qtyMinusBtn = tr.querySelector('.qty-minus-btn');
        const qtyPlusBtn = tr.querySelector('.qty-plus-btn');

        const selectedOpt = batchSelect.options[batchSelect.selectedIndex];
        if (selectedOpt && selectedOpt.value) {
            const availQty = parseInt(selectedOpt.dataset.qty) || 0;
            availBadge.innerHTML = `<i class="fas fa-circle-check text-emerald-500 text-[10px]"></i> ${availQty} Available`;
            availBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200/70 avail-badge animate-in fade-in duration-150';
            
            qtyInput.disabled = false;
            qtyMinusBtn.disabled = false;
            qtyPlusBtn.disabled = false;
            qtyInput.max = availQty;

            if (parseInt(qtyInput.value) > availQty) {
                qtyInput.value = availQty;
            }
        } else {
            availBadge.innerHTML = `<i class="fas fa-minus-circle text-[10px]"></i> - Pcs`;
            availBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-500 avail-badge';
            qtyInput.disabled = true;
            qtyMinusBtn.disabled = true;
            qtyPlusBtn.disabled = true;
        }
    }

    // Validate Row Quantity
    function validateRowQty(tr) {
        const batchSelect = tr.querySelector('.batch-select');
        const qtyInput = tr.querySelector('.qty-input');
        const selectedOpt = batchSelect.options[batchSelect.selectedIndex];

        if (selectedOpt && selectedOpt.value) {
            const availQty = parseInt(selectedOpt.dataset.qty) || 0;
            let enteredVal = parseInt(qtyInput.value) || 1;

            if (enteredVal > availQty) {
                qtyInput.value = availQty;
            } else if (enteredVal < 1) {
                qtyInput.value = 1;
            }
        }
    }

    // Check Table State
    function checkTableState() {
        const rows = tableBody.querySelectorAll('tr.row-item');
        if (rows.length === 0) {
            noItemsAlert.classList.remove('hidden');
        } else {
            noItemsAlert.classList.add('hidden');
        }
    }

    // Update Summary Footer
    function updateSummary() {
        const rows = tableBody.querySelectorAll('tr.row-item');
        let validItems = 0;
        let totalQty = 0;

        rows.forEach(row => {
            const pId = row.querySelector('.product-id-input')?.value;
            const bId = row.querySelector('.batch-select')?.value;
            const qty = parseInt(row.querySelector('.qty-input')?.value) || 0;

            if (pId && bId && qty > 0) {
                validItems++;
                totalQty += qty;
            }
        });

        summaryTotalItems.textContent = validItems;
        summaryTotalQty.textContent = `${totalQty} Pcs`;
    }

    // Global Event Listeners
    sourceSelect.addEventListener('change', () => {
        loadBranchProductsCount(sourceSelect.value);
    });

    document.getElementById('addRowBtn').addEventListener('click', addRow);

    // Global Keyboard Shortcuts (Ctrl+K and Alt+A)
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            const inputs = tableBody.querySelectorAll('.search-input');
            if (inputs.length > 0) {
                let targetInput = Array.from(inputs).find(input => !input.closest('tr').querySelector('.product-id-input').value);
                if (!targetInput) {
                    addRow();
                    const newInputs = tableBody.querySelectorAll('.search-input');
                    targetInput = newInputs[newInputs.length - 1];
                }
                if (targetInput) targetInput.focus();
            } else {
                addRow();
            }
        } else if (e.altKey && e.key.toLowerCase() === 'a') {
            e.preventDefault();
            addRow();
        }
    });

    // Form Submit Validation
    document.getElementById('transferForm').addEventListener('submit', function(e) {
        if (sourceSelect.value && destinationSelect.value && sourceSelect.value === destinationSelect.value) {
            e.preventDefault();
            alert('Source branch and Destination branch must be different.');
            return;
        }

        const validRows = Array.from(tableBody.querySelectorAll('tr.row-item')).filter(r => {
            const pId = r.querySelector('.product-id-input')?.value;
            const bId = r.querySelector('.batch-select')?.value;
            return pId && bId;
        });

        if (validRows.length === 0) {
            e.preventDefault();
            alert('Please select at least one medicine and batch for stock transfer.');
        }
    });

    // Initial Setup
    document.addEventListener('DOMContentLoaded', async () => {
        if (sourceSelect.value) {
            await loadBranchProductsCount(sourceSelect.value);
        }
        addRow(); // Add initial row
    });
</script>
@endpush
@endsection
