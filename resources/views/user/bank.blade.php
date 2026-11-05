@include('user.header')

<style>
/* ---------- Modern Design Variables ---------- */
:root {
  --primary: #C9A227;
  --primary-dark: #9E7C14;
  --primary-gradient: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #023635 80%, #C9A227 100%);
  --success: #10b981;
  --error: #ef4444;
  --warning: #f59e0b;
  --background: #f8fafc;
  --surface: #ffffff;
  --text-primary: #1e293b;
  --text-secondary: #64748b;
  --border: #e2e8f0;
  --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
  --shadow-lg: 0 20px 40px -10px rgba(0, 0, 0, 0.12), 0 4px 6px -2px rgba(0, 0, 0, 0.06);
}

/* ---------- Layout & Container ---------- */
.container-card {
  max-width: 960px;
  margin: 32px auto;
  padding: 0 16px;
}

.card-pro {
  border-radius: 24px;
  box-shadow: var(--shadow-lg);
  border: 1px solid rgba(0, 0, 0, 0.06);
  overflow: hidden;
  background: var(--surface);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-pro:hover {
  transform: translateY(-2px);
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.18);
}

.card-pro .card-header {
  background: var(--primary-gradient);
  border-bottom: 1px solid rgba(255, 255, 255, 0.12);
  padding: 28px 36px;
  color: white;
  position: relative;
  overflow: hidden;
}

.card-pro .card-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.1) 100%);
}

.card-pro .card-body { 
  padding: 32px; 
}

/* ---------- Typography & Text ---------- */
.card-pro .card-header h5 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 4px;
  position: relative;
  z-index: 1;
}

.card-pro .card-header small {
  opacity: 0.9;
  font-weight: 400;
  position: relative;
  z-index: 1;
}

.balance-display {
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  padding: 12px 16px;
  border: 1px solid rgba(255,255,255,0.2);
  position: relative;
  z-index: 1;
}

.balance-display .fw-600 {
  font-size: 0.875rem;
  opacity: 0.9;
}

.balance-display div:last-child {
  font-size: 1.25rem;
  font-weight: 700;
}

/* ---------- Form Elements ---------- */
.form-label {
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 8px;
  font-size: 0.9rem;
}

.form-control {
  border: 2px solid var(--border);
  border-radius: 12px;
  padding: 12px 16px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: var(--surface);
}

.form-control:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
  transform: translateY(-1px);
}

.form-control::placeholder {
  color: #94a3b8;
}

/* ---------- Buttons ---------- */
.btn {
  border-radius: 12px;
  padding: 14px 24px;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s ease;
  border: none;
  position: relative;
  overflow: hidden;
}

.btn-primary {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
}

.btn-success {
  background: linear-gradient(135deg, var(--success) 0%, #047857 100%);
  box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-success:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(5, 150, 105, 0.4);
}

.btn-outline-secondary {
  border: 2px solid var(--border);
  background: transparent;
  color: var(--text-secondary);
}

.btn-outline-secondary:hover {
  background: var(--background);
  border-color: var(--text-secondary);
}

/* ---------- PIN Inputs ---------- */
.pin-grid {
  display: flex;
  gap: 16px;
  justify-content: center;
  margin: 24px 0 8px;
}

.pin-digit {
  width: 72px;
  height: 72px;
  border-radius: 16px;
  font-size: 32px;
  font-weight: 600;
  text-align: center;
  border: 2px solid var(--border);
  background: var(--surface);
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
  color: var(--text-primary);
  -moz-appearance: textfield;
}

.pin-digit:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
  transform: scale(1.05);
}

.pin-digit.filled {
  border-color: var(--success);
  background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

/* Remove number input arrows */
.pin-digit::-webkit-outer-spin-button,
.pin-digit::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* ---------- Modal Design ---------- */
.modal-content {
  border-radius: 20px;
  overflow: hidden;
  border: none;
  box-shadow: var(--shadow-lg);
}

.modal-header {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  border-bottom: none;
  padding: 20px 24px;
  color: white;
  position: relative;
  overflow: hidden;
}

.modal-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.1) 100%);
}

.modal-title {
  font-weight: 600;
  font-size: 1.25rem;
  position: relative;
  z-index: 1;
}

.modal-body {
  padding: 32px;
}

.btn-close-white {
  filter: invert(1) brightness(100%);
  opacity: 0.8;
  position: relative;
  z-index: 1;
}

.btn-close-white:hover {
  opacity: 1;
}

/* ---------- Toast Notifications ---------- */
.bank-toast {
  position: fixed;
  top: 24px;
  right: 24px;
  z-index: 3000;
  display: flex;
  gap: 16px;
  align-items: center;
  min-width: 340px;
  max-width: 440px;
  padding: 16px 20px;
  border-radius: 16px;
  color: white;
  box-shadow: var(--shadow-lg);
  transform: translateX(100%) translateY(-20px);
  opacity: 0;
  transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
  backdrop-filter: blur(10px);
}

.bank-toast.show {
  transform: translateX(0) translateY(0);
  opacity: 1;
}

.bank-toast .icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 0 0 48px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(5px);
}

.bank-toast.success { 
  background: linear-gradient(135deg, var(--success) 0%, #047857 100%);
}

.bank-toast.error { 
  background: linear-gradient(135deg, var(--error) 0%, #b91c1c 100%);
}

.bank-toast.info { 
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
}

.bank-toast .text { 
  font-size: 15px; 
  line-height: 1.4;
  font-weight: 500;
}

/* fade out */
.bank-toast.hide { 
  opacity: 0;
  transform: translateX(100%) translateY(-20px);
  transition: all 0.3s ease;
}

/* ---------- Responsive Design ---------- */
@media (max-width: 768px) {
  .container-card {
    margin: 16px auto;
    padding: 0 12px;
  }
  
  .card-pro .card-body {
    padding: 24px 20px;
  }
  
  .pin-digit {
    width: 56px;
    height: 56px;
    font-size: 24px;
  }
  
  .bank-toast {
    left: 16px;
    right: 16px;
    top: 16px;
    min-width: unset;
    max-width: unset;
  }
  
  .modal-body {
    padding: 24px 20px;
  }
}

@media (max-width: 480px) {
  .pin-grid {
    gap: 12px;
  }
  
  .pin-digit {
    width: 48px;
    height: 48px;
    font-size: 20px;
  }
  
  .card-pro .card-header {
    padding: 20px 16px;
  }
  
  .balance-display {
    padding: 8px 12px;
  }
}

/* ---------- Loading Animation ---------- */
.btn-loading {
  position: relative;
  color: transparent;
}

.btn-loading::after {
  content: '';
  position: absolute;
  width: 20px;
  height: 20px;
  top: 50%;
  left: 50%;
  margin-left: -10px;
  margin-top: -10px;
  border: 2px solid transparent;
  border-top-color: currentColor;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* ---------- Form Validation Styles ---------- */
.form-control.is-invalid {
  border-color: var(--error);
  box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.invalid-feedback {
  font-size: 0.875rem;
  color: var(--error);
  margin-top: 4px;
  font-weight: 500;
}
</style>

<div class="container container-card">
  <div class="card card-pro">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-0">Bank Transfer</h5>
        <small class="text-muted">Transfer from your available balance  this action cannot be reversed.</small>
      </div>
      <div class="balance-display text-end">
        <div class="fw-600" >Available Balance</div>
        <div style="color:white">{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2, '.', ',') }}</div>
      </div>
    </div>

    <div class="card-body">
      {{-- Server messages are injected as data attributes for JS to show toast (no visual duplication) --}}
      <div id="server-message"
           data-status="@if(session('status')){{ session('status') }}@endif"
           data-error="@if(session('error')){{ session('error') }}@endif"
           style="display:none;"></div>

      <form id="transferForm" action="{{ route('user.transfer.bank.transfer') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="email" value="{{ Auth::user()->email }}">

        <div class="row gx-4">
          <div class="col-md-6 mb-4">
            <label class="form-label">Amount <span class="text-danger">*</span></label>
            <input name="amount" type="number" min="1" step="0.01" class="form-control" required placeholder="0.00">
            <div class="invalid-feedback">Please enter a valid amount greater than zero.</div>
          </div>

          <div class="col-md-6 mb-4">
            <label class="form-label">Account Name <span class="text-danger">*</span></label>
            <input name="account_name" type="text" class="form-control" required placeholder="Enter Account Name">
            <div class="invalid-feedback">Please enter the account name.</div>
          </div>

          <div class="col-md-6 mb-4">
            <label class="form-label">Account Number <span class="text-danger">*</span></label>
            <input name="account_number" type="text" inputmode="numeric" pattern="\d*" class="form-control" required placeholder="1234567890">
            <div class="invalid-feedback">Please enter a valid account number.</div>
          </div>

          <div class="col-md-6 mb-4">
            <label class="form-label">Bank Name <span class="text-danger">*</span></label>
            <input name="bank_name" type="text" class="form-control" required placeholder="Enter Bank Name">
            <div class="invalid-feedback">Please enter the bank name.</div>
          </div>

          <div class="col-md-6 mb-4">
            <label class="form-label">Branch Code <span class="text-danger">*</span></label>
            <input name="branch_code" type="text" class="form-control" required placeholder="000">
            <div class="invalid-feedback">Please enter the branch code.</div>
          </div>

          <div class="col-md-6 mb-4">
            <label class="form-label">Branch Name</label>
            <input name="branch_name" type="text" class="form-control" placeholder="Optional">
          </div>
        </div>

        <div class="mt-4">
          <button id="proceedBtn" type="button" class="btn btn-primary w-100 py-3">
            <span class="btn-text">Proceed  Authorize Transfer</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- PIN modal (Bootstrap) -->
<div class="modal fade" id="pinModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Verify Transaction</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div class="mb-3">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-primary">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
          </svg>
        </div>
        <p class="mb-2 text-muted">Enter your 4-digit transaction PIN to authorize this transfer.</p>
        <div id="pinGrid" class="pin-grid" aria-label="Transaction PIN">
          <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-digit" aria-label="PIN digit 1" />
          <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-digit" aria-label="PIN digit 2" />
          <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-digit" aria-label="PIN digit 3" />
          <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="pin-digit" aria-label="PIN digit 4" />
        </div>

        <div id="pinError" class="text-danger small mt-2" style="display:none;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="d-inline-block me-1">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
          Please enter your 4-digit PIN.
        </div>

        <div class="mt-4 d-grid gap-2">
          <button id="confirmPin" class="btn btn-success py-2">
            <span class="btn-text">Confirm & Authorize</span>
          </button>
          <button class="btn btn-outline-secondary py-2" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Toast container (dynamically filled) -->
<div id="toastContainer" aria-live="polite" aria-atomic="true"></div>

@include('user.footer')

<script>
/* ---------- Enhanced Audio with better tones ---------- */
function playSuccessSound() {
  try {
    const ctx = new (window.AudioContext || window.webkitAudioContext)();
    const now = ctx.currentTime;

    // Pleasant ascending chime
    const o1 = ctx.createOscillator(); 
    const g1 = ctx.createGain();
    o1.type = 'sine'; 
    o1.frequency.setValueAtTime(523.25, now); // C5
    o1.frequency.exponentialRampToValueAtTime(659.25, now + 0.15); // E5
    g1.gain.setValueAtTime(0, now); 
    g1.gain.linearRampToValueAtTime(0.15, now + 0.05); 
    g1.gain.linearRampToValueAtTime(0, now + 0.3);
    o1.connect(g1); 
    g1.connect(ctx.destination);
    o1.start(now); 
    o1.stop(now + 0.3);

    // Second harmonic
    const o2 = ctx.createOscillator(); 
    const g2 = ctx.createGain();
    o2.type = 'sine'; 
    o2.frequency.setValueAtTime(783.99, now + 0.1); // G5
    g2.gain.setValueAtTime(0, now + 0.1); 
    g2.gain.linearRampToValueAtTime(0.1, now + 0.15); 
    g2.gain.linearRampToValueAtTime(0, now + 0.35);
    o2.connect(g2); 
    g2.connect(ctx.destination);
    o2.start(now + 0.1); 
    o2.stop(now + 0.35);
  } catch (e) { /* ignore */ }
}

function playErrorSound() {
  try {
    const ctx = new (window.AudioContext || window.webkitAudioContext)();
    const now = ctx.currentTime;
    
    // Short descending buzz
    const o = ctx.createOscillator(); 
    const g = ctx.createGain();
    o.type = 'sawtooth'; 
    o.frequency.setValueAtTime(349.23, now); // F4
    o.frequency.exponentialRampToValueAtTime(220, now + 0.2); // A3
    g.gain.setValueAtTime(0, now); 
    g.gain.linearRampToValueAtTime(0.12, now + 0.02); 
    g.gain.exponentialRampToValueAtTime(0.001, now + 0.4);
    o.connect(g); 
    g.connect(ctx.destination);
    o.start(now); 
    o.stop(now + 0.4);
  } catch (e) { /* ignore */ }
}

/* ---------- Enhanced Toast Helper ---------- */
function showToast(message, type = 'info', timeout = 5000) {
  const container = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.className = `bank-toast ${type}`;
  
  const icon = document.createElement('div'); 
  icon.className = 'icon';
  
  // Enhanced SVG icons
  if (type === 'success') {
    icon.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`;
    playSuccessSound();
  } else if (type === 'error') {
    icon.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`;
    playErrorSound();
  } else {
    icon.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>`;
  }
  
  const text = document.createElement('div'); 
  text.className = 'text'; 
  text.innerText = message;
  
  toast.appendChild(icon); 
  toast.appendChild(text);
  container.appendChild(toast);
  
  // Trigger show animation
  requestAnimationFrame(() => toast.classList.add('show'));
  
  // Auto hide
  setTimeout(() => {
    toast.classList.add('hide');
    setTimeout(() => { 
      try { container.removeChild(toast); } catch(e){} 
    }, 400);
  }, timeout);
}

/* ---------- Enhanced PIN Modal & Form Flow ---------- */
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('transferForm');
  const proceedBtn = document.getElementById('proceedBtn');
  const pinModalEl = document.getElementById('pinModal');
  const pinModal = (typeof bootstrap !== 'undefined') ? new bootstrap.Modal(pinModalEl, {backdrop: 'static', keyboard: true}) : null;
  const pinGrid = document.getElementById('pinGrid');
  const pinDigits = Array.from(pinGrid.querySelectorAll('.pin-digit'));
  const pinError = document.getElementById('pinError');
  const confirmBtn = document.getElementById('confirmPin');

  // Enhanced form validation with visual feedback
  function validateField(field) {
    field.classList.remove('is-invalid');
    
    if (field.required && !field.value.trim()) {
      field.classList.add('is-invalid');
      return false;
    }
    
    if (field.type === 'number' && field.value && (+field.value <= 0 || isNaN(+field.value))) {
      field.classList.add('is-invalid');
      return false;
    }
    
    return true;
  }

  // Validate all form fields
  function isFormValid() {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
      if (!validateField(field)) {
        isValid = false;
        if (isValid === false) {
          // Focus first invalid field
          field.focus();
        }
      }
    });
    
    if (!isValid) {
      showToast('Please fill in all required fields correctly.', 'error');
    }
    
    return isValid;
  }

  // Real-time field validation
  form.querySelectorAll('input').forEach(input => {
    input.addEventListener('blur', () => validateField(input));
    input.addEventListener('input', () => {
      input.classList.remove('is-invalid');
    });
  });

  // Enhanced button loading state
  function setButtonLoading(button, isLoading) {
    const btnText = button.querySelector('.btn-text');
    if (isLoading) {
      button.disabled = true;
      btnText.textContent = 'Processing...';
      button.classList.add('btn-loading');
    } else {
      button.disabled = false;
      btnText.textContent = button === proceedBtn ? 'Proceed  Authorize Transfer' : 'Confirm & Authorize';
      button.classList.remove('btn-loading');
    }
  }

  // Focus management for PIN inputs
  function focusFirstPin() { 
    setTimeout(() => {
      pinDigits[0].focus();
      pinDigits[0].select();
    }, 200); 
  }

  // Enhanced PIN input handling
  pinDigits.forEach((input, idx) => {
    // Enhanced input handling
    input.addEventListener('input', (e) => {
      const val = (e.target.value || '').replace(/\D/g, '').slice(-1);
      e.target.value = val;
      
      if (val) {
        e.target.classList.add('filled');
        if (idx < pinDigits.length - 1) {
          pinDigits[idx + 1].focus();
          pinDigits[idx + 1].select();
        }
      } else {
        e.target.classList.remove('filled');
      }
      
      pinError.style.display = 'none';
    });

    // Enhanced keyboard navigation
    input.addEventListener('keydown', (e) => {
      switch (e.key) {
        case 'Backspace':
          if (!input.value && idx > 0) {
            pinDigits[idx - 1].focus();
            pinDigits[idx - 1].select();
          }
          break;
          
        case 'ArrowLeft':
          if (idx > 0) {
            pinDigits[idx - 1].focus();
            pinDigits[idx - 1].select();
            e.preventDefault();
          }
          break;
          
        case 'ArrowRight':
          if (idx < pinDigits.length - 1) {
            pinDigits[idx + 1].focus();
            pinDigits[idx + 1].select();
            e.preventDefault();
          }
          break;
          
        case 'ArrowUp':
          if (idx > 0) {
            pinDigits[idx - 1].focus();
            pinDigits[idx - 1].select();
            e.preventDefault();
          }
          break;
          
        case 'ArrowDown':
          if (idx < pinDigits.length - 1) {
            pinDigits[idx + 1].focus();
            pinDigits[idx + 1].select();
            e.preventDefault();
          }
          break;
      }
    });

    // Enhanced paste handling
    input.addEventListener('paste', (e) => {
      e.preventDefault();
      const paste = (e.clipboardData || window.clipboardData).getData('text') || '';
      const digits = paste.replace(/\D/g, '').slice(0, 4 - idx);
      
      if (!digits) return;
      
      for (let i = 0; i < digits.length; i++) {
        const pos = idx + i;
        if (pos >= pinDigits.length) break;
        pinDigits[pos].value = digits[i];
        pinDigits[pos].classList.add('filled');
      }
      
      const firstEmpty = pinDigits.find(d => !d.value);
      if (firstEmpty) {
        firstEmpty.focus();
        firstEmpty.select();
      } else {
        pinDigits[pinDigits.length - 1].focus();
      }
    });
  });

  // Proceed to PIN modal
  proceedBtn.addEventListener('click', function () {
    if (!isFormValid()) return;
    
    // Reset PIN fields
    pinDigits.forEach(d => { 
      d.value = ''; 
      d.classList.remove('filled'); 
    });
    pinError.style.display = 'none';
    
    if (pinModal) {
      pinModal.show();
      focusFirstPin();
    } else {
      // Fallback for no Bootstrap
      const p = prompt('Enter 4-digit transaction PIN:');
      if (p && /^\d{4}$/.test(p)) {
        appendPinAndSubmit(p);
      } else {
        showToast('Invalid PIN format. Please enter exactly 4 digits.', 'error');
      }
    }
  });

  // Confirm PIN and submit
  confirmBtn.addEventListener('click', () => {
    const pin = pinDigits.map(d => d.value || '').join('');
    
    if (!/^\d{4}$/.test(pin)) {
      pinError.style.display = 'block';
      showToast('Please enter your 4-digit PIN.', 'error');
      const firstEmpty = pinDigits.find(d => !d.value);
      if (firstEmpty) {
        firstEmpty.focus();
        firstEmpty.select();
      }
      return;
    }
    
    pinError.style.display = 'none';
    setButtonLoading(confirmBtn, true);
    appendPinAndSubmit(pin);
    
    if (pinModal) {
      setTimeout(() => pinModal.hide(), 500);
    }
  });

  function appendPinAndSubmit(pin) {
    // Remove existing PIN input
    const prev = form.querySelector('input[name="transaction_pin"]');
    if (prev) prev.remove();
    
    // Add new PIN input
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'transaction_pin';
    hidden.value = pin;
    form.appendChild(hidden);
    
    // Set loading state
    setButtonLoading(proceedBtn, true);
    
    // Submit form
    setTimeout(() => form.submit(), 300);
  }

  // Reset button states when modal closes
  if (pinModalEl) {
    pinModalEl.addEventListener('hidden.bs.modal', function () {
      setButtonLoading(proceedBtn, false);
      setButtonLoading(confirmBtn, false);
    });
  }

  /* ---------- Show server messages on page load ---------- */
  (function showServerMessage() {
    const server = document.getElementById('server-message');
    if (!server) return;
    
    const s = server.getAttribute('data-status') || '';
    const e = server.getAttribute('data-error') || '';
    
    if (s) {
      showToast(s, 'success', 5000);
    } else if (e) {
      showToast(e, 'error', 5000);
    }
  })();
});
</script>