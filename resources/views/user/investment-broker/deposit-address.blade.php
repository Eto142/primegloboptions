@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-qrcode"></i> Send Payment</div>
</div>

<div class="ib-card" style="max-width:560px;margin:0 auto;">

    {{-- Header --}}
    <div style="text-align:center;margin-bottom:24px;">
        <div style="font-size:1.05rem;font-weight:700;color:#fff;">
            Send <span style="color:var(--gold);font-family:'JetBrains Mono',monospace;">${{ number_format($data['amount'], 2) }}</span>
            worth of <span style="color:var(--gold);">{{ $data['item'] }}</span>
        </div>
        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:6px;">
            Destination: {{ $data['trading_name'] }}
        </div>
    </div>

    {{-- Countdown timer --}}
    <div style="text-align:center;margin-bottom:22px;">
        <div style="display:inline-flex;align-items:center;gap:10px;background:rgba(255,77,106,0.08);border:1px solid rgba(255,77,106,0.2);border-radius:30px;padding:8px 22px;">
            <i class="fas fa-clock" style="color:#ff4d6a;"></i>
            <span style="font-family:'JetBrains Mono',monospace;font-size:1.1rem;font-weight:700;color:#ff4d6a;" id="countdown">60:00</span>
            <span style="font-size:0.78rem;color:var(--text-muted);">remaining</span>
        </div>
    </div>

    {{-- Payment guide --}}
    <div style="background:rgba(201,162,39,0.04);border:1px solid rgba(201,162,39,0.12);border-radius:12px;padding:16px;margin-bottom:24px;">
        <div style="font-size:0.78rem;font-weight:800;color:var(--gold);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:10px;">
            <i class="fas fa-info-circle me-1"></i> Payment Guide
        </div>
        <ul style="margin:0;padding-left:18px;color:var(--text-muted);font-size:0.82rem;line-height:2;">
            <li>Copy or scan the wallet address below to make payment.</li>
            <li>Send <strong style="color:#fff;">exactly</strong> the amount shown — no more, no less.</li>
            <li>Do <strong style="color:#ff4d6a;">NOT</strong> send a different cryptocurrency to this address.</li>
            <li>Your account will be credited after admin confirmation.</li>
        </ul>
    </div>

    {{-- Resolve the address from this project's wallet row --}}
    @php
        $addr      = null;
        $coinLabel = '';
        $coinColor = '#C9A227';
        $coinIcon  = 'fas fa-coins';
        $addrId    = 'walletAddress';

        if ($wallet) {
            switch ($data['item']) {
                case 'Bitcoin':
                    $addr      = $wallet->bitcoin_address;
                    $coinLabel = 'Bitcoin (BTC)';
                    $coinColor = '#f7931a';
                    $coinIcon  = 'fab fa-bitcoin';
                    break;
                case 'Usdt':
                    $addr      = $wallet->usdt_address;
                    $coinLabel = 'Tether (USDT)';
                    $coinColor = '#26a17b';
                    $coinIcon  = 'fas fa-dollar-sign';
                    break;
                case 'Ethereum':
                    $addr      = $wallet->ethereum_address;
                    $coinLabel = 'Ethereum (ETH)';
                    $coinColor = '#627eea';
                    $coinIcon  = 'fab fa-ethereum';
                    break;
            }
        }
    @endphp

    @if($wallet && $addr)

        {{-- Coin label --}}
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;">
                <i class="{{ $coinIcon }}" style="color:{{ $coinColor }};font-size:1.2rem;"></i>
            </div>
            <div style="font-weight:700;color:#fff;font-size:0.92rem;">{{ $coinLabel }} Wallet Address</div>
        </div>

        {{-- QR code (generated from the real address) --}}
        <div style="text-align:center;margin-bottom:20px;">
            <div style="display:inline-block;background:#fff;padding:12px;border-radius:14px;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($addr) }}&size=200x200&margin=4"
                     alt="QR Code" width="200" height="200" style="display:block;border-radius:6px;">
            </div>
            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:8px;">Scan with your wallet app</div>
        </div>

        {{-- Address field --}}
        <label style="font-size:0.78rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.8px;margin-bottom:8px;display:block;">
            Wallet Address
        </label>
        <div style="display:flex;gap:8px;margin-bottom:20px;">
            <input type="text" id="{{ $addrId }}" value="{{ $addr }}" readonly
                   class="form-ib" style="font-family:'JetBrains Mono',monospace;font-size:0.82rem;flex:1;">
            <button onclick="copyAddress('{{ $addrId }}')" class="btn-gold" style="padding:10px 18px;white-space:nowrap;flex-shrink:0;">
                <i class="fas fa-copy me-1"></i> Copy
            </button>
        </div>

    @else
        {{-- No active crypto wallet configured --}}
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-wallet"></i></div>
            <div style="font-weight:700;color:#fff;margin-bottom:6px;">Wallet address not configured</div>
            <div style="font-size:0.82rem;color:var(--text-muted);">
                Please contact support and reference your deposit of
                <strong style="color:var(--gold);">${{ number_format($data['amount'], 2) }}</strong>
                to complete your funding.
            </div>
        </div>
    @endif

    {{-- Important notice --}}
    <div style="background:rgba(255,77,106,0.05);border:1px solid rgba(255,77,106,0.15);border-radius:12px;padding:16px;margin-bottom:24px;">
        <div style="font-size:0.78rem;font-weight:800;color:#ff4d6a;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:10px;">
            <i class="fas fa-exclamation-triangle me-1"></i> Important Notice
        </div>
        <ul style="margin:0;padding-left:18px;color:var(--text-muted);font-size:0.82rem;line-height:2;">
            <li>Do not transfer any cryptocurrency other than <strong style="color:#fff;">{{ $data['item'] }}</strong>.</li>
            <li>Please wait patiently — blockchain confirmations may take up to 30 minutes.</li>
            <li>Once confirmed by admin, your balance will be updated.</li>
        </ul>
    </div>

    {{-- Actions --}}
    <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <a href="{{ route('user.investments.history') }}" class="btn-gold" style="flex:1;text-align:center;padding:12px;">
            <i class="fas fa-clock me-1"></i> Wait for Confirmation
        </a>
        <a href="{{ route('user.investments.deposit.method') }}" class="btn-outline-gold" style="flex:1;text-align:center;padding:12px;">
            <i class="fas fa-exchange-alt me-1"></i> Change Method
        </a>
    </div>
</div>

<script>
    // 60-minute countdown
    (function () {
        let total = 60 * 60;
        const el  = document.getElementById('countdown');
        const iv  = setInterval(function () {
            if (total <= 0) {
                clearInterval(iv);
                el.textContent = '00:00';
                alert('Time is up! Please initiate the payment again.');
                return;
            }
            const m = Math.floor(total / 60);
            const s = total % 60;
            el.textContent = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
            total--;
        }, 1000);
    })();

    function copyAddress(id) {
        const input = document.getElementById(id);
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand('copy');

        const btn     = event.currentTarget;
        const original = btn.innerHTML;
        btn.innerHTML  = '<i class="fas fa-check me-1"></i> Copied!';
        setTimeout(() => { btn.innerHTML = original; }, 2000);
    }
</script>

@include('user.investment-broker.layout.footer')
