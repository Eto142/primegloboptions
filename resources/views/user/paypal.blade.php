@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-extrabold text-dark mb-1"><i class="fab fa-paypal me-2 text-primary"></i> PayPal Withdrawal Gateway</h3>
            <p class="text-muted small mb-0">Transfer funds from your available balance directly into your personal or business PayPal email account.</p>
        </div>
        <div class="d-flex align-items-center gap-2 bg-white p-2.5 rounded-3 shadow-sm border">
            <span class="text-muted small">Available Balance:</span>
            <span class="fw-extrabold font-monospace text-success fs-5">{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}</span>
        </div>
    </div>

    <!-- Server Messages -->
    <div id="server-message"
         data-status="@if(session('status')){{ session('status') }}@endif"
         data-error="@if(session('error')){{ session('error') }}@endif"
         style="display:none;"></div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4">
                <!-- Card Header -->
                <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #023635 80%, #C9A227 100%);">
                    <div class="d-flex justify-content-between align-items-center text-white">
                        <div>
                            <span class="badge rounded-pill px-3 py-1.5 mb-2 font-monospace" style="background: rgba(201,162,39, 0.2); color: #E8C14A; border: 1px solid rgba(201,162,39, 0.4);">
                                <i class="fas fa-bolt me-1"></i> Express PayPal Transfer
                            </span>
                            <h4 class="fw-extrabold mb-0 text-white">PayPal Withdrawal Form</h4>
                        </div>
                        <i class="fab fa-paypal fs-1 text-white opacity-75"></i>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="alert alert-info border-0 rounded-3 d-flex align-items-start gap-3 p-3.5 mb-4" style="background: rgba(158,124,20, 0.08); color: #0284c7;">
                        <i class="fas fa-info-circle fs-4 mt-0.5"></i>
                        <div class="small">
                            <strong>Notice:</strong> Please double-check your PayPal email address. Transferred funds will be credited to your linked PayPal wallet upon approval.
                        </div>
                    </div>

                    <div id="response_code"></div>

                    <form id="paypalForm" action="{{ route('user.withdrawal.paypal.withdrawal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}"/>
                        <input type="hidden" id="pin_routing" value="paypal">

                        <div id="content-one">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark small text-uppercase">Withdrawal Amount ({{ Auth::user()->currency }}) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-dark fw-bold">{{ Auth::user()->currency }}</span>
                                    <input type="number" step="0.01" min="1" name="amount" class="form-control form-control-lg bg-light border-start-0 font-monospace fw-bold py-2.5" placeholder="0.00" required />
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark small text-uppercase">PayPal Registered Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="paypal_email" class="form-control form-control-lg bg-light border-start-0 py-2.5" placeholder="name@example.com" required />
                                </div>
                            </div>

                            <button type="button" id="proceedPayPal" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold py-3 text-white shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #C9A227 100%); border: none;">
                                <i class="fas fa-paper-plane me-2"></i> Proceed to Security PIN Verification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PIN Modal -->
<div class="modal fade" id="pinModalPayPal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10">
                        <i class="fas fa-lock text-info fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mb-0">Security PIN Verification</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted small mb-4">Enter your 4-digit transaction security PIN to authorize this PayPal withdrawal.</p>

                <div id="pinGridPayPal" class="d-flex justify-content-center gap-2 mb-3">
                    <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control form-control-lg text-center font-monospace fw-bold pin-digit" style="width: 55px; height: 60px; font-size: 1.5rem;" aria-label="PIN digit 1" />
                    <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control form-control-lg text-center font-monospace fw-bold pin-digit" style="width: 55px; height: 60px; font-size: 1.5rem;" aria-label="PIN digit 2" />
                    <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control form-control-lg text-center font-monospace fw-bold pin-digit" style="width: 55px; height: 60px; font-size: 1.5rem;" aria-label="PIN digit 3" />
                    <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="form-control form-control-lg text-center font-monospace fw-bold pin-digit" style="width: 55px; height: 60px; font-size: 1.5rem;" aria-label="PIN digit 4" />
                </div>

                <div id="pinErrorPayPal" class="text-danger small mb-3 fw-bold" style="display: none;">
                    <i class="fas fa-exclamation-circle me-1"></i> Please enter your 4-digit PIN.
                </div>

                <div class="d-grid gap-2">
                    <button id="confirmPinPayPal" class="btn btn-success btn-lg fw-bold rounded-3 py-2.5" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">Confirm & Transfer</button>
                    <button class="btn btn-light fw-bold text-muted py-2.5" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 3000;"></div>

@include('user.footer')

<script>
function showToast(message, type = 'info', timeout = 4000) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} alert-dismissible fade show shadow-lg border-0 rounded-3 mb-2`;
    toast.innerHTML = `<div><strong>Notice:</strong> ${message}</div><button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    container.appendChild(toast);
    setTimeout(() => { try { container.removeChild(toast); } catch(e){} }, timeout);
}

document.addEventListener('DOMContentLoaded', function () {
    const paypalForm = document.getElementById('paypalForm');
    const proceedBtn = document.getElementById('proceedPayPal');
    const pinModalPayPalEl = document.getElementById('pinModalPayPal');
    const pinModalPayPal = (typeof bootstrap !== 'undefined') ? new bootstrap.Modal(pinModalPayPalEl, {backdrop: 'static', keyboard: true}) : null;
    const pinGridPayPal = document.getElementById('pinGridPayPal');
    const pinDigitsPayPal = Array.from(pinGridPayPal.querySelectorAll('.pin-digit'));
    const pinErrorPayPal = document.getElementById('pinErrorPayPal');
    const confirmBtnPayPal = document.getElementById('confirmPinPayPal');

    function validatePayPalForm() {
        const amount = paypalForm.querySelector('[name="amount"]');
        const paypalEmail = paypalForm.querySelector('[name="paypal_email"]');
        
        if (!amount.value || amount.value <= 0) {
            showToast('Please enter a valid amount greater than zero.', 'error');
            amount.focus();
            return false;
        }
        
        if (parseFloat(amount.value) > parseFloat('{{ $balance ?? Auth::user()->balance ?? 0 }}')) {
            showToast('Insufficient balance for this withdrawal.', 'error');
            amount.focus();
            return false;
        }
        
        if (!paypalEmail.value.trim()) {
            showToast('Please enter your PayPal email address.', 'error');
            paypalEmail.focus();
            return false;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(paypalEmail.value)) {
            showToast('Please enter a valid email address.', 'error');
            paypalEmail.focus();
            return false;
        }
        
        return true;
    }

    function setupPinInputs(pinDigits) {
        pinDigits.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                const val = (e.target.value || '').replace(/\D/g, '').slice(-1);
                e.target.value = val;
                
                if (val) {
                    e.target.classList.add('is-valid');
                    if (idx < pinDigits.length - 1) {
                        pinDigits[idx + 1].focus();
                    }
                } else {
                    e.target.classList.remove('is-valid');
                }
                
                pinErrorPayPal.style.display = 'none';
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (!input.value && idx > 0) {
                        pinDigits[idx - 1].focus();
                        pinDigits[idx - 1].value = '';
                        pinDigits[idx - 1].classList.remove('is-valid');
                    }
                }
            });
        });
    }

    setupPinInputs(pinDigitsPayPal);

    proceedBtn.addEventListener('click', function () {
        if (!validatePayPalForm()) return;
        
        pinDigitsPayPal.forEach(d => { 
            d.value = ''; 
            d.classList.remove('is-valid'); 
        });
        pinErrorPayPal.style.display = 'none';
        
        if (pinModalPayPal) {
            pinModalPayPal.show();
            setTimeout(() => pinDigitsPayPal[0].focus(), 200);
        }
    });

    confirmBtnPayPal.addEventListener('click', () => {
        const pin = pinDigitsPayPal.map(d => d.value || '').join('');
        
        if (!/^\d{4}$/.test(pin)) {
            pinErrorPayPal.style.display = 'block';
            showToast('Please enter your 4-digit PIN.', 'error');
            return;
        }
        
        pinErrorPayPal.style.display = 'none';
        
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'transaction_pin';
        hiddenInput.value = pin;
        paypalForm.appendChild(hiddenInput);
        
        confirmBtnPayPal.textContent = 'Processing...';
        confirmBtnPayPal.disabled = true;
        
        paypalForm.submit();
    });

    if (pinModalPayPalEl) {
        pinModalPayPalEl.addEventListener('hidden.bs.modal', function () {
            confirmBtnPayPal.disabled = false;
            confirmBtnPayPal.textContent = 'Confirm & Transfer';
        });
    }

    (function showServerMessage() {
        const server = document.getElementById('server-message');
        if (!server) return;
        
        const s = server.getAttribute('data-status') || '';
        const e = server.getAttribute('data-error') || '';
        
        if (s) {
            showToast(s, 'success');
        } else if (e) {
            showToast(e, 'error');
        }
    })();
});
</script>