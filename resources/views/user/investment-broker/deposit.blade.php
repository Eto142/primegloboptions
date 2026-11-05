@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-wallet"></i> Deposit Funds</div>
</div>

<div class="ib-card" style="max-width:650px;margin:0 auto;">
    <div class="ib-card-title"><i class="fab fa-bitcoin me-2" style="color:var(--gold);"></i>Cryptocurrency Gateway</div>
    <p style="color:var(--text-muted);font-size:0.82rem;margin-bottom:20px;">Select a cryptocurrency and enter the amount to generate a deposit address.</p>

    <div class="mb-3">
        <label class="form-label fw-semibold small" style="color:var(--text-muted);">Select Currency</label>
        <div class="d-flex flex-wrap gap-2">
            @php $coins = ['BTC','ETH','USDT','USDC','SOL','BNB','DOGE','LTC','TON','POLYGON']; @endphp
            @foreach ($coins as $coin)
            <button type="button" class="btn-outline-gold coin-btn" data-coin="{{ $coin }}" style="padding:8px 16px;font-size:0.8rem;" onclick="selectCoin('{{ $coin }}')">{{ $coin }}</button>
            @endforeach
        </div>
        <input type="hidden" name="coin" id="coinInput" value="BTC">
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold small" style="color:var(--text-muted);">Amount (USD)</label>
        <input type="number" id="depositAmount" class="form-ib" placeholder="0.00" min="1" step="0.01">
    </div>
    <button class="btn-gold w-100 mb-3" onclick="generateAddress()"><i class="fas fa-qrcode me-1"></i> Generate Address</button>
    <div id="qrResult" style="display:none;text-align:center;padding:20px;">
        <div id="qrAddress" style="font-family:'JetBrains Mono',monospace;font-size:0.82rem;color:var(--gold);word-break:break-all;margin-bottom:16px;"></div>
        <div style="width:180px;height:180px;background:rgba(255,255,255,0.05);border-radius:12px;margin:0 auto;display:flex;align-items:center;justify-content:center;color:var(--text-muted);">
            <i class="fas fa-qrcode" style="font-size:3rem;"></i>
        </div>
        <div class="small mt-2" style="color:var(--text-muted);">Scan QR or copy address to deposit</div>
    </div>
</div>

<script>
function selectCoin(coin) {
    document.getElementById('coinInput').value = coin;
    document.querySelectorAll('.coin-btn').forEach(b => b.classList.remove('btn-gold'));
    document.querySelectorAll('.coin-btn').forEach(b => b.classList.add('btn-outline-gold'));
    event.target.classList.remove('btn-outline-gold');
    event.target.classList.add('btn-gold');
}
function generateAddress() {
    const amt = document.getElementById('depositAmount').value;
    if (!amt || amt < 1) { alert('Please enter a valid amount'); return; }
    document.getElementById('qrResult').style.display = 'block';
    document.getElementById('qrAddress').textContent = document.getElementById('coinInput').value.toLowerCase() + '_deposit_address_' + Math.random().toString(36).substring(2, 15);
}
</script>

@include('user.investment-broker.layout.footer')
