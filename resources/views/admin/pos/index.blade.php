@extends('admin.layouts.app')
@php $header = 'POS System'; @endphp

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Tailwind styling for Select2 */
    .select2-container .select2-selection--single {
        height: 46px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.75rem !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #334155 !important;
        font-size: 0.875rem !important;
        line-height: normal !important;
        padding-left: 1rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1 !important;
        border-radius: 0.75rem !important;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }
    .select2-search__field {
        border-radius: 0.5rem !important;
        border: 1px solid #cbd5e1 !important;
    }
</style>
@endpush

@section('content')
<div class="flex gap-5 h-[calc(100vh-9rem)]">

    <!-- ========== LEFT: Search & Products ========== -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Search Bar -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
            <div class="flex gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="medicineSearch" placeholder="Search by name, barcode, SKU..." autocomplete="off"
                        class="w-full pl-11 pr-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="flex gap-1">
                    <select id="customerSelect" class="px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 min-w-[180px]">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="document.getElementById('customerModal').classList.remove('hidden')" class="px-3 py-3 bg-teal-100 hover:bg-teal-200 text-teal-700 rounded-xl transition flex items-center justify-center" title="Add Customer">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <!-- Search Results Dropdown -->
            <div id="searchResults" class="hidden mt-2 bg-white border border-slate-200 rounded-xl shadow-lg max-h-64 overflow-y-auto z-50"></div>
        </div>

        <!-- Cart Table -->
        <div class="flex-1 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-shopping-cart text-teal-600"></i> Cart
                    <span id="cartCount" class="ml-1 bg-teal-100 text-teal-700 text-xs font-bold px-2 py-0.5 rounded-full">0</span>
                </h3>
                <button onclick="clearCart()" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                    <i class="fas fa-trash"></i> Clear All
                </button>
            </div>
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-xs text-slate-500 uppercase sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left">Medicine</th>
                            <th class="px-4 py-3 text-left">Batch</th>
                            <th class="px-4 py-3 text-right">Price</th>
                            <th class="px-4 py-3 text-center">Qty</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-center w-8"></th>
                        </tr>
                    </thead>
                    <tbody id="cartBody">
                        <tr id="emptyCart">
                            <td colspan="6" class="px-4 py-16 text-center text-slate-400">
                                <i class="fas fa-shopping-basket text-4xl text-slate-200 mb-3 block"></i>
                                Search and add medicines to the cart
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ========== RIGHT: Payment Panel ========== -->
    <div class="w-80 flex-shrink-0 flex flex-col gap-4">

        <!-- Summary -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
            <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2">Payment Summary</h3>

            <div class="flex justify-between text-sm"><span class="text-slate-600">Subtotal</span><span class="font-semibold" id="posSubtotal">৳0.00</span></div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600">Discount (৳)</span>
                <input type="number" id="posDiscount" placeholder="0.00" min="0" step="0.01" class="w-24 px-2 py-1 border border-slate-200 rounded-lg text-right text-sm">
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-600">VAT/Tax (৳)</span>
                <input type="number" id="posTax" placeholder="0.00" min="0" step="0.01" class="w-24 px-2 py-1 border border-slate-200 rounded-lg text-right text-sm">
            </div>
            <div class="flex justify-between font-bold text-lg border-t border-slate-100 pt-3">
                <span class="text-slate-800">Total</span>
                <span class="text-teal-600" id="posTotal">৳0.00</span>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
            <h3 class="font-semibold text-slate-800">Payment Method</h3>
            <div class="grid grid-cols-3 gap-2" id="paymentMethods">
                @foreach(['Cash','bKash','Nagad','Rocket','Card','Due'] as $method)
                <button type="button" onclick="selectPayment('{{ strtolower($method) }}')"
                    class="payment-btn py-2.5 px-2 border-2 border-slate-200 rounded-xl text-xs font-semibold text-slate-600 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 transition"
                    data-method="{{ strtolower($method) }}">
                    {{ $method }}
                </button>
                @endforeach
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Paid Amount</label>
                <input type="number" id="posPaid" placeholder="0.00" value="0" min="0" step="0.01" readonly class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm text-right font-bold text-lg bg-slate-50 cursor-not-allowed text-slate-500">
            </div>
            <div class="flex justify-between text-sm bg-slate-50 rounded-xl p-3">
                <span class="font-semibold text-slate-600">Change / Due:</span>
                <span class="font-bold" id="posChange">৳0.00</span>
            </div>
        </div>

        <!-- Note -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Note</label>
            <textarea id="posNote" rows="2" placeholder="Optional note..." class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm"></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2">
            <button onclick="submitSale()" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-4 rounded-2xl transition shadow-sm flex items-center justify-center gap-2">
                <i class="fas fa-check-circle text-lg"></i> Complete Sale
            </button>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="holdBill()" class="py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold text-xs rounded-xl transition border border-amber-200">
                    <i class="fas fa-pause mr-1"></i> Hold
                </button>
                <button onclick="clearCart()" class="py-2.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs rounded-xl transition border border-red-200">
                    <i class="fas fa-times mr-1"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 text-center shadow-2xl">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Sale Completed!</h3>
        <p class="text-slate-500 text-sm mb-6" id="saleModalMsg">Sale recorded successfully.</p>
        <div class="flex gap-3">
            <a id="printInvoiceBtn" href="#" target="_blank" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm py-2.5 rounded-xl transition">
                <i class="fas fa-print mr-1"></i> Print Invoice
            </a>
            <button onclick="newSale()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm py-2.5 rounded-xl transition">
                New Sale
            </button>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div id="customerModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-slate-800">New Customer</h3>
            <button onclick="document.getElementById('customerModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
        </div>
        <form id="addCustomerForm" onsubmit="event.preventDefault(); saveCustomer();" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" id="custName" required class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Phone <span class="text-red-500">*</span></label>
                <input type="text" id="custPhone" required class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Address</label>
                <input type="text" id="custAddress" class="w-full px-3 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 rounded-xl transition">Save Customer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#customerSelect').select2({
        placeholder: "Select Customer",
        allowClear: false
    });
});

let cart = [];
let selectedPayment = 'cash';

// Search
let searchTimeout;
document.getElementById('medicineSearch').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const q = this.value.trim();
    if (q.length < 2) { document.getElementById('searchResults').classList.add('hidden'); return; }
    searchTimeout = setTimeout(() => {
        fetch(`{{ route('admin.pos.search') }}?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                const div = document.getElementById('searchResults');
                div.innerHTML = '';
                if (!data.length) { div.innerHTML = '<p class="p-4 text-slate-400 text-sm">No medicines found</p>'; }
                data.forEach(m => {
                    const batch = m.batches[0] ?? null;
                    if (!batch) return;
                    const el = document.createElement('div');
                    el.className = 'flex items-center justify-between px-4 py-3 hover:bg-teal-50 cursor-pointer border-b border-slate-50 transition';
                    el.innerHTML = `
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">${m.name}</p>
                            <p class="text-xs text-slate-400">Batch: ${batch.batch_no} | Qty: ${batch.quantity} | Exp: ${batch.expiry_date ?? 'N/A'}</p>
                        </div>
                        <span class="font-bold text-teal-700 text-sm">৳${parseFloat(batch.sale_price).toFixed(2)}</span>
                    `;
                    el.addEventListener('click', () => addToCart(m, batch));
                    div.appendChild(el);
                });
                div.classList.remove('hidden');
            });
    }, 300);
});

document.addEventListener('click', e => {
    if (!e.target.closest('#medicineSearch') && !e.target.closest('#searchResults')) {
        document.getElementById('searchResults').classList.add('hidden');
    }
});

function addToCart(medicine, batch) {
    const existing = cart.find(i => i.product_id === medicine.id && i.batch_id === batch.id);
    if (existing) {
        if (existing.qty < batch.quantity) { existing.qty++; }
    } else {
        cart.push({ product_id: medicine.id, batch_id: batch.id, name: medicine.name, batch_no: batch.batch_no, price: parseFloat(batch.sale_price), qty: 1, max: batch.quantity });
    }
    document.getElementById('medicineSearch').value = '';
    document.getElementById('searchResults').classList.add('hidden');
    renderCart();
}

function renderCart() {
    const tbody = document.getElementById('cartBody');
    if (!cart.length) {
        tbody.innerHTML = `<tr id="emptyCart"><td colspan="6" class="px-4 py-16 text-center text-slate-400"><i class="fas fa-shopping-basket text-4xl text-slate-200 mb-3 block"></i>Search and add medicines to the cart</td></tr>`;
        updateSummary();
        return;
    }
    tbody.innerHTML = cart.map((item, i) => `
        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
            <td class="px-4 py-3">
                <p class="font-semibold text-slate-800 text-sm">${item.name}</p>
            </td>
            <td class="px-4 py-3 text-xs text-slate-500 font-mono">${item.batch_no}</td>
            <td class="px-4 py-3 text-right font-semibold text-slate-700">৳${item.price.toFixed(2)}</td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button onclick="changeQty(${i}, -1)" class="w-6 h-6 bg-slate-100 hover:bg-slate-200 rounded text-slate-600 font-bold text-xs">-</button>
                    <span class="w-8 text-center font-bold text-sm">${item.qty}</span>
                    <button onclick="changeQty(${i}, 1)" class="w-6 h-6 bg-slate-100 hover:bg-slate-200 rounded text-slate-600 font-bold text-xs">+</button>
                </div>
            </td>
            <td class="px-4 py-3 text-right font-bold text-teal-700">৳${(item.qty * item.price).toFixed(2)}</td>
            <td class="px-4 py-3 text-center"><button onclick="removeFromCart(${i})" class="text-red-400 hover:text-red-600 text-xs p-1"><i class="fas fa-times"></i></button></td>
        </tr>
    `).join('');
    document.getElementById('cartCount').textContent = cart.reduce((s, i) => s + i.qty, 0);
    updateSummary();
}

function changeQty(index, delta) {
    cart[index].qty = Math.max(1, Math.min(cart[index].max, cart[index].qty + delta));
    renderCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
}

function clearCart() {
    cart = [];
    renderCart();
}

function updateSummary() {
    const subtotal = cart.reduce((s, i) => s + i.qty * i.price, 0);
    const discount = parseFloat(document.getElementById('posDiscount').value) || 0;
    const tax      = parseFloat(document.getElementById('posTax').value) || 0;
    const total    = subtotal - discount + tax;
    
    document.getElementById('posPaid').value = total > 0 ? total.toFixed(2) : '';
    
    const change   = 0;

    document.getElementById('posSubtotal').textContent = '৳' + subtotal.toFixed(2);
    document.getElementById('posTotal').textContent    = '৳' + total.toFixed(2);
    document.getElementById('posChange').textContent   = '৳' + change.toFixed(2);
    document.getElementById('posChange').className     = 'font-bold text-green-600';
}

['posDiscount','posTax'].forEach(id => document.getElementById(id).addEventListener('input', updateSummary));

function selectPayment(method) {
    selectedPayment = method;
    document.querySelectorAll('.payment-btn').forEach(btn => {
        btn.classList.toggle('border-teal-500', btn.dataset.method === method);
        btn.classList.toggle('bg-teal-50', btn.dataset.method === method);
        btn.classList.toggle('text-teal-600', btn.dataset.method === method);
        btn.classList.remove('border-slate-200');
        if (btn.dataset.method !== method) btn.classList.add('border-slate-200');
    });
    // Auto fill paid amount on cash
    if (method === 'cash') {
        const total = parseFloat(document.getElementById('posTotal').textContent.replace('৳','')) || 0;
        document.getElementById('posPaid').value = total.toFixed(2);
        updateSummary();
    }
}

// Init cash
selectPayment('cash');

function submitSale() {
    if (!cart.length) { alert('Please add at least one medicine to the cart.'); return; }

    const subtotal = cart.reduce((s, i) => s + i.qty * i.price, 0);
    const discount = parseFloat(document.getElementById('posDiscount').value) || 0;
    const tax      = parseFloat(document.getElementById('posTax').value) || 0;
    const total    = subtotal - discount + tax;
    const paid     = parseFloat(document.getElementById('posPaid').value) || 0;

    const payload = {
        _token: document.querySelector('meta[name=csrf-token]').content,
        customer_id: document.getElementById('customerSelect').value || null,
        items: cart.map(i => ({ product_id: i.product_id, batch_id: i.batch_id, quantity: i.qty, price: i.price })),
        discount, tax, total, paid,
        payment_method: selectedPayment,
        note: document.getElementById('posNote').value,
    };

    fetch('{{ route("admin.pos.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': payload._token },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('saleModalMsg').textContent = `Total: ৳${total.toFixed(2)} | Paid: ৳${paid.toFixed(2)}`;
            document.getElementById('printInvoiceBtn').href = data.invoice_url;
            document.getElementById('successModal').classList.remove('hidden');
        } else {
            alert(data.message || 'Sale failed. Please try again.');
        }
    })
    .catch(() => alert('Network error. Please try again.'));
}

function newSale() {
    cart = [];
    renderCart();
    document.getElementById('successModal').classList.add('hidden');
    document.getElementById('posDiscount').value = '';
    document.getElementById('posTax').value = '';
    document.getElementById('posPaid').value = '';
    document.getElementById('posNote').value = '';
    selectPayment('cash');
    updateSummary();
}

function holdBill() {
    if (!cart.length) return;
    const held = JSON.parse(localStorage.getItem('heldBills') || '[]');
    held.push({ cart, time: new Date().toISOString() });
    localStorage.setItem('heldBills', JSON.stringify(held));
    alert('Bill held successfully!');
    clearCart();
}

function saveCustomer() {
    const btn = document.querySelector('#addCustomerForm button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    const payload = {
        _token: document.querySelector('meta[name=csrf-token]').content,
        name: document.getElementById('custName').value,
        phone: document.getElementById('custPhone').value,
        address: document.getElementById('custAddress').value,
    };

    fetch('{{ route("admin.customers.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': payload._token },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = 'Save Customer';
        if (data.success) {
            // Add to select and close modal
            const sel = document.getElementById('customerSelect');
            const opt = new Option(`${data.customer.name} (${data.customer.phone})`, data.customer.id);
            sel.add(opt);
            $('#customerSelect').val(data.customer.id).trigger('change');
            
            document.getElementById('customerModal').classList.add('hidden');
            document.getElementById('addCustomerForm').reset();
        } else {
            alert('Error creating customer. Check inputs.');
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.innerHTML = 'Save Customer';
        alert('Network error. Please try again.');
    });
}
</script>
@endpush
