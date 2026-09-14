@extends('frontend.layouts.customer')

@section('content')
            {{-- Welcome Banner --}}
            <div class="cd-welcome">
                <div>
                    <h2>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! <svg class="w-6 h-6 inline-block pb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></h2>
                    <p>Here's a quick summary of your pharmacy activity today, {{ now()->format('d M Y') }}.</p>
                </div>
                <div class="cd-welcome-emoji">
                    <svg class="w-16 h-16 text-emerald-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="cd-stats">
                <div class="cd-stat-card green">
                    <div class="cd-stat-icon text-emerald-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="cd-stat-info">
                        <div class="label">Total Orders</div>
                        <div class="value" id="cnt-orders">0</div>
                        <div class="sub">All time</div>
                    </div>
                </div>
                <div class="cd-stat-card indigo">
                    <div class="cd-stat-icon text-indigo-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="cd-stat-info">
                        <div class="label">Total Spent</div>
                        <div class="value">৳<span id="cnt-spent">0</span></div>
                        <div class="sub">Lifetime</div>
                    </div>
                </div>
                <div class="cd-stat-card amber">
                    <div class="cd-stat-icon text-amber-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="cd-stat-info">
                        <div class="label">Pending Orders</div>
                        <div class="value" id="cnt-pending">0</div>
                        <div class="sub">Awaiting processing</div>
                    </div>
                </div>
                <div class="cd-stat-card cyan">
                    <div class="cd-stat-icon text-cyan-600">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="cd-stat-info">
                        <div class="label">Delivered</div>
                        <div class="value" id="cnt-delivered">0</div>
                        <div class="sub">Completed orders</div>
                    </div>
                </div>
            </div>

            {{-- Spending Chart --}}
            <div class="cd-card cd-chart-wrap">
                <div class="cd-card-header">
                    <h3 class="cd-card-title flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        Monthly Spending (Last 6 Months)
                    </h3>
                    <span class="cd-card-badge">৳ BDT</span>
                </div>
                <div class="cd-chart-container">
                    <canvas id="spendingChart"></canvas>
                </div>
            </div>

            {{-- Two Column Grid --}}
            <div class="cd-grid-2">

                {{-- Recent Orders --}}
                <div class="cd-card">
                    <div class="cd-card-header">
                        <h3 class="cd-card-title flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Recent Orders
                        </h3>
                        <a href="{{ route('customer.orders') }}" class="cd-card-badge" style="text-decoration:none;">View All →</a>
                    </div>

                    @if($recentOrders->count() > 0)
                        <table class="cd-orders-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td><strong>{{ $order->order_no }}</strong></td>
                                    <td><strong>৳{{ number_format($order->total, 0) }}</strong></td>
                                    <td>
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="cd-empty">
                            <div class="cd-empty-icon flex justify-center text-slate-300 mb-4">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <p>No orders yet. <a href="{{ route('home') }}" style="color: var(--primary)">Start shopping!</a></p>
                        </div>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="cd-card">
                    <div class="cd-card-header">
                        <h3 class="cd-card-title flex items-center gap-2">
                            <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="cd-actions">
                        <a href="{{ route('home') }}" class="cd-action-item">
                            <div class="ai text-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Browse Medicines</div>
                                <div style="font-size:12px;color:#94a3b8;">Shop from our full catalogue</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="{{ route('customer.prescriptions') }}" class="cd-action-item">
                            <div class="ai text-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Upload Prescription</div>
                                <div style="font-size:12px;color:#94a3b8;">Get prescription-based medicines</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="{{ route('customer.orders') }}" class="cd-action-item">
                            <div class="ai text-amber-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Track My Orders</div>
                                <div style="font-size:12px;color:#94a3b8;">Check delivery status</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="{{ route('customer.addresses') }}" class="cd-action-item">
                            <div class="ai text-cyan-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Manage Addresses</div>
                                <div style="font-size:12px;color:#94a3b8;">Add or update delivery address</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="{{ route('customer.profile') }}" class="cd-action-item">
                            <div class="ai text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Edit Profile</div>
                                <div style="font-size:12px;color:#94a3b8;">Update your information</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                    </div>
                </div>

            </div>{{-- /cd-grid-2 --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Counter Animation ─────────────────────────
    function animateNum(el, target, prefix = '') {
        if(!el) return;
        const duration = 1500;
        const start    = performance.now();
        const isFloat  = target % 1 !== 0;
        const step = (now) => {
            const pct = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - pct, 3);
            const val  = ease * target;
            el.textContent = isFloat
                ? Number(val.toFixed(0)).toLocaleString('en-BD')
                : Math.floor(val).toLocaleString('en-BD');
            if (pct < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    }

    animateNum(document.getElementById('cnt-orders'),    {{ $totalOrders ?? 0 }});
    animateNum(document.getElementById('cnt-spent'),     {{ round($totalSpent ?? 0) }});
    animateNum(document.getElementById('cnt-pending'),   {{ $pendingOrders ?? 0 }});
    animateNum(document.getElementById('cnt-delivered'), {{ $deliveredOrders ?? 0 }});

    // ── Monthly Spending Chart ─────────────────────
    const labels  = @json($labels ?? []);
    const amounts = @json($amounts ?? []);

    const chartEl = document.getElementById('spendingChart');
    if (chartEl) {
        const ctx = chartEl.getContext('2d');

        const grad = ctx.createLinearGradient(0, 0, 0, 240);
        grad.addColorStop(0,   'rgba(16,185,129,.35)');
        grad.addColorStop(1,   'rgba(16,185,129,.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Spending (৳)',
                    data: amounts,
                    borderColor: '#10b981',
                    backgroundColor: grad,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: .42,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#94a3b8',
                        bodyColor: '#fff',
                        padding: 12,
                        callbacks: {
                            label: ctx => ' ৳' + Number(ctx.parsed.y).toLocaleString('en-BD')
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8', font: { size: 12 } }
                    },
                    y: {
                        grid: { color: '#f1f5f9', lineWidth: 1 },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 12 },
                            callback: v => '৳' + Number(v).toLocaleString('en-BD')
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endpush
