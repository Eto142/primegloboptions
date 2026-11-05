@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-microchip"></i> Mining Hub</div>
</div>

<div class="ib-card text-center mb-4" style="background:linear-gradient(135deg, rgba(201,162,39,0.08), rgba(201,162,39,0.02));">
    <div class="stat-value display-5 mb-2" style="font-size:2.5rem;">${{ number_format($user_balance ?? 0, 2) }}</div>
    <div class="small" style="color:var(--text-muted);margin-bottom:20px;">MINING BALANCE</div>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('user.investments.deposit') }}" class="btn-gold"><i class="fas fa-shopping-cart me-1"></i> Buy Contract</a>
        <a href="{{ route('user.investments.history') }}" class="btn-outline-gold"><i class="fas fa-list me-1"></i> My Contracts</a>
    </div>
</div>

<div class="ib-card mb-4">
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
        { "symbols": [{"proName":"BITSTAMP:BTCUSD","title":"BTC/USD"},{"proName":"BITSTAMP:ETHUSD","title":"ETH/USD"},{"proName":"BITSTAMP:LTCUSD","title":"LTC/USD"}], "showSymbolLogo": true, "colorTheme": "dark", "isTransparent": true, "displayMode": "adaptive", "locale": "en" }
        </script>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="ib-card">
            <div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>{ "symbol": "FX:BTCUSD", "width": "100%", "height": "100%", "colorTheme": "dark", "isTransparent": true, "autosize": true }</script></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ib-card">
            <div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>{ "symbol": "FX:ETHUSD", "width": "100%", "height": "100%", "colorTheme": "dark", "isTransparent": true, "autosize": true }</script></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ib-card">
            <div class="tradingview-widget-container"><div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>{ "symbol": "FX:LTCUSD", "width": "100%", "height": "100%", "colorTheme": "dark", "isTransparent": true, "autosize": true }</script></div>
        </div>
    </div>
</div>

<div class="ib-card">
    <div class="ib-card-title"><i class="fas fa-coins me-2" style="color:var(--gold);"></i>Mining Pools</div>
    @php $pools = [['Bitcoin','BTC','120 GH/s'],['Ethereum','ETH','85 GH/s'],['BNB','BNB','60 GH/s'],['Dogecoin','DOGE','45 GH/s'],['Cosmos','ATOM','30 GH/s']]; @endphp
    @foreach ($pools as $pool)
    <div class="d-flex justify-content-between align-items-center p-3 mb-2" style="background:rgba(255,255,255,0.02); border-radius:10px;">
        <div><span class="fw-bold" style="color:#fff;">{{ $pool[0] }}</span> <span class="small" style="color:var(--text-muted);">({{ $pool[1] }})</span></div>
        <span class="badge-gold">{{ $pool[2] }}</span>
    </div>
    @endforeach
</div>

@include('user.investment-broker.layout.footer')
