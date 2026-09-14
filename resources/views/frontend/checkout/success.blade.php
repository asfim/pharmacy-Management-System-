@extends('frontend.layouts.app')

@section('content')
<div class="py-20 bg-slate-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
        <div class="bg-white rounded-3xl p-8 text-center border border-slate-100 shadow-xl shadow-slate-200/50">
            
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Order Successful!</h1>
            <p class="text-slate-500 mb-6">Thank you for your purchase. Your order has been placed successfully.</p>

            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 text-left mb-8">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-slate-500">Order Number</span>
                    <span class="font-bold text-slate-800">{{ $order->order_no }}</span>
                </div>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-slate-500">Date</span>
                    <span class="font-bold text-slate-800">{{ $order->created_at->format('d M, Y') }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                    <span class="text-sm text-slate-500">Total Amount</span>
                    <span class="font-extrabold text-emerald-500 text-lg">৳{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                @auth
                <a href="{{ route('customer.orders') }}" class="w-full py-4 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                    Track My Order
                </a>
                @endauth
                
                <a href="{{ route('home') }}" class="w-full py-4 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition-all">
                    Continue Shopping
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
