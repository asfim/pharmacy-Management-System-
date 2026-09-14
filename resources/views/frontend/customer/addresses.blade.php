@extends('frontend.layouts.customer')

@section('content')
<div class="cd-card">
    <div class="cd-card-header">
        <h3 class="cd-card-title flex items-center gap-2">
            <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Manage Addresses
        </h3>
        <button class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-600 transition-colors">
            + Add New Address
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if(isset($customer) && $customer->address)
            <div class="border border-emerald-200 bg-emerald-50 rounded-xl p-5 relative">
                <div class="absolute top-4 right-4 bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded">Default</div>
                <h4 class="font-bold text-slate-800 mb-1">Home Address</h4>
                <p class="text-sm text-slate-600 mb-4">{{ $customer->address }}</p>
                
                <div class="flex gap-3">
                    <button class="text-sm text-primary font-semibold hover:underline">Edit</button>
                </div>
            </div>
        @else
            <div class="cd-empty col-span-2">
                <div class="cd-empty-icon flex justify-center text-slate-300 mb-4">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <p>No addresses saved yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
