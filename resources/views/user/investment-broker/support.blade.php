@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-headset"></i> Support & Referrals</div>
</div>

<div class="ib-card mb-4">
    <div class="ib-card-title"><i class="fas fa-share-alt me-2" style="color:var(--gold);"></i>Your Referral Link</div>
    <p style="color:var(--text-muted);font-size:0.84rem;margin-bottom:16px;">Share this link with friends. When they register and invest, you earn a referral bonus.</p>
    <div class="d-flex gap-2">
        <input type="text" id="refLink" class="form-ib" value="{{ Auth::user()->account_number ? url('/register?ref=' . Auth::user()->account_number) : url('/register') }}" readonly>
        <button class="btn-gold" onclick="copyAdr()"><i class="fas fa-copy me-1"></i> Copy</button>
    </div>
</div>

<div class="ib-card">
    <div class="ib-card-title"><i class="fas fa-users me-2" style="color:var(--gold);"></i>Referral History</div>
    <table class="ib-table">
        <thead>
            <tr><th>ID</th><th>Username</th><th>Referral Bonus</th><th>Date</th></tr>
        </thead>
        <tbody>
            <tr><td colspan="4" class="text-center" style="color:var(--text-muted);padding:30px;">No referrals yet</td></tr>
        </tbody>
    </table>
    <div class="text-center mt-3">
        <a href="{{ route('user.investments.deposit') }}" class="btn-gold"><i class="fas fa-bolt me-1"></i> Start a new Investment plan</a>
    </div>
</div>

<script>
function copyAdr() {
    const input = document.getElementById('refLink');
    input.select();
    if (navigator.clipboard) navigator.clipboard.writeText(input.value);
    else document.execCommand('copy');
    alert('Referral link copied!');
}
</script>

@include('user.investment-broker.layout.footer')
