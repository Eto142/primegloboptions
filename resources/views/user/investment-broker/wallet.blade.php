@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-wallet"></i> My Wallet</div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="ib-card" style="border-top:3px solid #f7931a;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:12px;background:rgba(247,147,26,0.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#f7931a;"><i class="fab fa-bitcoin"></i></div>
                <div><h6 class="fw-bold mb-0" style="color:#fff;">Bitcoin Wallet</h6><div class="small" style="color:var(--text-muted);">BTC</div></div>
            </div>
            <div class="fs-5 fw-bold" style="color:#fff;font-family:'JetBrains Mono',monospace;">${{ number_format($user_balance ?? 0, 2) }}</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="ib-card" style="border-top:3px solid #627eea;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:12px;background:rgba(98,126,234,0.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#627eea;"><i class="fab fa-ethereum"></i></div>
                <div><h6 class="fw-bold mb-0" style="color:#fff;">Ethereum Wallet</h6><div class="small" style="color:var(--text-muted);">ETH</div></div>
            </div>
            <div class="fs-5 fw-bold" style="color:#fff;font-family:'JetBrains Mono',monospace;">${{ number_format($user_balance ?? 0, 2) }}</div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-4">
        <div class="ib-card" style="border-top:3px solid var(--danger);">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:12px;background:rgba(255,77,106,0.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:var(--danger);"><i class="fas fa-lock"></i></div>
                <div><h6 class="fw-bold mb-0" style="color:#fff;">Escrow Account</h6><div class="small" style="color:var(--text-muted);">Locked</div></div>
            </div>
            <div class="fs-5 fw-bold" style="color:var(--danger);font-family:'JetBrains Mono',monospace;">{{ Auth::user()->currency ?? '$' }}{{ number_format(Auth::user()->update_escrow ?? 0, 2) }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    @php $fiats = [['USD','$0.00','rgba(0,211,149,0.15)','var(--success)'],['EUR','Locked','rgba(255,77,106,0.15)','var(--danger)'],['CHF','Locked','rgba(255,77,106,0.15)','var(--danger)']]; @endphp
    @foreach ($fiats as $f)
    <div class="col-12 col-md-4">
        <div class="ib-card">
            <div class="d-flex align-items-center gap-3">
                <div style="width:44px;height:44px;border-radius:10px;background:{{ $f[2] }};display:flex;align-items:center;justify-content:center;color:{{ $f[3] }};">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div>
                    <div class="fw-bold" style="color:#fff;">{{ $f[0] }}</div>
                    <div class="small" style="color:var(--text-muted);">{{ $f[1] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@include('user.investment-broker.layout.footer')
