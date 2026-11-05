<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRIMEGLOBOPTIONS - Banking &amp; Investment Dashboard</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #C9A227;
            --primary-light: #E8C14A;
            --primary-dark: #9E7C14;
            --secondary: #0f172a;
            --accent: #C9A227;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #C9A227;
            --light: #f8fafc;
            --dark: #090d16;
            --gray: #64748b;
            --white: #ffffff;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --header-height: 72px;
            --card-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Base Styles */
        body {
            font-family: 'Segoe UI', 'Roboto', system-ui, sans-serif;
            background-color: #f5f7fb;
            color: #212529;
            overflow-x: hidden;
            line-height: 1.6;
            padding-bottom: 78px; /* space for bottom dock */
        }

        a {
            text-decoration: none;
            transition: var(--transition);
        }

        /* Sidebar - Ultra Luxury Fintech Edition */
        #sidebar {
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            background: #ffffff;
            box-shadow: 10px 0 30px rgba(15, 23, 42, 0.04);
            transition: var(--transition);
            z-index: 1050;
            border-right: 1px solid rgba(201,162,39, 0.12);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 18px 24px;
            background: #ffffff;
            min-height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(201,162,39, 0.12);
        }

        .sidebar-header img {
            max-height: 40px;
            max-width: 170px;
            object-fit: contain;
            transition: var(--transition);
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 14px;
            overflow-y: auto;
        }

        .sidebar-section-title {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
            padding: 12px 14px 6px;
            margin-top: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            list-style: none;
        }

        .nav-link {
            color: #475569;
            padding: 11px 16px;
            margin: 3px 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.9rem;
            position: relative;
        }

        .nav-link i {
            font-size: 1.05rem;
            min-width: 34px;
            height: 34px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #64748b;
            margin-right: 12px;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: #9E7C14;
            background-color: rgba(201,162,39, 0.06);
            transform: translateX(3px);
        }

        .nav-link:hover i {
            background: rgba(201,162,39, 0.15);
            color: #C9A227;
        }

        .nav-link.active {
            color: #9E7C14;
            font-weight: 700;
            background: linear-gradient(135deg, rgba(201,162,39, 0.12) 0%, rgba(158,124,20, 0.08) 100%);
            border: 1px solid rgba(201,162,39, 0.2);
            box-shadow: 0 4px 12px rgba(201,162,39, 0.08);
        }

        .nav-link.active i {
            background: linear-gradient(135deg, #9E7C14 0%, #C9A227 100%);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(201,162,39, 0.3);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -14px;
            top: 15%;
            height: 70%;
            width: 4px;
            background: #C9A227;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px rgba(201,162,39, 0.6);
        }

        .logout-link {
            color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.04);
            border: 1px solid rgba(239, 68, 68, 0.1);
        }

        .logout-link i {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
        }

        .logout-link:hover {
            background: rgba(239, 68, 68, 0.12) !important;
            transform: translateX(3px);
        }

        /* Collapsed Sidebar */
        #sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        #sidebar.collapsed .sidebar-header img {
            max-width: 40px;
        }

        #sidebar.collapsed .sidebar-section-title {
            display: none;
        }

        #sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
            position: absolute;
            transition: var(--transition);
        }

        #sidebar.collapsed .nav-link i {
            font-size: 1.2rem;
            margin-right: 0;
        }

        #sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }

        /* Main Content Area */
        #main-content {
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
        }

        #sidebar.collapsed + #main-content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Top Navigation Bar (Clean Light Luxury Theme) */
        .top-navbar {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 0 25px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1040;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(201,162,39, 0.15);
            color: #0f172a;
        }

        .toggle-btn {
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-size: 1.1rem;
            color: #9E7C14;
            cursor: pointer;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: var(--transition);
        }

        .toggle-btn:hover {
            background-color: rgba(201,162,39, 0.1);
            color: #C9A227;
            border-color: rgba(201,162,39, 0.3);
            transform: translateY(-1px);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-img-container {
            position: relative;
        }

        .profile-img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #C9A227;
            transition: var(--transition);
        }

        .profile-img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(201,162,39, 0.3);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Bottom Header styles moved to footer.blade.php */

        /* Dashboard Cards */
        .dashboard-card {
            background: var(--white);
            border-radius: var(--card-radius);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            padding: 25px;
            margin-bottom: 25px;
            border: none;
            transition: var(--transition);
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .card-title {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* Balance Display */
        .balance-container {
            position: relative;
        }

        .balance-display {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary);
            margin: 10px 0;
            letter-spacing: 0.5px;
            font-family: 'Roboto', sans-serif;
            transition: var(--transition);
        }

        .balance-hidden {
            letter-spacing: 3px;
        }

        /* Account Status */
        .account-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        /* Quick Actions Grid */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }

        .quick-action {
            background: var(--white);
            border-radius: var(--card-radius);
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            transition: var(--transition);
            border: 1px solid rgba(0,0,0,0.03);
            cursor: pointer;
            color: inherit;
        }

        .quick-action:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: var(--primary-light);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 1.3rem;
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            box-shadow: 0 4px 10px rgba(10, 92, 92, 0.2);
        }

        .action-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--secondary);
        }

        /* Transactions List */
        .transaction-list {
            border-radius: var(--card-radius);
            overflow: hidden;
        }

        .transaction-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: var(--white);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: var(--transition);
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-item:hover {
            background-color: rgba(10, 92, 92, 0.03);
        }

        .transaction-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            flex-shrink: 0;
        }

        .icon-deposit {
            background: linear-gradient(135deg, var(--success) 0%, #218838 100%);
        }

        .icon-withdrawal {
            background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%);
        }

        .icon-transfer {
            background: linear-gradient(135deg, var(--info) 0%, #138496 100%);
        }

        .icon-crypto {
            background: linear-gradient(135deg, var(--warning) 0%, #e0a800 100%);
        }

        .transaction-details {
            flex: 1;
            min-width: 0;
        }

        .transaction-title {
            font-weight: 500;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .transaction-meta {
            font-size: 0.8rem;
            color: var(--gray);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .transaction-amount {
            text-align: right;
            font-weight: 600;
            margin-left: 15px;
            white-space: nowrap;
        }

        .amount-positive {
            color: var(--success);
        }

        .amount-negative {
            color: var(--danger);
        }

        .transaction-status {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 10px;
            margin-top: 5px;
            display: inline-block;
        }

        .status-completed {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .status-pending {
            background-color: rgba(253, 126, 20, 0.1);
            color: var(--warning);
        }

        .status-failed {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
        }

        /* Charts and Analytics */
        .chart-container {
            height: 250px;
            background: var(--light);
            border-radius: var(--card-radius);
            position: relative;
            overflow: hidden;
        }

        .chart-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Savings Goals */
        .savings-goal {
            margin-bottom: 20px;
        }

        .goal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .goal-title {
            font-weight: 500;
            color: var(--secondary);
        }

        .goal-amount {
            font-weight: 600;
            color: var(--dark);
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: rgba(0,0,0,0.05);
        }

        /* Responsive Adjustments */
        @media (max-width: 1199px) {
            #sidebar {
                transform: translateX(-100%);
                z-index: 1051;
            }
            
            #sidebar.show {
                transform: translateX(0);
            }
            
            #main-content {
                margin-left: 0;
            }
            
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1050;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
            }
            
            #sidebar.show + .overlay {
                opacity: 1;
                visibility: visible;
            }
        }

        @media (max-width: 991px) {
            .quick-actions-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .balance-display {
                font-size: 1.9rem;
            }
        }

        @media (max-width: 767px) {
            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .top-navbar {
                padding: 0 15px;
            }
            
            .dashboard-card {
                padding: 20px;
            }
        }

        @media (max-width: 575px) {
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
            
            .transaction-item {
                flex-wrap: wrap;
            }
            
            .transaction-amount {
                width: 100%;
                text-align: left;
                margin-top: 10px;
                margin-left: 57px;
            }
            
            .balance-display {
                font-size: 1.7rem;
            }

            /* Bottom dock spacing on small screens */
            body {
                padding-bottom: 78px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadein {
            animation: fadeIn 0.4s ease-out forwards;
            opacity: 0;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>

<body>
    <!-- Premium Sidebar -->
    <aside id="sidebar">
        <div class="sidebar-header">
            <a href="{{route('user.home')}}" class="d-inline-flex align-items-center">
                <img src="{{asset('assets/images/logo.png')}}" alt="Bank Logo">
            </a>
            <span class="badge rounded-pill bg-success-subtle text-success small font-monospace d-none d-lg-inline-block px-2.5 py-1" style="font-size: 0.68rem; border: 1px solid rgba(16, 185, 129, 0.25);">
                <i class="fas fa-circle text-success me-1" style="font-size: 0.45rem;"></i> ONLINE
            </span>
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="sidebar-section-title">MAIN MENU</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}" href="{{route('user.home')}}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.investments') ? 'active' : '' }}" href="{{ route('user.investments') }}">
                        <i class="fas fa-seedling"></i>
                        <span>Invest</span>
                    </a>
                </li>

                <li class="sidebar-section-title">SAVING & INVESTING</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.savings-goals.*') ? 'active' : '' }}" href="{{ route('user.savings-goals.index') }}">
                        <i class="fas fa-bullseye"></i>
                        <span>Savings Goals</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.mutual-funds') ? 'active' : '' }}" href="{{ route('user.mutual-funds') }}">
                        <i class="fas fa-layer-group"></i>
                        <span>Mutual Funds</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.investment') ? 'active' : '' }}" href="{{ route('user.investment') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Markets</span>
                    </a>
                </li>

                <li class="sidebar-section-title">PAYMENTS & TRANSFERS</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.deposit.*') ? 'active' : '' }}" href="{{route('user.deposit.index')}}">
                        <i class="fas fa-wallet"></i>
                        <span>Deposit</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.bill.*') ? 'active' : '' }}" href="{{ route('user.bill.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Pay Bills</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.transfer.*') ? 'active' : '' }}" href="{{route('user.transfer.bank')}}">
                        <i class="fas fa-university"></i>
                        <span>Bank Transfers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.withdrawal.crypto') ? 'active' : '' }}" href="{{route('user.withdrawal.crypto')}}">
                        <i class="fab fa-bitcoin"></i>
                        <span>Crypto Withdrawal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.withdrawal.paypal') ? 'active' : '' }}" href="{{route('user.withdrawal.paypal')}}">
                        <i class="fab fa-paypal"></i>
                        <span>PayPal Withdrawals</span>
                    </a>
                </li>

                <li class="sidebar-section-title">CREDIT</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.loans.*') ? 'active' : '' }}" href="{{route('user.loans.loan')}}">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Apply for Loan</span>
                    </a>
                </li>

                <li class="sidebar-section-title">ACCOUNT</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.cards.*') ? 'active' : '' }}" href="{{route('user.cards.card')}}">
                        <i class="fas fa-id-card"></i>
                        <span>My Card</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{route('user.profile')}}">
                        <i class="fas fa-user-shield"></i>
                        <span>Account Profile</span>
                    </a>
                </li>
                
                <li class="nav-item mt-3">
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="margin: 0; padding: 0;">
                        @csrf
                        <a class="nav-link logout-link" href="#" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sign Out</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div class="overlay"></div>

<!-- Main Content Area -->
<main id="main-content">
    <!-- Premium Top Navigation (Luxury Glassmorphic Navbar) -->
    <nav class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="toggle-btn" title="Toggle Navigation Sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="d-none d-sm-flex align-items-center gap-2">
                <span class="badge rounded-pill px-3 py-1.5 font-monospace small d-inline-flex align-items-center gap-1.5" style="background: rgba(201,162,39, 0.08); border: 1px solid rgba(201,162,39, 0.2); color: #9E7C14 !important; font-weight: 600;">
                    <i class="fas fa-shield-alt text-success"></i> 256-bit SSL Encrypted
                </span>
            </div>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <div class="user-profile">
                <div class="text-end d-none d-md-block">
                    <div class="fw-bold mb-0" style="color: #0f172a; font-size: 0.92rem;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                    <small class="font-monospace fw-semibold" style="color: #9E7C14; font-size: 0.76rem;">Acc: {{ Auth::user()->account_number ?? Auth::user()->a_number }}</small>
                </div>
                <div class="profile-img-container position-relative">
                    <a class="d-inline-block p-0.5 rounded-circle" href="javascript:void(0)" role="button" onclick="triggerFileInput()" title="Click to update avatar">
                        <img src="{{ Auth::user()->display_picture ? Storage::url(Auth::user()->display_picture) : asset('uploads/display/avatar.jpg') }}" class="profile-img" alt="Profile">
                    </a>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle" style="width: 10px; height: 10px;" title="Online"></span>
                    
                    <form id="uploadForm" action="{{ route('user.personal.dp') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" id="profilePictureInput" name="image" accept="image/*" style="display: none;" onchange="uploadProfilePicture()">
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
      <!-- Top Right -->
                       <div class="gtranslate_wrapper"></div> <script>window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right","switcher_vertical_position":"top","alt_flags":{"en":"usa","pt":"brazil","es":"colombia","fr":"quebec"}}</script> <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
                    </div>
                    
                 