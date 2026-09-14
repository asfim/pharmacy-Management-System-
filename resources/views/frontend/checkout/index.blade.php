@extends('frontend.layouts.app')

@push('styles')
<style>
.co-wrap {
    padding: 60px 0;
    background: #f8fafc;
}
.co-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 32px;
    align-items: start;
}
@media (max-width: 992px) {
    .co-grid { grid-template-columns: 1fr; }
}
.co-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    padding: 30px;
}
.co-title {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.co-title svg { color: #10b981; }

.co-form-group { margin-bottom: 20px; }
.co-label {
    display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px;
}
.co-input {
    width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px;
    font-size: 14px; color: #0f172a; outline: none; transition: all .2s;
}
.co-input:focus { border-color: #10b981; box-shadow: 0 0 0 4px rgba(16,185,129,.1); }

.co-item {
    display: flex; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f1f5f9;
}
.co-item:last-child { border-bottom: none; }
.co-item-img {
    width: 70px; height: 70px; border-radius: 12px; background: #f8fafc;
    border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0; overflow: hidden;
}
.co-item-img img { width: 100%; height: 100%; object-fit: cover; }
.co-item-info { flex: 1; }
.co-item-name { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.co-item-price { font-size: 13px; color: #64748b; }
.co-item-total { font-size: 15px; font-weight: 800; color: #10b981; text-align: right; }

.co-summary-row {
    display: flex; justify-content: space-between; font-size: 14px; color: #475569;
    margin-bottom: 12px;
}
.co-summary-row.total {
    font-size: 20px; font-weight: 800; color: #0f172a; border-top: 2px dashed #e2e8f0;
    padding-top: 16px; margin-top: 16px; margin-bottom: 24px;
}
.co-btn {
    display: flex; align-items: center; justify-content: center; width: 100%; gap: 10px;
    padding: 16px; border-radius: 14px; border: none;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; font-size: 16px; font-weight: 800;
    cursor: pointer; transition: all .3s;
}
.co-btn:hover {
    transform: translateY(-2px); box-shadow: 0 10px 25px rgba(16,185,129,.3);
}
</style>
@endpush

@section('content')
<div class="co-wrap">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('checkout.place') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($isBuyNow) && $isBuyNow)
                <input type="hidden" name="is_buy_now" value="1">
            @endif
            <div class="co-grid">
                
                {{-- Left: Details --}}
                <div class="co-card">
                    <h2 class="co-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Delivery Details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                        <div class="co-form-group">
                            <label class="co-label">Full Name</label>
                            <input type="text" name="name" class="co-input" value="{{ old('name', $user->name ?? '') }}" required placeholder="e.g. Rahim Ahmed">
                        </div>
                        <div class="co-form-group">
                            <label class="co-label">Phone Number</label>
                            <input type="text" name="phone" class="co-input" value="{{ old('phone', $customer->phone ?? '') }}" required placeholder="e.g. 01712345678">
                        </div>
                    </div>

                    <div class="co-form-group">
                        <label class="co-label">Delivery Address</label>
                        <textarea name="address" class="co-input" rows="4" required placeholder="House, Road, Block, Area, City">{{ old('address', $customer->address_line ?? '') }}</textarea>
                    </div>
                    
                    @if(isset($prescriptionRequired) && $prescriptionRequired)
                    <div class="mt-6 p-5 bg-rose-50 border-2 border-rose-200 rounded-xl">
                        <h3 class="font-bold text-rose-700 flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Prescription Required
                        </h3>
                        <p class="text-sm text-rose-600 mb-4">One or more medicines in your cart require a valid doctor's prescription. Please upload a clear photo or PDF.</p>
                        <input type="file" name="prescription_file" accept="image/*,.pdf" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-rose-100 file:text-rose-700 hover:file:bg-rose-200 cursor-pointer">
                    </div>
                    @endif

                    <h2 class="co-title mt-8">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Payment Method
                    </h2>
                    
                    <label class="flex items-center gap-3 p-4 border-2 border-emerald-500 bg-emerald-50 rounded-xl cursor-pointer">
                        <input type="radio" name="payment" value="cod" checked class="w-5 h-5 text-emerald-500 focus:ring-emerald-500">
                        <span class="font-bold text-slate-800">Cash on Delivery</span>
                    </label>

                </div>

                {{-- Right: Order Summary --}}
                <div class="co-card" style="position: sticky; top: 100px;">
                    <h2 class="co-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Order Summary
                    </h2>

                    <div class="mb-6 max-h-80 overflow-y-auto pr-2">
                        @foreach($cart as $id => $item)
                        <div class="co-item">
                            <div class="co-item-img">
                                @if($item['image'])
                                    <img src="{{ asset('storage/'.$item['image']) }}" alt="">
                                @else
                                    💊
                                @endif
                            </div>
                            <div class="co-item-info">
                                <div class="co-item-name">{{ $item['name'] }}</div>
                                <div class="co-item-price">{{ $item['quantity'] }} x ৳{{ number_format($item['price'], 2) }}</div>
                            </div>
                            <div class="co-item-total">
                                ৳{{ number_format($item['price'] * $item['quantity'], 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="co-summary-row">
                        <span>Subtotal</span>
                        <span class="font-semibold text-slate-800">৳{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="co-summary-row">
                        <span>Delivery Charge</span>
                        <span class="font-semibold text-slate-800">৳{{ number_format($delivery, 2) }}</span>
                    </div>
                    <div class="co-summary-row total">
                        <span>Total Payable</span>
                        <span class="text-emerald-500">৳{{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="co-btn">
                        Place Order
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <p class="text-center text-xs text-slate-400 mt-4">
                        By placing this order, you agree to our Terms of Service & Privacy Policy.
                    </p>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
