@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fab fa-bitcoin"></i> Withdraw to Crypto</div>
</div>

<div class="ib-card" style="max-width:600px;margin:0 auto;">
    <form action="{{ route('user.investments.withdrawals') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Amount (USD)</label>
            <input type="number" name="amount" class="form-ib" min="0.01" step="0.01" placeholder="0.00" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Mode</label>
            <select name="mode" id="modeSelect" class="form-ib">
                <option value="Trading">Trading</option>
                <option value="Bitcoin Mining">Bitcoin Mining</option>
                <option value="Ethereum Mining">Ethereum Mining</option>
                <option value="Cosmos Mining">Cosmos Mining</option>
                <option value="Dogecoin Mining">Dogecoin Mining</option>
                <option value="Binance Coin Mining">Binance Coin Mining</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Crypto Type</label>
            <select name="trading_name" id="tradingName" class="form-ib">
                <option value="Bitcoin BTC">Bitcoin (BTC)</option>
                <option value="Tether USDT">Tether (USDT)</option>
                <option value="Ethereum ETH">Ethereum (ETH)</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Wallet Address</label>
            <input type="text" name="wallet_address" class="form-ib" placeholder="Enter wallet address" required>
        </div>
        <button type="submit" class="btn-gold w-100"><i class="fas fa-paper-plane me-1"></i> Submit Withdrawal</button>
    </form>
</div>

@include('user.investment-broker.layout.footer')
