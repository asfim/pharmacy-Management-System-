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

        <div class="border-t border-slate-100 pt-8 mb-6 mt-8">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-home text-teal-500 mr-2"></i> Hero Section Settings</h3>
            <p class="text-xs text-slate-500">Manage the texts, buttons, and statistics on the homepage hero section.</p>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Badge Text</label>
                <input type="text" name="hero_badge_text" value="{{ $siteSettings['hero_badge_text'] ?? '🎉 Trusted by 50,000+ customers' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Title (Line 1)</label>
                    <input type="text" name="hero_title" value="{{ $siteSettings['hero_title'] ?? 'Your Health,' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Title (Highlighted)</label>
                    <input type="text" name="hero_highlight" value="{{ $siteSettings['hero_highlight'] ?? 'Delivered Fast!' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="hero_desc" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">{{ $siteSettings['hero_desc'] ?? 'Order 100% genuine medicines online and get them delivered to your doorstep within 24 hours, securely & hassle-free.' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="p-4 border border-slate-200 rounded-xl bg-slate-50">
                    <h4 class="font-bold text-sm mb-3">Button 1 (Primary)</h4>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Text</label>
                    <input type="text" name="hero_btn1_text" value="{{ $siteSettings['hero_btn1_text'] ?? 'Order Now' }}" class="w-full px-3 py-2 mb-3 border border-slate-200 rounded text-sm">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link</label>
                    <input type="text" name="hero_btn1_link" value="{{ $siteSettings['hero_btn1_link'] ?? route('products') }}" class="w-full px-3 py-2 border border-slate-200 rounded text-sm">
                </div>
                <div class="p-4 border border-slate-200 rounded-xl bg-slate-50">
                    <h4 class="font-bold text-sm mb-3">Button 2 (Secondary)</h4>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Text</label>
                    <input type="text" name="hero_btn2_text" value="{{ $siteSettings['hero_btn2_text'] ?? 'Upload Prescription' }}" class="w-full px-3 py-2 mb-3 border border-slate-200 rounded text-sm">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link</label>
                    <input type="text" name="hero_btn2_link" value="{{ $siteSettings['hero_btn2_link'] ?? '#' }}" class="w-full px-3 py-2 border border-slate-200 rounded text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Hero Image</label>
                <div class="flex items-center gap-6 p-4 border border-slate-200 rounded-xl bg-slate-50">
                    @if(isset($siteSettings['hero_image']) && $siteSettings['hero_image'])
                        <img src="{{ asset('storage/' . $siteSettings['hero_image']) }}" class="h-24 w-auto object-contain bg-slate-900 p-1 rounded-lg shadow-sm border border-slate-800" alt="Current Hero Image">
                    @else
                        <img src="{{ asset('assets/images/hero_illustration.jpg') }}" class="h-24 w-auto object-contain bg-slate-900 p-1 rounded-lg shadow-sm border border-slate-800" alt="Default Hero Image">
                    @endif
                    <input type="file" name="hero_image" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer transition">
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-8 mb-6 mt-8">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-check-circle text-teal-500 mr-2"></i> Why Choose Us Settings</h3>
            <p class="text-xs text-slate-500">Manage the texts for the 'Why Choose PharmaSys' section.</p>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Badge Text</label>
                <input type="text" name="why_choose_badge" value="{{ $siteSettings['why_choose_badge'] ?? 'Why Choose PharmaSys' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Title</label>
                <input type="text" name="why_choose_title" value="{{ $siteSettings['why_choose_title'] ?? 'Your Trusted Partner in <span class=\'gradient-text\'>Healthcare</span>' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="why_choose_desc" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">{{ $siteSettings['why_choose_desc'] ?? 'We\'re committed to making healthcare accessible, affordable, and convenient for everyone across Bangladesh.' }}</textarea>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-8 mb-6 mt-8">
            <h3 class="text-lg font-bold text-slate-800 mb-1"><i class="fas fa-shoe-prints text-teal-500 mr-2"></i> Footer Settings</h3>
            <p class="text-xs text-slate-500">Manage footer description, contact info, social links, and quick links.</p>
        </div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Footer Description</label>
                <textarea name="footer_desc" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">{{ $siteSettings['footer_desc'] ?? 'Your trusted digital pharmacy. We provide genuine medicines, fast delivery, and authentic healthcare products at your doorstep across Bangladesh.' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Contact Address</label>
                    <input type="text" name="footer_address" value="{{ $siteSettings['footer_address'] ?? '123 Pharmacy Road, Dhaka, Bangladesh' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Contact Phone</label>
                    <input type="text" name="footer_phone" value="{{ $siteSettings['footer_phone'] ?? '+880 1234 567890' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Contact Email</label>
                    <input type="email" name="footer_email" value="{{ $siteSettings['footer_email'] ?? 'support@pharmasys.com' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Support Hours / Text</label>
                    <input type="text" name="footer_support" value="{{ $siteSettings['footer_support'] ?? '24/7 Customer Support' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Facebook URL</label>
                    <input type="url" name="footer_facebook" value="{{ $siteSettings['footer_facebook'] ?? '#' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Twitter URL</label>
                    <input type="url" name="footer_twitter" value="{{ $siteSettings['footer_twitter'] ?? '#' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Instagram URL</label>
                    <input type="url" name="footer_instagram" value="{{ $siteSettings['footer_instagram'] ?? '#' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">YouTube URL</label>
                    <input type="url" name="footer_youtube" value="{{ $siteSettings['footer_youtube'] ?? '#' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Copyright Text</label>
                <input type="text" name="footer_copyright" value="{{ $siteSettings['footer_copyright'] ?? '© '.date('Y').' PharmaSys. All rights reserved. Made with ❤️ in Bangladesh.' }}" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-teal-500 transition-all bg-slate-50">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Quick Links -->
                <div class="p-4 border border-slate-200 rounded-xl bg-slate-50">
                    <h4 class="font-bold text-sm mb-4">Quick Links</h4>
                    @for($i=1; $i<=4; $i++)
                    <div class="flex gap-2 mb-3">
                        <input type="text" name="quick_link_{{$i}}_name" value="{{ $siteSettings['quick_link_'.$i.'_name'] ?? '' }}" placeholder="Link {{$i}} Name" class="w-1/2 px-3 py-2 border border-slate-200 rounded text-sm">
                        <input type="text" name="quick_link_{{$i}}_url" value="{{ $siteSettings['quick_link_'.$i.'_url'] ?? '' }}" placeholder="URL (e.g. /about)" class="w-1/2 px-3 py-2 border border-slate-200 rounded text-sm">
                    </div>
                    @endfor
                </div>

                <!-- Customer Services -->
                <div class="p-4 border border-slate-200 rounded-xl bg-slate-50">
                    <h4 class="font-bold text-sm mb-4">Customer Services</h4>
                    @for($i=1; $i<=4; $i++)
                    <div class="flex gap-2 mb-3">
                        <input type="text" name="customer_link_{{$i}}_name" value="{{ $siteSettings['customer_link_'.$i.'_name'] ?? '' }}" placeholder="Link {{$i}} Name" class="w-1/2 px-3 py-2 border border-slate-200 rounded text-sm">
                        <input type="text" name="customer_link_{{$i}}_url" value="{{ $siteSettings['customer_link_'.$i.'_url'] ?? '' }}" placeholder="URL (e.g. /contact)" class="w-1/2 px-3 py-2 border border-slate-200 rounded text-sm">
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 mt-6 border-t border-slate-100">
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition shadow-md shadow-teal-500/20">Save Settings</button>
        </div>
    </form>
</div>
@endsection
