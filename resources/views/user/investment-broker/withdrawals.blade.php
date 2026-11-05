@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-arrow-up"></i> Request Withdrawal</div>
</div>

<div class="ib-card" style="max-width:650px;margin:0 auto;">
    <form action="{{ route('user.investments.withdrawals') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Amount (USD)</label>
            <input type="number" name="amount" class="form-ib" placeholder="0.00" min="0.01" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Payment Mode</label>
            <select name="mode" id="modeSelect" class="form-ib" onchange="toggleMode()">
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Crypto Currency">Crypto Currency</option>
            </select>
        </div>
        <div id="bankBlock">
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Account Number</label><input type="text" name="account_number" class="form-ib"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Account Name</label><input type="text" name="account_name" class="form-ib"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Bank Name</label><input type="text" name="bank_name" class="form-ib"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">SWIFT/BIC</label><input type="text" name="swift" class="form-ib"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Routing Number</label><input type="text" name="bank_routing_number" class="form-ib"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Country</label><input type="text" name="bank_country" class="form-ib"></div>
        </div>
        <div id="cryptoBlock" style="display:none;">
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Crypto Type</label>
                <select name="crypto_type" class="form-ib"><option value="BTC">Bitcoin</option><option value="ETH">Ethereum</option><option value="USDT">Tether</option><option value="LTC">Litecoin</option></select>
            </div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Wallet Address</label><input type="text" name="wallet_address" class="form-ib"></div>
        </div>
        <button type="submit" class="btn-gold w-100"><i class="fas fa-paper-plane me-1"></i> Submit Withdrawal Request</button>
    </form>
</div>

<script>
function toggleMode() {
    const mode = document.getElementById('modeSelect').value;
    document.getElementById('bankBlock').style.display = mode === 'Bank Transfer' ? 'block' : 'none';
    document.getElementById('cryptoBlock').style.display = mode === 'Crypto Currency' ? 'block' : 'none';
}
</script>

@include('user.investment-broker.layout.footer')
