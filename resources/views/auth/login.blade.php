<x-guest-layout>
<div class="min-h-screen flex relative overflow-hidden">

    <!-- ============================================
         LEFT SIDE — Branding Panel (Desktop Only)
         ============================================ -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 items-center justify-center p-12 overflow-hidden" style="background-size: 200% 200%; animation: gradient-shift 6s ease infinite;">
        <!-- Background Decorations -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <!-- Blobs -->
            <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl" style="animation: blob 8s ease-in-out infinite;"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-400/20 rounded-full blur-3xl" style="animation: blob 10s ease-in-out infinite 2s;"></div>
            <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-teal-300/15 rounded-full blur-3xl" style="animation: blob 12s ease-in-out infinite 4s;"></div>
            
            <!-- Floating icons -->
            <div class="absolute top-20 right-[20%] text-5xl opacity-20" style="animation: float 6s ease-in-out infinite;">💊</div>
            <div class="absolute top-[40%] right-[10%] text-4xl opacity-15" style="animation: float 8s ease-in-out infinite 1s;">🩺</div>
            <div class="absolute bottom-32 left-[15%] text-5xl opacity-20" style="animation: float 7s ease-in-out infinite 0.5s;">🧬</div>
            <div class="absolute top-28 left-[25%] text-3xl opacity-15" style="animation: float 9s ease-in-out infinite 2s;">🩹</div>
            <div class="absolute bottom-20 right-[30%] text-4xl opacity-15" style="animation: float 8s ease-in-out infinite 3s;">💉</div>

            <!-- Grid pattern -->
            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 max-w-md text-white">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 mb-10 group">
                <div class="w-14 h-14 bg-white/15 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-xl border border-white/20 group-hover:bg-white/25 transition-all duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div>
                    <span class="text-3xl font-extrabold tracking-tight">PHARMA<span class="text-emerald-200">SYS</span></span>
                    <p class="text-xs text-emerald-200/60 font-medium tracking-widest uppercase -mt-0.5">Online Pharmacy</p>
                </div>
            </a>

            <h1 class="text-4xl font-extrabold leading-tight mb-4" style="animation: slide-in-up 0.6s ease-out;">
                Welcome to Your <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 via-white to-cyan-200">Trusted Pharmacy</span>
            </h1>
            
            <p class="text-emerald-100/80 text-lg leading-relaxed mb-10" style="animation: slide-in-up 0.6s ease-out 0.1s both;">
                Access your account to manage orders, track deliveries, upload prescriptions, and explore 10,000+ genuine medicines.
            </p>

            <!-- Feature points -->
            <div class="space-y-5" style="animation: slide-in-up 0.6s ease-out 0.2s both;">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/10 shrink-0">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <span class="text-white font-semibold text-sm">100% Genuine Medicines</span>
                        <p class="text-emerald-200/50 text-xs">Certified & government approved</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/10 shrink-0">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <span class="text-white font-semibold text-sm">Fast 24h Delivery</span>
                        <p class="text-emerald-200/50 text-xs">Same-day in Dhaka city</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/10 shrink-0">
                        <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <span class="text-white font-semibold text-sm">Secure & Encrypted</span>
                        <p class="text-emerald-200/50 text-xs">Your data is always protected</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="flex space-x-8 mt-12 pt-8 border-t border-white/10" style="animation: slide-in-up 0.6s ease-out 0.3s both;">
                <div>
                    <div class="text-2xl font-extrabold">50K+</div>
                    <div class="text-emerald-200/50 text-xs font-medium">Customers</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold">10K+</div>
                    <div class="text-emerald-200/50 text-xs font-medium">Products</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold">30+</div>
                    <div class="text-emerald-200/50 text-xs font-medium">Branches</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         RIGHT SIDE — Login Form
         ============================================ -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-slate-50 relative">
        <!-- Background subtle pattern -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle at 1px 1px, #059669 1px, transparent 0); background-size: 30px 30px;"></div>

        <div class="w-full max-w-md relative z-10">
            
            <!-- Mobile Logo (hidden on desktop) -->
            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight">
                        <span class="text-emerald-600">PHARMA</span><span class="text-slate-800">SYS</span>
                    </span>
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Sign in to your account</h2>
                <p class="text-slate-500">Enter your credentials to access the dashboard</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form Card -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-2xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/10 transition-all duration-300 placeholder:text-slate-400"
                                placeholder="you@example.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full pl-12 pr-12 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-2xl text-sm focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/10 transition-all duration-300 placeholder:text-slate-400"
                                placeholder="Enter your password">
                            <!-- Toggle Password Visibility -->
                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-500 transition-colors" onclick="togglePassword()">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="w-4 h-4 rounded-md border-2 border-slate-300 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-0 transition cursor-pointer">
                            <span class="ml-2.5 text-sm text-slate-600 group-hover:text-slate-800 transition select-none">Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="loginBtn"
                        class="w-full py-3.5 px-6 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 text-sm flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        <span>Sign In</span>
                    </button>
                </form>
            </div>

            <!-- Register Link -->
            <div class="text-center mt-8">
                <p class="text-slate-500 text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-emerald-600 hover:text-emerald-700 transition ml-1">
                        Create Account →
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 pt-6 border-t border-slate-200/60">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} PharmaSys. All rights reserved.
                </p>
                <div class="flex justify-center space-x-4 mt-2">
                    <a href="#" class="text-xs text-slate-400 hover:text-emerald-500 transition">Privacy Policy</a>
                    <span class="text-slate-300">·</span>
                    <a href="#" class="text-xs text-slate-400 hover:text-emerald-500 transition">Terms of Service</a>
                    <span class="text-slate-300">·</span>
                    <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-emerald-500 transition">← Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Password Script -->
<script>
    function togglePassword() {
        const pwInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');
        
        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            pwInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }
</script>
</x-guest-layout>
