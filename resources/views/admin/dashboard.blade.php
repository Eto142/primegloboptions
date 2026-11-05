@include('admin.header')

<div class="main-content p-3 p-md-4" id="mainContent">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-extrabold text-dark mb-1">Admin Command Center</h2>
            <p class="text-muted small mb-0">Overview of active bank users, deposits, transfers, and system operations.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
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

    <!-- High-Impact Stats Cards Grid -->
    <div class="row g-4 mb-4">
        <!-- Total Users Card -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden" style="border-left: 4px solid #C9A227 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Total Registered Users</span>
                    <div class="p-2.5 rounded-3" style="background: rgba(201,162,39, 0.12); color: #C9A227;">
                        <i class="fas fa-users fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-dark font-monospace mb-2">{{ number_format($totalUsersCount) }}</h2>
                <div class="d-flex align-items-center gap-1.5 small text-success fw-bold">
                    <i class="fas fa-arrow-up"></i> {{ number_format($newUsersCount) }} new this week
                </div>
            </div>
        </div>

        <!-- Total Deposits Card -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden" style="border-left: 4px solid #10b981 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Total Deposits</span>
                    <div class="p-2.5 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="fas fa-wallet fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-dark font-monospace mb-2">{{ number_format($totalDepositCount) }}</h2>
                <div class="small text-muted">All time deposit transactions</div>
            </div>
        </div>

        <!-- Total Transfers Card -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden" style="border-left: 4px solid #C9A227 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Total Wire Transfers</span>
                    <div class="p-2.5 rounded-3 bg-info bg-opacity-10 text-info">
                        <i class="fas fa-exchange-alt fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-dark font-monospace mb-2">{{ number_format($totalTransferCount) }}</h2>
                <div class="small text-muted">Interbank & domestic transfers</div>
            </div>
        </div>

        <!-- Active Loans Card -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden" style="border-left: 4px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Active Loan Applications</span>
                    <div class="p-2.5 rounded-3 bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-hand-holding-usd fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-dark font-monospace mb-2">{{ number_format($totalLoanCount) }}</h2>
                <div class="small text-muted">Under review & approved loans</div>
            </div>
        </div>

        <!-- Pending Investment Orders Card -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden" style="border-left: 4px solid #8b5cf6 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Pending Investment Orders</span>
                    <div class="p-2.5 rounded-3 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-chart-line fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-dark font-monospace mb-2">{{ number_format($pendingTradeCount) }}</h2>
                <div class="small text-muted">Orders awaiting review</div>
            </div>
        </div>
    </div>

    <!-- Recent Registrations Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white border-0 p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-plus me-2 text-primary"></i> Recent Account Registrations</h5>
                <span class="text-muted small">Latest accounts signed up on the platform</span>
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3.5 py-1.5 fw-bold">
                View All Users <i class="fas fa-arrow-right me-1"></i>
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small font-monospace">USER ID</th>
                            <th class="py-3 text-muted small font-monospace">ACCOUNT HOLDER</th>
                            <th class="py-3 text-muted small font-monospace">EMAIL ADDRESS</th>
                            <th class="py-3 text-muted small font-monospace">PHONE</th>
                            <th class="py-3 text-muted small font-monospace">JOINED DATE</th>
                            <th class="pe-4 py-3 text-end text-muted small font-monospace">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td class="ps-4 font-monospace fw-bold text-dark">#{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $user->display_picture ? Storage::url($user->display_picture) : asset('uploads/display/avatar.jpg') }}" alt="Avatar" class="rounded-circle border" style="width: 38px; height: 38px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark mb-0">{{ $user->first_name }} {{ $user->last_name }}</div>
                                            <small class="text-muted font-monospace">{{ $user->account_type ?? 'Standard' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $user->email }}</td>
                                <td class="text-muted small font-monospace">{{ $user->phone ?? 'N/A' }}</td>
                                <td class="text-muted small">{{ $user->created_at->format('M j, Y') }}</td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.profile', $user->id) }}" class="btn btn-light text-primary border-0 rounded-2 me-1" title="Manage User Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="mailto:{{ $user->email }}" class="btn btn-light text-success border-0 rounded-2 me-1" title="Email User">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </div>
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

@include('admin.footer')