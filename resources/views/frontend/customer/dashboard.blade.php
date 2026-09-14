<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard - {{ config('app.name', 'PharmaSys') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
/* ─────────────────────────────────────────────
   CUSTOMER DASHBOARD  –  Premium Design
───────────────────────────────────────────── */

/* ---- Variables ---- */
:root {
    --primary:       #10b981;
    --primary-dark:  #059669;
    --primary-light: #d1fae5;
    --secondary:     #6366f1;
    --warning:       #f59e0b;
    --danger:        #ef4444;
    --info:          #06b6d4;
    --sidebar-bg:    #0f172a;
    --sidebar-width: 260px;
    --card-radius:   16px;
}

/* ---- Layout ---- */
.cd-wrapper {
    display: flex;
    min-height: 100vh;
    background: #f1f5f9;
}

/* ─── SIDEBAR ─────────────────────────────── */
.cd-sidebar {
    width: var(--sidebar-width);
    min-height: 100vh;
    background: var(--sidebar-bg);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    padding-top: 80px;
    transition: transform .3s ease;
}

.cd-sidebar-logo {
    padding: 0 24px 24px;
    border-bottom: 1px solid rgba(255,255,255,.08);
}
.cd-sidebar-logo .brand {
    display: flex;
    align-items: center;
    gap: 10px;
}
.cd-sidebar-logo .brand-icon {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 10px;
    display: grid;
    place-items: center;
    font-size: 18px;
}
.cd-sidebar-logo .brand-name {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: .3px;
}
.cd-sidebar-logo .brand-sub {
    color: #64748b;
    font-size: 11px;
    display: block;
}

/* User avatar in sidebar */
.cd-sidebar-user {
    margin: 20px 16px;
    padding: 16px;
    background: rgba(255,255,255,.05);
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.cd-sidebar-user .avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: grid;
    place-items: center;
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
}
.cd-sidebar-user .info strong {
    display: block;
    color: #f1f5f9;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
}
.cd-sidebar-user .info span {
    color: var(--primary);
    font-size: 11px;
    font-weight: 500;
}

/* Nav */
.cd-nav {
    padding: 8px 12px;
    flex: 1;
}
.cd-nav-label {
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 16px 12px 8px;
}
.cd-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 10px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 2px;
    transition: all .2s;
    position: relative;
}
.cd-nav-item:hover {
    background: rgba(255,255,255,.07);
    color: #f1f5f9;
    text-decoration: none;
}
.cd-nav-item.active {
    background: linear-gradient(135deg, rgba(16,185,129,.2), rgba(99,102,241,.15));
    color: var(--primary);
    font-weight: 600;
}
.cd-nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 60%;
    background: var(--primary);
    border-radius: 0 3px 3px 0;
}
.cd-nav-item .nav-icon {
    font-size: 18px;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}
.cd-nav-badge {
    margin-left: auto;
    background: var(--primary);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
}

/* Sidebar bottom */
.cd-sidebar-bottom {
    padding: 16px 12px;
    border-top: 1px solid rgba(255,255,255,.06);
}

/* ─── MAIN CONTENT ────────────────────────── */
.cd-main {
    margin-left: var(--sidebar-width);
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Top bar */
.cd-topbar {
    background: #fff;
    padding: 0 28px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 1px 3px rgba(0,0,0,.06);
}
.cd-topbar h1 {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.cd-topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
}
.cd-topbar-btn {
    width: 38px;
    height: 38px;
    background: #f1f5f9;
    border: none;
    border-radius: 10px;
    display: grid;
    place-items: center;
    cursor: pointer;
    font-size: 16px;
    color: #64748b;
    transition: all .2s;
    text-decoration: none;
}
.cd-topbar-btn:hover { background: var(--primary-light); color: var(--primary); }

.sidebar-toggle {
    display: none;
}

/* ─── PAGE BODY ───────────────────────────── */
.cd-body {
    padding: 28px;
    flex: 1;
}

/* Welcome banner */
.cd-welcome {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #065f46 100%);
    border-radius: var(--card-radius);
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow: hidden;
    position: relative;
}
.cd-welcome::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 220px; height: 220px;
    background: rgba(16,185,129,.15);
    border-radius: 50%;
}
.cd-welcome::after {
    content: '';
    position: absolute;
    bottom: -60px; right: 80px;
    width: 160px; height: 160px;
    background: rgba(99,102,241,.1);
    border-radius: 50%;
}
.cd-welcome h2 {
    color: #fff;
    font-size: 22px;
    font-weight: 700;
    margin: 0 0 6px;
}
.cd-welcome p {
    color: #94a3b8;
    font-size: 14px;
    margin: 0;
}
.cd-welcome-emoji {
    font-size: 56px;
    position: relative;
    z-index: 1;
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-8px); }
}

/* ─── STAT CARDS ───────────────────────────── */
.cd-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}
.cd-stat-card {
    background: #fff;
    border-radius: var(--card-radius);
    padding: 22px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .25s, box-shadow .25s;
    position: relative;
    overflow: hidden;
}
.cd-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0,0,0,.1);
}
.cd-stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--card-radius) var(--card-radius) 0 0;
}
.cd-stat-card.green::after  { background: linear-gradient(90deg, var(--primary), #34d399); }
.cd-stat-card.indigo::after { background: linear-gradient(90deg, var(--secondary), #818cf8); }
.cd-stat-card.amber::after  { background: linear-gradient(90deg, var(--warning), #fbbf24); }
.cd-stat-card.cyan::after   { background: linear-gradient(90deg, var(--info), #22d3ee); }

.cd-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: grid;
    place-items: center;
    font-size: 24px;
    flex-shrink: 0;
}
.cd-stat-card.green  .cd-stat-icon { background: #d1fae5; }
.cd-stat-card.indigo .cd-stat-icon { background: #e0e7ff; }
.cd-stat-card.amber  .cd-stat-icon { background: #fef3c7; }
.cd-stat-card.cyan   .cd-stat-icon { background: #cffafe; }

.cd-stat-info .label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.cd-stat-info .value {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    margin: 2px 0;
}
.cd-stat-info .sub {
    font-size: 12px;
    color: #64748b;
}

/* ─── GRID 2 COLS ─────────────────────────── */
.cd-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 28px;
}

/* ─── CARD ────────────────────────────────── */
.cd-card {
    background: #fff;
    border-radius: var(--card-radius);
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
}
.cd-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}
.cd-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.cd-card-badge {
    background: var(--primary-light);
    color: var(--primary-dark);
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

/* ─── RECENT ORDERS TABLE ──────────────────── */
.cd-orders-table {
    width: 100%;
    border-collapse: collapse;
}
.cd-orders-table th {
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .8px;
    padding: 0 12px 12px 0;
    border-bottom: 1px solid #f1f5f9;
    text-align: left;
}
.cd-orders-table td {
    padding: 13px 12px 13px 0;
    border-bottom: 1px solid #f8fafc;
    font-size: 13.5px;
    color: #334155;
    vertical-align: middle;
}
.cd-orders-table tr:last-child td { border-bottom: none; }

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
.status-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
}
.status-pending    { background: #fef3c7; color: #92400e; }
.status-pending::before    { background: var(--warning); }
.status-processing { background: #e0e7ff; color: #3730a3; }
.status-processing::before { background: var(--secondary); }
.status-shipped    { background: #cffafe; color: #164e63; }
.status-shipped::before    { background: var(--info); }
.status-delivered  { background: #d1fae5; color: #064e3b; }
.status-delivered::before  { background: var(--primary); }
.status-cancelled  { background: #fee2e2; color: #991b1b; }
.status-cancelled::before  { background: var(--danger); }

.cd-empty {
    text-align: center;
    padding: 40px 20px;
    color: #94a3b8;
}
.cd-empty-icon { font-size: 48px; margin-bottom: 8px; }

/* ─── QUICK ACTIONS ───────────────────────── */
.cd-actions {
    display: grid;
    gap: 10px;
}
.cd-action-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 12px;
    background: #f8fafc;
    text-decoration: none;
    color: #334155;
    transition: all .2s;
    font-size: 14px;
    font-weight: 500;
}
.cd-action-item:hover {
    background: var(--primary-light);
    color: var(--primary-dark);
    transform: translateX(4px);
    text-decoration: none;
}
.cd-action-item .ai {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #fff;
    display: grid;
    place-items: center;
    font-size: 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    flex-shrink: 0;
}
.cd-action-arrow {
    margin-left: auto;
    color: #cbd5e1;
    font-size: 16px;
    transition: transform .2s;
}
.cd-action-item:hover .cd-action-arrow {
    transform: translateX(4px);
    color: var(--primary);
}

/* ─── CHART FULL WIDTH ────────────────────── */
.cd-chart-wrap {
    margin-bottom: 28px;
}
.cd-chart-container {
    position: relative;
    height: 240px;
}

/* ─── RESPONSIVE ──────────────────────────── */
@media (max-width: 1024px) {
    .cd-grid-2 { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .cd-sidebar {
        transform: translateX(-100%);
    }
    .cd-sidebar.open {
        transform: translateX(0);
    }
    .cd-main {
        margin-left: 0;
    }
    .sidebar-toggle {
        display: grid;
    }
    .cd-body { padding: 16px; }
    .cd-stats { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
    .cd-stats { grid-template-columns: 1fr; }
}

/* ─── SIDEBAR OVERLAY (mobile) ───────────── */
.cd-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 999;
}
.cd-overlay.show { display: block; }
</style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body style="margin: 0; font-family: 'Inter', sans-serif;">

{{-- Mobile overlay --}}
<div class="cd-overlay" id="sidebarOverlay"></div>

<div class="cd-wrapper">

    {{-- ════════════════════════════════════════════
         SIDEBAR
    ════════════════════════════════════════════ --}}
    <aside class="cd-sidebar" id="cdSidebar">

        <div class="cd-sidebar-logo">
            <div class="brand">
                <div class="brand-icon">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div>
                    <div class="brand-name">PharmaSys</div>
                    <span class="brand-sub">Customer Portal</span>
                </div>
            </div>
        </div>

        <div class="cd-sidebar-user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="info">
                <strong>{{ Auth::user()->name }}</strong>
                <span style="display:flex; align-items:center; gap:4px;">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Customer
                </span>
            </div>
        </div>

        <nav class="cd-nav">
            <div class="cd-nav-label">Main Menu</div>
            <a href="{{ route('customer.dashboard') }}" class="cd-nav-item active">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></span> Dashboard
            </a>
            <a href="#" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg></span> My Orders
                @if($pendingOrders > 0)
                    <span class="cd-nav-badge">{{ $pendingOrders }}</span>
                @endif
            </a>
            <a href="{{ route('home') }}" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg></span> Shop Medicines
            </a>
            <a href="#" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></span> Wishlist
            </a>
            <a href="#" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></span> Prescriptions
            </a>

            <div class="cd-nav-label">Account</div>
            <a href="#" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span> Profile
            </a>
            <a href="#" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></span> Addresses
            </a>
            <a href="#" class="cd-nav-item">
                <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></span> Security
            </a>
        </nav>

        <div class="cd-sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="cd-nav-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">
                    <span class="nav-icon"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg></span> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ════════════════════════════════════════════
         MAIN CONTENT
    ════════════════════════════════════════════ --}}
    <div class="cd-main">

        {{-- Top Bar --}}
        <div class="cd-topbar">
            <div style="display:flex;align-items:center;gap:14px;">
                <button class="cd-topbar-btn sidebar-toggle" id="sidebarToggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1>Dashboard</h1>
            </div>
            <div class="cd-topbar-right">
                <a href="{{ route('home') }}" class="cd-topbar-btn" title="View Website" style="width:auto; padding:0 12px; font-size:14px; font-weight:600;">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    View Website
                </a>
                <a href="#" class="cd-topbar-btn" title="Notifications">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </a>
                <a href="#" class="cd-topbar-btn" title="Profile">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </a>
            </div>
        </div>

        {{-- Page Body --}}
        <div class="cd-body">

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
                        <a href="#" class="cd-card-badge" style="text-decoration:none;">View All →</a>
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
                        <a href="#" class="cd-action-item">
                            <div class="ai text-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Upload Prescription</div>
                                <div style="font-size:12px;color:#94a3b8;">Get prescription-based medicines</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="#" class="cd-action-item">
                            <div class="ai text-amber-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Track My Orders</div>
                                <div style="font-size:12px;color:#94a3b8;">Check delivery status</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="#" class="cd-action-item">
                            <div class="ai text-cyan-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <div style="font-weight:600;">Manage Addresses</div>
                                <div style="font-size:12px;color:#94a3b8;">Add or update delivery address</div>
                            </div>
                            <span class="cd-action-arrow">→</span>
                        </a>
                        <a href="#" class="cd-action-item">
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

        </div>{{-- /cd-body --}}
    </div>{{-- /cd-main --}}
</div>{{-- /cd-wrapper --}}

</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar Mobile Toggle ──────────────────────
    const sidebar = document.getElementById('cdSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle  = document.getElementById('sidebarToggle');

    if (toggle) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    // ── Counter Animation ─────────────────────────
    function animateNum(el, target, prefix = '') {
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

    animateNum(document.getElementById('cnt-orders'),    {{ $totalOrders }});
    animateNum(document.getElementById('cnt-spent'),     {{ round($totalSpent) }});
    animateNum(document.getElementById('cnt-pending'),   {{ $pendingOrders }});
    animateNum(document.getElementById('cnt-delivered'), {{ $deliveredOrders }});

    // ── Monthly Spending Chart ─────────────────────
    const labels  = @json($labels);
    const amounts = @json($amounts);

    const ctx = document.getElementById('spendingChart').getContext('2d');

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
});
</script>
