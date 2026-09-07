@extends('admin.layouts.app')
@php $header = 'Add Medicine'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div><h2 class="text-2xl font-bold text-slate-800">Add Medicine</h2><p class="text-sm text-slate-500">Add a new medicine to your pharmacy</p></div>
    <a href="{{ route('admin.medicines.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 rounded-lg flex items-center transition border border-slate-300 bg-white shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back
    </a>
</div>

@include('admin.layouts.alerts')

<form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left: Main Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Basic Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Medicine Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Generic</label>
                    <select name="generic_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Generic --</option>
                        @foreach($generics as $g)<option value="{{ $g->id }}" {{ old('generic_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Manufacturer</label>
                    <select name="manufacturer_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Manufacturer --</option>
                        @foreach($manufacturers as $m)<option value="{{ $m->id }}" {{ old('manufacturer_id') == $m->id ? 'selected' : '' }}>{{ $m->company_name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                    <select name="category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Product Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Medicine Type</label>
                    <select name="medicine_type" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Type --</option>
                        @foreach($medicineTypes as $type)<option value="{{ $type }}" {{ old('medicine_type') == $type ? 'selected' : '' }}>{{ $type }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Strength</label>
                    <input type="text" name="strength" value="{{ old('strength') }}" placeholder="e.g. 500mg" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Dosage Form</label>
                    <input type="text" name="dosage_form" value="{{ old('dosage_form') }}" placeholder="e.g. Oral" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pack Size</label>
                    <input type="text" name="pack_size" value="{{ old('pack_size') }}" placeholder="e.g. 10 Tablets" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('sku') border-red-500 @enderror">
                    @error('sku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Barcode</label>
                    <input type="text" name="barcode" value="{{ old('barcode') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('barcode') border-red-500 @enderror">
                    @error('barcode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Unit</label>
                    <select name="unit_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="">-- Select Unit --</option>
                        @foreach($units as $u)<option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>@endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Pricing</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Price *</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="purchase_price" value="{{ old('purchase_price', 0) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('purchase_price') border-red-500 @enderror"></div>
                    @error('purchase_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Sale Price *</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('sale_price') border-red-500 @enderror"></div>
                    @error('sale_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Wholesale Price</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="wholesale_price" value="{{ old('wholesale_price', 0) }}" step="0.01" min="0" class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">MRP</label>
                    <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                    <input type="number" name="mrp" value="{{ old('mrp', 0) }}" step="0.01" min="0" class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">VAT / Tax (%)</label>
                    <input type="number" name="tax" value="{{ old('tax', 0) }}" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Discount (%)</label>
                    <input type="number" name="discount" value="{{ old('discount', 0) }}" step="0.01" min="0" max="100" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Description & Usage</h3>
            <textarea name="description" rows="5" placeholder="Usage instructions, dosage information, side effects..." class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">{{ old('description') }}</textarea>
        </div>
    </div>

    <!-- Right: Settings -->
    <div class="space-y-6">
        <!-- Status & Settings -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Settings</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="active" {{ old('status','active')==='active'?'selected':'' }}>Active</option>
                        <option value="inactive" {{ old('status')==='inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Minimum Stock</label>
                    <input type="number" name="min_stock" value="{{ old('min_stock', 10) }}" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Reorder Level</label>
                    <input type="number" name="reorder_level" value="{{ old('reorder_level', 20) }}" min="0" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="flex items-center space-x-3 pt-2">
                    <input type="checkbox" name="prescription_required" id="prescription_required" value="1" {{ old('prescription_required') ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <label for="prescription_required" class="text-sm font-medium text-slate-700">Prescription Required (Rx)</label>
                </div>
            </div>
        </div>

        <!-- Image -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100">Product Image</h3>
            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 text-center hover:border-teal-400 transition">
                <svg class="mx-auto w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="text-sm text-slate-500 mb-3">Click to upload product image</p>
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
            @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-xl transition shadow-sm text-sm">
            Save Medicine
        </button>
    </div>
</div>
</form>
@endsection
