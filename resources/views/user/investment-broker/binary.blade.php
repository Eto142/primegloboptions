@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-chart-candlestick"></i> Binary Trading</div>
    <div class="d-flex gap-2">
        <a href="{{ route('user.investments.deposit') }}" class="btn-gold" style="padding:8px 18px;font-size:0.85rem;"><i class="fas fa-plus me-1"></i> Deposit</a>
        <a href="{{ route('user.investments.withdrawals') }}" class="btn-outline-gold" style="padding:8px 18px;font-size:0.85rem;"><i class="fas fa-arrow-up me-1"></i> Withdraw</a>
    </div>
</div>

<div class="ib-card text-center">
    <div class="tradingview-widget-container" style="min-height:610px;">
        <div id="tradingview_b4b8d" style="width:100%;height:610px;"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
        <script>
        new TradingView.widget({
            "container_id": "tradingview_b4b8d", "symbol": "FX:EURUSD", "interval": "D",
            "autosize": true, "theme": "dark", "locale": "en"
        });
        </script>
    </div>
</div>

@include('user.investment-broker.layout.footer')
