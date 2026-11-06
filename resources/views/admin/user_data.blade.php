@include('admin.header')

<!-- Main Content -->
<div class="main-content p-3 p-md-4" id="mainContent">
    @if(session('success') || session('error') || session('status') || session('message'))
    @php
        $alertKey  = session('success') ? 'success' : (session('error') ? 'error' : (session('status') ? 'status' : 'message'));
        $alertType = in_array($alertKey, ['success', 'status']) ? 'success' : 'danger';
        $alertMsg  = session('success') ?? session('error') ?? session('status') ?? session('message');
    @endphp
    <div class="alert-container">
        <div class="alert alert-{{ $alertType }} alert-dismissible fade show" role="alert">
            <div class="alert-content">
                <div class="alert-icon"><i class="fas fa-{{ $alertType === 'success' ? 'check-circle' : 'exclamation-circle' }}"></i></div>
                <div class="alert-text">{{ $alertMsg }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert-progress"></div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 mb-1">User Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $userProfile->first_name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Account Overview -->
    <style>
        /* â”€â”€ Account Overview â”€â”€ */
        .account-overview-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1a4a7a 100%);
            border-radius: 12px 12px 0 0;
            padding: 28px 28px 0;
            position: relative;
            overflow: hidden;
        }
        .account-overview-banner::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .user-avatar-ring {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #C9A227, #f0c040);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-weight: 700; color: #0f172a;
            border: 3px solid rgba(255,255,255,0.25);
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(0,0,0,0.3);
        }
        .overview-stat-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e8ecf0;
            padding: 16px 18px;
            transition: box-shadow .2s, transform .2s;
        }
        .overview-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.09); transform: translateY(-2px); }
        .overview-stat-icon {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem; flex-shrink: 0;
        }
        .overview-stat-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; font-weight: 600; }
        .overview-stat-value { font-size: 1.18rem; font-weight: 700; color: #111827; line-height: 1.2; margin-top: 2px; }
        .overview-stat-sub { font-size: 0.72rem; color: #9ca3af; margin-top: 2px; }
        .info-grid-row {
            display: flex; align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-grid-row:last-child { border-bottom: none; }
        .info-grid-label { font-size: 0.78rem; color: #6b7280; font-weight: 500; min-width: 155px; flex-shrink: 0; }
        .info-grid-value { font-size: 0.85rem; color: #111827; font-weight: 600; }
        .section-heading {
            font-size: 0.7rem; text-transform: uppercase; letter-spacing: .08em;
            color: #9ca3af; font-weight: 700; margin-bottom: 4px; margin-top: 18px;
        }
        .section-heading:first-child { margin-top: 0; }
    </style>

    <div class="mb-4" style="border-radius:12px; box-shadow:0 2px 18px rgba(15,23,42,.12); overflow:hidden; border:1px solid #e2e8f0;">

        {{-- â”€â”€ Banner header â”€â”€ --}}
        <div class="account-overview-banner">
            <div class="d-flex align-items-end gap-3 pb-0">
                <div class="user-avatar-ring">
                    {{ strtoupper(substr($userProfile->first_name, 0, 1)) }}{{ strtoupper(substr($userProfile->last_name, 0, 1)) }}
                </div>
                <div class="text-white pb-3">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h4 class="mb-0 fw-bold" style="font-size:1.3rem;">{{ $userProfile->first_name }} {{ $userProfile->last_name }}</h4>
                        <span class="badge" style="background:rgba(201,162,39,.25);color:#f0c040;border:1px solid rgba(201,162,39,.4);font-size:.7rem;">
                            {{ $userProfile->account_type }}
                        </span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <span class="d-flex align-items-center gap-1" style="font-size:.78rem;color:rgba(255,255,255,.65);">
                            <i class="fas fa-envelope" style="font-size:.68rem;"></i> {{ $userProfile->email }}
                        </span>
                        @if($userProfile->phone)
                        <span class="d-flex align-items-center gap-1" style="font-size:.78rem;color:rgba(255,255,255,.65);">
                            <i class="fas fa-phone" style="font-size:.68rem;"></i> {{ $userProfile->phone }}
                        </span>
                        @endif
                        @if($userProfile->country)
                        <span class="d-flex align-items-center gap-1" style="font-size:.78rem;color:rgba(255,255,255,.65);">
                            <i class="fas fa-globe" style="font-size:.68rem;"></i> {{ $userProfile->country }}
                        </span>
                        @endif
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <span class="badge rounded-pill px-3 py-1" style="background:{{ $userProfile->profit_limit_status == 1 ? 'rgba(16,185,129,.2)' : 'rgba(239,68,68,.2)' }};color:{{ $userProfile->profit_limit_status == 1 ? '#34d399' : '#f87171' }};border:1px solid {{ $userProfile->profit_limit_status == 1 ? 'rgba(16,185,129,.35)' : 'rgba(239,68,68,.35)' }};">
                            <i class="fas fa-chart-line me-1" style="font-size:.65rem;"></i> Profit Limit: {{ $userProfile->profit_limit_status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge rounded-pill px-3 py-1" style="background:{{ $userProfile->payment_status == 1 ? 'rgba(16,185,129,.2)' : 'rgba(245,158,11,.2)' }};color:{{ $userProfile->payment_status == 1 ? '#34d399' : '#fbbf24' }};border:1px solid {{ $userProfile->payment_status == 1 ? 'rgba(16,185,129,.35)' : 'rgba(245,158,11,.35)' }};">
                            <i class="fas fa-credit-card me-1" style="font-size:.65rem;"></i> Payment: {{ $userProfile->payment_status == 1 ? 'Activated' : 'Deactivated' }}
                        </span>
                        <span class="badge rounded-pill px-3 py-1" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.15);">
                            <i class="fas fa-hashtag me-1" style="font-size:.65rem;"></i> {{ $userProfile->account_number }}
                        </span>
                    </div>
                </div>
            </div>
            {{-- wave divider --}}
            <svg viewBox="0 0 1440 36" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin-top:16px;"><path d="M0 36 C360 0 1080 0 1440 36 L1440 36 L0 36 Z" fill="#f8fafc"/></svg>
        </div>

        {{-- â”€â”€ Financial stat tiles â”€â”€ --}}
        <div style="background:#f8fafc;padding:20px 24px 24px;">
            <p class="section-heading" style="margin-top:0;"><i class="fas fa-university me-1"></i> Banking Summary</p>
            <div class="row g-3 mb-3">
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="fas fa-wallet"></i></div>
                        </div>
                        <div class="overview-stat-label">Total Balance</div>
                        <div class="overview-stat-value text-success">{{ $userProfile->currency }}{{ number_format((float)$credit_transfers - (float)$debit_transfers, 2) }}</div>
                        <div class="overview-stat-sub">Net account balance</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="fas fa-arrow-circle-down"></i></div>
                        </div>
                        <div class="overview-stat-label">Total Credits</div>
                        <div class="overview-stat-value">{{ $userProfile->currency }}{{ number_format((float)$credit_transfers, 2) }}</div>
                        <div class="overview-stat-sub">All inbound credits</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#fee2e2;color:#dc2626;"><i class="fas fa-arrow-circle-up"></i></div>
                        </div>
                        <div class="overview-stat-label">Total Debits</div>
                        <div class="overview-stat-value text-danger">{{ $userProfile->currency }}{{ number_format((float)$debit_transfers, 2) }}</div>
                        <div class="overview-stat-sub">All outbound debits</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#e0f2fe;color:#0284c7;"><i class="fas fa-file-invoice-dollar"></i></div>
                        </div>
                        <div class="overview-stat-label">Total Deposits</div>
                        <div class="overview-stat-value text-info">{{ $userProfile->currency }}{{ number_format((float)$user_deposits, 2) }}</div>
                        <div class="overview-stat-sub">All deposits made</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#fef9c3;color:#b45309;"><i class="fas fa-hand-holding-usd"></i></div>
                        </div>
                        <div class="overview-stat-label">Total Loans</div>
                        <div class="overview-stat-value" style="color:#b45309;">{{ $userProfile->currency }}{{ number_format((float)$user_loans, 2) }}</div>
                        <div class="overview-stat-sub">Outstanding loans</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#f3e8ff;color:#7c3aed;"><i class="fas fa-wifi"></i></div>
                        </div>
                        <div class="overview-stat-label">Signal Strength</div>
                        <div class="overview-stat-value" style="color:#7c3aed;">{{ $userProfile->signal_strength }}%</div>
                        <div class="overview-stat-sub">
                            <div class="progress mt-1" style="height:4px;border-radius:2px;">
                                <div class="progress-bar bg-purple" style="width:{{ $userProfile->signal_strength }}%;background:#7c3aed;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="section-heading"><i class="fas fa-money-check-alt me-1"></i> Investment Broker Summary</p>
            <div class="row g-3">
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card" style="border-top:3px solid #10b981;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#dcfce7;color:#059669;"><i class="fas fa-chart-pie"></i></div>
                        </div>
                        <div class="overview-stat-label">Broker Balance</div>
                        <div class="overview-stat-value text-success">{{ $userProfile->currency }}{{ number_format((float)$investBalance, 2) }}</div>
                        <div class="overview-stat-sub">Current broker funds</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card" style="border-top:3px solid #10b981;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#dbeafe;color:#1d4ed8;"><i class="fas fa-layer-group"></i></div>
                        </div>
                        <div class="overview-stat-label">Total Invested</div>
                        <div class="overview-stat-value">{{ $userProfile->currency }}{{ number_format((float)$investTotalInvested, 2) }}</div>
                        <div class="overview-stat-sub">Capital deployed</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card" style="border-top:3px solid #10b981;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#ede9fe;color:#6d28d9;"><i class="fas fa-arrow-up"></i></div>
                        </div>
                        <div class="overview-stat-label">Net Profit</div>
                        <div class="overview-stat-value text-primary">{{ $userProfile->currency }}{{ number_format((float)$investTotalProfit, 2) }}</div>
                        <div class="overview-stat-sub">Profit accumulated</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card" style="border-top:3px solid #10b981;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-coins"></i></div>
                        </div>
                        <div class="overview-stat-label">Earnings</div>
                        <div class="overview-stat-value">{{ $userProfile->currency }}{{ number_format((float)$investTotalEarning, 2) }}</div>
                        <div class="overview-stat-sub">Total earnings</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card" style="border-top:3px solid #10b981;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#e0f2fe;color:#0284c7;"><i class="fas fa-users"></i></div>
                        </div>
                        <div class="overview-stat-label">Referral Bonus</div>
                        <div class="overview-stat-value text-info">{{ $userProfile->currency }}{{ number_format((float)$investTotalBonus, 2) }}</div>
                        <div class="overview-stat-sub">Referral earnings</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="overview-stat-card" style="border-top:3px solid #10b981;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div class="overview-stat-icon" style="background:#fff7ed;color:#c2410c;"><i class="fas fa-wallet"></i></div>
                        </div>
                        <div class="overview-stat-label">Withdrawals</div>
                        <div class="overview-stat-value text-warning">{{ $userProfile->currency }}{{ number_format((float)$investTotalWithdrawal, 2) }}</div>
                        <div class="overview-stat-sub">Total withdrawn</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- â”€â”€ Detailed info panels â”€â”€ --}}
        <div style="background:#fff;border-top:1px solid #e2e8f0;">
            <div class="row g-0">
                {{-- Personal & Account Info --}}
                <div class="col-lg-4" style="border-right:1px solid #f1f5f9;padding:24px 28px;">
                    <p class="section-heading" style="margin-top:0;"><i class="fas fa-user-circle me-1"></i> Personal Details</p>
                    <div class="info-grid-row"><span class="info-grid-label">Full Name</span><span class="info-grid-value">{{ $userProfile->first_name }} {{ $userProfile->last_name }}</span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Email</span><span class="info-grid-value" style="word-break:break-all;">{{ $userProfile->email }}</span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Phone</span><span class="info-grid-value">{{ $userProfile->phone ?? '—' }}</span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Country</span><span class="info-grid-value">{{ $userProfile->country ?? '—' }}</span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Account Number</span><span class="info-grid-value"><code class="text-dark">{{ $userProfile->account_number }}</code></span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Account Type</span><span class="info-grid-value"><span class="badge" style="background:#ede9fe;color:#5b21b6;">{{ $userProfile->account_type }}</span></span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Password (plain)</span><span class="info-grid-value"><code class="text-danger">{{ $userProfile->show_password }}</code></span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Transaction PIN</span><span class="info-grid-value"><code>{{ $userProfile->transaction_pin }}</code></span></div>
                </div>
                {{-- Withdrawal Settings --}}
                <div class="col-lg-4" style="border-right:1px solid #f1f5f9;padding:24px 28px;">
                    <p class="section-heading" style="margin-top:0;"><i class="fas fa-money-bill-wave me-1"></i> Withdrawal Settings</p>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Withdrawal Code</span>
                        <span class="info-grid-value">
                            @if($userProfile->withdrawal_code)
                                <span class="badge" style="background:#fef9c3;color:#92400e;font-size:.8rem;letter-spacing:.04em;">{{ $userProfile->withdrawal_code }}</span>
                            @else <span class="text-muted">—</span>@endif
                        </span>
                    </div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Withdrawal Tax Code</span>
                        <span class="info-grid-value">
                            @if($userProfile->withdrawal_tax_code)
                                <span class="badge" style="background:#fef9c3;color:#92400e;font-size:.8rem;letter-spacing:.04em;">{{ $userProfile->withdrawal_tax_code }}</span>
                            @else <span class="text-muted">—</span>@endif
                        </span>
                    </div>
                    <div class="info-grid-row"><span class="info-grid-label">Withdrawal Amount</span><span class="info-grid-value text-success fw-bold">{{ $userProfile->currency }}{{ number_format((float)($userProfile->withdrawal_amount ?? 0), 2) }}</span></div>
                    <div class="info-grid-row"><span class="info-grid-label">Tax Amount</span><span class="info-grid-value text-danger fw-bold">{{ $userProfile->currency }}{{ number_format((float)($userProfile->withdrawal_tax_amount ?? 0), 2) }}</span></div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Withdrawal %</span>
                        <span class="info-grid-value">
                            <span class="badge" style="background:#dcfce7;color:#166534;font-size:.82rem;">{{ $userProfile->withdrawal_percentage ?? 0 }}%</span>
                        </span>
                    </div>
                </div>
                {{-- Account Status Flags --}}
                <div class="col-lg-4" style="padding:24px 28px;">
                    <p class="section-heading" style="margin-top:0;"><i class="fas fa-toggle-on me-1"></i> Account Flags</p>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Profit Limit</span>
                        <span class="info-grid-value">
                            @if($userProfile->profit_limit_status == 1)
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Active</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Inactive</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Payment Status</span>
                        <span class="info-grid-value">
                            @if($userProfile->payment_status == 1)
                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Activated</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="fas fa-pause me-1"></i>Deactivated</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">KYC Notice</span>
                        <span class="info-grid-value">
                            @if($userProfile->show_kyc_notice)
                                <span class="badge bg-warning text-dark"><i class="fas fa-eye me-1"></i>Shown</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-eye-slash me-1"></i>Hidden</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Signal Display</span>
                        <span class="info-grid-value">
                            @if($userProfile->show_signal_strength)
                                <span class="badge bg-success"><i class="fas fa-wifi me-1"></i>Visible</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-wifi me-1"></i>Hidden</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Registered</span>
                        <span class="info-grid-value">{{ $userProfile->created_at ? $userProfile->created_at->format('M d, Y') : '—' }}</span>
                    </div>
                    <div class="info-grid-row">
                        <span class="info-grid-label">Last Updated</span>
                        <span class="info-grid-value">{{ $userProfile->updated_at ? $userProfile->updated_at->diffForHumans() : '—' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-bolt me-1"></i> Quick Actions</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-success w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#addDepositModal">
                        <i class="fas fa-wallet fs-2 mb-2"></i><span>Add Deposit</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-primary w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#addReferralModal">
                        <i class="fas fa-gift fs-2 mb-2"></i><span>Add Bonus</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-info w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#addProfitModal">
                        <i class="fas fa-arrow-up fs-2 mb-2"></i><span>Top Up Profit</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-warning w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#debitProfitModal">
                        <i class="fas fa-arrow-down fs-2 mb-2"></i><span>Debit Profit</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-success w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#creditUserModal">
                        <i class="fas fa-plus-circle fs-2 mb-2"></i><span>Credit User</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-danger w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#debitUserModal">
                        <i class="fas fa-minus-circle fs-2 mb-2"></i><span>Debit User</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-success w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#updatePaymentModal">
                        <i class="fas fa-toggle-on fs-2 mb-2"></i><span>Payment Status</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-primary w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#loanEligibilityModal">
                        <i class="fas fa-hand-holding-usd fs-2 mb-2"></i><span>Loan Eligibility</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-secondary w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#foreignCodeModal">
                        <i class="fas fa-key fs-2 mb-2"></i><span>Foreign Code</span>
                    </button>
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="button" class="btn btn-outline-danger w-100 d-flex flex-column align-items-center justify-content-center p-3" data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                        <i class="fas fa-trash fs-2 mb-2"></i><span>Delete User</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Settings -->
    <div class="card mb-4">
        <div class="card-header bg-white"><h5 class="mb-0"><i class="fas fa-sliders-h me-1"></i> Account Settings</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-success w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#signalStrengthModal"><i class="fas fa-wifi fs-2 mb-2"></i><span>Signal Strength</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#withdrawalCodeModal"><i class="fas fa-shield-alt fs-2 mb-2"></i><span>Withdrawal Code</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#withdrawalPercentageModal"><i class="fas fa-percent fs-2 mb-2"></i><span>Withdrawal Percentage</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#withdrawalAmountModal"><i class="fas fa-money-bill-wave fs-2 mb-2"></i><span>Withdrawal Amount</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#withdrawalTaxCodeModal"><i class="fas fa-shield-alt fs-2 mb-2"></i><span>Withdrawal Tax Code</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-primary w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#withdrawalTaxAmountModal"><i class="fas fa-money-bill-wave fs-2 mb-2"></i><span>Withdrawal Tax Amount</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-info w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#updateNotificationModal"><i class="fas fa-bell fs-2 mb-2"></i><span>Update Notification</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-info w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#pushNotificationModal"><i class="fas fa-paper-plane fs-2 mb-2"></i><span>Push Notification</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn btn-outline-info w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#profitLimitModal"><i class="fas fa-flag fs-2 mb-2"></i><span>Profit Limit</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn {{ $userProfile->show_kyc_notice ? 'btn-outline-warning' : 'btn-warning' }} w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#toggleKycNoticeModal"><i class="fas fa-id-card fs-2 mb-2"></i><span>KYC Notice: {{ $userProfile->show_kyc_notice ? 'ON' : 'OFF' }}</span></button></div>
                <div class="col-md-4 col-lg-3"><button type="button" class="btn {{ $userProfile->show_signal_strength ? 'btn-outline-success' : 'btn-success' }} w-100 d-flex flex-column align-items-center p-3" data-bs-toggle="modal" data-bs-target="#toggleSignalDisplayModal"><i class="fas fa-wifi fs-2 mb-2"></i><span>Signal Display: {{ $userProfile->show_signal_strength ? 'ON' : 'OFF' }}</span></button></div>
                <div class="col-md-4 col-lg-3">
                    <form method="POST" action="{{ route('admin.clear.account', $userProfile->id) }}" onsubmit="return confirm('Clear this account? This cannot be undone.')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 d-flex flex-column align-items-center p-3">
                            <i class="fas fa-broom fs-2 mb-2"></i><span>Clear Account</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Notifications -->
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-bell me-1"></i> User Notifications</h5>
            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#pushNotificationModal"><i class="fas fa-plus me-1"></i>Send Notification</button>
        </div>
        <div class="card-body p-0">
            @if($investNotifications->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0">
                        <thead class="table-light"><tr><th>Date</th><th>Message</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                        <tbody>
                            @foreach($investNotifications as $notif)
                                <tr>
                                    <td>{{ $notif->created_at ? $notif->created_at->format('M d, Y h:i A') : '-' }}</td>
                                    <td>{{ $notif->message }}</td>
                                    <td>@if($notif->is_read)<span class="badge bg-secondary">Read</span>@else<span class="badge bg-success">Unread</span>@endif</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.investment.delete-notification', $notif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this notification?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info m-3 mb-0"><i class="fas fa-info-circle me-2"></i> No notifications sent to this user.</div>
            @endif
        </div>
    </div>

    {{-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
         HISTORY SECTION  — two nav bars, one shared tab-content panel
         All switching is handled by the htabSwitch() JS below so
         Bootstrap's tab plugin (which needs the pane to be a child of
         the same tab-content as the button) is not used.
    â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• --}}

    <style>
        /* â”€â”€ History section wrapper â”€â”€ */
        .history-card {
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(15,23,42,.09);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .history-section-header {
            display: flex; align-items: center; gap: 10px;
            padding: 13px 20px;
            font-size: 0.78rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .06em;
        }
        .history-section-header.banking { background: linear-gradient(90deg,#1e3a5f,#1a4a7a); color:#fff; }
        .history-section-header.broker  { background: linear-gradient(90deg,#064e3b,#065f46); color:#fff; }
        .history-section-header i { font-size: 0.9rem; opacity:.85; }
        .htab-row {
            display: flex; flex-wrap: wrap; gap: 6px;
            padding: 12px 16px 10px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .htab-row.broker-row { background:#f0fdf4; border-bottom:1px solid #d1fae5; }
        /* Nav buttons styled as pills */
        .htab-row .htab-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 20px;
            background: #fff;
            color: #334155;
            font-size: 0.775rem; font-weight: 600;
            cursor: pointer; white-space: nowrap;
            transition: background .13s, color .13s, border-color .13s;
            line-height: 1.4;
        }
        .htab-row .htab-btn:hover { background:#f1f5f9; border-color:#94a3b8; }
        .htab-row .htab-btn.active { background:#1e3a5f; color:#fff; border-color:#1e3a5f; box-shadow:0 2px 8px rgba(30,58,95,.25); }
        .broker-row .htab-btn.active { background:#065f46; border-color:#065f46; box-shadow:0 2px 8px rgba(6,95,70,.25); }
        .htab-row .htab-btn i { font-size:0.7rem; opacity:.75; }
        .htab-row .htab-btn.active i { opacity:1; }
        .history-section-divider { border:none; border-top:2px dashed #e2e8f0; margin:0; }
        #allHistoryTabs { background:#fff; padding:20px; }
    </style>

    {{-- â•â• Unified History Card â•â• --}}
    <div class="history-card">

        {{-- â”€â”€ Banking nav â”€â”€ --}}
        <div class="history-section-header banking">
            <i class="fas fa-university"></i> Banking History
        </div>
        <div class="htab-row">
            <button type="button" class="htab-btn active" onclick="showPane('pane-transactions', this)"><i class="fas fa-exchange-alt"></i> Transactions</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-transfers', this)"><i class="fas fa-money-bill-wave"></i> Transfers</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-cards', this)"><i class="fas fa-credit-card"></i> Cards</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-deposits', this)"><i class="fas fa-file-invoice-dollar"></i> Deposits</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-loans', this)"><i class="fas fa-hand-holding-usd"></i> Loans</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-credits', this)"><i class="fas fa-plus-circle"></i> Credits</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-debits', this)"><i class="fas fa-minus-circle"></i> Debits</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-savings', this)"><i class="fas fa-bullseye"></i> Savings Goals</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-orders', this)"><i class="fas fa-chart-line"></i> Investment Orders</button>
        </div>

        <hr class="history-section-divider">

        {{-- â”€â”€ Broker nav â”€â”€ --}}
        <div class="history-section-header broker">
            <i class="fas fa-money-check-alt"></i> Investment Broker History
        </div>
        <div class="htab-row broker-row">
            <button type="button" class="htab-btn" onclick="showPane('pane-plans', this)"><i class="fas fa-layer-group"></i> Plans</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-profits', this)"><i class="fas fa-arrow-up"></i> Profits</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-debit-profits', this)"><i class="fas fa-arrow-down"></i> Debit Profits</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-earnings', this)"><i class="fas fa-coins"></i> Earnings</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-referrals', this)"><i class="fas fa-users"></i> Referrals</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-withdrawals', this)"><i class="fas fa-wallet"></i> Withdrawals</button>
            <button type="button" class="htab-btn" onclick="showPane('pane-kyc', this)"><i class="fas fa-id-card"></i> KYC</button>
        </div>

        {{-- â”€â”€ Shared content panel â”€â”€ --}}
        <div id="allHistoryTabs" style="background:#fff;padding:20px;">
            <!-- Transactions Tab -->
            <div id="pane-transactions" style="display:block;">
                @if($user_transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Update Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_transactions as $transaction)
                                <tr>
                                    <!-- Date -->
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}</td>

                                    <!-- Transaction Type -->
                                    <td>
                                        <span class="badge bg-{{ $transaction->transaction_type == 'Credit' ? 'success' : 'danger' }}">
                                            {{ $transaction->transaction_type }}
                                        </span>
                                    </td>

                                    <!-- Amount -->
                                    <td class="fw-bold">{{ $transaction->transaction_amount }}</td>

                                    <!-- Description -->
                                    <td>{{ $transaction->description ?? 'N/A' }}</td>

                                    <!-- Status -->
                                    <td>
                                        <span class="badge bg-{{ $transaction->transaction_status == '1' ? 'success' : 'warning' }}">
                                            {{ $transaction->transaction_status == '1' ? 'Completed' : 'Pending' }}
                                        </span>
                                    </td>

                                    <!-- Update Date -->
                                    <td>
                                        <form action="{{ route('admin.transaction.updateDate', $transaction->id) }}" method="POST">
                                            @csrf
                                            <input type="datetime-local" name="new_date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d\TH:i') }}">
                                            <button type="submit" class="btn btn-primary btn-sm mt-1 mt-sm-0">Update Date</button>
                                        </form>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <!-- Approve Button -->
                                            <form action="{{ route('admin.transaction.approve', $transaction->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-1">
                                                    <i class="bi bi-check"></i> Approve
                                                </button>
                                            </form>

                                            <!-- Decline Button -->
                                            <form action="{{ route('admin.transaction.decline', $transaction->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                    <i class="bi bi-x"></i> Decline
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Transaction pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No transactions found for this user.
                    </div>
                @endif
            </div>
            
            <!-- Transfers Tab -->
            <div id="pane-transfers" style="display:none;">
                @if(count($user_transfers_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Beneficiary</th>
                                    <th>Bank</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_transfers_list as $transfer)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('M d, Y h:i A') }}</td>
                                    <td class="fw-bold">${{ number_format($transfer->amount, 2) }}</td>
                                    <td>{{ $transfer->beneficiary_name }}</td>
                                    <td>{{ $transfer->bank_name }}</td>
                                    <td><code>{{ $transfer->transaction_id ?? 'N/A' }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $transfer->status == '1' ? 'success' : ($transfer->status == '2' ? 'danger' : 'warning') }}">
                                            @if($transfer->status == '1') Approved
                                            @elseif($transfer->status == '2') Declined
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.approve-transfer', $transfer->id) }}" method="POST" class="me-2 d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                            <input type="hidden" name="email" value="{{ $userProfile->email }}">
                                            <input type="hidden" name="amount" value="{{ $transfer->amount }}">
                                            <button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Decline Button -->
                                        <form action="{{ route('admin.decline-transfer', $transfer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                            <input type="hidden" name="email" value="{{ $userProfile->email }}">
                                            <input type="hidden" name="amount" value="{{ $transfer->amount }}">
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Decline">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Transfers pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No transfers found for this user.
                    </div>
                @endif
            </div>

            <!-- Cards Tab -->
            <div id="pane-cards" style="display:none;">
                @if(count($user_cards_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Card Number</th>
                                    <th>Expiry Date</th>
                                    <th>CVC</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_cards_list as $card)
                                <tr>
                                    <td>
                                        <code>**** **** **** {{ substr($card->card_number, -4) }}</code>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($card->card_expiry)->format('M Y') }}</td>
                                    <td>***</td>
                                    <td>
                                        <span class="badge bg-{{ $card->status == '1' ? 'success' : 'danger' }}">
                                            {{ $card->status == '1' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($card->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($card->status == '1')
                                                <form action="{{ route('admin.card.decline', $card->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                                                        <i class="fas fa-ban"></i> Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.card.approve', $card->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-1">
                                                        <i class="fas fa-check"></i> Activate
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.card.delete', $card->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Cards pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No cards found for this user.
                    </div>
                @endif
            </div>
            
            <!-- Deposits Tab -->
            <div id="pane-deposits" style="display:none;">
                @if(count($user_deposits_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_deposits_list as $deposit)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y h:i A') }}</td>
                                    <td class="fw-bold">{{ $deposit->amount }}</td>
                                    <td>{{ $deposit->method ?? 'N/A' }}</td>
                                    <td><code>{{ $deposit->reference ?? 'N/A' }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $deposit->status == '1' ? 'success' : ($deposit->status == '2' ? 'danger' : 'warning') }}">
                                            @if($deposit->status == '1') Approved
                                            @elseif($deposit->status == '2') Declined
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.approve-deposit', $deposit->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$deposit->amount}}">
                                            <input type="hidden" name="deposit_type" value="{{$deposit->deposit_type}}">
                                            <button class="btn btn-sm btn-success me-1" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.decline-deposit', $deposit->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$deposit->amount}}">
                                            <input type="hidden" name="deposit_type" value="{{$deposit->deposit_type}}">
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Decline">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Deposit pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No deposits found for this user.
                    </div>
                @endif
            </div>
                        
            <!-- Loans Tab -->
            <div id="pane-loans" style="display:none;">
                @if(count($user_loans_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Interest</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_loans_list as $loan)
                                <tr class="{{ \Carbon\Carbon::parse($loan->due_date)->isPast() && $loan->status == '1' ? 'table-danger' : '' }}">
                                    <td>{{ \Carbon\Carbon::parse($loan->created_at)->format('M d, Y h:i A') }}</td>
                                    <td class="fw-bold">{{ $loan->amount }}</td>
                                    <td>{{ $loan->interest_rate }}%</td>
                                    <td>
                                        @if($loan->due_date)
                                            {{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}
                                            @if(\Carbon\Carbon::parse($loan->due_date)->isPast() && $loan->status == '1')
                                                <span class="badge bg-danger ms-1">Overdue</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $loan->status == '1' ? 'success' : ($loan->status == '2' ? 'danger' : 'warning') }}">
                                            @if($loan->status == '1') Active
                                            @elseif($loan->status == '2') Declined
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($loan->status == '0')
                                        <button class="btn btn-sm btn-success me-1" data-bs-toggle="tooltip" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Decline">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @else
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($loan->status == '1')
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Mark as Paid">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Loan pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No loans found for this user.
                    </div>
                @endif
            </div>

            <!-- Credits Tab -->
            <div id="pane-credits" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">
                        <i class="fas fa-plus-circle text-success me-1"></i> Credit History
                        <span class="badge bg-success ms-1">{{ $userProfile->currency }}{{ number_format((float)$user_credit, 2) }}</span>
                    </h6>
                </div>
                @if($user_credits_list->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Sender Name</th>
                                    <th>Sender Account</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_credits_list as $credit)
                                    <tr>
                                        <td>{{ $credit->created_at ? $credit->created_at->format('M d, Y h:i A') : '-' }}</td>
                                        <td>{{ $credit->sender_name ?? '—' }}</td>
                                        <td><code>{{ $credit->sender_account ?? '—' }}</code></td>
                                        <td>{{ $credit->description ?? '—' }}</td>
                                        <td class="fw-bold text-success">{{ $userProfile->currency }}{{ number_format((float)$credit->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $credit->status == '1' ? 'success' : 'warning' }}">
                                                {{ $credit->status == '1' ? 'Approved' : 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i> No credit records found for this user.
                    </div>
                @endif
            </div>

            <!-- Debits Tab -->
            <div id="pane-debits" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">
                        <i class="fas fa-minus-circle text-danger me-1"></i> Debit History
                        <span class="badge bg-danger ms-1">{{ $userProfile->currency }}{{ number_format((float)$user_debit, 2) }}</span>
                    </h6>
                </div>
                @if($user_debits_list->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_debits_list as $debit)
                                    <tr>
                                        <td>{{ $debit->created_at ? $debit->created_at->format('M d, Y h:i A') : '-' }}</td>
                                        <td>{{ $debit->description ?? '—' }}</td>
                                        <td class="fw-bold text-danger">{{ $userProfile->currency }}{{ number_format((float)$debit->amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $debit->status == '1' ? 'success' : 'warning' }}">
                                                {{ $debit->status == '1' ? 'Approved' : 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i> No debit records found for this user.
                    </div>
                @endif
            </div>

            <!-- Savings Goals Tab -->
            <div id="pane-savings" style="display:none;">
                @if($user_savings_goals->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Goal</th>
                                    <th>Target Amount</th>
                                    <th>Saved Amount</th>
                                    <th>Progress</th>
                                    <th>Target Date</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_savings_goals as $goal)
                                    @php
                                    $progress = min(100, (int) round(((float) $goal->saved_amount / (float) $goal->target_amount) * 100));
                                @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $goal->name }}</td>
                                        <td>{{ $userProfile->currency }}{{ number_format((float) $goal->target_amount, 2) }}</td>
                                        <td>{{ $userProfile->currency }}{{ number_format((float) $goal->saved_amount, 2) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" role="progressbar" aria-label="Savings goal progress" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="height: 8px; min-width: 70px;">
                                                    <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}%</small>
                                            </div>
                                        </td>
                                        <td>{{ $goal->target_date?->format('M d, Y') ?? 'No target date' }}</td>
                                        <td>{{ $goal->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0">Savings goals are progress trackers only; contributions do not move funds or change the user's account balance.</p>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No savings goals found for this user.
                    </div>
                @endif
            </div>

            <!-- Investment Orders Tab -->
            <div id="pane-orders" style="display:none;">
                @if($user_trades->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Asset</th>
                                    <th>Side</th>
                                    <th>Order Type</th>
                                    <th>Amount (USD)</th>
                                    <th>Quantity</th>
                                    <th>Limit Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_trades as $trade)
                                    <tr>
                                        <td>{{ $trade->created_at->format('M d, Y h:i A') }}</td>
                                        <td><code>{{ $trade->transaction_id }}</code></td>
                                        <td>{{ $trade->asset_name }} <span class="text-muted">({{ $trade->asset_symbol }})</span></td>
                                        <td><span class="badge bg-{{ $trade->type === 'buy' ? 'success' : 'danger' }}">{{ ucfirst($trade->type) }}</span></td>
                                        <td>{{ ucfirst($trade->order_type) }}</td>
                                        <td>${{ number_format((float) $trade->amount_usd, 2) }}</td>
                                        <td>{{ number_format((float) $trade->quantity, 6) }}</td>
                                        <td>{{ $trade->limit_price !== null ? '$' . number_format((float) $trade->limit_price, 6) : 'Market' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $trade->status === 'pending' ? 'warning' : ($trade->status === 'executed' ? 'success' : 'secondary') }}">
                                                {{ ucfirst($trade->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0">Order requests are recorded here; pending orders have not been executed or deducted from the user's balance.</p>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No investment orders found for this user.
                    </div>
                @endif
            </div>

            <!-- Invest Plans Tab -->
            <div id="pane-plans" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-layer-group text-success me-1"></i> Investment Plans</h6>
                    <span class="small text-muted">Pending: <strong>{{ $investPlanPending }}</strong> Â· Active: <strong>{{ $investPlanActive }}</strong> Â· Completed: <strong>{{ $investPlanCompleted }}</strong></span>
                </div>
                @if($investPlans->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr><th>Date</th><th>Txn ID</th><th>Plan</th><th>Amount</th><th>ROI</th><th>Duration</th><th>Matures</th><th>Status</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                                @foreach($investPlans as $plan)
                                    @php $sc = ['pending'=>'warning','active'=>'success','completed'=>'info','cancelled'=>'secondary'][$plan->status] ?? 'secondary'; @endphp
                                    <tr>
                                        <td>{{ $plan->created_at?->format('M d, Y') ?? '-' }}</td>
                                        <td><code>{{ $plan->transaction_id }}</code></td>
                                        <td>{{ $plan->plan_name }}</td>
                                        <td class="fw-bold">{{ $userProfile->currency }}{{ number_format((float)$plan->amount,2) }}</td>
                                        <td>{{ number_format((float)$plan->roi_percent,2) }}%</td>
                                        <td>{{ $plan->plan_duration }}</td>
                                        <td>{{ $plan->matures_at?->format('M d, Y') ?? '-' }}</td>
                                        <td><span class="badge bg-{{ $sc }}">{{ ucfirst($plan->status) }}</span></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if($plan->status === 'pending')
                                                    <form action="{{ route('admin.investment.activate', $plan->id) }}" method="POST">@csrf
                                                        <button class="btn btn-success btn-sm" title="Activate"><i class="fas fa-check"></i></button>
                                                    </form>
                                                @endif
                                                @if($plan->status === 'active')
                                                    <form action="{{ route('admin.investment.complete', $plan->id) }}" method="POST">@csrf
                                                        <button class="btn btn-info btn-sm" title="Complete & credit ROI"><i class="fas fa-flag-checkered"></i></button>
                                                    </form>
                                                @endif
                                                @if(in_array($plan->status, ['pending','active']))
                                                    <form action="{{ route('admin.investment.cancel', $plan->id) }}" method="POST" onsubmit="return confirm('Cancel this plan?');">@csrf
                                                        <button class="btn btn-outline-danger btn-sm" title="Cancel"><i class="fas fa-ban"></i></button>
                                                    </form>
                                                @endif
                                                @if($plan->status === 'completed' || $plan->status === 'cancelled')
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No investment plans for this user.</div>
                @endif
            </div>

            <!-- Profits Tab -->
            <div id="pane-profits" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-arrow-up text-success me-1"></i> Profits <span class="badge bg-success">{{ $userProfile->currency }}{{ number_format((float)$investAddProfit,2) }}</span></h6>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addProfitModal"><i class="fas fa-plus me-1"></i>Add Profit</button>
                </div>
                @if($investProfits->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light"><tr><th>Date</th><th>Plan</th><th>Amount</th></tr></thead>
                            <tbody>
                                @foreach($investProfits as $profit)
                                    <tr>
                                        <td>{{ $profit->created_at?->format('M d, Y') ?? '-' }}</td>
                                        <td>{{ $profit->plan_name ?? 'Manual Profit' }}</td>
                                        <td class="fw-bold text-success">{{ $userProfile->currency }}{{ number_format((float)$profit->amount,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No profits recorded.</div>
                @endif
            </div>

            <!-- Debit Profits Tab -->
            <div id="pane-debit-profits" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-arrow-down text-danger me-1"></i> Debit Profits <span class="badge bg-danger">{{ $userProfile->currency }}{{ number_format((float)$investTotalDebitProfit,2) }}</span></h6>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#debitProfitModal"><i class="fas fa-minus me-1"></i>Debit Profit</button>
                </div>
                @if($investDebitProfits->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light"><tr><th>Date</th><th>Note</th><th>Amount</th></tr></thead>
                            <tbody>
                                @foreach($investDebitProfits as $debit)
                                    <tr>
                                        <td>{{ $debit->created_at?->format('M d, Y') ?? '-' }}</td>
                                        <td>{{ $debit->note ?? '-' }}</td>
                                        <td class="fw-bold text-danger">{{ $userProfile->currency }}{{ number_format((float)$debit->amount,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No debit profits recorded.</div>
                @endif
            </div>

            <!-- Earnings Tab -->
            <div id="pane-earnings" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-coins text-warning me-1"></i> Earnings & Bonuses <span class="badge bg-warning text-dark">{{ $userProfile->currency }}{{ number_format((float)$investTotalEarning,2) }}</span></h6>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addEarningModal"><i class="fas fa-plus me-1"></i>Add Earning</button>
                </div>
                @if($investEarnings->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light"><tr><th>Date</th><th>Type</th><th>Narration</th><th>Amount</th></tr></thead>
                            <tbody>
                                @foreach($investEarnings as $earning)
                                    <tr>
                                        <td>{{ $earning->created_at?->format('M d, Y') ?? '-' }}</td>
                                        <td><span class="badge bg-warning text-dark">{{ $earning->type }}</span></td>
                                        <td>{{ $earning->narration }}</td>
                                        <td class="fw-bold">{{ $userProfile->currency }}{{ number_format((float)$earning->amount,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No earnings recorded.</div>
                @endif
            </div>

            <!-- Referrals Tab -->
            <div id="pane-referrals" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-users text-primary me-1"></i> Referral Bonuses <span class="badge bg-primary">{{ $userProfile->currency }}{{ number_format((float)$investTotalBonus,2) }}</span></h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addReferralModal"><i class="fas fa-plus me-1"></i>Add Referral</button>
                </div>
                @if($investReferrals->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light"><tr><th>Date</th><th>Txn ID</th><th>Amount</th></tr></thead>
                            <tbody>
                                @foreach($investReferrals as $referral)
                                    <tr>
                                        <td>{{ $referral->created_at?->format('M d, Y') ?? '-' }}</td>
                                        <td><code>{{ $referral->transaction_id }}</code></td>
                                        <td class="fw-bold text-primary">{{ $userProfile->currency }}{{ number_format((float)$referral->amount,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No referral bonuses recorded.</div>
                @endif
            </div>

            <!-- Broker Withdrawals Tab -->
            <div id="pane-withdrawals" style="display:none;">
                <h6 class="mb-2"><i class="fas fa-wallet text-danger me-1"></i> Broker Withdrawals</h6>
                @if($investWithdrawals->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light"><tr><th>Date</th><th>Txn ID</th><th>Method</th><th>Amount</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach($investWithdrawals as $withdrawal)
                                    @php
                                        $ws = $withdrawal->status ?? '0';
                                        $wc = $ws=='1'?'success':($ws=='2'?'danger':'warning');
                                        $wl = $ws=='1'?'Approved':($ws=='2'?'Declined':'Pending');
                                    @endphp
                                    <tr>
                                        <td>{{ $withdrawal->created_at?->format('M d, Y') ?? '-' }}</td>
                                        <td><code>{{ $withdrawal->transaction_id ?? '-' }}</code></td>
                                        <td>{{ $withdrawal->mode ?? $withdrawal->crypto_type ?? '-' }}</td>
                                        <td class="fw-bold">{{ $userProfile->currency }}{{ number_format((float)$withdrawal->amount,2) }}</td>
                                        <td><span class="badge bg-{{ $wc }}">{{ $wl }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No broker withdrawals.</div>
                @endif
            </div>

            <!-- KYC Tab -->
            <div id="pane-kyc" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-id-card text-info me-1"></i> KYC Verification</h6>
                    <form action="{{ route('admin.investment.toggle-kyc-notice', $userProfile->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="show_kyc_notice" value="{{ $userProfile->show_kyc_notice ? 0 : 1 }}">
                        <button class="btn btn-sm btn-outline-{{ $userProfile->show_kyc_notice ? 'success' : 'secondary' }}">KYC Notice: <strong>{{ $userProfile->show_kyc_notice ? 'Shown' : 'Hidden' }}</strong></button>
                    </form>
                </div>
                @php $kb = $userProfile->kyc_status=='1'?['success','Verified']:($userProfile->kyc_status=='2'?['danger','Rejected']:['warning','Pending']); @endphp
                <div class="mb-3">
                    <span class="text-muted me-2">Account KYC Status:</span>
                    <span class="badge bg-{{ $kb[0] }}">{{ $kb[1] }}</span>
                    <div class="mt-2 d-flex gap-2">
                        <a href="{{ route('admin.investment.accept-kyc', $userProfile->id) }}" class="btn btn-success btn-sm"><i class="fas fa-check me-1"></i>Accept KYC</a>
                        <a href="{{ route('admin.investment.reject-kyc', $userProfile->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-times me-1"></i>Reject KYC</a>
                    </div>
                </div>
                @if($investKycs->isNotEmpty())
                    <div class="row g-3">
                        @foreach($investKycs as $kyc)
                            @php $ks = $kyc->status=='1'?['success','Approved']:($kyc->status=='2'?['danger','Rejected']:['warning','Pending']); @endphp
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-semibold">Submission #{{ $kyc->id }}</span>
                                            <span class="badge bg-{{ $ks[0] }}">{{ $ks[1] }}</span>
                                        </div>
                                        <div class="row g-2">
                                            @if($kyc->idcard)<div class="col-6"><small class="text-muted d-block mb-1">ID Card</small><a href="{{ asset('storage/'.$kyc->idcard) }}" target="_blank"><img src="{{ asset('storage/'.$kyc->idcard) }}" class="img-thumbnail" alt="ID Card"></a></div>@endif
                                            @if($kyc->passport)<div class="col-6"><small class="text-muted d-block mb-1">Passport</small><a href="{{ asset('storage/'.$kyc->passport) }}" target="_blank"><img src="{{ asset('storage/'.$kyc->passport) }}" class="img-thumbnail" alt="Passport"></a></div>@endif
                                            @if(!$kyc->idcard && !$kyc->passport)<div class="col-12"><span class="text-muted small">No documents uploaded.</span></div>@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info mb-0"><i class="fas fa-info-circle me-2"></i> No KYC submissions for this user.</div>
                @endif
            </div>


        </div><!-- /tab-content -->
    </div><!-- /history-card -->


<!-- Add Investment Profit Modal -->
<div class="modal fade" id="addProfitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Investment Profit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.investment.add-profit') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" placeholder="e.g. Weekly profit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Profit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Debit Investment Profit Modal -->
<div class="modal fade" id="debitProfitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Debit Investment Profit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.investment.debit-profit') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <input type="text" class="form-control" name="description" placeholder="Reason for debit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Debit Profit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Earning / Bonus Modal -->
<div class="modal fade" id="addEarningModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Earning / Bonus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.investment.add-earning') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="bonus">Bonus</option>
                            <option value="referral">Referral</option>
                            <option value="reward">Reward</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Narration</label>
                        <input type="text" class="form-control" name="narration" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Add Earning</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Referral Bonus Modal -->
<div class="modal fade" id="addReferralModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Referral Bonus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.investment.add-referral') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Bonus Amount</label>
                        <input type="number" step="0.01" min="0.01" class="form-control" name="amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Referral</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Deposit Modal -->
<div class="modal fade" id="addDepositModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Add User Deposit</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.add-deposit') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
            <input type="hidden" name="email" value="{{ $userProfile->email }}">
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Amount</label><input type="number" step="0.01" min="0.01" name="amount" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Payment Method</label><input type="text" name="payment_method" class="form-control" value="Bitcoin"></div>
                <div class="mb-3"><label class="form-label">Deposit Date</label><input type="date" name="deposit_date" class="form-control"></div>
                <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2" placeholder="Optional note"></textarea></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success">Add Deposit</button></div>
        </form>
    </div></div>
</div>

<!-- Signal Strength Modal -->
<div class="modal fade" id="signalStrengthModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Signal Strength</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-signal', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Signal Strength (%)</label><input type="number" min="0" max="100" name="signal_strength" class="form-control" value="{{ $userProfile->signal_strength }}" required></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Withdrawal Code Modal -->
<div class="modal fade" id="withdrawalCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Withdrawal Code</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-withdrawal-code', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Withdrawal Code</label><input type="text" name="withdrawal_code" class="form-control" value="{{ $userProfile->withdrawal_code ?? '' }}" required></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Withdrawal Percentage Modal -->
<div class="modal fade" id="withdrawalPercentageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Withdrawal Percentage</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-withdrawal-percentage', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Withdrawal Percentage</label><input type="number" step="0.01" min="0" name="withdrawal_percentage" class="form-control" value="{{ $userProfile->withdrawal_percentage ?? 0 }}" required></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Withdrawal Amount Modal -->
<div class="modal fade" id="withdrawalAmountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Withdrawal Amount</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-withdrawal-amount', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Withdrawal Amount</label><input type="number" step="0.01" min="0" name="withdrawal_amount" class="form-control" value="{{ $userProfile->withdrawal_amount ?? 0 }}" required></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Withdrawal Tax Code Modal -->
<div class="modal fade" id="withdrawalTaxCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Withdrawal Tax Code</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.withdrawal.tax.code', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Withdrawal Tax Code</label><input type="text" name="withdrawal_tax_code" class="form-control" value="{{ $userProfile->withdrawal_tax_code ?? '' }}" required></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Withdrawal Tax Amount Modal -->
<div class="modal fade" id="withdrawalTaxAmountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Withdrawal Tax Amount</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-withdrawal-tax-amount', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Withdrawal Tax Amount</label><input type="number" step="0.01" min="0" name="withdrawal_tax_amount" class="form-control" value="{{ $userProfile->withdrawal_tax_amount ?? 0 }}" required></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Update Notification Modal -->
<div class="modal fade" id="updateNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Notification Banner</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-notification', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Notification Message</label><textarea name="update_notification" class="form-control" rows="4" placeholder="Banner text shown to user">{{ $userProfile->update_notification ?? '' }}</textarea></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-info">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Push Notification Modal -->
<div class="modal fade" id="pushNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Send Push Notification</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.add-notification', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Notification Message</label><textarea name="update_notification" class="form-control" rows="3" placeholder="Send a notification to this investor" required></textarea></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Send</button></div>
        </form>
    </div></div>
</div>

<!-- Profit Limit Modal -->
<div class="modal fade" id="profitLimitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Profit Limit Status</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.update-profit-limit', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Profit Limit Status</label><select name="profit_limit_status" class="form-select" required><option value="1" {{ $userProfile->profit_limit_status == 1 ? 'selected' : '' }}>Activate</option><option value="0" {{ $userProfile->profit_limit_status == 0 ? 'selected' : '' }}>Deactivate</option></select></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-info">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Toggle KYC Notice Modal -->
<div class="modal fade" id="toggleKycNoticeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">KYC Notice Display</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.toggle-kyc-notice', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Show KYC Notice on Dashboard</label><select name="show_kyc_notice" class="form-select" required><option value="1" {{ $userProfile->show_kyc_notice ? 'selected' : '' }}>On (Visible to user)</option><option value="0" {{ ! $userProfile->show_kyc_notice ? 'selected' : '' }}>Off (Hidden from user)</option></select></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-warning">Update</button></div>
        </form>
    </div></div>
</div>

<!-- Toggle Signal Display Modal -->
<div class="modal fade" id="toggleSignalDisplayModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Signal Strength Display</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <form action="{{ route('admin.investment.toggle-signal-display', $userProfile->id) }}" method="POST">
            @csrf
            <div class="modal-body"><div class="mb-3"><label class="form-label">Show Signal Strength on Dashboard</label><select name="show_signal_strength" class="form-select" required><option value="1" {{ $userProfile->show_signal_strength ? 'selected' : '' }}>On (Visible to user)</option><option value="0" {{ ! $userProfile->show_signal_strength ? 'selected' : '' }}>Off (Hidden from user)</option></select></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success">Update</button></div>
        </form>
    </div></div>
</div>
<!-- Credit User Modal -->
<div class="modal fade" id="creditUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-plus-circle text-success me-2"></i>Credit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.credit.user') }}" method="POST">
            @csrf
            <input type="hidden" name="email"          value="{{ $userProfile->email }}">
            <input type="hidden" name="first_name"     value="{{ $userProfile->first_name }}">
            <input type="hidden" name="last_name"      value="{{ $userProfile->last_name }}">
            <input type="hidden" name="id"             value="{{ $userProfile->id }}">
            <input type="hidden" name="balance"        value="{{ (float) $credit_transfers - (float) $debit_transfers }}">
            <input type="hidden" name="a_number"       value="{{ $userProfile->account_number }}">
            <input type="hidden" name="currency"       value="{{ $userProfile->currency }}">
            <input type="hidden" name="name"           value="{{ $userProfile->first_name }}">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Sender Name</label>
                    <input type="text" class="form-control" name="sender_name" placeholder="Enter sender name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Sender Account Number</label>
                    <input type="text" class="form-control" name="sender_account" placeholder="Enter sender account number" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Amount</label>
                    <input type="number" step="0.01" min="0.01" class="form-control" name="amount" placeholder="Enter amount" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" name="description" rows="2" placeholder="Transaction description (optional)"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Date</label>
                    <input type="date" class="form-control" name="date" value="{{ now()->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Credit User</button>
            </div>
        </form>
    </div></div>
</div>

<!-- Debit User Modal -->
<div class="modal fade" id="debitUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-minus-circle text-danger me-2"></i>Debit User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.debit.user') }}" method="POST">
            @csrf
            <input type="hidden" name="email"    value="{{ $userProfile->email }}">
            <input type="hidden" name="name"     value="{{ $userProfile->first_name }}">
            <input type="hidden" name="id"       value="{{ $userProfile->id }}">
            <input type="hidden" name="balance"  value="{{ number_format((float) $credit_transfers - (float) $debit_transfers, 2) }}">
            <input type="hidden" name="a_number" value="{{ $userProfile->account_number }}">
            <input type="hidden" name="currency" value="{{ $userProfile->currency }}">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Amount</label>
                    <input type="number" step="0.01" min="0.01" class="form-control" name="amount" placeholder="Enter amount" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" name="description" rows="2" placeholder="Transaction description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Debit User</button>
            </div>
        </form>
    </div></div>
</div>

<!-- Update Payment Status Modal -->
<div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-toggle-on text-success me-2"></i>Update Payment Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.updatepaymentstatus') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $userProfile->id }}">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Payment Status</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="1" {{ $userProfile->payment_status == 1 ? 'selected' : '' }}>Activate</option>
                        <option value="0" {{ $userProfile->payment_status == 0 ? 'selected' : '' }}>Deactivate</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Update Status</button>
            </div>
        </form>
    </div></div>
</div>

<!-- Loan Eligibility Modal -->
<div class="modal fade" id="loanEligibilityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-hand-holding-usd text-primary me-2"></i>Update Loan Eligibility</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.debit.user') }}" method="POST">
            @csrf
            <input type="hidden" name="email"    value="{{ $userProfile->email }}">
            <input type="hidden" name="name"     value="{{ $userProfile->first_name }}">
            <input type="hidden" name="id"       value="{{ $userProfile->id }}">
            <input type="hidden" name="balance"  value="{{ number_format((float) $credit_transfers - (float) $debit_transfers, 2) }}">
            <input type="hidden" name="a_number" value="{{ $userProfile->account_number }}">
            <input type="hidden" name="currency" value="{{ $userProfile->currency }}">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Eligible Loan Amount</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="amount" placeholder="Enter loan eligibility amount" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Loan Eligibility</button>
            </div>
        </form>
    </div></div>
</div>

<!-- Foreign Code Modal -->
<div class="modal fade" id="foreignCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-key text-secondary me-2"></i>Generate Foreign Code</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.updatewithdrawalcode') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $userProfile->id }}">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foreign Code</label>
                    <input type="number" class="form-control" name="withdrawal_code" value="{{ $userProfile->withdrawal_code ?? '' }}" placeholder="Enter foreign code" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-secondary">Update Foreign Code</button>
            </div>
        </form>
    </div></div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm User Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> This action will permanently delete the user account and all associated data.
                </div>
                <div class="mb-3">
                    <label class="form-label">User Details</label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ $userProfile->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($userProfile->first_name).'&background=random' }}" 
                                     class="rounded-circle me-3" width="40" height="40" alt="Profile Photo">
                                <div>
                                    <h6 class="mb-0">{{ $userProfile->first_name }}</h6>
                                    <small class="text-muted">{{ $userProfile->email }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Action</label>
                    <input type="text" class="form-control" name="confirmation" placeholder="Type 'DELETE' to confirm" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Initialize tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>

<style>

    /* Alert System */
.alert-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    width: 100%;
    max-width: 400px;
    padding: 0 15px;
}

.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 1rem;
}

.alert-content {
    display: flex;
    align-items: center;
    padding: 15px;
    position: relative;
}

.alert-icon {
    margin-right: 12px;
    display: flex;
    align-items: center;
}

.alert-icon svg {
    width: 20px;
    height: 20px;
}

.alert-text {
    flex: 1;
    font-size: 14px;
    line-height: 1.4;
}

.btn-close {
    background: none;
    border: none;
    padding: 0;
    margin-left: 12px;
    opacity: 0.7;
    cursor: pointer;
    transition: opacity 0.2s;
}

.btn-close:hover {
    opacity: 1;
}

.btn-close svg {
    width: 16px;
    height: 16px;
}

.alert-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.3);
    animation: progressBar 5s linear forwards;
}

@keyframes progressBar {
    0% { width: 100%; }
    100% { width: 0%; }
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .alert-container {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }
    
    .alert-content {
        padding: 12px;
    }
    
    .alert-text {
        font-size: 13px;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss only the top flash notification alerts, not the info alerts inside panes
    const alerts = document.querySelectorAll('.alert-container .alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
            alert.style.transform = 'translateX(100%)';
            alert.style.opacity = '0';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
        
        // Pause animation on hover
        var progressBar = alert.querySelector('.alert-progress');
        if (progressBar) {
            alert.addEventListener('mouseenter', () => {
                progressBar.style.animationPlayState = 'paused';
            });
            alert.addEventListener('mouseleave', () => {
                progressBar.style.animationPlayState = 'running';
            });
        }
    });
});
</script>



<script>
function showPane(paneId, btn) {
    // Hide all panes
    var panes = ['pane-transactions','pane-transfers','pane-cards','pane-deposits','pane-loans','pane-savings','pane-orders','pane-plans','pane-profits','pane-debit-profits','pane-earnings','pane-referrals','pane-withdrawals','pane-kyc'];
    panes.forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });
    // Show target pane
    var target = document.getElementById(paneId);
    if (target) target.style.display = 'block';
    // Update active button
    document.querySelectorAll('.htab-row .htab-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    if (btn) btn.classList.add('active');
}
</script>

@include('admin.footer')
