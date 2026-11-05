@include('user.header')

<style>
/* ── Dashboard Page Styles ──────────────────────────────── */
.dash-page {
  background: #f0f2f5;
  min-height: 100vh;
}

/* ── Balance Card ─────────────────────────────────────────── */
.balance-card {
  background: linear-gradient(160deg, #0a0f1e 0%, #111827 45%, #161f35 100%);
  border: 1px solid rgba(201,162,39,0.15);
  position: relative;
  overflow: hidden;
}
/* Large decorative orbs */
.balance-card .orb-1 {
  position: absolute; top: -100px; right: -60px;
  width: 340px; height: 340px; border-radius: 50%;
  background: radial-gradient(circle, rgba(201,162,39,0.14) 0%, transparent 65%);
  pointer-events: none;
}
.balance-card .orb-2 {
  position: absolute; bottom: -80px; left: -50px;
  width: 260px; height: 260px; border-radius: 50%;
  background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 65%);
  pointer-events: none;
}
/* Subtle grid texture */
.balance-card .grid-texture {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
  background-size: 40px 40px;
  pointer-events: none;
}

/* Top header strip */
.bc-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  padding-bottom: 18px;
  border-bottom: 1px solid rgba(255,255,255,0.07);
}
.bc-name-badge {
  display: flex; align-items: center; gap: 8px;
}
.bc-name-badge .avatar {
  width: 36px; height: 36px; border-radius: 10px;
  background: linear-gradient(135deg, #C9A227, #9E7C14);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.78rem; font-weight: 800; color: #0f172a;
  flex-shrink: 0;
  letter-spacing: 0.5px;
}
.bc-name-badge .name-stack .holder-name {
  font-size: 0.82rem; font-weight: 700; color: #fff; line-height: 1.2;
  letter-spacing: 0.2px;
}
.bc-name-badge .name-stack .acct-type {
  font-size: 0.68rem; font-weight: 600; color: #C9A227;
  text-transform: uppercase; letter-spacing: 1px;
}
.ssl-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(16,185,129,0.10);
  border: 1px solid rgba(16,185,129,0.22);
  color: #34d399;
  border-radius: 50px;
  font-size: 0.68rem; font-weight: 700;
  letter-spacing: 0.8px;
  padding: 4px 12px;
}
.ssl-badge .ssl-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: #34d399;
  box-shadow: 0 0 6px #34d399;
  animation: pulse-dot 2s infinite;
  flex-shrink: 0;
}
@keyframes pulse-dot {
  0%,100% { opacity:1; transform:scale(1); }
  50% { opacity:0.5; transform:scale(0.7); }
}

/* Balance hero */
.bc-balance-section { padding: 18px 0; }
.bc-balance-label {
  font-size: 0.68rem; font-weight: 700; letter-spacing: 2.5px;
  color: rgba(255,255,255,0.38); text-transform: uppercase; margin-bottom: 6px;
  display: flex; align-items: center; gap: 10px;
}
.balance-toggle-btn {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.10);
  border-radius: 50px;
  padding: 2px 9px 2px 7px;
  cursor: pointer;
  transition: background 0.15s;
  color: rgba(255,255,255,0.45);
  font-size: 0.65rem; font-weight: 600; letter-spacing: 0.3px;
  user-select: none;
}
.balance-toggle-btn:hover { background: rgba(255,255,255,0.1); }
.balance-toggle-btn i { font-size: 0.65rem; }

.balance-amount {
  font-size: 2.6rem; font-weight: 800;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  letter-spacing: -1.5px; line-height: 1;
  color: #fff;
}
@media (min-width: 768px) { .balance-amount { font-size: 3.1rem; } }
.balance-currency-tag {
  font-size: 1rem; font-weight: 700;
  color: rgba(201,162,39,0.85);
  letter-spacing: 0px;
  margin-right: 2px;
}

/* Account info grid */
.bc-info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  padding: 16px 0;
  border-top: 1px solid rgba(255,255,255,0.06);
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
@media (min-width: 640px) {
  .bc-info-grid { grid-template-columns: 2fr 1fr 1.5fr; }
  .bc-info-grid .span-2-sm { grid-column: 1 / -1; }
}
@media (max-width: 639px) {
  .bc-info-grid .span-2-sm { grid-column: span 2; }
}
.bc-info-item {
  display: flex; flex-direction: column; gap: 4px;
  padding: 12px 14px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.07);
  border-radius: 12px;
  transition: background 0.15s;
}
.bc-info-item:hover { background: rgba(255,255,255,0.07); }
.bc-info-label {
  font-size: 0.62rem; font-weight: 700;
  color: rgba(255,255,255,0.3);
  text-transform: uppercase; letter-spacing: 1px;
}
.bc-info-value {
  font-size: 0.9rem; font-weight: 700;
  color: #fff; font-family: 'JetBrains Mono', monospace;
  letter-spacing: 0.3px;
  display: flex; align-items: center; gap: 6px;
}
.bc-info-value .copy-btn {
  background: none; border: none; padding: 0;
  color: rgba(201,162,39,0.6);
  cursor: pointer;
  font-size: 0.72rem;
  transition: color 0.15s;
  line-height: 1;
  flex-shrink: 0;
}
.bc-info-value .copy-btn:hover { color: #C9A227; }
.currency-pill {
  display: inline-flex; align-items: center;
  background: rgba(201,162,39,0.15);
  color: #E8C14A; border: 1px solid rgba(201,162,39,0.3);
  border-radius: 6px; padding: 1px 8px;
  font-size: 0.82rem; font-weight: 700;
  font-family: 'JetBrains Mono', monospace;
}

/* Action buttons */
.bc-actions {
  display: flex; flex-wrap: wrap; gap: 8px;
  padding-top: 16px;
}
.bc-btn {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 0.82rem; font-weight: 700;
  border-radius: 10px; padding: 8px 18px;
  cursor: pointer; transition: all 0.18s ease;
  border: none; text-decoration: none;
  white-space: nowrap;
}
.bc-btn:hover { transform: translateY(-1px); }
.bc-btn-gold {
  background: linear-gradient(135deg, #C9A227, #a07818);
  color: #0f172a;
  box-shadow: 0 4px 14px rgba(201,162,39,0.3);
}
.bc-btn-gold:hover { box-shadow: 0 6px 20px rgba(201,162,39,0.4); color: #0f172a; }
.bc-btn-ghost {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.13);
  color: rgba(255,255,255,0.85);
}
.bc-btn-ghost:hover { background: rgba(255,255,255,0.11); color: #fff; }

/* Action buttons row (legacy kept for other uses) */
.action-btn-row .btn {
  font-size: 0.84rem; font-weight: 600;
  border-radius: 10px; padding: 0.55rem 1rem;
  transition: all 0.2s ease;
}
.action-btn-row .btn:hover { transform: translateY(-1px); }
.btn-primary-gold { background: #C9A227; border: none; color: #0f172a; }
.btn-primary-gold:hover { background: #E8C14A; color: #0f172a; }
.btn-glass {
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.18); color: #fff;
}
.btn-glass:hover { background: rgba(255,255,255,0.15); color: #fff; }

/* Debit Card */
.virtual-card {
  background: linear-gradient(135deg, #C9A227 0%, #a07818 50%, #0f172a 100%);
  border-radius: 16px;
  padding: 20px;
  color: #fff;
  position: relative;
  overflow: hidden;
  min-height: 175px;
}
.virtual-card::before {
  content: '';
  position: absolute;
  top: -40px; right: -40px;
  width: 130px; height: 130px;
  border-radius: 50%;
  background: rgba(255,255,255,0.07);
}
.virtual-card::after {
  content: '';
  position: absolute;
  bottom: -30px; left: 30px;
  width: 100px; height: 100px;
  border-radius: 50%;
  background: rgba(255,255,255,0.04);
}
.card-chip {
  width: 34px; height: 25px;
  background: linear-gradient(135deg, #fef9c3, #ca8a04);
  border-radius: 5px;
}

/* Quick Actions */
.quick-action-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  text-decoration: none;
  padding: 14px 8px;
  border-radius: 14px;
  background: #fff;
  border: 1px solid #eef0f4;
  transition: all 0.2s ease;
  gap: 8px;
}
.quick-action-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.08);
  border-color: rgba(201,162,39,0.3);
}
.qa-icon {
  width: 44px; height: 44px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem;
  color: #fff;
  flex-shrink: 0;
}
.qa-label { font-size: 0.8rem; font-weight: 600; color: #1e293b; line-height: 1.2; }
.qa-sub   { font-size: 0.68rem; color: #94a3b8; margin-top: 1px; }

/* Transaction rows */
.txn-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 14px;
  border-radius: 12px;
  background: #f8f9fc;
  border: 1px solid transparent;
  transition: all 0.15s ease;
}
.txn-row:hover {
  background: #fff;
  border-color: #eef0f4;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.txn-icon {
  width: 40px; height: 40px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.95rem;
  flex-shrink: 0;
}

/* Analytics card */
.stat-pill {
  border-radius: 10px;
  padding: 10px 12px;
  background: #f8f9fc;
}
.net-pill {
  border-radius: 12px;
  padding: 12px 16px;
  background: #f8f9fc;
}

/* Banner Promo */
.promo-card {
  border-radius: 16px;
  padding: 28px 32px;
  color: #fff;
  min-height: 140px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  overflow: hidden;
}
.promo-card::after {
  content: '';
  position: absolute;
  right: -30px; top: -30px;
  width: 180px; height: 180px;
  border-radius: 50%;
  background: rgba(255,255,255,0.06);
}

/* Section headings */
.section-title {
  font-size: 0.93rem;
  font-weight: 700;
  color: #1e293b;
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-title .dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #C9A227;
  flex-shrink: 0;
}

/* Carousel nav dots */
.carousel-indicators [data-bs-target] {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: rgba(255,255,255,0.5);
  border: none;
}
.carousel-indicators .active { background: #fff; }

/* Payment pending banner */
.payment-banner {
  background: linear-gradient(135deg, #fff7ed, #fef3c7);
  border: 1px solid rgba(245,158,11,0.3);
  border-radius: 12px;
  padding: 12px 16px;
}
</style>

<div class="dash-page container-fluid px-2 px-md-4 py-4">

  <!-- ───────────────────────────── ROW 1: Balance + Card ─── -->
  <div class="row g-3 mb-4">

    <!-- Balance Card -->
    <div class="col-lg-8">
      <div class="balance-card rounded-4 shadow-lg p-4 h-100" style="display:flex; flex-direction:column; gap:0;">

        <!-- Decorative layers -->
        <div class="orb-1"></div>
        <div class="orb-2"></div>
        <div class="grid-texture"></div>

        <!-- Header: name + account type + ssl -->
        <div class="bc-header position-relative">
          <div class="bc-name-badge">
            <div class="avatar">
              {{ strtoupper(substr(Auth::user()->first_name,0,1)) }}{{ strtoupper(substr(Auth::user()->last_name,0,1)) }}
            </div>
            <div class="name-stack">
              <div class="holder-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
              <div class="acct-type">{{ strtoupper(Auth::user()->account_type ?? 'Savings Account') }}</div>
            </div>
          </div>
          <div class="ssl-badge">
            <span class="ssl-dot"></span>
            256-BIT SSL ENCRYPTED
          </div>
        </div>

        <!-- Balance hero -->
        <div class="bc-balance-section position-relative">
          <div class="bc-balance-label">
            Available Balance
            <span class="balance-toggle-btn" onclick="toggleBalance()" id="balanceToggleWrap">
              <i class="fas fa-eye" id="balanceEyeIcon"></i>
              <span id="balanceToggleLabel">Hide</span>
            </span>
          </div>
          <div class="d-flex align-items-baseline gap-1 flex-wrap">
            <span class="balance-currency-tag">{{ Auth::user()->currency }}</span>
            <span class="balance-amount" id="mainBalanceDisplay">{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}</span>
          </div>
          <!-- Subtle "verified" indicator -->
          <div class="d-flex align-items-center gap-2 mt-2" style="font-size:0.68rem; color:rgba(255,255,255,0.28); font-weight:500; letter-spacing:0.5px;">
            <i class="fas fa-shield-alt" style="color:rgba(201,162,39,0.5); font-size:0.7rem;"></i>
            Verified Account &nbsp;·&nbsp; Last updated {{ now()->format('d M Y, H:i') }}
          </div>
        </div>

        <!-- Account Info Grid -->
        <div class="bc-info-grid position-relative">

          <!-- Account Number -->
          <div class="bc-info-item span-2-sm">
            <span class="bc-info-label">Account Number</span>
            <span class="bc-info-value">
              {{ Auth::user()->account_number }}
              <button class="copy-btn" onclick="copyText('{{ Auth::user()->account_number }}', this)" title="Copy account number">
                <i class="far fa-copy"></i>
              </button>
            </span>
          </div>

          <!-- Currency -->
          <div class="bc-info-item">
            <span class="bc-info-label">Currency</span>
            <span class="bc-info-value">
              <span class="currency-pill">{{ Auth::user()->currency }}</span>
            </span>
          </div>

          <!-- SWIFT -->
          <div class="bc-info-item">
            <span class="bc-info-label">SWIFT / Routing</span>
            <span class="bc-info-value">
              TPSTUS33
              <button class="copy-btn" onclick="copyText('TPSTUS33', this)" title="Copy SWIFT code">
                <i class="far fa-copy"></i>
              </button>
            </span>
          </div>

          <!-- Bank Name -->
          <div class="bc-info-item">
            <span class="bc-info-label">Institution</span>
            <span class="bc-info-value" style="font-size:0.78rem; letter-spacing:0px;">PrimeGlob Options</span>
          </div>

        </div>

        <!-- Action Buttons -->
        <div class="bc-actions position-relative">
          @if(Auth::user()->payment_status == 1)
            <a href="{{ route('user.payments.index') }}" class="bc-btn bc-btn-gold">
              <i class="fas fa-bolt" style="font-size:0.78rem;"></i> Make Payment
            </a>
          @endif
          <a href="{{ route('user.deposit.index') }}" class="bc-btn bc-btn-gold">
            <i class="fas fa-plus" style="font-size:0.78rem;"></i> Deposit
          </a>
          <a href="{{ route('user.transfer.bank') }}" class="bc-btn bc-btn-ghost">
            <i class="fas fa-paper-plane" style="font-size:0.78rem;"></i> Send Money
          </a>
          <a href="{{ route('user.transactions') }}" class="bc-btn bc-btn-ghost">
            <i class="fas fa-history" style="font-size:0.78rem;"></i> History
          </a>
        </div>

      </div>
    </div>

    <!-- Debit Card Column -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background:#fff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="section-title"><span class="dot"></span> Digital Card</span>
          <a href="{{ route('user.cards.card') }}" class="text-decoration-none fw-semibold" style="font-size:0.8rem; color:#C9A227;">Manage →</a>
        </div>

        @forelse($details as $detail)
          @if($detail->status == 0)
            <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background:#fef9f0; border:1px solid rgba(201,162,39,0.2);">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-warning" style="width:42px;height:42px;background:rgba(245,158,11,0.12);flex-shrink:0;">
                <i class="fas fa-hourglass-half"></i>
              </div>
              <div>
                <div class="fw-semibold text-dark" style="font-size:0.88rem;">Card Request Pending</div>
                <div class="text-muted" style="font-size:0.78rem;">Processing — ready within 24 hours</div>
              </div>
            </div>
          @else
            <!-- Virtual Card -->
            <div class="virtual-card mb-3 position-relative">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="fw-bold text-white" style="font-size:0.78rem; letter-spacing:1px; opacity:0.85;">PRIMEGLOBOPTIONS</span>
                <i class="fab fa-cc-mastercard fa-xl text-white" style="opacity:0.9;"></i>
              </div>
              <div class="card-chip mb-3"></div>
              <div class="fw-bold font-monospace text-white mb-3" style="font-size:1.05rem; letter-spacing:2.5px;">
                {{ implode(' ', str_split($detail->card_number, 4)) }}
              </div>
              <div class="d-flex justify-content-between align-items-end">
                <div>
                  <div class="text-white-50 mb-1" style="font-size:0.6rem; text-transform:uppercase; letter-spacing:0.8px;">Cardholder</div>
                  <div class="fw-bold text-white text-uppercase" style="font-size:0.78rem;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                </div>
                <div class="d-flex gap-3">
                  <div class="text-end">
                    <div class="text-white-50 mb-1" style="font-size:0.6rem; text-transform:uppercase; letter-spacing:0.8px;">Expires</div>
                    <div class="fw-bold text-white font-monospace" style="font-size:0.82rem;">{{ \Carbon\Carbon::parse($detail->card_expiry)->format('m/y') }}</div>
                  </div>
                  <div class="text-end">
                    <div class="text-white-50 mb-1" style="font-size:0.6rem; text-transform:uppercase; letter-spacing:0.8px;">CVV</div>
                    <div class="fw-bold text-white font-monospace" style="font-size:0.82rem;">{{ $detail->card_cvc }}</div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Card buttons -->
            <div class="d-flex gap-2">
              <a href="{{ route('user.cards.card') }}" class="btn btn-sm flex-grow-1 rounded-3 fw-semibold" style="background:#f1f5f9; color:#1e293b; font-size:0.8rem; border:1px solid #e2e8f0;">
                <i class="fas fa-eye me-1" style="color:#C9A227;"></i> View Details
              </a>
              <button type="button" class="btn btn-sm flex-grow-1 rounded-3 fw-semibold" style="background:#C9A227; color:#0f172a; font-size:0.8rem; border:none;" data-bs-toggle="modal" data-bs-target="#requestFormModal">
                <i class="fas fa-truck me-1"></i> Physical Card
              </button>
            </div>
          @endif
        @empty
          <div class="text-center py-4 rounded-4" style="background:#f8f9fc; border:1.5px dashed #d1d5db;">
            <div class="mb-2 d-inline-flex align-items-center justify-content-center rounded-circle" style="width:52px;height:52px;background:rgba(201,162,39,0.1);">
              <i class="fas fa-credit-card" style="color:#C9A227; font-size:1.3rem;"></i>
            </div>
            <div class="fw-semibold text-dark mb-1" style="font-size:0.9rem;">No Active Card</div>
            <p class="text-muted mb-3" style="font-size:0.78rem;">Issue a virtual or physical card for worldwide use.</p>
            <a href="{{ route('user.cards.request.card', Auth::user()->id) }}" class="btn btn-sm rounded-pill px-4 fw-semibold" style="background:#C9A227; color:#0f172a; font-size:0.8rem;">
              <i class="fas fa-plus me-1"></i> Issue Card
            </a>
          </div>
        @endforelse

      </div>
    </div>
  </div>

  <!-- ───────────────────────────── ROW 2: Quick Actions ─── -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4" style="background:#fff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="section-title"><span class="dot"></span> Quick Actions</span>
          <span class="text-muted" style="font-size:0.75rem;">Instant Services</span>
        </div>

        <div class="row row-cols-3 row-cols-sm-5 row-cols-md-10 g-2">

          <div class="col">
            <a href="{{ route('user.deposit.index') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#C9A227,#10b981);">
                <i class="fas fa-plus-circle"></i>
              </div>
              <span class="qa-label">Deposit</span>
              <span class="qa-sub">Add Funds</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.transfer.bank') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#C9A227,#9E7C14);">
                <i class="fas fa-paper-plane"></i>
              </div>
              <span class="qa-label">Transfer</span>
              <span class="qa-sub">Send Money</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.withdrawal.crypto') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <i class="fab fa-bitcoin"></i>
              </div>
              <span class="qa-label">Crypto</span>
              <span class="qa-sub">BTC & USDT</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.loans.loan') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <span class="qa-label">Loan</span>
              <span class="qa-sub">Apply Now</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.withdrawal.paypal') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#0070ba,#1546a0);">
                <i class="fab fa-paypal"></i>
              </div>
              <span class="qa-label">PayPal</span>
              <span class="qa-sub">Withdraw</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.skrill') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#e11d48,#be123c);">
                <i class="fas fa-wallet"></i>
              </div>
              <span class="qa-label">Skrill</span>
              <span class="qa-sub">Withdraw</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.bill.index') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                <i class="fas fa-file-invoice-dollar"></i>
              </div>
              <span class="qa-label">Pay Bills</span>
              <span class="qa-sub">Utilities</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.investment') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                <i class="fas fa-chart-line"></i>
              </div>
              <span class="qa-label">Invest</span>
              <span class="qa-sub">Grow Wealth</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.mutual-funds') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#0ea5e9,#C9A227);">
                <i class="fas fa-layer-group"></i>
              </div>
              <span class="qa-label">Mutual Funds</span>
              <span class="qa-sub">Explore</span>
            </a>
          </div>

          <div class="col">
            <a href="{{ route('user.savings-goals.index') }}" class="quick-action-item">
              <div class="qa-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                <i class="fas fa-bullseye"></i>
              </div>
              <span class="qa-label">Goals</span>
              <span class="qa-sub">Save Smart</span>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ─────────────────── ROW 3: Transactions + Analytics ── -->
  <div class="row g-3 mb-4">

    <!-- Recent Transactions -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 h-100" style="background:#fff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="section-title"><span class="dot"></span> Recent Transactions</span>
          <a href="{{ route('user.transactions') }}" class="btn btn-sm rounded-pill fw-semibold px-3" style="background:#f1f5f9; color:#1e293b; font-size:0.78rem; border:1px solid #e2e8f0;">View All</a>
        </div>

        <div class="d-flex flex-column gap-2">
          @if($transaction->isEmpty())
            <div class="text-center py-5">
              <div class="mb-3 d-inline-flex align-items-center justify-content-center rounded-circle" style="width:56px;height:56px;background:#f1f5f9;">
                <i class="fas fa-receipt text-muted fa-lg"></i>
              </div>
              <p class="text-muted mb-0" style="font-size:0.88rem;">No transactions on record yet.</p>
            </div>
          @else
            @foreach($transaction as $txn)
              @php
                $isDebit = in_array($txn->transaction, ['Bank Transfer','Paypal Withdrawal','Skrill Withdrawal','Crypto Withdrawal']);
                $icons = [
                  'Bank Transfer'      => 'fa-exchange-alt',
                  'Loan'               => 'fa-hand-holding-usd',
                  'Card'               => 'fa-credit-card',
                  'Crypto Withdrawal'  => 'fa-bitcoin',
                  'Paypal Withdrawal'  => 'fa-paypal',
                  'Skrill Withdrawal'  => 'fa-wallet',
                ];
                $isBrand = in_array($txn->transaction, ['Crypto Withdrawal', 'Paypal Withdrawal']);
                $iconPrefix = $isBrand ? 'fab' : 'fas';
                $iconClass = $icons[$txn->transaction] ?? 'fa-file-invoice-dollar';
                $iconBg = $isDebit ? 'rgba(239,68,68,0.10)' : 'rgba(16,185,129,0.10)';
                $iconColor = $isDebit ? '#ef4444' : '#10b981';
              @endphp
              <div class="txn-row">
                <div class="d-flex align-items-center gap-3">
                  <div class="txn-icon" style="background:{{ $iconBg }}; color:{{ $iconColor }};">
                    <i class="{{ $iconPrefix }} {{ $iconClass }}"></i>
                  </div>
                  <div>
                    <div class="fw-semibold text-dark" style="font-size:0.88rem; line-height:1.3;">
                      {{ Str::limit($txn->transaction_description, 30) }}
                    </div>
                    <div class="text-muted d-flex align-items-center gap-1" style="font-size:0.75rem;">
                      <span>{{ $txn->transaction }}</span>
                      @if(!str_contains($txn->transaction_description, 'From'))
                        <span>·</span>
                        <span class="font-monospace">•••{{ substr($txn->account_number ?? '0000', -4) }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="text-end ms-3 flex-shrink-0">
                  <div class="fw-bold font-monospace mb-1" style="font-size:0.9rem; color:{{ $isDebit ? '#ef4444' : '#10b981' }};">
                    {{ $isDebit ? '−' : '+' }}{{ Auth::user()->currency }}{{ number_format($txn->transaction_amount, 2) }}
                  </div>
                  @if($txn->transaction_status == '1')
                    <span class="badge rounded-pill" style="background:rgba(16,185,129,0.12);color:#10b981;font-size:0.67rem;">Successful</span>
                  @elseif($txn->transaction_status == '0')
                    <span class="badge rounded-pill" style="background:rgba(245,158,11,0.12);color:#d97706;font-size:0.67rem;">Pending</span>
                  @else
                    <span class="badge rounded-pill" style="background:rgba(239,68,68,0.12);color:#ef4444;font-size:0.67rem;">Failed</span>
                  @endif
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>

    <!-- Monthly Cash Flow -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 h-100" style="background:#fff;">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="section-title"><span class="dot"></span> Cash Flow</span>
          <span class="text-muted fw-semibold" style="font-size:0.78rem;">{{ now()->format('M Y') }}</span>
        </div>

        <div class="my-3" style="height:180px; position:relative;">
          <canvas id="debitCreditChart"></canvas>
        </div>

        <div class="d-flex flex-column gap-2">
          <div class="d-flex gap-2">
            <div class="stat-pill flex-grow-1 text-center">
              <div class="text-muted mb-1" style="font-size:0.72rem;">Total Debit</div>
              <div class="fw-bold" style="color:#ef4444; font-size:0.92rem;">{{ Auth::user()->currency }}{{ number_format($debit_transfers, 2) }}</div>
            </div>
            <div class="stat-pill flex-grow-1 text-center">
              <div class="text-muted mb-1" style="font-size:0.72rem;">Total Credit</div>
              <div class="fw-bold" style="color:#10b981; font-size:0.92rem;">{{ Auth::user()->currency }}{{ number_format($credit_transfers, 2) }}</div>
            </div>
          </div>

          @php
            $net = $credit_transfers - $debit_transfers;
            $netPositive = $net >= 0;
          @endphp
          <div class="net-pill d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted mb-1" style="font-size:0.72rem;">Net Balance</div>
              <div class="fw-bold" style="font-size:1rem; color:{{ $netPositive ? '#10b981' : '#ef4444' }};">
                {{ Auth::user()->currency }}{{ number_format(abs($net), 2) }}
              </div>
            </div>
            <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background:{{ $netPositive ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)' }}; color:{{ $netPositive ? '#10b981' : '#ef4444' }}; font-size:0.72rem;">
              {{ $netPositive ? '↑ Surplus' : '↓ Deficit' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ────────────────────────── ROW 4: Promo Banners ────── -->
  <div class="row g-3 mb-2">
    <div class="col-md-6">
      <div class="promo-card shadow-sm" style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 100%);">
        <div class="mb-2" style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:rgba(201,162,39,0.8); text-transform:uppercase;">Fixed Deposits</div>
        <h5 class="fw-bold text-white mb-1" style="font-size:1.15rem;">High-Yield Tenured Savings</h5>
        <p class="mb-3" style="font-size:0.82rem; color:rgba(255,255,255,0.55); max-width:340px;">Earn up to 8.5% p.a. guaranteed returns on long-term fixed deposit accounts.</p>
        <a href="{{ route('user.deposit.index') }}" class="btn btn-sm rounded-pill px-4 fw-semibold" style="background:#C9A227; color:#0f172a; font-size:0.8rem;">Explore Deposits</a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="promo-card shadow-sm" style="background:linear-gradient(135deg,#C9A227 0%,#9E7C14 100%);">
        <div class="mb-2" style="font-size:0.7rem; font-weight:700; letter-spacing:1.5px; color:rgba(255,255,255,0.6); text-transform:uppercase;">International Transfers</div>
        <h5 class="fw-bold text-white mb-1" style="font-size:1.15rem;">Instant Global Transfers</h5>
        <p class="mb-3" style="font-size:0.82rem; color:rgba(255,255,255,0.65); max-width:340px;">Send money across 50+ countries with live real-time FX rates and zero delays.</p>
        <a href="{{ route('user.transfer.bank') }}" class="btn btn-sm rounded-pill px-4 fw-semibold" style="background:#fff; color:#9E7C14; font-size:0.8rem;">Transfer Funds</a>
      </div>
    </div>
  </div>

</div>

<!-- ──────────── Card Delivery Modal ──────────────────────── -->
<div class="modal fade" id="requestFormModal" tabindex="-1" aria-labelledby="requestFormModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0 pb-0 pt-4 px-4">
        <h5 class="modal-title fw-bold text-dark" id="requestFormModalLabel">
          <i class="fas fa-truck me-2" style="color:#C9A227;"></i> Card Delivery Request
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('user.cards.requestcard.delivery') }}" method="POST">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.85rem;">Full Name</label>
            <input type="text" class="form-control rounded-3" name="fname" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.85rem;">Delivery Address</label>
            <input type="text" class="form-control rounded-3" name="address" placeholder="Street, City, Country" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:0.85rem;">Phone Number</label>
            <input type="tel" class="form-control rounded-3" name="phone" value="{{ Auth::user()->phone }}" required>
          </div>
          <div class="mb-1">
            <label class="form-label fw-semibold" style="font-size:0.85rem;">Email Address</label>
            <input type="email" class="form-control rounded-3" name="emailAddress" value="{{ Auth::user()->email }}" required>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex gap-2">
          <button type="button" class="btn btn-sm rounded-3 fw-semibold flex-grow-1" style="background:#f1f5f9; color:#1e293b; border:1px solid #e2e8f0;" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-sm rounded-3 fw-semibold flex-grow-1" style="background:#C9A227; color:#0f172a; border:none;">Submit Request</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Chart.js + Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
(function () {
  /* ── Balance toggle ── */
  var shown  = true;
  var actual = "{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}";
  var masked = "••••••••";

  function toggleBalance() {
    shown = !shown;
    var display = document.getElementById('mainBalanceDisplay');
    var icon    = document.getElementById('balanceEyeIcon');
    var label   = document.getElementById('balanceToggleLabel');
    if (display) display.textContent = shown ? actual : masked;
    if (icon)    icon.className = shown ? 'fas fa-eye' : 'fas fa-eye-slash';
    if (label)   label.textContent = shown ? 'Hide' : 'Show';
  }
  window.toggleBalance = toggleBalance;

  /* ── Copy helper ── */
  function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(function () {
      var icon = btn.querySelector('i');
      icon.className = 'fas fa-check';
      icon.style.color = '#34d399';
      setTimeout(function () {
        icon.className = 'far fa-copy';
        icon.style.color = '';
      }, 1800);
    });
  }
  window.copyText = copyText;

  /* ── Cash flow chart ── */
  document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById('debitCreditChart');
    if (!canvas) return;
    new Chart(canvas.getContext('2d'), {
      type: 'bar',
      data: {
        labels: ['Debit', 'Credit'],
        datasets: [{
          data: [{{ $debit_transfers }}, {{ $credit_transfers }}],
          backgroundColor: ['rgba(239,68,68,0.15)', 'rgba(16,185,129,0.15)'],
          borderColor:     ['#ef4444', '#10b981'],
          borderWidth: 2,
          borderRadius: 8,
          borderSkipped: false,
          barPercentage: 0.5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#1e293b',
            padding: 10,
            callbacks: {
              label: function (ctx) {
                return '  {{ Auth::user()->currency }}' + ctx.raw.toLocaleString('en-US', { minimumFractionDigits: 2 });
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.04)' },
            border: { dash: [4, 4] },
            ticks: {
              color: '#94a3b8',
              font: { size: 11 },
              callback: function (v) { return '{{ Auth::user()->currency }}' + v.toLocaleString(); }
            }
          },
          x: {
            grid: { display: false },
            ticks: { color: '#64748b', font: { size: 12, weight: '600' } }
          }
        }
      }
    });
  });
})();
</script>

@include('user.footer')
