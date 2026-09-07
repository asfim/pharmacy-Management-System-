@extends('admin.layouts.app')
@php $header = 'Add Batch'; @endphp
@section('content')
<div class="mb-6 flex justify-between items-center">
    <div><h2 class="text-2xl font-bold text-slate-800">Add Batch</h2></div>
    <a href="{{ route('admin.batches.index') }}" class="text-slate-500 hover:text-slate-700 font-medium py-2 px-4 rounded-lg flex items-center transition border border-slate-300 bg-white shadow-sm">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>Back
    </a>
</div>
<div class="bg-white rounded-xl border border-slate-200 shadow-sm max-w-2xl">
    <form action="{{ route('admin.batches.store') }}" method="POST" class="p-6 sm:p-8 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Medicine *</label>
            {{-- Hidden input that actually gets submitted --}}
            <input type="hidden" name="product_id" id="product_id" value="{{ old('product_id') }}" required>

            {{-- Search box --}}
            <div class="relative">
                <input type="text"
                       id="medicineSearch"
                       placeholder="Type to search medicine..."
                       autocomplete="off"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('product_id') border-red-500 @enderror"
                       value="{{ old('product_id') ? optional($medicines->firstWhere('id', old('product_id')))->name : '' }}">

                {{-- Spinner --}}
                <svg id="medicineSpinner" class="w-4 h-4 text-teal-500 absolute right-3 top-2.5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>

                {{-- Dropdown results --}}
                <ul id="medicineDropdown"
                    class="hidden absolute z-50 w-full bg-white border border-slate-200 rounded-lg shadow-lg mt-1 max-h-56 overflow-y-auto text-sm">
                </ul>
            </div>

            @error('product_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Batch Number *</label>
                <input type="text" name="batch_no" value="{{ old('batch_no') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('batch_no') border-red-500 @enderror">
                @error('batch_no')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Quantity *</label>
                <input type="number" name="quantity" value="{{ old('quantity', 0) }}" min="0" required class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 @error('quantity') border-red-500 @enderror">
                @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Manufacturing Date</label>
                <input type="date" name="manufacturing_date" value="{{ old('manufacturing_date') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Purchase Price *</label>
                <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                <input type="number" name="purchase_price" value="{{ old('purchase_price', 0) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Sale Price *</label>
                <div class="relative"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">৳</span>
                <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" step="0.01" min="0" required class="w-full pl-8 px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500"></div>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 px-6 rounded-lg transition shadow-sm">Save Batch</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// All medicines passed from controller — search client-side (no extra AJAX needed)
const allMedicines = @json($medicines->map(fn($m) => ['id' => $m->id, 'name' => $m->name]));

const searchInput  = document.getElementById('medicineSearch');
const hiddenInput  = document.getElementById('product_id');
const dropdown     = document.getElementById('medicineDropdown');
const spinner      = document.getElementById('medicineSpinner');

function renderDropdown(results) {
    dropdown.innerHTML = '';
    if (!results.length) {
        dropdown.innerHTML = '<li class="px-4 py-2 text-slate-400 text-sm">No medicines found.</li>';
        dropdown.classList.remove('hidden');
        return;
    }
    results.forEach(m => {
        const li = document.createElement('li');
        li.className = 'px-4 py-2 cursor-pointer hover:bg-teal-50 hover:text-teal-700 text-slate-700 transition';
        li.textContent = m.name;
        li.addEventListener('mousedown', () => {
            hiddenInput.value = m.id;
            searchInput.value = m.name;
            dropdown.classList.add('hidden');
            searchInput.classList.remove('border-red-400');
            searchInput.classList.add('border-teal-400');
        });
        dropdown.appendChild(li);
    });
    dropdown.classList.remove('hidden');
}

let timer;
searchInput.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    hiddenInput.value = ''; // clear selection when typing
    searchInput.classList.remove('border-teal-400');

    if (!q) { dropdown.classList.add('hidden'); return; }

    clearTimeout(timer);
    spinner.classList.remove('hidden');
    timer = setTimeout(() => {
        const results = allMedicines.filter(m => m.name.toLowerCase().includes(q));
        spinner.classList.add('hidden');
        renderDropdown(results);
    }, 150);
});

// Hide dropdown on outside click
document.addEventListener('click', function (e) {
    if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
        // If user typed but didn't select — clear search field
        if (!hiddenInput.value) searchInput.value = '';
    }
});

// Reopen dropdown on focus if text present
searchInput.addEventListener('focus', function () {
    if (this.value.trim() && !hiddenInput.value) {
        const q = this.value.trim().toLowerCase();
        renderDropdown(allMedicines.filter(m => m.name.toLowerCase().includes(q)));
    }
});

// Prevent form submit if no medicine selected
document.querySelector('form').addEventListener('submit', function (e) {
    if (!hiddenInput.value) {
        e.preventDefault();
        searchInput.classList.add('border-red-400', 'ring-1', 'ring-red-400');
        searchInput.focus();
        searchInput.placeholder = 'Please select a medicine!';
    }
});
</script>
@endpush
