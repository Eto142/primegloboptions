@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-desktop"></i> <span id="trTitle">Trading Room</span></div>
    <div class="balance-pill"><i class="fas fa-wallet me-1"></i>${{ number_format($user_balance ?? 0, 2) }}</div>
</div>

<div class="ib-card">
    <div class="tradingview-widget-container" style="min-height:500px;">
        <div id="tv_chart" style="width:100%;height:500px;"></div>
    </div>
</div>

<div class="d-flex justify-content-center gap-3 mt-4">
    <button class="btn-gold" onclick="buy()" style="background:linear-gradient(135deg, #00d395, #00a878);"><i class="fas fa-arrow-up me-1"></i> BUY / UP</button>
    <button class="btn-gold" onclick="sell()" style="background:linear-gradient(135deg, #ff4d6a, #e63956);"><i class="fas fa-arrow-down me-1"></i> SELL / DOWN</button>
</div>

<script src="https://s3.tradingview.com/tv.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const item = JSON.parse(localStorage.getItem('selectedItem') || '{}');
    if (item.name) document.getElementById('trTitle').textContent = item.name + ' Trading Room';
    function getSymbol(name, type) {
        if (type === 'crypto') return name.toUpperCase() + 'USD';
        if (type === 'stocks') return name;
        if (type === 'currencies') return 'OANDA:' + name.replace('/', '');
        if (type === 'indices') return name;
        return name.toUpperCase();
    }
    new TradingView.widget({
        container_id: 'tv_chart',
        symbol: getSymbol(item.name || 'BTC', item.type || 'crypto'),
        interval: 'D', autosize: true, theme: 'dark', locale: 'en'
    });
});
function buy() { alert('Buy order submitted for ' + (JSON.parse(localStorage.getItem('selectedItem') || '{}').name || 'asset')); }
function sell() { alert('Sell order submitted for ' + (JSON.parse(localStorage.getItem('selectedItem') || '{}').name || 'asset')); }
</script>

@include('user.investment-broker.layout.footer')
