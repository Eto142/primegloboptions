@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-globe"></i> Markets Browser</div>
    <select id="dataType" class="form-ib" style="width:auto;">
        <option value="crypto">Crypto</option>
        <option value="currencies">Currencies</option>
        <option value="stocks">Stocks</option>
        <option value="indices">Indices</option>
    </select>
</div>

<div class="ib-card">
    <div id="marketResults" class="row g-2">
        <div class="col-12 text-center py-5" style="color:var(--text-muted);">
            <i class="fas fa-magnifying-glass fs-2 mb-2 d-block"></i>
            Select a market type and browse available assets.
        </div>
    </div>
</div>

<script>
document.getElementById('dataType').addEventListener('change', loadMarket);
function loadMarket() {
    const type = document.getElementById('dataType').value;
    const container = document.getElementById('marketResults');
    container.innerHTML = '<div class="col-12 text-center py-4" style="color:var(--text-muted);"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
    const symbols = {
        crypto: ['BTC','ETH','BNB','SOL','XRP','ADA','DOGE','DOT'],
        currencies: ['EUR/USD','GBP/USD','USD/JPY','AUD/USD','USD/CAD','USD/CHF'],
        stocks: ['AAPL','TSLA','NVDA','MSFT','GOOGL','AMZN','META','NFLX'],
        indices: ['SPX','NSDQ','DJI','FTSE','DAX','Nikkei']
    };
    const list = symbols[type] || [];
    container.innerHTML = '';
    list.forEach(function(sym) {
        const div = document.createElement('div');
        div.className = 'col-6 col-md-4 col-lg-3';
        div.innerHTML = '<div class="ib-card" style="cursor:pointer;padding:16px;" onclick="selectItem(\'' + sym + '\',\'' + type + '\')">' +
            '<div class="d-flex align-items-center gap-2">' +
            '<i class="fas fa-star" style="color:var(--gold);cursor:pointer;" onclick="event.stopPropagation();toggleWatch(\'' + sym + '\',this)"></i>' +
            '<span style="color:#fff;font-weight:700;">' + sym + '</span>' +
            '</div></div>';
        container.appendChild(div);
    });
}
function selectItem(sym, type) {
    localStorage.setItem('selectedItem', JSON.stringify({name: sym, type: type}));
    window.location.href = '{{ route("user.investments.trading-room") }}';
}
function toggleWatch(sym, star) {
    star.style.color = star.style.color === 'rgb(201, 162, 39)' ? '#6b7fa3' : '#C9A227';
}
loadMarket();
</script>

@include('user.investment-broker.layout.footer')
