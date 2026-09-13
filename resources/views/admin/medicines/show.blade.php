@extends('admin.layouts.app')
@php $header = 'Medicine Details — ' . $medicine->name; @endphp

@section('content')
<div class="space-y-6">

    <!-- Top Action & Navigation Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-teal-500/10 text-teal-600 flex items-center justify-center text-2xl font-bold border border-teal-500/20 shadow-xs">
                <i class="fas fa-pills"></i>
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $medicine->name }}</h2>
                    @if($medicine->prescription_required)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-500 text-white uppercase tracking-wider shadow-xs">
                        <i class="fas fa-file-prescription text-[10px] mr-1"></i> Rx Required
                    </span>
                    @endif
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $medicine->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst($medicine->status ?? 'active') }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                    <span class="font-medium text-slate-700"><i class="fas fa-dna text-teal-500 mr-1"></i> {{ $medicine->generic->name ?? 'No Generic Assigned' }}</span>
                    <span>•</span>
                    <span><i class="fas fa-industry text-slate-400 mr-1"></i> {{ $medicine->manufacturer->company_name ?? $medicine->manufacturer->name ?? 'No Manufacturer' }}</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2.5 flex-wrap">
            <a href="{{ route('admin.medicines.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i> Back
            </a>
            @can('edit medicines')
            <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition flex items-center gap-2 shadow-xs">
                <i class="fas fa-pen-to-square text-xs"></i> Edit Medicine
            </a>
            @endcan
            <a href="{{ route('admin.purchases.create', ['product_id' => $medicine->id]) }}" class="px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold transition flex items-center gap-2 shadow-xs">
                <i class="fas fa-cart-flatbed text-xs"></i> Restock / Purchase
            </a>
        </div>
    </div>

    @php
        $totalAllBranchesStock = $medicine->batches->sum('quantity');
        $activeBranchStock = $activeBranch 
            ? (int) $medicine->stock_balances->where('branch_id', $activeBranch->id)->sum('qty_on_hand')
            : $totalAllBranchesStock;
        $isLowStock = $activeBranchStock <= ($medicine->min_stock ?? 0);
        $profitMargin = $medicine->purchase_price > 0 ? round((($medicine->sale_price - $medicine->purchase_price) / $medicine->purchase_price) * 100, 1) : 0;
    @endphp

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Stock Available Card -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                    {{ $activeBranch ? ('Stock (' . $activeBranch->name . ')') : 'Total Stock (All Branches)' }}
                </p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-black {{ $isLowStock ? 'text-rose-600' : 'text-slate-800' }}">{{ number_format($activeBranchStock) }}</span>
                    <span class="text-xs font-semibold text-slate-500">Pcs</span>
                </div>
                @if($activeBranch)
                    <p class="text-[11px] text-slate-500 font-semibold mt-1">
                        Total across all branches: <strong class="text-slate-700">{{ number_format($totalAllBranchesStock) }} Pcs</strong>
                    </p>
                @endif
                <div class="mt-2">
                    @if($activeBranchStock == 0)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-md bg-rose-100 text-rose-700">
                            <i class="fas fa-circle-exclamation text-[10px]"></i> Out of Stock
                        </span>
                    @elseif($isLowStock)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-800">
                            <i class="fas fa-triangle-exclamation text-[10px]"></i> Low Stock Alert
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700">
                            <i class="fas fa-check-circle text-[10px]"></i> Stock Level Healthy
                        </span>
                    @endif
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl {{ $isLowStock ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center text-xl">
                <i class="fas fa-boxes-stacked"></i>
            </div>
        </div>

        <!-- Minimum Stock Requirement -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Minimum Required Stock</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-black text-slate-800">{{ number_format($medicine->min_stock ?? 0) }}</span>
                    <span class="text-xs font-semibold text-slate-500">Pcs</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">Reorder triggered when stock falls below this</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fas fa-shield-halved"></i>
            </div>
        </div>

        <!-- Sale Price & MRP -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sale Price / MRP</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-black text-teal-600">৳{{ number_format($medicine->sale_price, 2) }}</span>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">MRP: <span class="font-bold text-slate-700">৳{{ number_format($medicine->mrp ?: $medicine->sale_price, 2) }}</span></p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fas fa-tag"></i>
            </div>
        </div>

        <!-- Purchase Price & Margin -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Purchase Price / Margin</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <span class="text-3xl font-black text-slate-800">৳{{ number_format($medicine->purchase_price, 2) }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-2">Margin: <strong class="text-emerald-600">+{{ $profitMargin }}%</strong> profit</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Content Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Details (Left 2 Columns) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Branch Stock Distribution Table -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-code-branch"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Branch-wise Stock Distribution</h3>
                            <p class="text-xs text-slate-400">Current available quantity in each branch</p>
                        </div>
                    </div>
                    <span class="text-xs font-extrabold px-3 py-1 bg-purple-50 text-purple-700 rounded-full">
                        {{ $medicine->stock_balances->groupBy('branch_id')->count() }} Branch(es)
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3.5 text-left">Branch Name</th>
                                <th class="px-5 py-3.5 text-right">Available Stock</th>
                                <th class="px-5 py-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($medicine->stock_balances->groupBy('branch_id') as $bId => $balances)
                                @php
                                    $branchName = $balances->first()->branch->name ?? ('Branch #' . $bId);
                                    $branchQty = $balances->sum('qty_on_hand');
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-5 py-4 font-bold text-slate-800">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-store text-slate-400 text-xs"></i>
                                            <span>{{ $branchName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-right font-black text-slate-800 text-base">
                                        {{ number_format($branchQty) }} <span class="text-xs font-normal text-slate-400">Pcs</span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($branchQty == 0)
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">Out of Stock</span>
                                        @elseif($branchQty <= ($medicine->min_stock ?? 0))
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Low Stock</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">In Stock</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center text-slate-400 text-sm">
                                        No branch stock balances recorded for this medicine yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Batches & Expiry List -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-sm font-bold">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Batches & Expiry Records</h3>
                            <p class="text-xs text-slate-400">All registered batches and their expiry dates</p>
                        </div>
                    </div>
                    <span class="text-xs font-extrabold px-3 py-1 bg-teal-50 text-teal-700 rounded-full">
                        {{ $medicine->batches->count() }} Batch(es)
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3.5 text-left">Batch No</th>
                                <th class="px-5 py-3.5 text-left">Expiry Date</th>
                                <th class="px-5 py-3.5 text-center">Status</th>
                                <th class="px-5 py-3.5 text-right">Qty</th>
                                <th class="px-5 py-3.5 text-right">Purchase Price</th>
                                <th class="px-5 py-3.5 text-right">Sale Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($medicine->batches as $batch)
                                @php
                                    $expDate = \Carbon\Carbon::parse($batch->expiry_date);
                                    $isExpired = $expDate->isPast();
                                    $isNearExpiry = !$isExpired && $expDate->diffInDays(now()) <= 90;
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-5 py-4 font-mono font-bold text-slate-700">
                                        {{ $batch->batch_no }}
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-slate-800">
                                        {{ $expDate->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($isExpired)
                                            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-700">
                                                🔴 Expired ({{ abs((int)$expDate->diffInDays(now())) }}d ago)
                                            </span>
                                        @elseif($isNearExpiry)
                                            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800">
                                                🟡 Near Expiry ({{ (int)$expDate->diffInDays(now()) }}d left)
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-700">
                                                🟢 Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right font-black text-slate-800">
                                        {{ number_format($batch->quantity) }}
                                    </td>
                                    <td class="px-5 py-4 text-right text-slate-600">
                                        ৳{{ number_format($batch->purchase_price, 2) }}
                                    </td>
                                    <td class="px-5 py-4 text-right font-bold text-teal-600">
                                        ৳{{ number_format($batch->sale_price, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-sm">
                                        No batches registered for this medicine.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Product Overview (Right Column) -->
        <div class="space-y-6">

            <!-- Product Image & Meta -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xs space-y-5">
                <div class="text-center">
                    @if($medicine->image)
                        <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="w-32 h-32 object-cover mx-auto rounded-2xl border border-slate-100 shadow-sm mb-3">
                    @else
                        <div class="w-32 h-32 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-4xl mb-3">
                            <i class="fas fa-pills"></i>
                        </div>
                    @endif
                    <h4 class="font-bold text-slate-800 text-lg">{{ $medicine->name }}</h4>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $medicine->generic->name ?? 'General Medicine' }}</p>
                </div>

                <div class="divide-y divide-slate-100 text-sm">
                    <div class="py-3 flex items-center justify-between gap-4">
                        <span class="text-slate-400 flex-shrink-0">Barcode</span>
                        <span class="font-mono font-bold text-slate-700 text-right">{{ $medicine->barcode ?? 'N/A' }}</span>
                    </div>
                    <div class="py-3 flex items-center justify-between gap-4">
                        <span class="text-slate-400 flex-shrink-0">SKU</span>
                        <span class="font-mono font-bold text-slate-700 text-right">{{ $medicine->sku ?? 'N/A' }}</span>
                    </div>
                    <div class="py-3 flex items-start justify-between gap-4">
                        <span class="text-slate-400 flex-shrink-0">Category</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $medicine->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <div class="py-3 flex items-start justify-between gap-4">
                        <span class="text-slate-400 flex-shrink-0">Manufacturer</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $medicine->manufacturer->company_name ?? $medicine->manufacturer->name ?? 'N/A' }}</span>
                    </div>
                    @php
                        $unitDisplay = 'Pcs';
                        if (!empty($medicine->unit)) {
                            if (is_object($medicine->unit)) {
                                $unitDisplay = $medicine->unit->name ?? $medicine->unit->symbol ?? 'Pcs';
                            } elseif (is_string($medicine->unit)) {
                                $decoded = json_decode($medicine->unit, true);
                                if (is_array($decoded) && isset($decoded['name'])) {
                                    $unitDisplay = $decoded['name'];
                                } elseif (is_array($decoded) && isset($decoded['NAME'])) {
                                    $unitDisplay = $decoded['NAME'];
                                } else {
                                    $unitDisplay = $medicine->unit;
                                }
                            }
                        }
                    @endphp
                    <div class="py-3 flex items-center justify-between gap-4">
                        <span class="text-slate-400 flex-shrink-0">Unit Type</span>
                        <span class="font-semibold text-slate-800 text-right">{{ strtoupper($unitDisplay) }}</span>
                    </div>
                    <div class="py-3 flex items-start justify-between gap-4">
                        <span class="text-slate-400 flex-shrink-0">Prescription Required</span>
                        <span class="font-bold text-right {{ $medicine->prescription_required ? 'text-rose-600' : 'text-emerald-600' }}">
                            {{ $medicine->prescription_required ? 'Yes (Rx Required)' : 'No (Over the Counter)' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Action Links -->
            <div class="bg-slate-900 p-6 rounded-3xl text-white space-y-4 shadow-xl">
                <h4 class="font-bold text-sm text-slate-300 uppercase tracking-wider">Quick Management Actions</h4>
                <div class="space-y-2.5">
                    @can('edit medicines')
                    <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="w-full px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs flex items-center justify-between transition">
                        <span><i class="fas fa-pen-to-square mr-2 text-amber-400"></i> Edit Medicine Details</span>
                        <i class="fas fa-chevron-right text-[10px] text-slate-500"></i>
                    </a>
                    @endcan
                    <a href="{{ route('admin.purchases.create', ['product_id' => $medicine->id]) }}" class="w-full px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs flex items-center justify-between transition">
                        <span><i class="fas fa-cart-flatbed mr-2 text-teal-400"></i> Add Stock via Purchase</span>
                        <i class="fas fa-chevron-right text-[10px] text-slate-500"></i>
                    </a>
                    <a href="{{ route('admin.stock.low') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs flex items-center justify-between transition">
                        <span><i class="fas fa-triangle-exclamation mr-2 text-amber-400"></i> View All Low Stock Alerts</span>
                        <i class="fas fa-chevron-right text-[10px] text-slate-500"></i>
                    </a>
                    <a href="{{ route('admin.stock.expiry') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs flex items-center justify-between transition">
                        <span><i class="fas fa-calendar-xmark mr-2 text-rose-400"></i> View All Expiry Alerts</span>
                        <i class="fas fa-chevron-right text-[10px] text-slate-500"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
