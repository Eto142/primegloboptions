@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-extrabold text-dark mb-1">Fund Your Account</h3>
            <p class="text-muted small mb-0">Select your preferred deposit method to add funds instantly to your available balance.</p>
        </div>
        <div class="d-flex align-items-center gap-2 bg-white p-2.5 rounded-3 shadow-sm border">
            <span class="text-muted small">Available Balance:</span>
            <span class="fw-extrabold font-monospace text-success fs-5">{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}</span>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-exclamation-circle fs-4 text-danger"></i>
            <div><strong>Error Notice:</strong> {{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-check-circle fs-4 text-success"></i>
            <div><strong>Deposit Update:</strong> {{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Deposit Options -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4 bg-white">
                <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #004d4a 0%, #007875 45%, #009691 85%, #00a9a4 100%);">
                    <div class="d-flex justify-content-between align-items-center text-white">
                        <div>
                            <span class="badge rounded-pill px-3 py-1.5 mb-2 font-monospace" style="background: rgba(0, 169, 164, 0.2); color: #20c9c3; border: 1px solid rgba(0, 169, 164, 0.4);">
                                <i class="fas fa-wallet me-1"></i> Instant Deposit Gateway
                            </span>
                            <h4 class="fw-extrabold mb-0 text-white">Mobile Check Deposit</h4>
                        </div>
                        <i class="fas fa-money-check-alt fs-1 opacity-75"></i>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center mb-4 g-4">
                        <div class="col-md-4 text-center">
                            <div class="p-4 rounded-4 bg-light border text-center">
                                <img src="{{ asset('cheque.png') }}" alt="Check Deposit" class="img-fluid mb-2" style="max-height: 100px;">
                                <div class="fw-bold text-dark small">Check Capture Scanner</div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="fw-bold text-dark mb-2">Deposit Checks Remotely</h5>
                            <p class="text-muted small mb-3">Snap and upload front & back images of your certified bank check or paycheck for quick clearing into your account.</p>
                            <button type="button" class="btn btn-primary rounded-3 px-4 py-2.5 fw-bold shadow-sm" style="background: linear-gradient(135deg, #0284c7, #00a9a4); border: none;" data-bs-toggle="modal" data-bs-target="#fiatModalIndex">
                                <i class="fas fa-camera me-2"></i> Start Mobile Check Deposit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-bolt text-warning me-2"></i> Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('user.transfer.bank') }}" class="btn btn-light rounded-3 py-2.5 text-start fw-bold d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-university text-primary me-2"></i> Bank Wire Transfer</span>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ route('user.transactions') }}" class="btn btn-light rounded-3 py-2.5 text-start fw-bold d-flex align-items-center justify-content-between">
                        <span><i class="fas fa-history text-success me-2"></i> Deposit History</span>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-info-circle text-info me-2"></i> Deposit Guidelines</h6>
                <ul class="text-muted small ps-3 mb-0">
                    <li class="mb-2">Ensure check payee name matches your registered full account name.</li>
                    <li class="mb-2">Checks usually process within 12 - 24 business hours.</li>
                    <li>For crypto or wire deposits, contact live support for dedicated wallet details.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Check Deposit Modal -->
<div class="modal fade" id="fiatModalIndex" tabindex="-1" aria-labelledby="fiatModalIndexTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10">
                        <i class="fas fa-money-check text-info fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mb-0" id="fiatModalIndexTitle">Mobile Check Deposit Form</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('user.deposit.make.deposit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}"/>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Check Amount ({{ Auth::user()->currency }}) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" class="form-control form-control-lg font-monospace fw-bold py-2.5" placeholder="0.00" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase"><i class="fas fa-upload me-1 text-primary"></i> Upload Check Front & Back Slip <span class="text-danger">*</span></label>
                        <input type="file" name="front_cheque" class="form-control py-2.5" accept="image/*" required />
                        <small class="text-muted mt-1 d-block">Clear JPG, PNG, or PDF images up to 5MB.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">4-Digit Transaction PIN <span class="text-danger">*</span></label>
                        <input type="password" maxlength="4" name="transaction_pin" class="form-control text-center font-monospace tracking-widest fw-bold py-2.5" placeholder="••••" required />
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3 py-2.5" style="background: linear-gradient(135deg, #0284c7 0%, #00a9a4 100%); border: none;">
                            <i class="fas fa-paper-plane me-1.5"></i> Submit Check Deposit
                        </button>
                        <button type="button" class="btn btn-light fw-bold text-muted py-2.5" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('user.footer')