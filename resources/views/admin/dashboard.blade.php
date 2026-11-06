@include('admin.header')

<div class="main-content p-3 p-md-4" id="mainContent">

    {{-- ── Page Header ────────────────────────────────────────────────── --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-extrabold text-dark mb-1">Admin Command Center</h2>
            <p class="text-muted small mb-0">
                Live overview of users, deposits, transfers, withdrawals, loans, and trades.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small font-monospace">
                <i class="fas fa-clock me-1"></i>{{ now()->format('M j, Y · g:i A') }}
            </span>
            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold font-monospace">
                <i class="fas fa-signal me-1"></i> System Online
            </span>
        </div>
    </div>

    @if(session('status') || session('message'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-check-circle fs-4 text-success"></i>
            <div>{{ session('status') ?? session('message') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ── Row 1 – Core User & Volume KPIs ────────────────────────────── --}}
    <div class="row g-3 mb-3">

        {{-- Total Users --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="kpi-card h-100" style="--accent:#C9A227;">
                <div class="kpi-icon" style="background:rgba(201,162,39,.12);color:#C9A227;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="kpi-value">{{ number_format($totalUsersCount) }}</div>
                <div class="kpi-label">Total Users</div>
                <div class="kpi-sub text-success"><i class="fas fa-arrow-up me-1"></i>{{ number_format($newUsersCount) }} this week</div>
            </div>
        </div>

        {{-- Active Users --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="kpi-card h-100" style="--accent:#10b981;">
                <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#10b981;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="kpi-value">{{ number_format($activeUsersCount) }}</div>
                <div class="kpi-label">Active (30d)</div>
                <div class="kpi-sub text-muted">Users with activity</div>
            </div>
        </div>

        {{-- Total Deposit Amount --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="kpi-card h-100" style="--accent:#10b981;">
                <div class="kpi-icon" style="background:rgba(16,185,129,.12);color:#10b981;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="kpi-value">${{ number_format($totalDepositAmount, 0) }}</div>
                <div class="kpi-label">Deposits Volume</div>
                <div class="kpi-sub text-muted">{{ number_format($approvedDepositCount) }} approved</div>
            </div>
        </div>

        {{-- Total Transfer Amount --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="kpi-card h-100" style="--accent:#3b82f6;">
                <div class="kpi-icon" style="background:rgba(59,130,246,.12);color:#3b82f6;">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="kpi-value">${{ number_format($totalTransferAmount, 0) }}</div>
                <div class="kpi-label">Transfers Volume</div>
                <div class="kpi-sub text-muted">{{ number_format($completedTransferCount) }} completed</div>
            </div>
        </div>

        {{-- Total Withdrawal Amount --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="kpi-card h-100" style="--accent:#ef4444;">
                <div class="kpi-icon" style="background:rgba(239,68,68,.12);color:#ef4444;">
                    <i class="fas fa-arrow-circle-up"></i>
                </div>
                <div class="kpi-value">${{ number_format($totalWithdrawalAmount, 0) }}</div>
                <div class="kpi-label">Withdrawals</div>
                <div class="kpi-sub text-muted">{{ number_format($approvedWithdrawalCount) }} approved</div>
            </div>
        </div>

        {{-- Trade Volume --}}
        <div class="col-6 col-md-4 col-lg-2">
            <div class="kpi-card h-100" style="--accent:#8b5cf6;">
                <div class="kpi-icon" style="background:rgba(139,92,246,.12);color:#8b5cf6;">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="kpi-value">${{ number_format($totalTradeVolume, 0) }}</div>
                <div class="kpi-label">Trade Volume</div>
                <div class="kpi-sub text-muted">{{ number_format($completedTradeCount) }} completed</div>
            </div>
        </div>
    </div>

    {{-- ── Row 2 – Pending Action Counts ──────────────────────────────── --}}
    <div class="row g-3 mb-4">

        {{-- Pending Deposits --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.deposits') }}" class="text-decoration-none">
                <div class="action-card h-100" style="--accent:#f59e0b;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="action-count text-warning">{{ number_format($pendingDepositCount) }}</div>
                            <div class="action-label">Pending Deposits</div>
                            <div class="action-total">{{ number_format($totalDepositCount) }} total</div>
                        </div>
                        <span class="badge bg-warning bg-opacity-15 text-warning rounded-pill px-2 py-1 small">
                            <i class="fas fa-clock"></i> Review
                        </span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Pending Transfers --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.transfers') }}" class="text-decoration-none">
                <div class="action-card h-100" style="--accent:#3b82f6;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="action-count text-primary">{{ number_format($pendingTransferCount) }}</div>
                            <div class="action-label">Pending Transfers</div>
                            <div class="action-total">{{ number_format($totalTransferCount) }} total</div>
                        </div>
                        <span class="badge bg-primary bg-opacity-15 text-primary rounded-pill px-2 py-1 small">
                            <i class="fas fa-clock"></i> Review
                        </span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Pending Withdrawals --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="action-card h-100" style="--accent:#ef4444;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="action-count text-danger">{{ number_format($pendingWithdrawalCount) }}</div>
                            <div class="action-label">Pending Withdrawals</div>
                            <div class="action-total">{{ number_format($totalWithdrawalCount) }} total</div>
                        </div>
                        <span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-2 py-1 small">
                            <i class="fas fa-clock"></i> Review
                        </span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Pending Loans --}}
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.loans') }}" class="text-decoration-none">
                <div class="action-card h-100" style="--accent:#C9A227;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="action-count" style="color:#C9A227;">{{ number_format($pendingLoanCount) }}</div>
                            <div class="action-label">Pending Loans</div>
                            <div class="action-total">{{ number_format($totalLoanCount) }} total · {{ number_format($approvedLoanCount) }} approved</div>
                        </div>
                        <span class="badge rounded-pill px-2 py-1 small" style="background:rgba(201,162,39,.15);color:#C9A227;">
                            <i class="fas fa-clock"></i> Review
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- ── Row 3 – Deeper Stats Summary Bar ────────────────────────────── --}}
    <div class="card border-0 shadow-sm rounded-4 bg-dark mb-4 text-white overflow-hidden">
        <div class="card-body p-0">
            <div class="row g-0 text-center">
                <div class="col-6 col-md stat-bar-item">
                    <div class="stat-bar-val">{{ number_format($totalTransactionCount) }}</div>
                    <div class="stat-bar-lbl">All Transactions</div>
                </div>
                <div class="col-6 col-md stat-bar-item">
                    <div class="stat-bar-val">{{ number_format($totalDepositCount) }}</div>
                    <div class="stat-bar-lbl">Deposit Records</div>
                </div>
                <div class="col-6 col-md stat-bar-item">
                    <div class="stat-bar-val">{{ number_format($totalTransferCount) }}</div>
                    <div class="stat-bar-lbl">Wire Transfers</div>
                </div>
                <div class="col-6 col-md stat-bar-item">
                    <div class="stat-bar-val">{{ number_format($totalWithdrawalCount) }}</div>
                    <div class="stat-bar-lbl">Withdrawals</div>
                </div>
                <div class="col-6 col-md stat-bar-item">
                    <div class="stat-bar-val">{{ number_format($totalTradeCount) }}</div>
                    <div class="stat-bar-lbl">Trade Orders</div>
                </div>
                <div class="col-6 col-md stat-bar-item border-end-0">
                    <div class="stat-bar-val">{{ number_format($pendingTradeCount) }}</div>
                    <div class="stat-bar-lbl">Pending Trades</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 4 – Tables: Recent Users + Recent Deposits ──────────────── --}}
    <div class="row g-4 mb-4">

        {{-- Recent Registrations --}}
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                <div class="card-header bg-white border-0 p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-user-plus me-2 text-primary"></i> Recent Registrations
                        </h5>
                        <span class="text-muted small">Newest accounts on the platform</span>
                    </div>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                        All Users <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small font-monospace">ID</th>
                                    <th class="py-3 text-muted small font-monospace">ACCOUNT HOLDER</th>
                                    <th class="py-3 text-muted small font-monospace">EMAIL</th>
                                    <th class="py-3 text-muted small font-monospace">PHONE</th>
                                    <th class="py-3 text-muted small font-monospace">JOINED</th>
                                    <th class="pe-4 py-3 text-end text-muted small font-monospace">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td class="ps-4 font-monospace fw-bold text-muted small">#{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ $user->display_picture ? Storage::url($user->display_picture) : asset('uploads/display/avatar.jpg') }}"
                                                     alt="Avatar" class="rounded-circle border"
                                                     style="width:34px;height:34px;object-fit:cover;">
                                                <div>
                                                    <div class="fw-bold text-dark small mb-0">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                    <small class="text-muted font-monospace" style="font-size:.7rem;">{{ $user->account_type ?? 'Standard' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">{{ $user->email }}</td>
                                        <td class="text-muted small font-monospace">{{ $user->phone ?? 'N/A' }}</td>
                                        <td class="text-muted small">{{ $user->created_at->format('M j, Y') }}</td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ route('admin.profile', $user->id) }}"
                                               class="btn btn-sm btn-light text-primary border-0 rounded-2 me-1" title="Manage User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="mailto:{{ $user->email }}"
                                               class="btn btn-sm btn-light text-success border-0 rounded-2" title="Email User">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-users-slash fs-2 mb-2 opacity-50 d-block"></i>
                                            No user accounts registered yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Deposits --}}
        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                <div class="card-header bg-white border-0 p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-wallet me-2 text-success"></i> Recent Deposits
                        </h5>
                        <span class="text-muted small">Latest deposit submissions</span>
                    </div>
                    <a href="{{ route('admin.deposits') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                        All Deposits <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small font-monospace">USER</th>
                                    <th class="py-3 text-muted small font-monospace">AMOUNT</th>
                                    <th class="py-3 text-muted small font-monospace">TYPE</th>
                                    <th class="pe-4 py-3 text-muted small font-monospace">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentDeposits as $deposit)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark small">
                                                {{ optional($deposit->user)->first_name }} {{ optional($deposit->user)->last_name }}
                                            </div>
                                            <small class="text-muted font-monospace" style="font-size:.7rem;">
                                                {{ $deposit->created_at->format('M j, Y') }}
                                            </small>
                                        </td>
                                        <td class="fw-bold font-monospace text-dark small">
                                            ${{ number_format($deposit->amount, 2) }}
                                        </td>
                                        <td class="text-muted small text-capitalize">
                                            {{ $deposit->deposit_type ?? 'Bank' }}
                                        </td>
                                        <td class="pe-4">
                                            @if($deposit->status == 1)
                                                <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-2">Approved</span>
                                            @elseif($deposit->status == 2)
                                                <span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-2">Declined</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-15 text-warning rounded-pill px-2">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fs-2 mb-2 opacity-50 d-block"></i>
                                            No deposits yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 5 – Recent Transactions ────────────────────────────────── --}}
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white border-0 p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-list-alt me-2 text-warning"></i> Recent Transactions
                </h5>
                <span class="text-muted small">Latest transaction activity across all accounts</span>
            </div>
            <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">
                All Transactions <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small font-monospace">TXN ID</th>
                            <th class="py-3 text-muted small font-monospace">USER</th>
                            <th class="py-3 text-muted small font-monospace">TYPE</th>
                            <th class="py-3 text-muted small font-monospace">AMOUNT</th>
                            <th class="py-3 text-muted small font-monospace">DESCRIPTION</th>
                            <th class="py-3 text-muted small font-monospace">DATE</th>
                            <th class="pe-4 py-3 text-muted small font-monospace">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $txn)
                            <tr>
                                <td class="ps-4 font-monospace text-muted small">
                                    #{{ Str::limit($txn->transaction_id, 12, '…') }}
                                </td>
                                <td>
                                    <div class="fw-bold text-dark small">
                                        {{ optional($txn->user)->first_name }} {{ optional($txn->user)->last_name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-15 text-secondary text-capitalize rounded-pill px-2">
                                        {{ $txn->transaction_type ?? 'General' }}
                                    </span>
                                </td>
                                <td class="fw-bold font-monospace small">
                                    @if($txn->credit)
                                        <span class="text-success">+${{ number_format($txn->credit, 2) }}</span>
                                    @elseif($txn->debit)
                                        <span class="text-danger">-${{ number_format($txn->debit, 2) }}</span>
                                    @else
                                        <span class="text-muted">${{ number_format($txn->transaction_amount ?? 0, 2) }}</span>
                                    @endif
                                </td>
                                <td class="text-muted small" style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $txn->transaction_description ?? '—' }}
                                </td>
                                <td class="text-muted small">{{ $txn->created_at->format('M j, Y') }}</td>
                                <td class="pe-4">
                                    @php $s = strtolower($txn->transaction_status ?? 'pending'); @endphp
                                    @if($s === 'completed' || $s === 'approved' || $s === 'success')
                                        <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-2">{{ ucfirst($s) }}</span>
                                    @elseif($s === 'failed' || $s === 'declined')
                                        <span class="badge bg-danger bg-opacity-15 text-danger rounded-pill px-2">{{ ucfirst($s) }}</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-15 text-warning rounded-pill px-2">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-receipt fs-2 mb-2 opacity-50 d-block"></i>
                                    No transactions recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ── Component Styles ────────────────────────────────────────────────── --}}
<style>
/* KPI card */
.kpi-card {
    background: #fff;
    border-radius: 1rem;
    padding: 1.1rem 1rem;
    box-shadow: 0 1px 8px rgba(0,0,0,.06);
    border-left: 4px solid var(--accent);
    transition: transform .15s, box-shadow .15s;
}
.kpi-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.kpi-icon {
    width: 38px; height: 38px;
    border-radius: .6rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    margin-bottom: .55rem;
}
.kpi-value {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.3rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    margin-bottom: .15rem;
}
.kpi-label {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #94a3b8;
    margin-bottom: .2rem;
}
.kpi-sub {
    font-size: .7rem;
    font-weight: 600;
}

/* Action card (pending items) */
.action-card {
    background: #fff;
    border-radius: 1rem;
    padding: 1.1rem 1rem;
    box-shadow: 0 1px 8px rgba(0,0,0,.06);
    border-left: 4px solid var(--accent);
    transition: transform .15s, box-shadow .15s;
}
.action-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.action-count {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: .2rem;
}
.action-label {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #475569;
    margin-bottom: .15rem;
}
.action-total {
    font-size: .68rem;
    color: #94a3b8;
}

/* Dark stat summary bar */
.stat-bar-item {
    padding: .9rem .5rem;
    border-right: 1px solid rgba(255,255,255,.08);
}
.stat-bar-val {
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.2rem;
    font-weight: 800;
    color: #f8fafc;
    margin-bottom: .15rem;
}
.stat-bar-lbl {
    font-size: .68rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #94a3b8;
}
</style>

@include('admin.footer')
