<nav class="bg-teal-700 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-12">
            <div class="flex space-x-6 items-center">
                <!-- Categories Dropdown Button -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 bg-teal-800 px-4 py-3 font-semibold hover:bg-teal-900 transition h-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <span>All Categories</span>
                    </button>
                    <!-- Mega Menu Placeholder (hidden by default) -->
                    <div class="absolute left-0 top-full w-64 bg-white border border-slate-200 shadow-xl text-slate-800 hidden group-hover:block transition z-50">
                        <a href="#" class="block px-4 py-3 hover:bg-teal-50 hover:text-teal-600 border-b border-slate-100">Prescription Medicines</a>
                        <a href="#" class="block px-4 py-3 hover:bg-teal-50 hover:text-teal-600 border-b border-slate-100">Over The Counter (OTC)</a>
                        <a href="#" class="block px-4 py-3 hover:bg-teal-50 hover:text-teal-600 border-b border-slate-100">Vitamins & Supplements</a>
                        <a href="#" class="block px-4 py-3 hover:bg-teal-50 hover:text-teal-600 border-b border-slate-100">Baby Care</a>
                        <a href="#" class="block px-4 py-3 hover:bg-teal-50 hover:text-teal-600">Personal Care</a>
                    </div>
                </div>

                <!-- Main Nav Links -->
                <div class="hidden md:flex space-x-8 items-center h-full">
                    <a href="{{ route('home') }}" class="font-medium hover:text-teal-200 transition">Home</a>
                    <a href="#" class="font-medium hover:text-teal-200 transition">Products</a>
                    <a href="#" class="font-medium hover:text-teal-200 transition text-yellow-300">Flash Sale</a>
                    <a href="#" class="font-medium hover:text-teal-200 transition">Brands</a>
                    <a href="#" class="font-medium hover:text-teal-200 transition">Generics</a>
                </div>
            </div>
            
            <!-- Upload Prescription CTA -->
            <div class="hidden lg:flex items-center">
                <a href="#" class="flex items-center space-x-2 bg-rose-500 hover:bg-rose-600 px-4 py-1.5 rounded-full font-medium text-sm transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span>Upload Prescription</span>
                </a>
            </div>
        </div>
    </div>
</nav>
