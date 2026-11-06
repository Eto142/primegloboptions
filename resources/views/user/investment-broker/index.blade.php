@include('user.investment-broker.layout.header')

{{-- Profit Limit Modal --}}<style>
    .kyc-banner {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 8px; margin: 0 0 10px 0; padding: 10px 14px;
        border-radius: 10px; box-sizing: border-box;
    }
    .kyc-banner--warning {
        background: linear-gradient(135deg, rgba(240,165,0,0.15), rgba(255,230,156,0.08));
        border-left: 5px solid #f0a500; box-shadow: 0 2px 8px rgba(240,165,0,0.15);
    }
    .kyc-banner--danger {
        background: linear-gradient(135deg, rgba(220,53,69,0.15), rgba(245,194,199,0.08));
        border-left: 5px solid #dc3545; box-shadow: 0 2px 8px rgba(220,53,69,0.15);
    }
    .kyc-banner__left { display: flex; align-items: center; gap: 12px; flex: 1 1 0; min-width: 0; }
    .kyc-banner__icon {
        border-radius: 50%; width: 42px; height: 42px; min-width: 42px;
        display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fff;
    }
    .kyc-banner__icon--warning { background: #f0a500; }
    .kyc-banner__icon--danger  { background: #dc3545; }
    .kyc-banner__title { font-weight: 700; font-size: 15px; line-height: 1.3; color: #fff; }
    .kyc-banner__text { font-size: 13px; margin-top: 3px; line-height: 1.45; color: var(--text-muted); }
    .kyc-banner__btn {
        display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none;
        font-weight: 600; font-size: 14px; white-space: nowrap; color: #fff; text-align: center; flex-shrink: 0;
    }
    .kyc-banner__btn--warning { background: #f0a500; }
    .kyc-banner__btn--danger  { background: #dc3545; }
    @media (max-width: 480px) {
        .kyc-banner { flex-direction: column; align-items: flex-start; margin: 10px 10px; padding: 14px 14px; }
        .kyc-banner__btn { width: 100%; padding: 11px 0; }
    }

    .crypto-box {
        background-image: url("{{ asset('stock.jpg') }}");
        background-size: cover;
        background-position: center;
        border: 1px solid var(--border);
        border-radius: 15px; padding: 30px; color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); min-height: 250px;
        position: relative; overflow: hidden;
    }
    .crypto-box::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(6,11,24,0.82) 0%, rgba(13,21,37,0.72) 60%, rgba(6,11,24,0.60) 100%);
        border-radius: 15px;
        z-index: 0;
    }
    .crypto-box > * { position: relative; z-index: 1; }
    .crypto-box .amount { font-size: 1.8em; margin-bottom: 5px; font-family: 'JetBrains Mono', monospace; font-weight: 800; color: var(--gold); }
    .crypto-box b { font-size: 0.78rem; color: var(--text-muted); letter-spacing: 1px; }

    .progress { height: 24px; background: #14161b; border-radius: 50px; overflow: hidden; box-shadow: inset 0 0 12px rgba(0,0,0,0.6); margin-top: 15px; }
    .progress-bar { height: 100%; border-radius: 50px; transition: width 1.2s ease-in-out; position: relative; }
    .progress-bar::before {
        content: ""; position: absolute; top: 0; left: -40%; height: 100%; width: 40%;
        background: linear-gradient(90deg, rgba(255,255,255,0.3), transparent); animation: shine 2.5s infinite linear;
    }
    @keyframes shine { 0% { left: -40%; } 100% { left: 100%; } }
    .progress-bar.weak { background: linear-gradient(90deg, #ff4c4c, #c0392b); box-shadow: 0 0 18px #ff4c4c80; }
    .progress-bar.moderate { background: linear-gradient(90deg, #ffa047, #e67e22); box-shadow: 0 0 18px #ffa04780; }
    .progress-bar.strong { background: linear-gradient(90deg, #2ecc71, #27ae60); box-shadow: 0 0 18px #2ecc7180; }
    .progress-bar.very-strong { background: linear-gradient(90deg, #3498db, #1f78d1); box-shadow: 0 0 18px #3498db80; }
    .progress-bar.extreme { background: linear-gradient(90deg, #b36ae2, #8e44ad); box-shadow: 0 0 18px #b36ae280; }

    .signal-strength { font-size: 1.1rem; color: #fff; margin-top: 12px; text-align: center; font-weight: 500; letter-spacing: 0.4px; }
    .signal-level { font-size: 1.25rem; font-weight: 700; color: #fff; text-shadow: 0 0 12px rgba(255,255,255,0.3); margin-top: 6px; }
    .signal-message {
        font-size: 1rem; font-weight: 600; color: #fff; margin-top: 14px; text-align: center;
        line-height: 1.75; border-radius: 14px; padding: 18px 20px; transition: all 0.4s ease;
        backdrop-filter: blur(10px); border: 2px solid transparent; box-shadow: 0 0 18px rgba(0,0,0,0.5);
        position: relative; animation: fadeIn 0.8s ease-in-out;
    }
    .signal-message span.icon { font-size: 1.4rem; margin-right: 8px; vertical-align: middle; display: inline-block; }
    @keyframes fadeIn { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }
    .signal-message.weak { background: rgba(231,76,60,0.35); border-color: #ff5c5c; box-shadow: 0 0 25px rgba(231,76,60,0.4); }
    .signal-message.moderate { background: rgba(230,126,34,0.35); border-color: #ff9933; box-shadow: 0 0 25px rgba(230,126,34,0.4); }
    .signal-message.strong { background: rgba(46,204,113,0.35); border-color: #2ecc71; box-shadow: 0 0 25px rgba(46,204,113,0.4); }
    .signal-message.very-strong { background: rgba(52,152,219,0.35); border-color: #3498db; box-shadow: 0 0 25px rgba(52,152,219,0.4); }
    .signal-message.extreme { background: rgba(155,89,182,0.35); border-color: #b76deb; box-shadow: 0 0 25px rgba(155,89,182,0.5); }
    .signal-message:hover { transform: scale(1.03); box-shadow: 0 0 30px rgba(255,255,255,0.2); }

    .custom-button {
        border-radius: 20px; border: 2px solid var(--gold); color: var(--gold);
        padding: 10px 20px; background: transparent; margin: 10px; cursor: pointer;
        transition: background-color 0.3s, color 0.3s; font-weight: 700;
    }
    .custom-button:hover { background: var(--gold); color: #fff; }

    .marquee {
        background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: 10px;
        padding: 8px 16px; margin-bottom: 16px; color: var(--gold); font-size: 0.85rem; font-weight: 600;
    }
    .page-title { color: #fff; font-weight: 800; margin-bottom: 12px; font-size: 1.2rem; }

    .trade-card {
        background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px;
        padding: 16px 20px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;
    }
    .trade-card .icon-circle {
        width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        background: rgba(201,162,39,0.12); color: var(--gold); margin-right: 14px; flex-shrink: 0;
    }
    .nav-tabs-custom-dark { display: flex; gap: 4px; background: rgba(255,255,255,0.04); border-radius: 10px; padding: 4px; margin-bottom: 16px; }
    .nav-tabs-custom-dark a { color: var(--text-muted); font-weight: 600; font-size: 0.85rem; padding: 8px 20px; border-radius: 8px; cursor: pointer; }
    .nav-tabs-custom-dark a.active { color: #fff; background: rgba(201,162,39,0.15); }
    .badge-warning-dark { background: rgba(245,158,11,0.15); color: #fbbf24; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .badge-success-dark { background: rgba(0,211,149,0.15); color: var(--success); font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .tradingview-widget-container { margin-bottom: 20px; }
    .profit-limit-modal .modal-content { background: var(--dark2); border: 1px solid var(--border); border-radius: 12px; }
    .profit-limit-modal .modal-header { background: linear-gradient(90deg, #0d6efd, #198754); border: none; }
</style>

{{-- Profit Limit Modal --}}
@if(Auth::user()->profit_limit_status == 1)
    <button type="button" class="btn btn-primary d-none" id="profitLimitModalBtn" data-bs-toggle="modal" data-bs-target="#profitLimitModal">Open Modal</button>
    <div class="modal fade profit-limit-modal" id="profitLimitModal" tabindex="-1" aria-labelledby="profitLimitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content shadow-lg" style="border-radius:12px; overflow:hidden; border:none;">
                <div class="modal-header bg-gradient text-white" style="background: linear-gradient(90deg, #0d6efd, #198754); border-bottom:none;">
                    <h5 class="modal-title" id="profitLimitModalLabel">Profit Alert</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background:var(--dark2); font-family: 'Plus Jakarta Sans', sans-serif; line-height:1.5; color:#e2e8f0;">
                    <p>Hello <strong>{{ Auth::user()->first_name ?? Auth::user()->name }}</strong>,</p>
                    <p><strong>Wow! You've hit high profits.</strong></p>
                    <p>Your account needs an <strong>upgrade</strong> to continue trading without limits.</p>
                    <div class="text-center my-3">
                        <a href="mailto:support@primegloboptions.com" class="btn-gold" style="padding:12px 30px; border-radius:6px; text-decoration:none;">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('profitLimitModalBtn').click();
        });
    </script>
@endif

{{-- KYC Banner --}}
@if(Auth::user()->show_kyc_notice != 0)
    @if(Auth::user()->kyc_status == '0')
    <div class="kyc-banner kyc-banner--warning">
        <div class="kyc-banner__left">
            <div class="kyc-banner__icon kyc-banner__icon--warning">⚠️</div>
            <div>
                <div class="kyc-banner__title">Identity Verification Required</div>
                <div class="kyc-banner__text">Your account is not yet verified. Please complete KYC to unlock full trading features and withdrawals.</div>
            </div>
        </div>
        <a href="{{ route('user.investments.profile') }}" class="kyc-banner__btn kyc-banner__btn--warning">Verify Now →</a>
    </div>
    @elseif(Auth::user()->kyc_status == '2')
    <div class="kyc-banner kyc-banner--danger">
        <div class="kyc-banner__left">
            <div class="kyc-banner__icon kyc-banner__icon--danger">❌</div>
            <div>
                <div class="kyc-banner__title">KYC Verification Rejected</div>
                <div class="kyc-banner__text">Your KYC submission was rejected. Please resubmit your documents to continue.</div>
            </div>
        </div>
        <a href="{{ route('user.investments.profile') }}" class="kyc-banner__btn kyc-banner__btn--danger">Resubmit KYC →</a>
    </div>
    @endif
@endif

<h4 class="page-title">Trading</h4>
<marquee class="marquee" behavior="scroll" direction="left" scrollamount="5">
    Notification: {{ Auth::user()->update_notification ?? 'Welcome to PGO Invest — your trusted investment platform.' }}
</marquee>

{{-- Balance / Profit / Deposit Box --}}
<div class="crypto-box">
    <div class="row align-items-center text-center">
        <div class="col-4 text-start">
            <div class="amount">${{ number_format($user_balance ?? 0, 2) }}</div>
            <b>BALANCE</b>
        </div>
        <div class="col-4">
            <div class="amount">${{ number_format($profit ?? 0, 2) }}</div>
            <b>PROFIT</b>
        </div>
        <div class="col-4 text-end">
            <div class="amount">${{ number_format($deposit ?? 0, 2) }}</div>
            <b>DEPOSIT</b>
        </div>
    </div>

    @if(Auth::user()->show_signal_strength != 0)
    @php
        $strength = Auth::user()->signal_strength ?? 50;
        if ($strength < 40) {
            $class = 'weak'; $level = '🟥 Weak Signal'; $icon = '⚠️';
            $message = 'Market conditions are uncertain. A signal payment is recommended to unlock stronger insights.';
        } elseif ($strength < 70) {
            $class = 'moderate'; $level = '🟧 Moderate Signal'; $icon = '💡';
            $message = 'Good potential. Consider a small signal payment to boost confidence and optimize profits.';
        } elseif ($strength < 85) {
            $class = 'strong'; $level = '🟩 Strong Signal'; $icon = '✅';
            $message = 'High-probability signal! You are in a good position to earn significant profits.';
        } elseif ($strength < 95) {
            $class = 'very-strong'; $level = '🟦 Very Strong Signal'; $icon = '🚀';
            $message = 'Excellent alignment! Low risk, high reward potential — prime time for trading.';
        } else {
            $class = 'extreme'; $level = '🟪 Extreme Signal'; $icon = '🔥';
            $message = 'Exceptional strength! Maximum profit potential detected — secure your trade now.';
        }
    @endphp
    <div class="row mt-4">
        <div class="col-12">
            <div class="progress">
                <div class="progress-bar {{ $class }}" role="progressbar"
                    style="width: {{ $strength }}%;" aria-valuenow="{{ $strength }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>
            <div class="signal-strength">
                <b>Signal Strength:</b> {{ $strength }}%
                <div class="signal-level">{{ $level }}</div>
            </div>
            <div class="signal-message {{ $class }}">
                <span class="icon">{{ $icon }}</span> {{ $message }}
            </div>
        </div>
    </div>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('user.investments.deposit') }}"><button class="custom-button">Add Funds</button></a>
        <a href="{{ route('user.investments.bot') }}"><button class="custom-button">Trading Bot</button></a>
    </div>
</div>

<br><br>

{{-- TradingView Ticker Tape --}}
<div class="tradingview-widget-container">
    <div class="tradingview-widget-container__widget"></div>
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
    {
    "symbols": [
        {"proName": "FOREXCOM:SPXUSD", "title": "S&P 500"},
        {"proName": "FOREXCOM:NSXUSD", "title": "Nasdaq 100"},
        {"proName": "FX_IDC:EURUSD", "title": "EUR/USD"},
        {"proName": "BITSTAMP:BTCUSD", "title": "BTC/USD"},
        {"proName": "BITSTAMP:ETHUSD", "title": "ETH/USD"}
    ],
    "showSymbolLogo": true, "colorTheme": "dark", "isTransparent": true, "displayMode": "adaptive", "locale": "en"
    }
    </script>
</div>

<br>

{{-- TradingView Mini Charts --}}
<div class="row g-3">
    <div class="col-md-4">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
            { "symbol": "FX:BTCUSD", "width": "100%", "height": "100%", "locale": "en", "dateRange": "12M", "colorTheme": "dark", "trendLineColor": "rgba(201,162,39,1)", "underLineColor": "rgba(201,162,39,0.3)", "underLineBottomColor": "rgba(201,162,39,0.0)", "isTransparent": true, "autosize": true }
            </script>
        </div>
    </div>
    <div class="col-md-4">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
            { "symbol": "FX:ETHUSD", "width": "100%", "height": "100%", "locale": "en", "dateRange": "12M", "colorTheme": "dark", "trendLineColor": "rgba(201,162,39,1)", "underLineColor": "rgba(201,162,39,0.3)", "underLineBottomColor": "rgba(201,162,39,0.0)", "isTransparent": true, "autosize": true }
            </script>
        </div>
    </div>
    <div class="col-md-4">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
            { "symbol": "FX:LTCUSD", "width": "100%", "height": "100%", "locale": "en", "dateRange": "12M", "colorTheme": "dark", "trendLineColor": "rgba(201,162,39,1)", "underLineColor": "rgba(201,162,39,0.3)", "underLineBottomColor": "rgba(201,162,39,0.0)", "isTransparent": true, "autosize": true }
            </script>
        </div>
    </div>
</div>

<br>

{{-- Open / Closed Trades Tabs --}}
<div class="ib-card">
    <div class="nav-tabs-custom-dark" id="nav-tab" role="tablist">
        <a class="active" id="nav-open-tab" data-bs-toggle="pill" data-bs-target="#openTrades" type="button" role="tab">Open Trades</a>
        <a id="nav-closed-tab" data-bs-toggle="pill" data-bs-target="#closedTrades" type="button" role="tab">Closed Trades</a>
    </div>
    <div class="tab-content">
        {{-- Open Trades --}}
        <div class="tab-pane fade show active" id="openTrades" role="tabpanel">
            @if (!empty($profithistory) && $profithistory->count() > 0)
                @foreach ($profithistory as $history)
                    <div class="trade-card">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle"><i class="fas fa-chart-line"></i></div>
                            <div>
                                <div style="font-weight:700; color:#fff;">{{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div style="font-weight:800; color:var(--success); font-family:'JetBrains Mono',monospace;">
                            ${{ number_format($history->amount, 2) }}
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:30px; color:var(--text-muted);">
                    <i class="fas fa-chart-line fs-2 mb-2 d-block"></i>
                    <div style="font-size:0.82rem;">NO OPEN TRADES</div>
                </div>
            @endif
        </div>
        {{-- Closed Trades --}}
        <div class="tab-pane fade" id="closedTrades" role="tabpanel">
            @if (!empty($withdrawalhistory) && $withdrawalhistory->count() > 0)
                @foreach ($withdrawalhistory as $w)
                    <div class="trade-card">
                        <div class="d-flex align-items-center">
                            <span style="font-size:1.4rem; font-weight:700; color:#fff; margin-right:20px; font-family:'JetBrains Mono',monospace;">
                                {{ \Carbon\Carbon::parse($w->created_at)->format('M d') }}
                            </span>
                            <div>
                                <span style="font-weight:700; color:#fff;">${{ $w->amount }}</span><br>
                                <span style="color:var(--text-muted); font-size:0.82rem;">{{ $w->mode }}</span><br>
                                @if($w->status == '0')
                                    <span class="badge-warning-dark">Pending</span>
                                @else
                                    <span class="badge-success-dark">Approved</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align:center; padding:30px; color:var(--text-muted);">
                    <i class="fas fa-check-circle fs-2 mb-2 d-block"></i>
                    <div style="font-size:0.82rem;">NO CLOSED TRADES</div>
                </div>
            @endif
        </div>
    </div>
</div>

@include('user.investment-broker.layout.footer')
