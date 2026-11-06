<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Center | Primegloboptions Bank</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #090d16;
            --secondary-color: #0f172a;
            --accent-color: #C9A227;
            --light-color: #f8fafc;
            --dark-color: #041f23;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #C9A227;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* ── Sidebar ─────────────────────────────────────────────── */
        .sidebar {
            background-color: var(--primary-color);
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s ease;
            z-index: 1000;
            left: 0;
            top: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.25rem 1rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,.08);
            position: sticky;
            top: 0;
            background-color: var(--primary-color);
            z-index: 10;
            flex-shrink: 0;
        }

        .sidebar-brand img { height: 32px; }

        /* Nav sections */
        .sidebar-section-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
            padding: .75rem 1.5rem .25rem;
            margin-top: .25rem;
        }

        .sidebar-nav {
            padding: .5rem 0 1rem;
            flex: 1;
        }

        .nav-link {
            color: rgba(255,255,255,.75);
            padding: .6rem 1.5rem;
            margin: .1rem .75rem;
            border-radius: 7px;
            display: flex;
            align-items: center;
            transition: background .2s, color .2s;
            white-space: nowrap;
            font-size: .85rem;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(255,255,255,.1);
            color: white;
            text-decoration: none;
        }

        .nav-link.active {
            background-color: rgba(201,162,39,.18);
            color: #C9A227;
            border-left: 3px solid #C9A227;
            margin-left: calc(.75rem - 3px);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .nav-link .badge {
            margin-left: auto;
            font-size: .65rem;
            padding: .2em .5em;
        }

        /* Collapsible sub-menu */
        .nav-collapse .nav-link {
            padding-left: 3rem;
            font-size: .8rem;
            color: rgba(255,255,255,.6);
        }
        .nav-collapse .nav-link:hover { color: white; }

        .nav-collapse-toggle {
            position: relative;
        }
        .nav-collapse-toggle::after {
            content: "\f107";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: 1.2rem;
            transition: transform .2s;
        }
        .nav-collapse-toggle.collapsed::after {
            transform: rotate(-90deg);
        }

        /* Sidebar footer */
        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,.08);
            padding: .85rem 1rem;
            flex-shrink: 0;
        }

        /* ── Main content ─────────────────────────────────────────── */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* ── Overlay / toggle (mobile) ───────────────────────────── */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0,0,0,.5);
            z-index: 999;
            display: none;
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0,0,0,.25);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* ── Cards ───────────────────────────────────────────────── */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,.05);
            margin-bottom: 24px;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,.05);
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
        }

        /* ── Tables ──────────────────────────────────────────────── */
        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: .75rem;
            letter-spacing: 1px;
            padding: 15px;
        }

        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }

        .table tr:hover { background-color: rgba(0,0,0,.02); }

        /* ── Scrollbar ───────────────────────────────────────────── */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,.05); }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 2px; }

        /* ── Responsive ──────────────────────────────────────────── */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,.3);
            }
            .main-content {
                margin-left: 0 !important;
                padding-top: 70px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                width: 100% !important;
            }
            .sidebar-toggle { display: flex !important; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>

<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar Toggle (Mobile) -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

<!-- ── Sidebar ──────────────────────────────────────────────────────── -->
<div class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <img src="{{ asset('logo.png') }}" alt="Logo">
    </div>

    <nav class="sidebar-nav">

        {{-- Overview --}}
        <div class="sidebar-section-label">Overview</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        {{-- User Management --}}
        <div class="sidebar-section-label">Users</div>

        <a href="{{ route('admin.users') }}"
           class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Manage Users
        </a>

        {{-- <a href="{{ route('admin.credit.user') }}"
           class="nav-link {{ request()->routeIs('admin.credit.user') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Credit User
        </a>

        <a href="{{ route('admin.debit.user') }}"
           class="nav-link {{ request()->routeIs('admin.debit.user') ? 'active' : '' }}">
            <i class="fas fa-minus-circle"></i> Debit User
        </a> --}}

        {{-- Transactions --}}
        <div class="sidebar-section-label">Transactions</div>

        <a href="{{ route('admin.deposits') }}"
           class="nav-link {{ request()->routeIs('admin.deposits') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> Deposits
        </a>

        <a href="{{ route('admin.transfers') }}"
           class="nav-link {{ request()->routeIs('admin.transfers') ? 'active' : '' }}">
            <i class="fas fa-paper-plane"></i> Wire Transfers
        </a>

        {{-- <a href="{{ route('admin.withdrawals') }}"
           class="nav-link {{ request()->routeIs('admin.withdrawals') ? 'active' : '' }}">
            <i class="fas fa-arrow-circle-up"></i> Withdrawals
        </a> --}}

        <a href="{{ route('admin.transactions') }}"
           class="nav-link {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
            <i class="fas fa-exchange-alt"></i> Transactions
        </a>

        {{-- Finance --}}
        <div class="sidebar-section-label">Finance</div>

        <a href="{{ route('admin.loans') }}"
           class="nav-link {{ request()->routeIs('admin.loans') ? 'active' : '' }}">
            <i class="fas fa-hand-holding-usd"></i> Loans
        </a>

        <a href="{{ route('admin.investments') }}"
           class="nav-link {{ request()->routeIs('admin.investments') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Investments
        </a>

        <a href="{{ route('admin.cards') }}"
           class="nav-link {{ request()->routeIs('admin.cards') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Cards
        </a>

        {{-- Settings --}}
        <div class="sidebar-section-label">Settings</div>

        {{-- <a href="{{ route('admin.wallets.index') }}"
           class="nav-link {{ request()->routeIs('admin.wallets.index') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i> Payment Methods
        </a> --}}

        <a href="{{ route('admin.mail.history') }}"
           class="nav-link {{ request()->routeIs('admin.mail.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Send Mail
        </a>

    </nav>

    {{-- Sidebar Footer: Admin info + logout --}}
    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center fw-bold text-dark"
                 style="width:34px;height:34px;flex-shrink:0;font-size:.8rem;">
                {{ strtoupper(substr(Auth::guard('admin')->user()->email ?? 'A', 0, 1)) }}
            </div>
            <div style="overflow:hidden;">
                <div class="text-white fw-semibold small" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ Auth::guard('admin')->user()->email ?? 'Admin' }}
                </div>
                <div style="font-size:.65rem;color:rgba(255,255,255,.45);">Administrator</div>
            </div>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST" class="d-grid">
            @csrf
            <button type="submit" class="btn btn-sm rounded-2 fw-semibold"
                    style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.75);border:1px solid rgba(255,255,255,.1);">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </button>
        </form>
    </div>
</div>
{{-- End Sidebar --}}
