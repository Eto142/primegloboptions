@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-chart-bar"></i> Stock Market Today</div>
</div>

<div class="ib-card">
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-hotlists.js" async>
        { "exchange": "US", "showSymbolLogo": true, "colorTheme": "dark", "isTransparent": true, "locale": "en", "width": "100%", "height": "500" }
        </script>
    </div>
</div>

@include('user.investment-broker.layout.footer')
