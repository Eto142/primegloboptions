@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header Page Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-extrabold text-dark mb-1">Virtual & Physical Cards</h3>
            <p class="text-muted small mb-0">Manage your Primegloboptions Bank debit cards, security limits, and instant delivery requests.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-3.5 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0284c7, #C9A227); border: none;" data-bs-toggle="modal" data-bs-target="#requestFormModal">
                <i class="fas fa-plus-circle"></i> Request Card Delivery
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-exclamation-circle fs-4 text-danger"></i>
            <div><strong>Error:</strong> {{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-check-circle fs-4 text-success"></i>
            <div><strong>Success:</strong> {{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Card Display Column -->
        <div class="col-lg-6 col-xl-5">
            @forelse($details as $detail)
                @if($detail->status == 0)
                    <!-- Card Under Review -->
                    <div class="card border-0 shadow-lg rounded-4 text-white p-4 overflow-hidden mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); position: relative; min-height: 250px;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge bg-warning text-dark font-monospace px-3 py-1.5 fw-bold"><i class="fas fa-clock me-1"></i> Under Review</span>
                            <i class="fas fa-shield-alt text-white-50 fs-3"></i>
                        </div>
                        <div class="my-auto text-center py-3">
                            <h5 class="fw-bold text-white mb-2">Card Application Under Review</h5>
                            <p class="text-white-50 small mb-0">Our risk management team is reviewing your card request. You will be notified once activated.</p>
                        </div>
                    </div>
                @else
                    <!-- Ultra-Premium Debit Card Visual (Interactive Flip/Reveal) -->
                    <div class="card border-0 shadow-lg rounded-4 text-white p-4 overflow-hidden mb-4 position-relative" style="background: linear-gradient(135deg, #7A5A0A 0%, #9E7C14 45%, #B08A20 85%, #C9A227 100%); min-height: 260px; border: 1px solid rgba(255,255,255,0.2) !important; box-shadow: 0 20px 40px -10px rgba(201,162,39, 0.3) !important;">
                        <!-- Ambient Glows -->
                        <div style="position: absolute; right: -40px; top: -40px; width: 200px; height: 200px; background: rgba(201,162,39, 0.35); filter: blur(50px); border-radius: 50%; pointer-events: none;"></div>
                        <div style="position: absolute; left: -40px; bottom: -40px; width: 180px; height: 180px; background: rgba(158,124,20, 0.25); filter: blur(45px); border-radius: 50%; pointer-events: none;"></div>

                        <div class="d-flex justify-content-between align-items-center position-relative z-1 mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-extrabold font-manrope text-white tracking-wider" style="font-size: 1.1rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Primegloboptions</span>
                            </div>
                            <i class="fab fa-cc-mastercard text-white fs-1 opacity-90"></i>
                        </div>

                        <!-- Chip & Contactless -->
                        <div class="d-flex align-items-center gap-3 position-relative z-1 my-2">
                            <div style="width: 48px; height: 36px; background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border-radius: 6px; border: 1px solid rgba(255,255,255,0.4); box-shadow: inset 0 0 4px rgba(0,0,0,0.3);"></div>
                            <i class="fas fa-wifi text-white-50 fs-5" style="transform: rotate(90deg);"></i>
                        </div>

                        <!-- Card Number -->
                        <div class="position-relative z-1 mt-3 mb-3">
                            <div class="text-white-50 text-uppercase font-monospace small" style="letter-spacing: 1px; font-size: 0.7rem;">Card Number</div>
                            <div class="d-flex align-items-center gap-3">
                                <h4 class="fw-bold text-white font-monospace mb-0" id="cardNumberDisplay" style="letter-spacing: 2.5px; text-shadow: 0 2px 8px rgba(0,0,0,0.6);">
                                    •••• •••• •••• {{ substr($detail->card_number, -4) }}
                                </h4>
                                <button type="button" class="btn btn-sm btn-link text-info p-0" id="toggleCardDetails" title="Toggle Card Visibility">
                                    <i class="far fa-eye fs-6" id="cardEyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Footer Details: Expiry, CVV, Cardholder -->
                        <div class="d-flex justify-content-between align-items-end position-relative z-1 mt-auto pt-2 border-top border-white border-opacity-10">
                            <div>
                                <div class="text-white-50 text-uppercase font-monospace" style="font-size: 0.65rem;">Cardholder</div>
                                <div class="fw-extrabold text-white font-manrope text-uppercase" style="font-size: 0.95rem;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                            </div>
                            <div class="d-flex gap-4">
                                <div>
                                    <div class="text-white-50 text-uppercase font-monospace" style="font-size: 0.65rem;">Expires</div>
                                    <div class="fw-bold text-white font-monospace" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($detail->card_expiry)->format('m/y') }}</div>
                                </div>
                                <div>
                                    <div class="text-white-50 text-uppercase font-monospace" style="font-size: 0.65rem;">CVV</div>
                                    <div class="fw-bold text-white font-monospace" id="cvvDisplay" style="font-size: 0.9rem;">•••</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Card Controls -->
                    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark small">Card Status</span>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold"><i class="fas fa-check-circle me-1"></i> Active</span>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <button type="button" class="btn btn-outline-dark rounded-3 fw-bold btn-sm py-2 d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#requestFormModal">
                                <i class="fas fa-truck text-primary"></i> Order Physical Card Delivery
                            </button>
                        </div>
                    </div>
                @endif
            @empty
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white mb-4">
                    <div class="p-3 rounded-circle bg-light d-inline-flex mb-3 mx-auto">
                        <i class="fas fa-credit-card fs-1 text-muted"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">No Active Card Found</h5>
                    <p class="text-muted small mb-4">You do not have any physical or virtual card attached to your account yet.</p>
                    <a href="{{ route('user.cards.request.card', Auth::user()->id) }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-bold mx-auto" style="background: linear-gradient(135deg, #0284c7, #C9A227); border: none;">
                        <i class="fas fa-plus-circle me-1.5"></i> Request New Card Now
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Details & Features Column -->
        <div class="col-lg-6 col-xl-7">
            <!-- Account Profile Info Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-shield me-2 text-primary"></i> Account Verification Data</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 bg-light">
                                <div class="text-muted small mb-1">First Name</div>
                                <div class="fw-bold text-dark">{{ Auth::user()->first_name }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 bg-light">
                                <div class="text-muted small mb-1">Last Name</div>
                                <div class="fw-bold text-dark">{{ Auth::user()->last_name }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 bg-light">
                                <div class="text-muted small mb-1">Date of Birth</div>
                                <div class="fw-bold text-dark">{{ Auth::user()->dob ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3 bg-light">
                                <div class="text-muted small mb-1">Gender</div>
                                <div class="fw-bold text-dark text-capitalize">{{ Auth::user()->gender ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Security Features -->
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-shield-alt me-2 text-success"></i> Security & Card Benefits</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <div class="p-2.5 rounded-3 bg-success bg-opacity-10 text-success">
                            <i class="fas fa-bolt fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Instant Activation</h6>
                            <p class="text-muted small mb-0">Virtual cards are instantly ready for online checkout upon admin approval.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <div class="p-2.5 rounded-3 bg-info bg-opacity-10 text-info">
                            <i class="fas fa-lock fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">End-to-End Encryption</h6>
                            <p class="text-muted small mb-0">Protected by 256-bit SSL encryption for secure worldwide POS & online transactions.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2.5 rounded-3 bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-globe fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Zero Foreign Transaction Fee</h6>
                            <p class="text-muted small mb-0">Seamless multi-currency transactions with no hidden conversion markups.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Request Physical Card Delivery Modal -->
<div class="modal fade" id="requestFormModal" tabindex="-1" aria-labelledby="requestFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10">
                        <i class="fas fa-shipping-fast text-info fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mb-0" id="requestFormModalLabel">Physical Card Delivery Request</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="requestForm" action="{{ route('user.cards.requestcard.delivery') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Full Name</label>
                        <input type="text" class="form-control py-2.5" id="fullName" name="fname" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Delivery House Address</label>
                        <input type="text" class="form-control py-2.5" id="houseAddress" name="address" placeholder="123 Street Name, City, Country" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Contact Phone Number</label>
                        <input type="tel" class="form-control py-2.5" id="phoneNumber" name="phone" value="{{ Auth::user()->phone_number }}" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Email Address</label>
                        <input type="email" class="form-control py-2.5" id="emailAddress" name="emailAddress" value="{{ Auth::user()->email }}" required />
                    </div>
                </form>
            </div>
            <div class="modal-footer p-3 bg-light">
                <button type="button" class="btn btn-light fw-bold text-muted px-4" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3" form="requestForm" style="background: linear-gradient(135deg, #0284c7, #C9A227); border: none;">Submit Request</button>
            </div>
        </div>
    </div>
</div>

@include('user.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleCardDetails');
        const numDisplay = document.getElementById('cardNumberDisplay');
        const cvvDisplay = document.getElementById('cvvDisplay');
        const eyeIcon = document.getElementById('cardEyeIcon');

        let revealed = false;

        if (toggleBtn && numDisplay && cvvDisplay) {
            toggleBtn.addEventListener('click', function() {
                revealed = !revealed;
                if (revealed) {
                    @if(isset($detail) && $detail)
                        numDisplay.textContent = "{{ implode(' ', str_split($detail->card_number, 4)) }}";
                        cvvDisplay.textContent = "{{ $detail->card_cvc }}";
                    @endif
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    @if(isset($detail) && $detail)
                        numDisplay.textContent = "•••• •••• •••• {{ substr($detail->card_number, -4) }}";
                        cvvDisplay.textContent = "•••";
                    @endif
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        }
    });
</script>