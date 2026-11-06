@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-credit-card"></i> Select Payment Method</div>
</div>

<div class="ib-card" style="max-width:520px;margin:0 auto;">
    <div class="ib-card-title" style="text-align:center;font-size:1.2rem;">
        Pay <span style="color:var(--gold);font-family:'JetBrains Mono',monospace;">${{ number_format($data['amount'], 2) }}</span>
    </div>
    <p style="color:var(--text-muted);font-size:0.83rem;text-align:center;margin-bottom:28px;">
        Choose how you'd like to fund your account.
    </p>

    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- Send Crypto option --}}
        <form method="POST" action="{{ route('user.investments.deposit.payment') }}">
            @csrf
            <input type="hidden" name="amount" value="{{ $data['amount'] }}">
            <input type="hidden" name="trading_name" value="{{ $data['trading_name'] }}">
            <input type="hidden" name="item" value="Bitcoin">
            <button type="submit" class="w-100 text-start" style="background:rgba(201,162,39,0.06);border:1px solid var(--border);border-radius:14px;padding:18px 22px;cursor:pointer;transition:all 0.2s ease;display:flex;align-items:center;gap:18px;" onmouseover="this.style.borderColor='rgba(201,162,39,0.4)'" onmouseout="this.style.borderColor='var(--border)'">
                <div style="width:48px;height:48px;border-radius:12px;background:rgba(201,162,39,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fab fa-bitcoin" style="font-size:1.5rem;color:var(--gold);"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#fff;font-size:0.92rem;">Send Crypto (BTC)</div>
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:2px;">Pay with Bitcoin</div>
                </div>
                <i class="fas fa-chevron-right ms-auto" style="color:var(--text-muted);"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('user.investments.deposit.payment') }}">
            @csrf
            <input type="hidden" name="amount" value="{{ $data['amount'] }}">
            <input type="hidden" name="trading_name" value="{{ $data['trading_name'] }}">
            <input type="hidden" name="item" value="Usdt">
            <button type="submit" class="w-100 text-start" style="background:rgba(201,162,39,0.06);border:1px solid var(--border);border-radius:14px;padding:18px 22px;cursor:pointer;transition:all 0.2s ease;display:flex;align-items:center;gap:18px;" onmouseover="this.style.borderColor='rgba(201,162,39,0.4)'" onmouseout="this.style.borderColor='var(--border)'">
                <div style="width:48px;height:48px;border-radius:12px;background:rgba(38,161,123,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-dollar-sign" style="font-size:1.3rem;color:#26a17b;"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#fff;font-size:0.92rem;">Send Crypto (USDT)</div>
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:2px;">Pay with Tether (USDT)</div>
                </div>
                <i class="fas fa-chevron-right ms-auto" style="color:var(--text-muted);"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('user.investments.deposit.payment') }}">
            @csrf
            <input type="hidden" name="amount" value="{{ $data['amount'] }}">
            <input type="hidden" name="trading_name" value="{{ $data['trading_name'] }}">
            <input type="hidden" name="item" value="Ethereum">
            <button type="submit" class="w-100 text-start" style="background:rgba(201,162,39,0.06);border:1px solid var(--border);border-radius:14px;padding:18px 22px;cursor:pointer;transition:all 0.2s ease;display:flex;align-items:center;gap:18px;" onmouseover="this.style.borderColor='rgba(201,162,39,0.4)'" onmouseout="this.style.borderColor='var(--border)'">
                <div style="width:48px;height:48px;border-radius:12px;background:rgba(98,126,234,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fab fa-ethereum" style="font-size:1.4rem;color:#627eea;"></i>
                </div>
                <div>
                    <div style="font-weight:700;color:#fff;font-size:0.92rem;">Send Crypto (ETH)</div>
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:2px;">Pay with Ethereum</div>
                </div>
                <i class="fas fa-chevron-right ms-auto" style="color:var(--text-muted);"></i>
            </button>
        </form>

    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('user.investments.deposit') }}" style="color:var(--text-muted);font-size:0.82rem;">
            <i class="fas fa-arrow-left me-1"></i> Go back
        </a>
    </div>
</div>

@include('user.investment-broker.layout.footer')
