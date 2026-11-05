@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-extrabold text-dark mb-1">Loans & Credit Facility</h3>
            <p class="text-muted small mb-0">Apply for quick low-interest personal and business loans directly into your account balance.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0284c7, #C9A227); border: none;" data-bs-toggle="modal" data-bs-target="#loanModal">
                <i class="fas fa-hand-holding-usd"></i> Request Instant Loan
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-exclamation-circle fs-4 text-danger"></i>
            <div><strong>Notice:</strong> {{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-check-circle fs-4 text-success"></i>
            <div><strong>Loan Application Status:</strong> {{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Outstanding Loan</span>
                    <div class="p-2.5 rounded-3 bg-secondary bg-opacity-10 text-secondary">
                        <i class="fas fa-balance-scale fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-dark font-monospace mb-1">{{ Auth::user()->currency }}{{ number_format($outstanding_loan ?? 0, 2) }}</h2>
                <div class="text-muted small">Current active loan balance</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden" style="border-left: 4px solid #10b981 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Eligible Loan Credit</span>
                    <div class="p-2.5 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="fas fa-check-circle fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-success font-monospace mb-1">{{ Auth::user()->currency }}{{ number_format(Auth::user()->eligible_loan ?? 0, 2) }}</h2>
                <div class="text-muted small">Maximum instant approval limit</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100 position-relative overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold text-uppercase tracking-wider">Pending Requests</span>
                    <div class="p-2.5 rounded-3 bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-clock fs-5"></i>
                    </div>
                </div>
                <h2 class="fw-extrabold text-warning font-monospace mb-1">{{ Auth::user()->currency }}{{ number_format($pending_loan ?? 0, 2) }}</h2>
                <div class="text-muted small">Applications awaiting review</div>
            </div>
        </div>
    </div>

    <!-- Loan History Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history me-2 text-primary"></i> Loan Applications History</h5>
                <span class="text-muted small">Loans are approved based on account tenure & verification tier</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small font-monospace">REFERENCE #</th>
                            <th class="py-3 text-muted small font-monospace">AMOUNT</th>
                            <th class="py-3 text-muted small font-monospace">DATE REQUESTED</th>
                            <th class="py-3 text-muted small font-monospace">ACCOUNT NO.</th>
                            <th class="pe-4 py-3 text-end text-muted small font-monospace">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaction as $details)
                            <tr>
                                <td class="ps-4 fw-bold font-monospace text-dark">{{ $details->transaction_ref }}</td>
                                <td class="fw-extrabold font-monospace text-dark">{{ Auth::user()->currency }}{{ number_format($details->transaction_amount, 2) }}</td>
                                <td class="text-muted small">{{ \Carbon\Carbon::parse($details->transaction_created_at)->format('D, M j, Y g:i A') }}</td>
                                <td class="font-monospace text-muted">{{ Auth::user()->account_number ?? Auth::user()->a_number }}</td>
                                <td class="pe-4 text-end">
                                    @if($details->transaction_status == '1')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-bold"><i class="fas fa-check-circle me-1"></i> Approved</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1.5 fw-bold"><i class="fas fa-clock me-1"></i> Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-hand-holding-usd fs-2 mb-2 text-muted opacity-50 d-block"></i>
                                    No loan history records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Loan Request Modal -->
<div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="loanModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10">
                        <i class="fas fa-coins text-info fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mb-0" id="loanModalTitle">Loan Application Form</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="loanForm" action="{{ route('user.loans.make.loan') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Loan Amount ({{ Auth::user()->currency }}) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control form-control-lg font-monospace fw-bold py-2.5" placeholder="0.00" required />
                        <small class="text-muted mt-1 d-block">Maximum Eligible: {{ Auth::user()->currency }}{{ number_format(Auth::user()->eligible_loan ?? 0, 2) }}</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Purpose / Reason for Loan <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control py-2.5" rows="3" placeholder="Briefly describe what this loan is intended for..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">Transaction Security PIN <span class="text-danger">*</span></label>
                        <input type="password" maxlength="4" name="pin" class="form-control text-center font-monospace tracking-widest fw-bold py-2.5" placeholder="••••" required />
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3 py-2.5" style="background: linear-gradient(135deg, #0284c7 0%, #C9A227 100%); border: none;">
                            <i class="fas fa-paper-plane me-1.5"></i> Submit Loan Request
                        </button>
                        <button type="button" class="btn btn-light fw-bold text-muted py-2.5" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('user.footer')