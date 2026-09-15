<!-- Wave Top Divider -->
<div class="relative">
    <svg class="w-full h-16 text-slate-950 -mb-1" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C57.1,88.13,125.63,68.46,190.7,58.75,242.93,51.24,279.59,61.11,321.39,56.44Z" fill="currentColor"></path>
    </svg>
</div>

<footer class="bg-gradient-to-b from-slate-950 to-slate-900 text-slate-300 pt-16 pb-8 relative overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 right-10 w-60 h-60 bg-emerald-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 left-10 w-60 h-60 bg-teal-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-14">
            
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-5 group">
                    @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" class="h-10 w-auto object-contain" alt="Site Logo">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:shadow-emerald-500/40 transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight">
                            <span class="text-emerald-500">{{ isset($siteSettings['site_title']) ? strtok($siteSettings['site_title'], ' ') : 'PHARMA' }}</span><span class="text-white">{{ isset($siteSettings['site_title']) ? substr($siteSettings['site_title'], strpos($siteSettings['site_title'], ' ')) : 'SYS' }}</span>
                        </span>
                    @endif
                </a>
                <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                    {{ $siteSettings['footer_desc'] ?? 'Your trusted digital pharmacy. We provide genuine medicines, fast delivery, and authentic healthcare products at your doorstep across Bangladesh.' }}
                </p>
                
                <!-- Social Icons -->
                <div class="flex space-x-3">
                    @if(!empty($siteSettings['footer_facebook']))
                    <a href="{{ $siteSettings['footer_facebook'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800/80 hover:bg-gradient-to-r hover:from-blue-500 hover:to-blue-600 text-slate-400 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/20">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['footer_instagram']))
                    <a href="{{ $siteSettings['footer_instagram'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800/80 hover:bg-gradient-to-r hover:from-pink-500 hover:to-rose-500 text-slate-400 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-500/20">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['footer_twitter']))
                    <a href="{{ $siteSettings['footer_twitter'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800/80 hover:bg-gradient-to-r hover:from-sky-400 hover:to-sky-500 text-slate-400 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-sky-500/20">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['footer_youtube']))
                    <a href="{{ $siteSettings['footer_youtube'] }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-800/80 hover:bg-gradient-to-r hover:from-red-500 hover:to-rose-600 text-slate-400 hover:text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-red-500/20">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-bold mb-5 text-base flex items-center space-x-2">
                    <div class="w-1 h-5 bg-gradient-to-b from-emerald-500 to-teal-500 rounded-full"></div>
                    <span>Quick Links</span>
                </h3>
                <ul class="space-y-3 text-sm">
                    @for($i=1; $i<=4; $i++)
                        @if(!empty($siteSettings['quick_link_'.$i.'_name']))
                        <li><a href="{{ $siteSettings['quick_link_'.$i.'_url'] ?? '#' }}" class="text-slate-400 hover:text-emerald-400 transition-colors flex items-center space-x-2 group"><svg class="w-3 h-3 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg><span>{{ $siteSettings['quick_link_'.$i.'_name'] }}</span></a></li>
                        @endif
                    @endfor
                    @if(empty($siteSettings['quick_link_1_name']) && empty($siteSettings['quick_link_2_name']) && empty($siteSettings['quick_link_3_name']) && empty($siteSettings['quick_link_4_name']))
                        <li><a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors flex items-center space-x-2 group"><svg class="w-3 h-3 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg><span>About Us</span></a></li>
                        <li><a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors flex items-center space-x-2 group"><svg class="w-3 h-3 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg><span>Contact Us</span></a></li>
                    @endif
                </ul>
            </div>

            <!-- Customer Services -->
            <div>
                <h3 class="text-white font-bold mb-5 text-base flex items-center space-x-2">
                    <div class="w-1 h-5 bg-gradient-to-b from-emerald-500 to-teal-500 rounded-full"></div>
                    <span>Customer Services</span>
                </h3>
                <ul class="space-y-3 text-sm">
                    @for($i=1; $i<=4; $i++)
                        @if(!empty($siteSettings['customer_link_'.$i.'_name']))
                        <li><a href="{{ $siteSettings['customer_link_'.$i.'_url'] ?? '#' }}" class="text-slate-400 hover:text-emerald-400 transition-colors flex items-center space-x-2 group"><svg class="w-3 h-3 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg><span>{{ $siteSettings['customer_link_'.$i.'_name'] }}</span></a></li>
                        @endif
                    @endfor
                    @if(empty($siteSettings['customer_link_1_name']) && empty($siteSettings['customer_link_2_name']) && empty($siteSettings['customer_link_3_name']) && empty($siteSettings['customer_link_4_name']))
                        <li><a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors flex items-center space-x-2 group"><svg class="w-3 h-3 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg><span>My Account</span></a></li>
                        <li><a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors flex items-center space-x-2 group"><svg class="w-3 h-3 text-slate-600 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg><span>Track Order</span></a></li>
                    @endif
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-white font-bold mb-5 text-base flex items-center space-x-2">
                    <div class="w-1 h-5 bg-gradient-to-b from-emerald-500 to-teal-500 rounded-full"></div>
                    <span>Contact Info</span>
                </h3>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex items-start space-x-3 group">
                        <div class="w-9 h-9 bg-slate-800/80 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="mt-1.5">{{ $siteSettings['footer_address'] ?? '123 Pharmacy Road, Dhaka, Bangladesh' }}</span>
                    </li>
                    <li class="flex items-start space-x-3 group">
                        <div class="w-9 h-9 bg-slate-800/80 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <span class="mt-1.5">{{ $siteSettings['footer_phone'] ?? '+880 1234 567890' }}</span>
                    </li>
                    <li class="flex items-start space-x-3 group">
                        <div class="w-9 h-9 bg-slate-800/80 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="mt-1.5">{{ $siteSettings['footer_email'] ?? 'support@pharmasys.com' }}</span>
                    </li>
                    <li class="flex items-start space-x-3 group">
                        <div class="w-9 h-9 bg-slate-800/80 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="mt-1.5">{{ $siteSettings['footer_support'] ?? '24/7 Customer Support' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-slate-800/80 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500">{!! $siteSettings['footer_copyright'] ?? '&copy; ' . date('Y') . ' PharmaSys. All rights reserved. Made with ❤️ in Bangladesh.' !!}</p>
                <div class="flex items-center space-x-4">
                    <span class="text-slate-600 text-sm">Secure Payments:</span>
                    <div class="flex space-x-2">
                        <span class="px-3 py-1.5 bg-slate-800/80 rounded-lg text-xs font-bold text-white border border-slate-700/50 hover:border-emerald-500/30 transition-colors">bKash</span>
                        <span class="px-3 py-1.5 bg-slate-800/80 rounded-lg text-xs font-bold text-white border border-slate-700/50 hover:border-emerald-500/30 transition-colors">Nagad</span>
                        <span class="px-3 py-1.5 bg-slate-800/80 rounded-lg text-xs font-bold text-white border border-slate-700/50 hover:border-emerald-500/30 transition-colors">VISA</span>
                        <span class="px-3 py-1.5 bg-slate-800/80 rounded-lg text-xs font-bold text-white border border-slate-700/50 hover:border-emerald-500/30 transition-colors">MasterCard</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
