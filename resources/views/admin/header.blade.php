<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Center | Top Saver Trust Bank</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
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
        
        /* Sidebar Styles */
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
        }
        
        .sidebar-brand {
            padding: 1.5rem 1rem;
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            background-color: var(--primary-color);
            z-index: 10;
        }
        
        .sidebar-brand img {
            height: 30px;
            margin-right: 10px;
        }
        
        .sidebar-nav {
            padding: 1rem 0;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 5px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            white-space: nowrap;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
        }
        
        .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .nav-link .badge {
            margin-left: auto;
        }
        
        .sidebar-footer {
            position: sticky;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background-color: var(--primary-color);
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .user-name {
            font-weight: 500;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .user-role {
            font-size: 0.75rem;
            opacity: 0.7;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
        }
        
        /* Stats Cards */
        .stat-card {
            padding: 20px;
            border-left: 4px solid;
        }
        
        .stat-card.primary {
            border-left-color: var(--primary-color);
        }
        
        .stat-card.success {
            border-left-color: var(--success-color);
        }
        
        .stat-card.warning {
            border-left-color: var(--warning-color);
        }
        
        .stat-card.danger {
            border-left-color: var(--danger-color);
        }
        
        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card .label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .stat-card .change {
            font-size: 0.8rem;
            margin-top: 5px;
        }
        
        .stat-card .change.positive {
            color: var(--success-color);
        }
        
        .stat-card .change.negative {
            color: var(--danger-color);
        }
        
        /* Tables */
        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }
        
        .table tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        
        /* Badges */
        .badge {
            padding: 5px 10px;
            font-weight: 500;
            font-size: 0.75rem;
            border-radius: 4px;
        }
        
        /* User Avatar */
        .user-avatar-sm {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        /* Mobile Toggle Button */
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            }
            
            .main-content {
                margin-left: 0 !important;
                padding-top: 70px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                width: 100% !important;
            }
            
            .sidebar-toggle {
                display: flex !important;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Toggle Button (Mobile) -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('logo.png') }}" alt="logo" width="">
        </div>
        
        <div class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.users') }}" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Manage Users</span>
            </a>

            
            <a href="{{ route('admin.wallets.index') }}" class="nav-link">
    <i class="fas fa-sync-alt"></i>
    <span>Update Wallet/Bank</span>
</a>

            
            <a href="{{ route('admin.transfers') }}" class="nav-link">
                <i class="fas fa-piggy-bank"></i>
                <span>Transfers</span>
            </a>

              {{-- <a href="#" class="nav-link">
                <i class="fas fa-piggy-bank"></i>
                <span>Accounts</span>
            </a> --}}
            

                <a href="{{ route('admin.deposits') }}" class="nav-link">
                <i class="fas fa-file-invoice-dollar"></i>
                <span> Deposits</span>
            </a>
            
            <a href="{{ route('admin.loans') }}" class="nav-link">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Loans</span>
            </a>

            <a href="{{ route('admin.investments') }}" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>Investments</span>
            </a>
            
            <a href="{{ route('admin.cards') }}" class="nav-link">
                <i class="fas fa-credit-card"></i>
                <span>Cards</span>
            </a>
            
              <a href="{{ route('admin.transactions') }}" class="nav-link">
                <i class="fas fa-exchange-alt"></i>
                <span>Transactions</span>
               
            </a>
        
            
            {{-- <a href="#" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a> --}}
            
          <!-- Logout Link with Hidden Form -->
<a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
    <i class="fas fa-sign-out-alt"></i>
    <span>Logout</span>
</a>

<!-- Hidden Logout Form -->
<form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

        </div>
        
     
        </div>
    </div>
