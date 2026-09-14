@extends('admin.layouts.app')
@php $header = 'Order Details'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Order #{{ $order->order_no }}</h2>
        <p class="text-slate-500 text-sm">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
    </div>
    <div>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition font-semibold">Back to Orders</a>
    </div>
</div>
@include('admin.layouts.alerts')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Order Items -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Order Items</h3>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-700">{{ $order->order_items->count() }} items</span>
            </div>
            <div class="p-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-100">
                            <th class="text-left pb-3 font-semibold">Product</th>
                            <th class="text-center pb-3 font-semibold">Qty</th>
                            <th class="text-right pb-3 font-semibold">Price</th>
                            <th class="text-right pb-3 font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($order->order_items as $item)
                        <tr>
                            <td class="py-4">
                                <p class="font-bold text-slate-800">{{ $item->product->name ?? 'Unknown Product' }}</p>
                            </td>
                            <td class="py-4 text-center font-semibold text-slate-700">{{ $item->quantity }}</td>
                            <td class="py-4 text-right text-slate-600">৳{{ number_format($item->unit_price, 2) }}</td>
                            <td class="py-4 text-right font-bold text-slate-800">৳{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t border-slate-100">
                        <tr>
                            <td colspan="3" class="py-3 text-right text-slate-500">Subtotal</td>
                            <td class="py-3 text-right font-semibold text-slate-800">৳{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-3 text-right text-slate-500">Delivery Charge</td>
                            <td class="py-3 text-right font-semibold text-slate-800">৳{{ number_format($order->delivery_charge, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="py-4 text-right font-bold text-slate-800 text-lg border-t border-slate-100">Total</td>
                            <td class="py-4 text-right font-bold text-teal-600 text-lg border-t border-slate-100">৳{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if($order->prescription_required)
            @php
                $orderPrescription = \App\Models\OrderPrescription::with('prescription')->where('order_id', $order->id)->first();
                $prescription = $orderPrescription ? $orderPrescription->prescription : null;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-rose-50 flex justify-between items-center">
                    <h3 class="font-bold text-rose-800 flex items-center gap-2">
                        <i class="fas fa-file-medical"></i> Prescription Details
                    </h3>
                </div>
                <div class="p-6">
                    @if($prescription)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-slate-700 mb-3">Uploaded Document</h4>
                                <a href="{{ asset('storage/' . $prescription->image_file) }}" target="_blank" class="block border-2 border-dashed border-slate-200 rounded-xl p-2 hover:border-teal-400 transition">
                                    @if(Str::endsWith(strtolower($prescription->image_file), '.pdf'))
                                        <div class="h-48 bg-slate-50 flex items-center justify-center flex-col text-slate-400">
                                            <i class="fas fa-file-pdf text-4xl mb-2 text-rose-400"></i>
                                            <span>View PDF Document</span>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $prescription->image_file) }}" class="w-full h-48 object-cover rounded-lg" alt="Prescription">
                                    @endif
                                </a>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-700 mb-3">AI Verification Analysis</h4>
                                @if($prescription->verification_status == 'verified')
                                    <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 mb-4">
                                        <div class="flex items-center gap-2 mb-2 font-bold">
                                            <i class="fas fa-check-circle text-emerald-500"></i> AI Match Successful
                                        </div>
                                        <p class="text-sm whitespace-pre-line">{{ $prescription->notes }}</p>
                                    </div>
                                @else
                                    <div class="bg-rose-50 text-rose-800 p-4 rounded-xl border border-rose-200 mb-4">
                                        <div class="flex items-center gap-2 mb-2 font-bold">
                                            <i class="fas fa-exclamation-triangle text-rose-500"></i> AI Match Failed or Pending
                                        </div>
                                        <p class="text-sm whitespace-pre-line">{{ $prescription->notes }}</p>
                                    </div>
                                @endif
                                <p class="text-xs text-slate-500">AI analysis is automated. Please double check the image manually.</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6 text-slate-500">
                            No prescription uploaded for this order.
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column: Customer & Status -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-4">Order Status</h3>
            @php
                $statusColors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'indigo','ready'=>'purple','shipped'=>'cyan','delivered'=>'green','cancelled'=>'red','returned'=>'orange','refunded'=>'slate'];
                $c = $statusColors[$order->status] ?? 'slate';
            @endphp
            <div class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-bold bg-{{ $c }}-50 text-{{ $c }}-700 capitalize border border-{{ $c }}-200">
                <i class="fas fa-info-circle mr-2"></i> {{ $order->status }}
            </div>
            <p class="text-xs text-slate-400 mt-3">Status can be updated from the main orders list.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 mb-4">Customer Details</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-start gap-3">
                    <i class="fas fa-user text-slate-400 mt-1"></i>
                    <div>
                        <p class="font-semibold text-slate-700">{{ $order->customer->name ?? 'Guest' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <i class="fas fa-phone text-slate-400 mt-1"></i>
                    <div>
                        <p class="text-slate-600">{{ $order->customer->phone ?? 'N/A' }}</p>
                    </div>
                </div>
                @if($order->customer_address)
                <div class="flex items-start gap-3">
                    <i class="fas fa-map-marker-alt text-slate-400 mt-1"></i>
                    <div>
                        <p class="text-slate-600">{{ $order->customer_address->address_line }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
