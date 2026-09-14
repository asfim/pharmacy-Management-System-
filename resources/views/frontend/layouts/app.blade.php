<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="PharmaSys — Your trusted digital pharmacy. Order genuine medicines online with fast delivery across Bangladesh.">

    <title>{{ config('app.name', 'PharmaSys — Online Pharmacy') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E💊%3C/text%3E%3C/svg%3E">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts (Tailwind + App) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased text-slate-800 bg-white overflow-x-hidden">
    
    <!-- Top Announcement & Header -->
    @include('frontend.layouts.header')

    <!-- Main Navigation -->
    @include('frontend.layouts.navbar')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top w-12 h-12 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 flex items-center justify-center" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
    </button>

    <!-- Scroll Reveal & Back to Top Script -->
    <script>
        // Back to Top
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        // Intersection Observer for scroll reveals
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
            observer.observe(el);
        });

        // Counter Animation
        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'));
            const suffix = el.getAttribute('data-suffix') || '';
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = Math.floor(current) + suffix;
            }, 16);
        }

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('[data-counter]').forEach(el => {
            counterObserver.observe(el);
        });

        // Add to Cart (AJAX)
        function addToCart(productId, quantity = 1, btnEl = null) {
            if (btnEl) {
                btnEl.disabled = true;
                btnEl.style.opacity = '0.7';
            }

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if (btnEl) {
                    btnEl.disabled = false;
                    btnEl.style.opacity = '1';
                }
                if (data.success) {
                    const badge = document.getElementById('cartCountBadge');
                    if (badge) {
                        badge.textContent = data.totalItems;
                        badge.classList.remove('hidden');
                        badge.classList.remove('animate-pulse-badge');
                        void badge.offsetWidth;
                        badge.classList.add('animate-pulse-badge');
                    }
                    
                    // Update mini cart HTML
                    const miniCartItems = document.getElementById('miniCartItems');
                    if (miniCartItems && data.miniCartHtml) {
                        miniCartItems.innerHTML = data.miniCartHtml;
                    }

                    // Update Subtotal and Footer
                    const subtotalEl = document.getElementById('miniCartSubtotal');
                    if (subtotalEl && data.subtotal !== undefined) {
                        subtotalEl.textContent = '৳' + Number(data.subtotal).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }
                    const miniCartFooter = document.getElementById('miniCartFooter');
                    if (miniCartFooter) {
                        miniCartFooter.style.display = 'block';
                    }

                    showToast(data.message, 'success');
                } else {
                    showToast('Failed to add product to cart.', 'error');
                }
            })
            .catch(err => {
                if (btnEl) {
                    btnEl.disabled = false;
                    btnEl.style.opacity = '1';
                }
                console.error(err);
                showToast('Something went wrong!', 'error');
            });
        }

        // Buy Now (Direct checkout without affecting main cart)
        function buyNow(productId) {
            const qtyEl = document.getElementById('qty');
            const qty = qtyEl ? qtyEl.value : 1;
            window.location.href = `{{ route("checkout") }}?buy_now_id=${productId}&qty=${qty}`;
        }

        // Remove from Cart
        function removeFromCart(productId, btnEl) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Remove from DOM
                    if (btnEl) {
                        btnEl.closest('.cart-item-row').remove();
                    }
                    
                    // Update badge
                    const badge = document.getElementById('cartCountBadge');
                    if (badge) {
                        badge.textContent = data.totalItems;
                        if (data.totalItems == 0) badge.classList.add('hidden');
                    }

                    // Update Subtotal
                    const subtotalEl = document.getElementById('miniCartSubtotal');
                    if (subtotalEl) {
                        subtotalEl.textContent = '৳' + Number(data.subtotal).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    }

                    // If empty, show empty message
                    if (data.totalItems == 0) {
                        const miniCartItems = document.getElementById('miniCartItems');
                        if (miniCartItems) {
                            miniCartItems.innerHTML = `
                                <div class="text-center py-6 text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p class="text-sm">Your cart is empty.</p>
                                </div>
                            `;
                        }
                        const miniCartFooter = document.getElementById('miniCartFooter');
                        if (miniCartFooter) miniCartFooter.style.display = 'none';
                    }

                    showToast('Item removed', 'success');
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Error removing item', 'error');
            });
        }

        // Custom Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-5 right-5 px-6 py-3 rounded-xl shadow-2xl text-white font-semibold z-50 transform transition-all duration-300 translate-y-10 opacity-0 ${type === 'success' ? 'bg-emerald-600' : 'bg-red-500'}`;
            toast.style.display = 'flex';
            toast.style.alignItems = 'center';
            toast.style.gap = '10px';
            
            toast.innerHTML = type === 'success' 
                ? `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${message}`
                : `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${message}`;

            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            }, 100);

            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

    @stack('scripts')
</body>
</html>
