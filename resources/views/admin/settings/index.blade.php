@extends('admin.layouts.app')
@php $header = 'System Settings'; @endphp
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">System & Branding Settings</h2>
        <p class="text-sm text-slate-500 mt-1">Configure your site's global logo, favicon, and title.</p>
    </div>
</div>

@include('admin.layouts.alerts')

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md hover:shadow-xl transition-shadow max-w-3xl p-8">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="border-b border-slate-100 pb-4 mb-6">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-globe text-teal-500 mr-2"></i> Global Branding</h3>
            <p class="text-xs text-slate-500">These settings will reflect across the frontend, admin panel, and invoices.</p>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Site Title</label>
                <input type="text" name="site_title" value="{{ $siteSettings['site_title'] ?? 'Pharmacy App' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50" placeholder="e.g. My Pharmacy">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Site Logo</label>
                <div class="flex items-center gap-6 p-4 border border-slate-200 rounded-xl bg-slate-50">
                    @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" class="h-16 w-auto object-contain bg-white p-2 rounded-lg shadow-sm border border-slate-100" alt="Current Logo">
                    @else
                        <div class="h-16 w-32 bg-slate-200 rounded-lg flex items-center justify-center text-xs text-slate-400 font-bold">No Logo</div>
                    @endif
                    <input type="file" name="site_logo" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Favicon</label>
                <div class="flex items-center gap-6 p-4 border border-slate-200 rounded-xl bg-slate-50">
                    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
                        <img src="{{ asset('storage/' . $siteSettings['site_favicon']) }}" class="h-12 w-12 object-contain bg-white p-2 rounded-lg shadow-sm border border-slate-100" alt="Current Favicon">
                    @else
                        <div class="h-12 w-12 bg-slate-200 rounded-lg flex items-center justify-center text-xs text-slate-400 font-bold">Icon</div>
                    @endif
                    <input type="file" name="site_favicon" accept="image/*,.ico" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer transition">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 mt-6 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition shadow-md shadow-teal-500/20">Save Branding Settings</button>
        </div>
    </form>
</div>
@endsection
