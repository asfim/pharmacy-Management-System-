@extends('admin.layouts.app')
@php $header = 'System Settings'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">System & Application Settings</h2>
        <p class="text-sm text-slate-500 mt-1">Configure store info, invoice header, currency & POS settings</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-4xl p-6">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="border-b border-slate-100 pb-4 mb-4">
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Pharmacy Details</h3>
            <p class="text-xs text-slate-400">Basic business information used in reports and receipts</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pharmacy Name</label>
                <input type="text" name="site_name" value="PharmaSys Central" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contact Phone</label>
                <input type="text" name="phone" value="+8801700000000" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contact Email</label>
                <input type="email" name="email" value="admin@pharmasys.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Currency Symbol</label>
                <input type="text" name="currency_symbol" value="৳" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Address</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-teal-500">Dhanmondi, Dhaka, Bangladesh</textarea>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition shadow-sm">Save Settings</button>
        </div>
    </form>
</div>
@endsection
