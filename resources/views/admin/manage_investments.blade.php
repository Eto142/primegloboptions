@include('admin.header')

<div class="main-content p-3 p-md-4" id="mainContent">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-extrabold text-dark mb-1">Investment Plans</h2>
            <p class="text-muted small mb-0">Manage user investment plan purchases, activate plans, and credit profits.</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger border-0 rounded-3 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-muted small fw-semibold mb-1"><i class="fas fa-layer-group me-1 text-primary"></i> Total Plans</div>
                <div class="fs-4 fw-extrabold text-dark">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-muted small fw-semibold mb-1"><i class="fas fa-clock me-1 text-warning"></i> Pending</div>
                <div class="fs-4 fw-extrabold text-warning">{{ $stats['pending'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-muted small fw-semibold mb-1"><i class="fas fa-check-circle me-1 text-success"></i> Active</div>
                <div class="fs-4 fw-extrabold text-success">{{ $stats['active'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-3 p-3 h-100">
                <div class="text-muted small fw-semibold mb-1"><i class="fas fa-dollar-sign me-1 text-primary"></i> Total Invested</div>
                <div class="fs-4 fw-extrabold text-primary">${{ number_format($stats['total_amount'], 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">All Investment Plans</h5>
            <form method="GET" class="d-flex gap-2 flex-wrap">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search user, plan, TXN ID..." value="{{ request('search') }}">
                <select name="status" class="form-select form-select-sm" style="width:auto;">
                    <option value="">All Status</option>
                    <option value="pending"   {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active"     {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed"  {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled"  {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button class="btn btn-sm btn-primary text-nowrap" type="submit"><i class="fas fa-filter"></i> Filter</button>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table custom-table table-hover align-middle mb-0" id="highlightRowColumn">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>ROI</th>
                            <th>Duration</th>
                            <th>Est. Return</th>
                            <th>Matures</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark">{{ $plan->user->first_name ?? '' }} {{ $plan->user->last_name ?? '' }}</div>
                                <div class="small text-muted">{{ $plan->user->email ?? '' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $plan->plan_name }}</div>
                                <div class="small text-muted font-monospace">#{{ $plan->transaction_id }}</div>
                            </td>
                            <td class="fw-bold">${{ number_format($plan->amount, 2) }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success">{{ number_format($plan->roi_percent, 1) }}%</span></td>
                            <td class="text-muted small">{{ $plan->plan_duration }}</td>
                            <td class="fw-bold text-success">+${{ number_format($plan->return_amount, 2) }}</td>
                            <td class="small text-muted">
                                {{ $plan->matures_at ? $plan->matures_at->format('M j, Y') : '—' }}
                            </td>
                            <td>
                                @if ($plan->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif ($plan->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif ($plan->status === 'completed')
                                    <span class="badge bg-primary">Completed</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $plan->created_at->format('M j, Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if ($plan->status === 'pending')
                                        <li>
                                            <form action="{{ route('admin.investment.activate', $plan->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check-circle me-1"></i> Activate Plan
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if ($plan->status === 'active')
                                        <li>
                                            <form action="{{ route('admin.investment.complete', $plan->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-primary">
                                                    <i class="fas fa-flag-checkered me-1"></i> Complete & Credit Profit
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        @if ($plan->status === 'pending' || $plan->status === 'active')
                                        <li>
                                            <form action="{{ route('admin.investment.cancel', $plan->id) }}" method="POST"
                                                  onsubmit="return confirm('Cancel this investment plan?');">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-times-circle me-1"></i> Cancel Plan
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addProfitModal"
                                                    data-user-id="{{ $plan->user_id }}"
                                                    data-user-name="{{ $plan->user->first_name ?? '' }} {{ $plan->user->last_name ?? '' }}"
                                                    data-plan-name="{{ $plan->plan_name }}">
                                                <i class="fas fa-plus-circle me-1 text-success"></i> Add Profit
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addEarningModal"
                                                    data-user-id="{{ $plan->user_id }}"
                                                    data-user-name="{{ $plan->user->first_name ?? '' }} {{ $plan->user->last_name ?? '' }}">
                                                <i class="fas fa-gift me-1 text-primary"></i> Add Earning
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if ($plans->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="fas fa-chart-line fs-2 mb-2 d-block"></i>
                                No investment plans found.
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($plans->hasPages())
            <div class="card-footer">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0 text-muted small">
                        Showing
                        <span class="fw-semibold">{{ $plans->firstItem() ?? 0 }}</span>
                        to
                        <span class="fw-semibold">{{ $plans->lastItem() ?? 0 }}</span>
                        of
                        <span class="fw-semibold">{{ $plans->total() }}</span>
                        plans
                    </div>
                    {{ $plans->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Add Profit Modal --}}
<div class="modal fade" id="addProfitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.investment.add-profit') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle text-success me-2"></i>Add Profit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="profitUserId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">User</label>
                        <input type="text" class="form-control" id="profitUserName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Plan Name</label>
                        <input type="text" name="plan_name" class="form-control" id="profitPlanName" placeholder="e.g. Growth Plan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Amount ($)</label>
                        <input type="number" name="amount" class="form-control" min="0.01" step="0.01" placeholder="0.00" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill"><i class="fas fa-check me-1"></i> Add Profit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add Earning Modal --}}
<div class="modal fade" id="addEarningModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.investment.add-earning') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-gift text-primary me-2"></i>Add Earning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="earningUserId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">User</label>
                        <input type="text" class="form-control" id="earningUserName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Type</label>
                        <input type="text" name="type" class="form-control" placeholder="e.g. referral, bonus" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Amount ($)</label>
                        <input type="number" name="amount" class="form-control" min="0.01" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Narration</label>
                        <input type="text" name="narration" class="form-control" placeholder="e.g. Referral bonus for inviting John" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill"><i class="fas fa-check me-1"></i> Add Earning</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('addProfitModal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('profitUserId').value   = btn.dataset.userId;
        document.getElementById('profitUserName').value = btn.dataset.userName;
        document.getElementById('profitPlanName').value = btn.dataset.planName || '';
    });

    document.getElementById('addEarningModal').addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('earningUserId').value   = btn.dataset.userId;
        document.getElementById('earningUserName').value = btn.dataset.userName;
    });
</script>

@include('admin.footer')
