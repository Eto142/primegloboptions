<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PGO Invest — Investment Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A227;
            --gold-light: #E8C14A;
            --gold-dark: #9E7C14;
            --dark: #060b18;
            --dark2: #0d1525;
            --dark3: #111c30;
            --card-bg: #0f1d35;
            --border: rgba(201,162,39,0.15);
            --text-muted: #6b7fa3;
            --success: #00d395;
            --danger: #ff4d6a;
            --radius: 16px;
            --sidebar-w: 260px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark);
            color: #e2e8f0;
            min-height: 100vh;
            overflow-x: hidden;
            margin: 0;
        }
        a { text-decoration: none; transition: var(--transition); }

        /* ── SIDEBAR ─────────────────────────────── */
        .ib-sidebar {
            position: fixed; left: 0; top: 0; width: var(--sidebar-w); height: 100vh;
            background: var(--dark2); border-right: 1px solid var(--border);
            display: flex; flex-direction: column; z-index: 1060;
            transition: var(--transition);
        }
        .ib-sidebar-header {
            padding: 18px 22px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; min-height: 68px;
        }
        .ib-sidebar-header .brand { display: flex; align-items: center; gap: 10px; }
        .ib-sidebar-header .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff; font-weight: 800;
        }
        .ib-sidebar-header .brand-name { font-weight: 800; font-size: 1.05rem; color: #fff; letter-spacing: -0.3px; }
        .ib-sidebar-header .brand-name span { color: var(--gold); }

        .ib-sidebar-user {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 12px;
        }
        .ib-sidebar-user img, .ib-sidebar-user .avatar-placeholder {
            width: 42px; height: 42px; border-radius: 50%; object-fit: cover;
            border: 2px solid var(--gold); flex-shrink: 0;
        }
        .ib-sidebar-user .avatar-placeholder {
            background: rgba(201,162,39,0.12); display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 1.1rem;
        }
        .ib-sidebar-user .user-name { font-weight: 700; color: #fff; font-size: 0.85rem; }
        .ib-sidebar-user .user-email { font-size: 0.72rem; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 160px; }

        .ib-sidebar-menu { flex: 1; padding: 12px 10px; overflow-y: auto; }
        .ib-sidebar-section { font-size: 0.66rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.2px; color: #475569; padding: 14px 14px 6px; list-style: none; }
        .ib-nav-link {
            display: flex; align-items: center; gap: 12px; padding: 10px 14px; margin: 2px 0;
            border-radius: 10px; color: #94a3b8; font-weight: 600; font-size: 0.85rem;
            transition: all 0.2s ease; position: relative;
        }
        .ib-nav-link i { width: 20px; text-align: center; font-size: 0.95rem; }
        .ib-nav-link:hover { color: var(--gold); background: rgba(201,162,39,0.06); transform: translateX(2px); }
        .ib-nav-link.active {
            color: var(--gold); background: linear-gradient(135deg, rgba(201,162,39,0.12), rgba(158,124,20,0.06));
            border: 1px solid rgba(201,162,39,0.2);
        }
        .ib-nav-link.active::before {
            content: ''; position: absolute; left: -10px; top: 20%; height: 60%; width: 3px;
            background: var(--gold); border-radius: 0 3px 3px 0;
        }
        .ib-nav-link.logout { color: var(--danger); }
        .ib-nav-link.logout:hover { background: rgba(255,77,106,0.06); color: var(--danger); }
        .ib-nav-link .badge-kyc { font-size: 0.58rem; font-weight: 700; padding: 2px 6px; border-radius: 10px; margin-left: auto; }
        .badge-kyc.verified { background: rgba(0,211,149,0.15); color: var(--success); }
        .badge-kyc.pending { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .badge-kyc.rejected { background: rgba(255,77,106,0.15); color: var(--danger); }

        /* ── MAIN AREA ───────────────────────────── */
        .ib-main { margin-left: var(--sidebar-w); transition: var(--transition); min-height: 100vh; }

        /* ── TOP NAV ─────────────────────────────── */
        .ib-topnav {
            height: 68px; background: rgba(6,11,24,0.95); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border); padding: 0 28px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 1040;
        }
        .ib-topnav-toggle {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            color: #94a3b8; border-radius: 10px; width: 42px; height: 42px;
            display: none; align-items: center; justify-content: center; cursor: pointer;
        }
        .ib-topnav-toggle:hover { background: rgba(255,255,255,0.1); color: #e2e8f0; }
        .ib-balance-pill {
            background: rgba(201,162,39,0.1); border: 1px solid var(--border);
            border-radius: 30px; padding: 6px 16px; font-size: 0.83rem;
            font-weight: 700; font-family: 'JetBrains Mono', monospace; color: var(--gold);
        }
        .ib-topnav-right { display: flex; align-items: center; gap: 12px; }
        .ib-back-btn {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            color: #94a3b8; border-radius: 10px; padding: 7px 14px; font-size: 0.82rem;
            font-weight: 600; display: flex; align-items: center; gap: 6px; transition: var(--transition);
        }
        .ib-back-btn:hover { background: rgba(255,255,255,0.1); color: #e2e8f0; }
        .ib-notification-toggle {
            position: relative; width: 42px; height: 42px; display: flex; align-items: center;
            justify-content: center; background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1); border-radius: 10px;
            color: #94a3b8; font-size: 1rem; transition: var(--transition);
        }
        .ib-notification-toggle:hover, .ib-notification-toggle[aria-expanded="true"] {
            background: rgba(201,162,39,0.1); border-color: var(--border); color: var(--gold);
        }
        .ib-notification-count {
            position: absolute; top: -5px; right: -5px; min-width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center; padding: 0 4px;
            background: var(--danger); border: 2px solid var(--dark); border-radius: 10px;
            color: #fff; font-size: 0.62rem; font-weight: 800; line-height: 1;
        }
        .ib-notification-menu {
            width: min(360px, calc(100vw - 32px)); padding: 0; overflow: hidden;
            background: var(--dark2); border: 1px solid var(--border); border-radius: 14px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.4);
        }
        .ib-notification-menu-head, .ib-notification-menu-foot { padding: 14px 16px; }
        .ib-notification-menu-head { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); }
        .ib-notification-menu-title { color: #fff; font-size: 0.88rem; font-weight: 800; }
        .ib-notification-menu-count { color: var(--gold); font-size: 0.72rem; font-weight: 700; }
        .ib-notification-list { max-height: 340px; overflow-y: auto; }
        .ib-notification-item {
            display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.05); color: #e2e8f0;
        }
        .ib-notification-item:last-child { border-bottom: 0; }
        .ib-notification-item:hover { background: rgba(201,162,39,0.06); color: #fff; }
        .ib-notification-item.unread { background: rgba(201,162,39,0.04); }
        .ib-notification-icon {
            width: 34px; height: 34px; display: flex; flex: 0 0 34px; align-items: center;
            justify-content: center; border-radius: 10px; background: rgba(201,162,39,0.1);
            color: var(--gold); font-size: 0.82rem;
        }
        .ib-notification-message { color: #e2e8f0; font-size: 0.78rem; line-height: 1.5; overflow-wrap: anywhere; }
        .ib-notification-time { margin-top: 4px; color: var(--text-muted); font-size: 0.68rem; }
        .ib-notification-empty { padding: 30px 16px; color: var(--text-muted); text-align: center; font-size: 0.8rem; }
        .ib-notification-menu-foot { display: flex; align-items: center; justify-content: space-between; gap: 10px; border-top: 1px solid var(--border); }
        .ib-notification-menu-foot a, .ib-notification-menu-foot button {
            padding: 0; border: 0; background: transparent; color: var(--gold);
            font-size: 0.74rem; font-weight: 700; white-space: nowrap;
        }
        .ib-notification-menu-foot a:hover, .ib-notification-menu-foot button:hover { color: var(--gold-light); }
        @media (max-width: 575px) {
            .ib-topnav { padding: 0 12px; gap: 8px; }
            .ib-topnav-right { gap: 7px; }
            .ib-balance-pill { padding: 6px 9px; font-size: 0.72rem; }
            .ib-back-btn { padding: 7px 10px; }
        }

        /* ── TICKER ──────────────────────────────── */
        .ticker-bar {
            background: var(--dark2); border-bottom: 1px solid var(--border);
            padding: 8px 28px; display: flex; gap: 32px; overflow: hidden; white-space: nowrap;
        }
        .ticker-item { display: inline-flex; align-items: center; gap: 8px; font-size: 0.8rem; font-family: 'JetBrains Mono', monospace; flex-shrink: 0; }
        .ticker-item .sym { color: #94a3b8; font-weight: 600; }
        .ticker-item .val { color: #e2e8f0; font-weight: 700; }
        .ticker-item .chg-up { color: var(--success); }
        .ticker-item .chg-down { color: var(--danger); }

        /* ── CONTENT ─────────────────────────────── */
        .ib-content { padding: 28px; }

        /* ── SHARED COMPONENTS ───────────────────── */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px; }
        .stat-card {
            background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 20px; position: relative; overflow: hidden; transition: var(--transition);
        }
        .stat-card::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, var(--gold-dark), var(--gold-light)); opacity: 0; transition: var(--transition); }
        .stat-card:hover { transform: translateY(-2px); border-color: rgba(201,162,39,0.3); }
        .stat-card:hover::after { opacity: 1; }
        .stat-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 10px; }
        .stat-value { font-size: 1.5rem; font-weight: 800; font-family: 'JetBrains Mono', monospace; color: #fff; margin-bottom: 6px; }
        .stat-value.green { color: var(--success); }
        .stat-change { font-size: 0.78rem; font-weight: 600; display: flex; align-items: center; gap: 4px; }
        .stat-change.up { color: var(--success); }
        .stat-change.down { color: var(--danger); }
        .stat-change.neutral { color: var(--text-muted); }

        .section-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .section-title { font-size: 1rem; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px; }
        .section-title i { color: var(--gold); font-size: 0.95rem; }

        .ib-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; margin-bottom: 20px; }
        .ib-card-title { font-weight: 800; color: #fff; font-size: 0.95rem; margin-bottom: 16px; }

        .ib-table { width: 100%; border-collapse: collapse; }
        .ib-table th { text-align: left; padding: 12px 16px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        .ib-table td { padding: 14px 16px; font-size: 0.84rem; color: #e2e8f0; border-bottom: 1px solid rgba(255,255,255,0.04); }
        .ib-table tr:last-child td { border-bottom: none; }
        .ib-table tr:hover td { background: rgba(201,162,39,0.03); }

        .badge-gold { background: rgba(201,162,39,0.12); color: var(--gold); font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .badge-green { background: rgba(0,211,149,0.12); color: var(--success); font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .badge-red { background: rgba(255,77,106,0.12); color: var(--danger); font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
        .badge-yellow { background: rgba(245,158,11,0.12); color: #fbbf24; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

        .btn-gold { background: linear-gradient(135deg, var(--gold-dark), var(--gold-light)); border: none; color: #fff; font-weight: 700; padding: 10px 24px; border-radius: 10px; transition: var(--transition); cursor: pointer; }
        .btn-gold:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(201,162,39,0.3); }
        .btn-outline-gold { background: rgba(201,162,39,0.08); border: 1px solid var(--border); color: var(--gold); font-weight: 700; padding: 10px 24px; border-radius: 10px; transition: var(--transition); cursor: pointer; }
        .btn-outline-gold:hover { background: rgba(201,162,39,0.15); }

        .form-ib { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; color: #fff; padding: 11px 14px; font-size: 0.9rem; width: 100%; outline: none; transition: var(--transition); }
        .form-ib:focus { border-color: var(--gold); background: rgba(201,162,39,0.05); }
        .form-ib::placeholder { color: rgba(255,255,255,0.3); }

        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-state .empty-icon { width: 64px; height: 64px; border-radius: 18px; background: rgba(201,162,39,0.08); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--gold); margin: 0 auto 16px; }

        .pagination .page-link { background: var(--card-bg); border: 1px solid var(--border); color: #e2e8f0; border-radius: 8px !important; margin: 0 3px; font-weight: 600; }
        .pagination .page-link:hover { background: rgba(201,162,39,0.1); color: var(--gold); }
        .pagination .active .page-link { background: var(--gold); border-color: var(--gold); color: #fff; }

        /* ── MOBILE ──────────────────────────────── */
        .ib-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1055; opacity: 0; visibility: hidden; transition: var(--transition); }
        @media (max-width: 991px) {
            .ib-sidebar { transform: translateX(-100%); }
            .ib-sidebar.show { transform: translateX(0); }
            .ib-main { margin-left: 0; }
            .ib-topnav-toggle { display: flex; }
            .ib-overlay.show { opacity: 1; visibility: visible; }
        }
        @media (max-width: 767px) {
            .ib-content { padding: 16px; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--dark); }
        ::-webkit-scrollbar-thumb { background: rgba(201,162,39,0.3); border-radius: 10px; }
    </style>
</head>
<body>

{{-- ── SIDEBAR ─────────────────────────────────────────── --}}
<aside class="ib-sidebar" id="ibSidebar">
    <div class="ib-sidebar-header">
        <a href="{{ route('user.investments') }}" style="display:flex; align-items:center; gap:10px;">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-height:38px; max-width:170px; object-fit:contain;">
        </a>
    </div>

    <div class="ib-sidebar-user">
        @if (Auth::user()->display_picture)
            <img src="{{ Storage::url(Auth::user()->display_picture) }}" alt="User">
        @else
            <div class="avatar-placeholder"><i class="fas fa-user"></i></div>
        @endif
        <div style="min-width:0; overflow:hidden;">
            <div class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>
        </div>
    </div>

    <div class="ib-sidebar-menu">
        <ul class="list-unstyled mb-0">

            <li class="ib-sidebar-section">Dashboard</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments') ? 'active' : '' }}" href="{{ route('user.investments') }}">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.trading') ? 'active' : '' }}" href="{{ route('user.investments.trading') }}">
                    <i class="fas fa-chart-line"></i> Trading
                </a>
            </li>

            <li class="ib-sidebar-section">Funds</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.deposit') ? 'active' : '' }}" href="{{ route('user.investments.deposit') }}">
                    <i class="fas fa-wallet"></i> Deposit
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.withdrawals') ? 'active' : '' }}" href="{{ route('user.investments.withdrawals') }}">
                    <i class="fas fa-arrow-up"></i> Withdrawals
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.wallet') ? 'active' : '' }}" href="{{ route('user.investments.wallet') }}">
                    <i class="fas fa-money-bill-wave"></i> Wallet
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.earnings') ? 'active' : '' }}" href="{{ route('user.investments.earnings') }}">
                    <i class="fas fa-coins"></i> Earnings
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.bonus') ? 'active' : '' }}" href="{{ route('user.investments.bonus') }}">
                    <i class="fas fa-gift"></i> Bonus
                </a>
            </li>

            <li class="ib-sidebar-section">Trading</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.plans') ? 'active' : '' }}" href="{{ route('user.investments.plans') }}">
                    <i class="fas fa-cubes"></i> Plans
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.markets') ? 'active' : '' }}" href="{{ route('user.investments.markets') }}">
                    <i class="fas fa-globe"></i> Markets
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.stocks') ? 'active' : '' }}" href="{{ route('user.investments.stocks') }}">
                    <i class="fas fa-chart-bar"></i> Stocks
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.traders') ? 'active' : '' }}" href="{{ route('user.investments.traders') }}">
                    <i class="fas fa-users"></i> Traders
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.trading-room') ? 'active' : '' }}" href="{{ route('user.investments.trading-room') }}">
                    <i class="fas fa-desktop"></i> Trading Room
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.bot') ? 'active' : '' }}" href="{{ route('user.investments.bot') }}">
                    <i class="fas fa-robot"></i> Trading Bot
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.binary') ? 'active' : '' }}" href="{{ route('user.investments.binary') }}">
                    <i class="fas fa-chart-candlestick"></i> Binary
                </a>
            </li>

            <li class="ib-sidebar-section">Mining</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.mining') ? 'active' : '' }}" href="{{ route('user.investments.mining') }}">
                    <i class="fas fa-microchip"></i> Mining
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.mining-plans') ? 'active' : '' }}" href="{{ route('user.investments.mining-plans') }}">
                    <i class="fas fa-server"></i> Mining Plans
                </a>
            </li>

            <li class="ib-sidebar-section">History</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.account-history') ? 'active' : '' }}" href="{{ route('user.investments.account-history') }}">
                    <i class="fas fa-clock-rotate-left"></i> Account History
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.trading-history') ? 'active' : '' }}" href="{{ route('user.investments.trading-history') }}">
                    <i class="fas fa-history"></i> Trading History
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.investment-history') ? 'active' : '' }}" href="{{ route('user.investments.investment-history') }}">
                    <i class="fas fa-folder-history"></i> Investment History
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.history') ? 'active' : '' }}" href="{{ route('user.investments.history') }}">
                    <i class="fas fa-list-alt"></i> My Plans
                </a>
            </li>

            <li class="ib-sidebar-section">Account</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.profile') ? 'active' : '' }}" href="{{ route('user.investments.profile') }}">
                    <i class="fas fa-user"></i> My Account
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.profile') ? 'active' : '' }}" href="{{ route('user.investments.profile') }}">
                    <i class="fas fa-shield-halved"></i> KYC Verification
                    @php $kyc = Auth::user()->kyc_status; @endphp
                    @if ($kyc == '1') <span class="badge-kyc verified">Verified</span>
                    @elseif ($kyc == '2') <span class="badge-kyc rejected">Rejected</span>
                    @else <span class="badge-kyc pending">Pending</span> @endif
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.referral') ? 'active' : '' }}" href="{{ route('user.investments.referral') }}">
                    <i class="fas fa-share-alt"></i> Referral
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.notifications') ? 'active' : '' }}" href="{{ route('user.investments.notifications') }}">
                    <i class="fas fa-bell"></i> Notifications
                </a>
            </li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.settings') ? 'active' : '' }}" href="{{ route('user.investments.settings') }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>

            <li class="ib-sidebar-section">Support</li>
            <li>
                <a class="ib-nav-link {{ request()->routeIs('user.investments.support') ? 'active' : '' }}" href="{{ route('user.investments.support') }}">
                    <i class="fas fa-headset"></i> Support
                </a>
            </li>
            <li>
                <a class="ib-nav-link" href="{{ route('user.home') }}">
                    <i class="fas fa-university"></i> Bank Dashboard
                </a>
            </li>
            <li>
                <form action="{{ route('user.logout') }}" method="POST" style="margin:0; padding:0;">
                    @csrf
                    <a class="ib-nav-link logout" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Sign Out
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>

<div class="ib-overlay" id="ibOverlay" onclick="document.getElementById('ibSidebar').classList.remove('show'); this.classList.remove('show');"></div>

{{-- ── MAIN AREA ──────────────────────────────────────── --}}
<div class="ib-main">

    {{-- TOP NAV --}}
    <nav class="ib-topnav">
        <button class="ib-topnav-toggle" onclick="document.getElementById('ibSidebar').classList.add('show'); document.getElementById('ibOverlay').classList.add('show');">
            <i class="fas fa-bars"></i>
        </button>
        <div class="ib-balance-pill">
            <i class="fas fa-wallet me-1"></i>
            {{ Auth::user()->currency ?? '$' }}{{ number_format($user_balance ?? $balance ?? 0, 2) }}
        </div>
        <div class="ib-topnav-right">
            <div class="dropdown">
                <button class="ib-notification-toggle" type="button" id="ibNotificationsDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        aria-label="Notifications, {{ $unread_notification_count }} unread">
                    <i class="fas fa-bell" aria-hidden="true"></i>
                    @if ($unread_notification_count > 0)
                        <span class="ib-notification-count">{{ $unread_notification_count > 99 ? '99+' : $unread_notification_count }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end ib-notification-menu" aria-labelledby="ibNotificationsDropdown">
                    <div class="ib-notification-menu-head">
                        <span class="ib-notification-menu-title"><i class="fas fa-bell me-2" style="color:var(--gold);"></i>Notifications</span>
                        <span class="ib-notification-menu-count">{{ $unread_notification_count }} unread</span>
                    </div>
                    <div class="ib-notification-list">
                        @forelse ($header_notifications as $notification)
                            <a class="ib-notification-item {{ $notification->is_read ? '' : 'unread' }}"
                               href="{{ route('user.investments.notifications') }}">
                                <span class="ib-notification-icon"><i class="fas fa-bell" aria-hidden="true"></i></span>
                                <span>
                                    <span class="ib-notification-message">{{ $notification->message }}</span>
                                    <span class="ib-notification-time d-block">{{ $notification->created_at->diffForHumans() }}</span>
                                </span>
                            </a>
                        @empty
                            <div class="ib-notification-empty">
                                <i class="fas fa-bell-slash d-block mb-2" style="font-size:1.2rem;"></i>
                                You're all caught up.
                            </div>
                        @endforelse
                    </div>
                    <div class="ib-notification-menu-foot">
                        @if ($unread_notification_count > 0)
                            <form action="{{ route('user.investments.mark-all-read') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit"><i class="fas fa-check-double me-1"></i>Mark all read</button>
                            </form>
                        @else
                            <span class="ib-notification-menu-count">You're up to date</span>
                        @endif
                        <a href="{{ route('user.investments.all-notifications') }}">View all <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            <a href="{{ route('user.home') }}" class="ib-back-btn">
                <i class="fas fa-arrow-left"></i>
                <span class="d-none d-sm-inline">Bank Dashboard</span>
            </a>
        </div>
    </nav>

    {{-- TICKER BAR --}}
    <div class="ticker-bar" id="tickerBar">
        <div class="ticker-item"><span class="sym">BTC</span><span class="val">$67,420</span><span class="chg-up"><i class="fas fa-caret-up"></i> 2.4%</span></div>
        <div class="ticker-item"><span class="sym">ETH</span><span class="val">$3,510</span><span class="chg-up"><i class="fas fa-caret-up"></i> 1.8%</span></div>
        <div class="ticker-item"><span class="sym">AAPL</span><span class="val">$213.50</span><span class="chg-down"><i class="fas fa-caret-down"></i> 0.4%</span></div>
        <div class="ticker-item"><span class="sym">TSLA</span><span class="val">$248.70</span><span class="chg-up"><i class="fas fa-caret-up"></i> 3.1%</span></div>
        <div class="ticker-item"><span class="sym">NVDA</span><span class="val">$875.20</span><span class="chg-up"><i class="fas fa-caret-up"></i> 1.2%</span></div>
        <div class="ticker-item"><span class="sym">EUR/USD</span><span class="val">1.0872</span><span class="chg-down"><i class="fas fa-caret-down"></i> 0.1%</span></div>
        <div class="ticker-item"><span class="sym">XAU</span><span class="val">$2,318</span><span class="chg-up"><i class="fas fa-caret-up"></i> 0.6%</span></div>
        <div class="ticker-item"><span class="sym">SPX</span><span class="val">5,248</span><span class="chg-up"><i class="fas fa-caret-up"></i> 0.9%</span></div>
        <div class="ticker-item"><span class="sym">SOL</span><span class="val">$174.60</span><span class="chg-up"><i class="fas fa-caret-up"></i> 4.2%</span></div>
        <div class="ticker-item"><span class="sym">GBP/USD</span><span class="val">1.2695</span><span class="chg-down"><i class="fas fa-caret-down"></i> 0.2%</span></div>
    </div>

    {{-- CONTENT --}}
    <div class="ib-content">
        @if (session('success'))
            <div class="alert border-0 rounded-3 mb-4" style="background:rgba(0,211,149,0.1); border:1px solid rgba(0,211,149,0.2) !important; color:#00d395;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert border-0 rounded-3 mb-4" style="background:rgba(255,77,106,0.1); border:1px solid rgba(255,77,106,0.2) !important; color:#ff4d6a;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert border-0 rounded-3 mb-4" style="background:rgba(255,77,106,0.1); border:1px solid rgba(255,77,106,0.2) !important; color:#ff4d6a;">
                @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif
