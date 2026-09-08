@extends('admin.layouts.app')
@php $header = 'New Purchase'; @endphp

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Tailwind styling for Select2 */
    .select2-container .select2-selection--single {
        min-height: 42px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155 !important;
        font-size: 0.875rem !important;
        line-height: normal !important;
        padding-left: 0.75rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 8px !important;
        display: flex;
        align-items: center;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.5rem !important;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        z-index: 9999;
    }
    .select2-search__field {
        border-radius: 0.375rem !important;
        border: 1px solid #cbd5e1 !important;
        padding: 4px 8px !important;
    }
</style>
@endpush

@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">New Purchase</h2><p class="text-sm text-slate-500">Record a new medicine purchase from supplier</p></div>
    <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<form id="purchaseForm" action="{{ route('admin.purchases.store') }}" method="POST">
@csrf
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Main -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Header Info -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Purchase Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Supplier *</label>
                    <select name="supplier_id" id="supplierSelect" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Select Supplier --</option>
                        @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Invoice No *</label>
                    <input type="text" name="invoice_no" value="{{ old('invoice_no', 'PO-'.date('Ymd').'-'.rand(100,999)) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Purchase Date *</label>
                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-slate-800">Medicine Items</h3>
                <button type="button" id="addRow" class="inline-flex items-center gap-2 bg-teal-50 hover:bg-teal-100 text-teal-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
                    <i class="fas fa-plus"></i> Add Row
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="itemsTable">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase">
                        <tr>
                            <th class="px-3 py-2.5 text-left min-w-[160px]">Medicine</th>
                            <th class="px-3 py-2.5 text-left min-w-[100px]">Batch No</th>
                            <th class="px-3 py-2.5 text-left min-w-[110px]">Expiry</th>
                            <th class="px-3 py-2.5 text-right min-w-[60px]">Qty</th>
                            <th class="px-3 py-2.5 text-right min-w-[60px]">Free</th>
                            <th class="px-3 py-2.5 text-right min-w-[80px]">Buy Price</th>
                            <th class="px-3 py-2.5 text-right min-w-[80px]">Sale Price</th>
                            <th class="px-3 py-2.5 text-right min-w-[80px]">Total</th>
                            <th class="px-3 py-2.5 text-center w-8"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr class="item-row border-b border-slate-100">
                            <td class="px-2 py-2">
                                <select name="items[0][product_id]" class="medicine-select w-full px-2 py-2 border border-slate-200 rounded-lg text-sm" required>
                                    <option value="">Select</option>
                                </select>
                            </td>
                            <td class="px-2 py-2"><input type="text" name="items[0][batch_no]" required placeholder="Batch" class="w-full px-2 py-2 border border-slate-200 rounded-lg text-sm"></td>
                            <td class="px-2 py-2"><input type="date" name="items[0][expiry_date]" class="w-full px-2 py-2 border border-slate-200 rounded-lg text-sm"></td>
                            <td class="px-2 py-2"><input type="number" name="items[0][quantity]" value="1" min="1" class="w-full px-2 py-2 border border-slate-200 rounded-lg text-sm text-right qty-input" required></td>
                            <td class="px-2 py-2"><input type="number" name="items[0][free_quantity]" value="0" min="0" class="w-full px-2 py-2 border border-slate-200 rounded-lg text-sm text-right"></td>
                            <td class="px-2 py-2"><input type="number" name="items[0][purchase_price]" value="0" min="0" step="0.01" class="w-full px-2 py-2 border border-slate-200 rounded-lg text-sm text-right price-input" required></td>
                            <td class="px-2 py-2"><input type="number" name="items[0][sale_price]" value="0" min="0" step="0.01" class="w-full px-2 py-2 border border-slate-200 rounded-lg text-sm text-right" required></td>
                            <td class="px-2 py-2 text-right"><span class="row-total font-semibold text-slate-700">0.00</span></td>
                            <td class="px-2 py-2 text-center"><button type="button" class="remove-row text-red-400 hover:text-red-600 p-1"><i class="fas fa-times"></i></button></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="px-3 py-3 text-right font-semibold text-slate-700">Subtotal:</td>
                            <td class="px-3 py-3 text-right font-bold text-slate-800" id="subtotalDisplay">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Right: Summary -->
    <div class="space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
            <h3 class="font-semibold text-slate-800">Payment Summary</h3>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Discount (৳)</label>
                <input type="number" name="discount" id="discount" value="0" min="0" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">VAT / Tax (৳)</label>
                <input type="number" name="tax" id="tax" value="0" min="0" step="0.01" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
            </div>

            <div class="bg-slate-50 rounded-xl p-4 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-slate-600">Subtotal</span><span class="font-semibold" id="subtotal">৳0.00</span></div>
                <div class="flex justify-between"><span class="text-slate-600">Discount</span><span class="font-semibold text-red-500">-৳<span id="discountShow">0.00</span></span></div>
                <div class="flex justify-between"><span class="text-slate-600">VAT/Tax</span><span class="font-semibold">+৳<span id="taxShow">0.00</span></span></div>
                <div class="flex justify-between border-t border-slate-200 pt-2"><span class="font-bold text-slate-800">Total</span><span class="font-bold text-lg text-teal-600">৳<span id="total">0.00</span></span></div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Paid Amount *</label>
                <input type="number" name="paid" id="paid" value="0" min="0" step="0.01" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
            </div>
            <div class="bg-red-50 rounded-xl p-3 text-sm flex justify-between">
                <span class="text-red-600 font-medium">Due:</span>
                <span class="font-bold text-red-700">৳<span id="due">0.00</span></span>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Payment Method</label>
                <select name="payment_method" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm">
                    <option value="cash">Cash</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="due">Due/Credit</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Note</label>
                <textarea name="note" rows="2" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm"></textarea>
            </div>

            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-3 rounded-xl transition shadow-sm">
                <i class="fas fa-save mr-2"></i> Save Purchase
            </button>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#supplierSelect').select2({
        placeholder: "Select Supplier",
        allowClear: true
    });
    initMedicineSelect2('.medicine-select');
});

function initMedicineSelect2(selector) {
    $(selector).select2({
        placeholder: "Select Medicine",
        allowClear: true,
        ajax: {
            url: '{{ route("admin.ajax.medicines-search") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return { results: data.results };
            },
            cache: true
        }
    }).on('select2:select', function (e) {
        const data = e.params.data;
        const row = $(this).closest('.item-row')[0];
        if (data.price !== undefined) row.querySelector('.price-input').value = data.price;
        if (data.sale !== undefined) row.querySelectorAll('input[type=number]')[3].value = data.sale;
        updateRowTotal(row);
    });
}

let rowIndex = 1;

function updateRowTotal(row) {
    const qty   = parseFloat(row.querySelector('.qty-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const total = qty * price;
    row.querySelector('.row-total').textContent = total.toFixed(2);
    updateSummary();
}

function updateSummary() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(r => {
        const qty   = parseFloat(r.querySelector('.qty-input').value) || 0;
        const price = parseFloat(r.querySelector('.price-input').value) || 0;
        subtotal += qty * price;
    });
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax      = parseFloat(document.getElementById('tax').value) || 0;
    const total    = subtotal - discount + tax;
    const paid     = parseFloat(document.getElementById('paid').value) || 0;
    const due      = total - paid;

    document.getElementById('subtotal').textContent = '৳' + subtotal.toFixed(2);
    document.getElementById('subtotalDisplay').textContent = subtotal.toFixed(2);
    document.getElementById('discountShow').textContent = discount.toFixed(2);
    document.getElementById('taxShow').textContent = tax.toFixed(2);
    document.getElementById('total').textContent = total.toFixed(2);
    document.getElementById('due').textContent = due.toFixed(2);
}

// Add row
document.getElementById('addRow').addEventListener('click', () => {
    // Destroy select2 on the original before cloning to avoid duplicating select2 DOM elements
    $('.medicine-select').select2('destroy');
    
    const template = document.querySelector('.item-row').cloneNode(true);
    template.querySelectorAll('input').forEach(i => { i.name = i.name.replace(/\[\d+\]/, `[${rowIndex}]`); if(i.type !== 'date') i.value = i.type === 'number' ? 0 : ''; });
    template.querySelector('select').name = template.querySelector('select').name.replace(/\[\d+\]/, `[${rowIndex}]`);
    template.querySelector('select').innerHTML = '<option value="">Select</option>';
    template.querySelector('.row-total').textContent = '0.00';
    template.querySelector('.remove-row').addEventListener('click', function() { this.closest('.item-row').remove(); updateSummary(); });
    
    document.getElementById('itemsBody').appendChild(template);
    
    // Re-initialize select2 on all medicine selects with AJAX
    initMedicineSelect2('.medicine-select');

    addRowListeners(template);
    rowIndex++;
});

function addRowListeners(row) {
    row.querySelector('.qty-input').addEventListener('input', () => updateRowTotal(row));
    row.querySelector('.price-input').addEventListener('input', () => updateRowTotal(row));
}

// Remove row
document.querySelectorAll('.remove-row').forEach(btn => {
    btn.addEventListener('click', function() { this.closest('.item-row').remove(); updateSummary(); });
});

// Summary listeners
['discount','tax','paid'].forEach(id => document.getElementById(id).addEventListener('input', updateSummary));

addRowListeners(document.querySelector('.item-row'));
updateSummary();
</script>
@endpush
