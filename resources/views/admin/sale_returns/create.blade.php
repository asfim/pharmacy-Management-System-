@extends('admin.layouts.app')
@php $header = 'New Sale Return'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Create Sale Return</h2>
    </div>
    <a href="{{ route('admin.sale-returns.index') }}" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium px-4 py-2 rounded-xl transition">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow max-w-2xl">
    <form action="{{ route('admin.sale-returns.store') }}" method="POST" class="p-6 space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Select Invoice / Sale *</label>
            <select name="sale_id" id="saleSelect" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
                <option value="">-- Select Sale Invoice --</option>
                @foreach($salesData as $s)
                <option value="{{ $s['id'] }}" 
                        data-total="{{ $s['total'] }}"
                        data-items="{{ json_encode($s['items']) }}">
                    Invoice: {{ $s['invoice_no'] }} (Customer: {{ $s['customer'] }} | Total: ৳{{ number_format($s['total'], 2) }})
                </option>
                @endforeach
            </select>
            @error('sale_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Dynamic Items Container -->
        <div id="itemsContainer" class="hidden space-y-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 flex items-center justify-between">
                <span>Select Return Quantity Per Item:</span>
                <span class="text-[11px] font-normal text-slate-400">Stock will be added back automatically</span>
            </h4>
            <div id="itemsList" class="space-y-2"></div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Refund Amount (৳) *</label>
            <input type="number" name="refund_amount" id="refundAmount" step="0.01" value="{{ old('refund_amount', 0) }}" required class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 font-semibold text-teal-700">
            @error('refund_amount')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Reason / Note</label>
            <textarea name="reason" rows="3" placeholder="Reason for return..." class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">{{ old('reason') }}</textarea>
            @error('reason')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">
                <i class="fas fa-undo mr-1.5"></i> Process Return & Restore Stock
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('saleSelect').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const itemsContainer = document.getElementById('itemsContainer');
    const itemsList = document.getElementById('itemsList');
    const refundInput = document.getElementById('refundAmount');

    if (!option || !option.value) {
        itemsContainer.classList.add('hidden');
        itemsList.innerHTML = '';
        refundInput.value = '0.00';
        return;
    }

    const items = JSON.parse(option.getAttribute('data-items') || '[]');
    itemsList.innerHTML = '';

    if (items.length > 0) {
        itemsContainer.classList.remove('hidden');
        let totalRefund = 0;

        items.forEach(item => {
            const itemTotal = item.sold_qty * item.price;
            totalRefund += itemTotal;

            const div = document.createElement('div');
            div.className = 'flex items-center justify-between bg-white p-3 rounded-lg border border-slate-200 text-sm';
            div.innerHTML = `
                <div>
                    <p class="font-semibold text-slate-800">${item.name}</p>
                    <p class="text-xs text-slate-400">Sold: ${item.sold_qty} Pcs | Price: ৳${item.price.toFixed(2)}</p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-xs text-slate-500">Return Qty:</label>
                    <input type="number" 
                           name="return_items[${item.id}]" 
                           value="${item.sold_qty}" 
                           min="0" 
                           max="${item.sold_qty}" 
                           data-price="${item.price}"
                           class="w-20 px-2 py-1 border border-slate-300 rounded text-right font-bold text-slate-800 focus:ring-teal-500 item-return-qty">
                </div>
            `;
            itemsList.appendChild(div);
        });

        refundInput.value = totalRefund.toFixed(2);

        document.querySelectorAll('.item-return-qty').forEach(input => {
            input.addEventListener('input', calculateRefund);
        });
    } else {
        itemsContainer.classList.add('hidden');
        refundInput.value = (parseFloat(option.getAttribute('data-total')) || 0).toFixed(2);
    }
});

function calculateRefund() {
    let total = 0;
    document.querySelectorAll('.item-return-qty').forEach(input => {
        const qty = parseFloat(input.value) || 0;
        const price = parseFloat(input.getAttribute('data-price')) || 0;
        total += qty * price;
    });
    document.getElementById('refundAmount').value = total.toFixed(2);
}
</script>
@endpush
@endsection
