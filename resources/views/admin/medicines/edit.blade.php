@extends('admin.layouts.app')
@php $header = 'Edit Medicine'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div><h2 class="text-2xl font-bold text-slate-800">Edit: {{ $medicine->name }}</h2></div>
    <a href="{{ route('admin.medicines.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 rounded-lg flex items-center transition border border-slate-300 bg-white shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back
    </a>
</div>

<form action="{{ route('admin.medicines.update', $medicine) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Basic Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Medicine Name *</label>
                    <input type="text" name="name" value="{{ old('name', $medicine->name) }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Generic</label>
                    <select name="generic_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Generic --</option>
                        @foreach($generics as $g)<option value="{{ $g->id }}" {{ old('generic_id', $medicine->generic_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Manufacturer</label>
                    <select name="manufacturer_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Manufacturer --</option>
                        @foreach($manufacturers as $m)<option value="{{ $m->id }}" {{ old('manufacturer_id', $medicine->manufacturer_id) == $m->id ? 'selected' : '' }}>{{ $m->company_name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id', $medicine->category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Product Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Medicine Type</label>
                    <select name="medicine_type" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Type --</option>
                        @foreach($medicineTypes as $type)<option value="{{ $type }}" {{ old('medicine_type', $medicine->medicine_type) == $type ? 'selected' : '' }}>{{ $type }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Strength</label>
                    <input type="text" name="strength" value="{{ old('strength', $medicine->strength) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Dosage Form</label>
                    <input type="text" name="dosage_form" value="{{ old('dosage_form', $medicine->dosage_form) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pack Size</label>
                    <input type="text" name="pack_size" value="{{ old('pack_size', $medicine->pack_size) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $medicine->sku) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Barcode</label>
                    <input type="text" name="barcode" value="{{ old('barcode', $medicine->barcode) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Pricing</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Price *</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price', $medicine->purchase_price) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sale Price *</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $medicine->sale_price) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Wholesale Price</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="wholesale_price" value="{{ old('wholesale_price', $medicine->wholesale_price) }}" step="0.01" min="0" class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">MRP</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="mrp" value="{{ old('mrp', $medicine->mrp) }}" step="0.01" min="0" class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">VAT / Tax (%)</label>
                    <input type="number" name="tax" value="{{ old('tax', $medicine->tax) }}" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Discount (%)</label>
                    <input type="number" name="discount" value="{{ old('discount', $medicine->discount) }}" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Description & Usage</h3>
            <textarea name="description" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">{{ old('description', $medicine->description) }}</textarea>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Settings</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="active" {{ old('status',$medicine->status)==='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ old('status',$medicine->status)==='inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Minimum Stock</label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', $medicine->min_stock) }}" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Reorder Level</label>
                    <input type="number" name="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level) }}" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="flex items-center space-x-3 pt-2">
                    <input type="checkbox" name="prescription_required" id="prescription_required" value="1" {{ old('prescription_required', $medicine->prescription_required) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <label for="prescription_required" class="text-sm font-medium text-slate-700">Prescription Required (Rx)</label>
                </div>
            </div>
        </div>

        <!-- Batches, Expiry Date & Branch Stock Card -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
            @php
                $selectedBranchId = session('selected_branch_id');
                $userBranchId     = auth()->user()->branch_id ?? null;
                $activeBranchId   = (!empty($userBranchId) && !auth()->user()->hasRole('Super Admin'))
                    ? $userBranchId
                    : (($selectedBranchId && $selectedBranchId !== 'all') ? $selectedBranchId : null);

                $activeBranchName = $activeBranchId
                    ? (\App\Models\Branch::where('id', $activeBranchId)->value('name') ?? 'Active Branch')
                    : 'All Branches';
            @endphp
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 gap-2">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-xs">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 tracking-tight">Batches & Branch Stock</h3>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200/80 rounded-full text-xs font-semibold whitespace-nowrap shadow-2xs">
                    <i class="fas fa-store text-[10px]"></i>
                    <span class="truncate max-w-[140px]">{{ $activeBranchName }}</span>
                </span>
            </div>

            @if($medicine->batches->count() > 0)
                <div class="space-y-3">
                    @foreach($medicine->batches as $b)
                        @php
                            $stockQuery = \App\Models\StockBalance::withoutGlobalScopes()
                                ->where('batch_id', $b->id);
                            if ($activeBranchId) {
                                $stockQuery->where('branch_id', $activeBranchId);
                            }
                            $branchStock = $stockQuery->sum('qty_on_hand');
                        @endphp
                        <div class="p-3.5 bg-slate-50/70 hover:bg-slate-50 border border-slate-200/80 hover:border-teal-300 rounded-xl transition-all duration-150 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Batch:</span>
                                    <span class="font-mono text-xs font-bold text-slate-800 bg-white px-2 py-0.5 border border-slate-200 rounded-md shadow-2xs">
                                        {{ $b->batch_no }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $branchStock > 10 ? 'bg-emerald-100 text-emerald-800' : ($branchStock > 0 ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                    <i class="fas fa-cubes text-[10px]"></i> {{ number_format($branchStock) }} Pcs
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-1">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">
                                        <i class="far fa-calendar-alt text-teal-600 mr-1"></i> Expiry Date
                                    </label>
                                    <input type="date" 
                                           name="batches[{{ $b->id }}][expiry_date]" 
                                           value="{{ $b->expiry_date ? \Carbon\Carbon::parse($b->expiry_date)->format('Y-m-d') : '' }}" 
                                           class="w-full px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 font-medium">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">
                                        <i class="fas fa-layer-group text-teal-600 mr-1"></i> Stock (Pcs)
                                    </label>
                                    <div class="relative">
                                        <input type="number" 
                                               name="batches[{{ $b->id }}][branch_qty]" 
                                               value="{{ $branchStock }}" 
                                               min="0" 
                                               class="w-full pl-2.5 pr-8 py-1.5 border border-slate-300 rounded-lg text-xs text-right font-bold text-slate-800 bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                        <span class="absolute right-2.5 top-1.5 text-[11px] font-semibold text-slate-400">Pcs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                    <p class="text-xs font-semibold text-slate-600">No batches exist. Add initial batch for <strong>{{ $activeBranchName }}</strong>:</p>
                    <div class="space-y-2.5">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Batch Number</label>
                            <input type="text" name="new_batch_no" placeholder="Auto-generated if empty" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs font-mono bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Expiry Date</label>
                            <input type="date" name="new_expiry_date" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Initial Stock (Pcs)</label>
                            <div class="relative">
                                <input type="number" name="new_branch_qty" value="0" min="0" class="w-full pl-3 pr-8 py-1.5 border border-slate-300 rounded-lg text-xs text-right font-bold bg-white">
                                <span class="absolute right-2.5 top-1.5 text-[11px] font-semibold text-slate-400">Pcs</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Product Image</h3>
            @php
                $imgUrl = $medicine->product_images->first()->image_url ?? $medicine->image ?? null;
                if ($imgUrl && !str_starts_with($imgUrl, 'http')) {
                    $imgUrl = asset('storage/' . $imgUrl);
                }
            @endphp
            @if($imgUrl)
                <div class="mb-4">
                    <p class="text-xs font-medium text-slate-500 mb-1.5">Current Medicine Image:</p>
                    <img src="{{ $imgUrl }}" 
                         alt="{{ $medicine->name }}" 
                         onclick="openImagePreview('{{ $imgUrl }}', '{{ addslashes($medicine->name) }}')"
                         title="Click to view large image"
                         class="h-28 w-28 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer hover:scale-105 hover:ring-2 hover:ring-teal-500 transition-all duration-150">
                </div>
            @endif
            <label class="block text-sm font-medium text-slate-700 mb-1">Upload New Image</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-xl transition shadow-sm text-sm">Update Medicine</button>
    </div>
</div>
</form>
@endsection
