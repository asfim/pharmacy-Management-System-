@extends('frontend.layouts.app')

@section('content')

<!-- Hero Slider Placeholder -->
<section class="bg-teal-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight mb-4">
                    Your Health, <br><span class="text-teal-600">Delivered Fast!</span>
                </h1>
                <p class="text-lg text-slate-600 mb-8 max-w-lg">
                    Order 100% genuine medicines online and get them delivered to your doorstep quickly and securely.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition">Order Now</a>
                    <a href="#" class="bg-white border-2 border-teal-600 text-teal-600 hover:bg-teal-50 font-semibold py-3 px-8 rounded-full transition">Upload Prescription</a>
                </div>
            </div>
            <div class="hidden md:flex justify-end">
                <div class="w-96 h-96 bg-teal-200 rounded-full flex items-center justify-center opacity-50">
                    <span class="text-teal-800 font-bold">[ Hero Image Placeholder ]</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-12 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="p-4">
                <div class="w-16 h-16 mx-auto bg-teal-100 rounded-full flex items-center justify-center text-teal-600 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-slate-800">Genuine Medicines</h3>
                <p class="text-sm text-slate-500 mt-2">100% authentic products</p>
            </div>
            <div class="p-4">
                <div class="w-16 h-16 mx-auto bg-teal-100 rounded-full flex items-center justify-center text-teal-600 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-slate-800">Fast Delivery</h3>
                <p class="text-sm text-slate-500 mt-2">Within 24 hours</p>
            </div>
            <div class="p-4">
                <div class="w-16 h-16 mx-auto bg-teal-100 rounded-full flex items-center justify-center text-teal-600 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="font-bold text-slate-800">Secure Payments</h3>
                <p class="text-sm text-slate-500 mt-2">bKash, Nagad, Card</p>
            </div>
            <div class="p-4">
                <div class="w-16 h-16 mx-auto bg-teal-100 rounded-full flex items-center justify-center text-teal-600 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <h3 class="font-bold text-slate-800">30+ Branches</h3>
                <p class="text-sm text-slate-500 mt-2">All over the country</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Placeholder -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Featured Medicines</h2>
                <p class="text-slate-500 mt-1">Top rated and highly recommended</p>
            </div>
            <a href="#" class="text-teal-600 font-medium hover:text-teal-700 hover:underline">View All &rarr;</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @for ($i = 0; $i < 5; $i++)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition">
                <div class="bg-slate-100 h-40 rounded-lg mb-4 flex items-center justify-center">
                    <span class="text-slate-400 text-xs">[ Image ]</span>
                </div>
                <div class="text-xs font-semibold text-teal-600 mb-1">Square Pharma</div>
                <h3 class="font-bold text-slate-800 truncate mb-1">Napa Extend 665mg</h3>
                <p class="text-xs text-slate-500 mb-3">Paracetamol</p>
                <div class="flex justify-between items-center mt-auto">
                    <span class="font-bold text-slate-900">৳ 2.00</span>
                    <button class="w-8 h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center hover:bg-teal-600 hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </button>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

@endsection
