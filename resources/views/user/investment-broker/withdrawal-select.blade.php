@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-arrow-up"></i> Choose Withdrawal Method</div>
</div>

<div class="row g-3">
    <div class="col-12 col-md-4">
        <a href="{{ route('user.investments.withdrawals') }}" class="text-reset">
            <div class="ib-card h-100 text-center" style="border-top:3px solid #60a5fa;">
                <div style="width:56px;height:56px;border-radius:14px;background:rgba(59,130,246,0.15);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#60a5fa;margin:0 auto 16px;"><i class="fas fa-university"></i></div>
                <h6 class="fw-bold mb-1" style="color:#fff;">Bank Transfer</h6>
                <div class="small" style="color:var(--text-muted);">Withdraw to your bank account</div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-4">
        <a href="{{ route('user.investments.withdrawals') }}" class="text-reset">
            <div class="ib-card h-100 text-center" style="border-top:3px solid #f7931a;">
                <div style="width:56px;height:56px;border-radius:14px;background:rgba(247,147,26,0.15);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#f7931a;margin:0 auto 16px;"><i class="fab fa-bitcoin"></i></div>
                <h6 class="fw-bold mb-1" style="color:#fff;">Cryptocurrency</h6>
                <div class="small" style="color:var(--text-muted);">Withdraw to crypto wallet</div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-4">
        <a href="{{ route('user.investments.withdrawals') }}" class="text-reset">
            <div class="ib-card h-100 text-center" style="border-top:3px solid #0070ba;">
                <div style="width:56px;height:56px;border-radius:14px;background:rgba(0,112,186,0.15);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#0070ba;margin:0 auto 16px;"><i class="fab fa-paypal"></i></div>
                <h6 class="fw-bold mb-1" style="color:#fff;">PayPal</h6>
                <div class="small" style="color:var(--text-muted);">Withdraw to PayPal account</div>
            </div>
        </a>
    </div>
</div>

@include('user.investment-broker.layout.footer')
