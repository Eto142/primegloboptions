@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: #ffffff;">
                <!-- Card Header -->
                <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #023635 80%, #C9A227 100%); position: relative;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 text-white position-relative z-1">
                        <div>
                            <span class="badge rounded-pill px-3 py-1.5 mb-2 font-monospace" style="background: rgba(201,162,39, 0.2); color: #E8C14A; border: 1px solid rgba(201,162,39, 0.4); font-size: 0.78rem;">
                                <i class="fas fa-paper-plane me-1"></i> Wire & Transfer Portal
                            </span>
                            <h4 class="fw-extrabold mb-1 text-white">Transfer Funds</h4>
                            <p class="text-white-50 small mb-0">Send instant wire payments to local & international bank accounts securely.</p>
                        </div>
                        <div class="text-end bg-white bg-opacity-10 backdrop-blur rounded-3 p-3 border border-white border-opacity-10">
                            <span class="text-white-50 small d-block">Available Balance</span>
                            <span class="fs-4 fw-extrabold text-white font-monospace">{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 p-md-5">
                    @if (session('error'))
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
                            <i class="fas fa-exclamation-circle fs-4 text-danger"></i>
                            <div>
                                <strong>Error Notice:</strong> {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session('status'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
                            <i class="fas fa-check-circle fs-4 text-success"></i>
                            <div>
                                <strong>Success:</strong> {{ session('status') }}
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('transfer.funds') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Account Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-user"></i></span>
                                    <input type="text" name="account_name" class="form-control bg-light border-start-0 py-2.5" placeholder="Beneficiary Account Name" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Account Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-hashtag"></i></span>
                                    <input type="number" name="account_number" class="form-control bg-light border-start-0 py-2.5 font-monospace" placeholder="e.g. 1029384756" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Bank Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-university"></i></span>
                                    <input type="text" name="bank_name" class="form-control bg-light border-start-0 py-2.5" placeholder="e.g. Chase Bank, Barclays" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Routing / Swift Code <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-code-branch"></i></span>
                                    <input type="text" name="routing_number" class="form-control bg-light border-start-0 py-2.5 font-monospace" placeholder="Enter Routing / SWIFT Code" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Account Type <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-wallet"></i></span>
                                    <select name="account_type" class="form-select bg-light border-start-0 py-2.5">
                                        <option value="Savings Account" selected>Savings Account</option>
                                        <option value="Current Account">Current Account</option>
                                        <option value="Checking Account">Checking Account</option>
                                        <option value="Business Account">Business Account</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Transfer Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-dark fw-bold">{{ Auth::user()->currency }}</span>
                                    <input type="number" step="0.01" name="amount" class="form-control bg-light border-start-0 py-2.5 font-monospace fw-bold" placeholder="0.00" required />
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Payment Description / Reference (Optional)</label>
                                <textarea class="form-control bg-light py-2.5" name="description" rows="3" placeholder="Add a note or invoice description..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-lg w-100 rounded-3 text-white fw-bold shadow-sm py-3" style="background: linear-gradient(135deg, #0284c7 0%, #C9A227 100%); border: none;" data-bs-toggle="modal" data-bs-target="#otpModal">
                                <i class="fas fa-paper-plane me-2"></i> Review & Authorize Transfer
                            </button>
                        </div>

                        <!-- OTP Verification Modal -->
                        <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                    <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle p-2 bg-white bg-opacity-10">
                                                <i class="fas fa-shield-alt text-info fs-5"></i>
                                            </div>
                                            <h5 class="modal-title fw-bold text-white mb-0" id="otpModalTitle">Security Authorization</h5>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 text-center">
                                        <p class="text-muted small mb-4">Please enter your authorization OTP code or transaction PIN to execute this wire transfer.</p>
                                        
                                        <div class="mb-4 text-start">
                                            <label class="form-label fw-bold small text-uppercase">Authorization OTP / PIN</label>
                                            <input type="text" name="otp" class="form-control form-control-lg text-center font-monospace tracking-widest fw-bold py-3" placeholder="••••••" required />
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success btn-lg fw-bold rounded-3 py-2.5" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                                                <i class="fas fa-check-circle me-1.5"></i> Confirm & Send Funds
                                            </button>
                                            <button type="button" class="btn btn-light btn-lg fw-bold rounded-3 text-muted py-2.5" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('user.footer')
