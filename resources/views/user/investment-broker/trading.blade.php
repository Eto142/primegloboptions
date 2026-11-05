@include('user.investment-broker.layout.header')


<div class="section-head">
    <div class="section-title"><i class="fas fa-chart-line"></i> Trading Dashboard</div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Balance</div>
        <div class="stat-value">${{ number_format($user_balance ?? 0, 2) }}</div>
        <div class="stat-change neutral"><i class="fas fa-wallet"></i> Available</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Profit</div>
        <div class="stat-value green">${{ number_format($profit ?? 0, 2) }}</div>
        <div class="stat-change up"><i class="fas fa-arrow-up"></i> Total earned</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Deposit</div>
        <div class="stat-value">${{ number_format($deposit ?? 0, 2) }}</div>
        <div class="stat-change neutral"><i class="fas fa-piggy-bank"></i> Total deposited</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Active Plans</div>
        <div class="stat-value">{{ $active_plans ?? 0 }}</div>
        <div class="stat-change neutral"><i class="fas fa-layer-group"></i> Running</div>
    </div>
</div>

<div class="text-center mb-4 d-flex justify-content-center gap-3">
    <a href="{{ route('user.investments.deposit') }}"><button class="btn-gold"><i class="fas fa-plus me-1"></i> Add Funds</button></a>
    <a href="{{ route('user.investments.bot') }}"><button class="btn-outline-gold"><i class="fas fa-robot me-1"></i> Trading Bot</button></a>
</div>

<div class="ib-card mb-4">
    <div class="ib-card-title"><i class="fas fa-tape me-2" style="color:var(--gold);"></i>Live Ticker</div>
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
        { "symbols": [{"proName":"FOREXCOM:SPXUSD","title":"S&P 500"},{"proName":"FOREXCOM:NSXUSD","title":"Nasdaq 100"},{"proName":"FX_IDC:EURUSD","title":"EUR/USD"},{"proName":"BITSTAMP:BTCUSD","title":"BTC/USD"},{"proName":"BITSTAMP:ETHUSD","title":"ETH/USD"}], "showSymbolLogo": true, "colorTheme": "dark", "isTransparent": true, "displayMode": "adaptive", "locale": "en" }
        </script>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="ib-card">
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                { "symbol": "FX:BTCUSD", "width": "100%", "height": "100%", "locale": "en", "dateRange": "12M", "colorTheme": "dark", "isTransparent": true, "autosize": true }
                </script>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ib-card">
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                { "symbol": "FX:ETHUSD", "width": "100%", "height": "100%", "locale": "en", "dateRange": "12M", "colorTheme": "dark", "isTransparent": true, "autosize": true }
                </script>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ib-card">
            <div class="tradingview-widget-container">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                { "symbol": "FX:LTCUSD", "width": "100%", "height": "100%", "locale": "en", "dateRange": "12M", "colorTheme": "dark", "isTransparent": true, "autosize": true }
                </script>
            </div>
        </div>
    </div>
</div>

<div class="ib-card">
    <ul class="nav nav-pills gap-2 mb-3" id="tradesTab" role="tablist">
        <li class="nav-item"><button class="nav-link active rounded-pill" data-bs-toggle="pill" data-bs-target="#open" type="button">Open Trades</button></li>
        <li class="nav-item"><button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#closed" type="button">Closed Trades</button></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="open" role="tabpanel">
            @if (!empty($profithistory) && $profithistory->count() > 0)
                @foreach ($profithistory as $history)
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2" style="background:rgba(255,255,255,0.02); border-radius:12px; border:1px solid rgba(255,255,255,0.05);">
                        <div>
                            <div class="fw-bold" style="color:#fff;">{{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y') }}</div>
                            <div class="small" style="color:var(--text-muted);">Profit earned</div>
                        </div>
                        <div class="fw-bold" style="color:var(--success); font-family:'JetBrains Mono',monospace;">
                            ${{ number_format($history->amount, 2) }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-chart-line"></i></div>
                    <div style="font-weight:800; color:#fff; margin-bottom:8px;">No Open Trades</div>
                    <div style="font-size:0.82rem; color:var(--text-muted);">Your active trades will appear here.</div>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="closed" role="tabpanel">
            @if (!empty($withdrawalhistory) && $withdrawalhistory->count() > 0)
                @foreach ($withdrawalhistory as $w)
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2" style="background:rgba(255,255,255,0.02); border-radius:12px; border:1px solid rgba(255,255,255,0.05);">
                        <div>
                            <div class="fw-bold" style="color:#fff;">${{ $w->amount }}</div>
                            <div class="small" style="color:var(--text-muted);">{{ $w->mode ?? 'Withdrawal' }}</div>
                        </div>
                        @if ($w->status == '0')
                            <span class="badge-yellow">Pending</span>
                        @else
                            <span class="badge-green">Approved</span>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-check"></i></div>
                    <div style="font-weight:800; color:#fff; margin-bottom:8px;">No Closed Trades</div>
                    <div style="font-size:0.82rem; color:var(--text-muted);">Your completed trades will appear here.</div>
                </div>
            @endif
        </div>
    </div>
</div>

@include('user.investment-broker.layout.footer')
