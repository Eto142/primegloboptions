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

    body {
        background-color: var(--background);
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        color: var(--text-primary);
        line-height: 1.6;
    }

    /* ---------- Layout & Container ---------- */
    .container-card {
        max-width: 1200px;
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

    /* ---------- Two Column Layout for Laptop ---------- */
    .withdrawal-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        align-items: start;
    }

    .support-info {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #bae6fd;
        height: fit-content;
    }

    .withdrawal-form {
        display: flex;
        flex-direction: column;
        gap: 24px;
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

    .support-info h4 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .support-info p {
        color: var(--text-secondary);
        margin-bottom: 16px;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .support-info .highlight {
        background: rgba(255, 255, 255, 0.7);
        padding: 12px 16px;
        border-radius: 12px;
        margin-top: 16px;
        border-left: 4px solid var(--warning);
    }

    /* ---------- Form Elements ---------- */
    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
        font-size: 0.95rem;
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

    /* ---------- Code Input ---------- */
    .code-input-container {
        margin-bottom: 8px;
    }

    .code-input {
        font-size: 1.25rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-align: center;
        padding: 16px;
        height: 60px;
    }

    .code-input::placeholder {
        letter-spacing: normal;
        font-weight: normal;
    }

    .code-requirements {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-top: 8px;
        text-align: center;
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

    /* ---------- Responsive Design ---------- */
    @media (max-width: 992px) {
        .withdrawal-layout {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        
        .support-info {
            order: 2;
        }
        
        .withdrawal-form {
            order: 1;
        }
    }

    @media (max-width: 768px) {
        .container-card {
            margin: 16px auto;
            padding: 0 12px;
        }
        
        .card-pro .card-body {
            padding: 24px 20px;
        }
        
        .bank-toast {
            left: 16px;
            right: 16px;
            top: 16px;
            min-width: unset;
            max-width: unset;
        }
    }

    @media (max-width: 480px) {
        .card-pro .card-header {
            padding: 20px 16px;
        }
        
        .balance-display {
            padding: 8px 12px;
        }
        
        .support-info {
            padding: 16px;
        }
    }
</style>

<div class="container container-card">
    <div class="card card-pro">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Withdraw</h5>
                <small>Enter Withdrawal Code</small>
            </div>
            <div class="balance-display text-end">
                <div class="fw-600">Available Balance</div>
                <div>{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2, '.', ',') }}</div>
            </div>
        </div>

        <div class="card-body">
            <div class="withdrawal-layout">
                <div class="support-info">
                    <h4><i class="fas fa-info-circle"></i> Contact Support</h4>
                    <p>To initiate a withdrawal, you need a valid <strong>Foreign Transaction Code</strong>. Please contact our support team to request your code.</p>
                    
                    <p><i class="fas fa-envelope me-2"></i> Email: <a href="mailto:support@topsavertbc.online">support@topsavertbc.online</a></p>
                    
                    <div class="highlight">
                        <p class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> <strong>Please note:</strong> A fee is attached to every code activated. Make sure you have sufficient balance to cover both the withdrawal amount and the transaction fee.</p>
                    </div>
                </div>

                <div class="withdrawal-form">

                       <form id="withdrawalForm" novalidate action="{{ route('user.withdrawal.withdraw.code') }}" method="POST">
    @csrf

    <div class="code-input-container">
        <label class="form-label">Enter Withdrawal Code <span class="text-danger">*</span></label>
        <input name="withdrawal_code" type="text" class="form-control code-input @error('withdrawal_code') is-invalid @enderror"
               required placeholder="Enter your 6-digit withdrawal code" value="{{ old('withdrawal_code') }}">
        <div class="invalid-feedback">
            @error('withdrawal_code') {{ $message }} @else Withdrawal Code is required. @enderror
        </div>
        <div class="code-requirements">Enter the 6-digit code you received from support</div>
    </div>

    <div class="mt-2">
        <button id="proceedBtn" type="submit" class="btn btn-primary w-100 py-3">
            <span class="btn-text">PROCEED WITH WITHDRAWAL</span>
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast container (dynamically filled) -->
<div id="toastContainer" aria-live="polite" aria-atomic="true"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Toast container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    @if(session('success') || $errors->has('withdrawal_code'))
    <div class="toast align-items-center text-bg-{{ session('success') ? 'success' : 'danger' }} border-0 show" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') ?? $errors->first('withdrawal_code') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.map(function(toastEl) {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();

        // Play sound
        @if(session('success'))
            playSuccessSound();
        @elseif($errors->has('withdrawal_code'))
            playErrorSound();
        @endif
    });

    function playSuccessSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const o = ctx.createOscillator(), g = ctx.createGain();
            o.type = 'sine';
            o.frequency.setValueAtTime(523.25, ctx.currentTime);
            g.gain.setValueAtTime(0.1, ctx.currentTime);
            o.connect(g); g.connect(ctx.destination);
            o.start(); o.stop(ctx.currentTime + 0.3);
        } catch(e){}
    }
    function playErrorSound() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const o = ctx.createOscillator(), g = ctx.createGain();
            o.type = 'sawtooth';
            o.frequency.setValueAtTime(349.23, ctx.currentTime);
            g.gain.setValueAtTime(0.1, ctx.currentTime);
            o.connect(g); g.connect(ctx.destination);
            o.start(); o.stop(ctx.currentTime + 0.3);
        } catch(e){}
    }
});
</script>



@include('user.footer')