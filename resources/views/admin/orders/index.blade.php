@extends('admin.layouts.app')
@php $header = 'Online Orders'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h2 class="text-2xl font-bold text-slate-800">E-Commerce Orders</h2></div>
</div>
@include('admin.layouts.alerts')

<!-- Status Filter Tabs -->
<div class="flex gap-2 mb-5 flex-wrap">
    @foreach(['all','pending','confirmed','ready','delivered','cancelled'] as $s)
    <a href="{{ request()->fullUrlWithQuery(['status' => $s == 'all' ? '' : $s]) }}"
       class="px-4 py-1.5 rounded-full text-xs font-semibold border {{ request('status', '') == ($s == 'all' ? '' : $s) ? 'bg-teal-600 text-white border-teal-600' : 'border-slate-300 text-slate-600 hover:border-teal-500 hover:text-teal-600' }} transition">
        {{ ucfirst($s) }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase">
                <tr>
                    <th class="px-5 py-4 text-left">Order #</th>
                    <th class="px-5 py-4 text-left">Customer</th>
                    <th class="px-5 py-4 text-left">Date</th>
                    <th class="px-5 py-4 text-right">Amount</th>
                    <th class="px-5 py-4 text-center">Prescription</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $o)
                @php
                    $statusColors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'indigo','ready'=>'purple','shipped'=>'cyan','delivered'=>'green','cancelled'=>'red','returned'=>'orange','refunded'=>'slate'];
                    $c = $statusColors[$o->status] ?? 'slate';
                @endphp
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-5 py-3.5 font-mono font-semibold text-slate-700">{{ $o->order_no }}</td>
                    <td class="px-5 py-3.5">
                        <p class="font-semibold text-slate-800">{{ $o->customer->name ?? 'Guest' }}</p>
                        <p class="text-xs text-slate-400">{{ $o->customer->phone ?? '' }}</p>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $o->created_at->format('d M Y, h:i A') }}</td>
                    <td class="px-5 py-3.5 text-right font-bold text-slate-800">৳{{ number_format($o->total, 2) }}</td>
                    <td class="px-5 py-3.5 text-center">
                        @if($o->prescription_required)
                            @php
                                $prescription = $o->order_prescriptions->first()?->prescription;
                            @endphp
                            @if($prescription)
                                @if($prescription->verification_status == 'verified')
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                        <i class="fas fa-check-circle"></i> Match
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-100">
                                        <i class="fas fa-times-circle"></i> Not Match
                                    </span>
                                @endif
                            @else
                                <span class="text-xs text-slate-400">Missing</span>
                            @endif
                        @else
                            <span class="text-xs text-slate-300">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-center">
                        <select onchange="updateOrderStatus({{ $o->id }}, this)" class="text-xs font-bold rounded-lg border-2 border-slate-200 bg-{{ $c }}-50 text-{{ $c }}-700 hover:border-teal-400 focus:ring-4 focus:ring-teal-50 focus:border-teal-500 cursor-pointer shadow-sm transition-all py-1.5 px-3">
                            @foreach(['pending','confirmed','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $o->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <div class="flex justify-end gap-1">
                            <a href="{{ route('admin.orders.show', $o) }}" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg"><i class="fas fa-eye text-xs"></i></a>
                            <a href="{{ route('admin.orders.invoice', $o) }}" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg"><i class="fas fa-print text-xs"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50">{{ $orders->links() }}</div>
    @endif
</div>

<script>
const statusColors = {
    'pending': 'bg-yellow-50 text-yellow-700',
    'confirmed': 'bg-blue-50 text-blue-700',
    'delivered': 'bg-green-50 text-green-700',
    'cancelled': 'bg-red-50 text-red-700'
};

function updateOrderStatus(orderId, selectElement) {
    const status = selectElement.value;
    
    fetch(`/admin/orders/${orderId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove all color classes
            Object.values(statusColors).forEach(colorClass => {
                const classes = colorClass.split(' ');
                selectElement.classList.remove(...classes);
            });
            
            // Add new color classes
            if (statusColors[status]) {
                const newClasses = statusColors[status].split(' ');
                selectElement.classList.add(...newClasses);
            }
        } else {
            console.error('Failed to update status.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection
