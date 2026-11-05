@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-share-alt"></i> Referral Program</div>
</div>

<div class="ib-card text-center mb-4">
    <div style="width:64px;height:64px;border-radius:16px;background:rgba(201,162,39,0.12);display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:var(--gold);margin:0 auto 16px;">
        <i class="fas fa-gift"></i>
    </div>
    <h5 class="fw-bold mb-2" style="color:#fff;">Invite Friends, Earn Together</h5>
    <p style="color:var(--text-muted);font-size:0.85rem;max-width:500px;margin:0 auto 20px;">Share your referral link and earn bonuses when your friends start investing.</p>
    <div class="d-flex gap-2 justify-content-center">
        <input type="text" id="referralLink" class="form-ib" style="max-width:400px;" value="{{ Auth::user()->account_number ? url('/register?ref=' . Auth::user()->account_number) : url('/register') }}" readonly>
        <button class="btn-gold" onclick="copyRef()"><i class="fas fa-copy me-1"></i> Copy</button>
    </div>
</div>

<div class="ib-card">
    <div class="ib-card-title"><i class="fas fa-users me-2" style="color:var(--gold);"></i>My Referrals</div>
    @if (isset($referral) && $referral > 0)
        <div class="stat-card" style="background:rgba(255,255,255,0.02);padding:16px;margin-bottom:12px;">
            <div class="d-flex justify-content-between align-items-center">
                <div><span class="fw-bold" style="color:#fff;">Referral Bonus</span></div>
                <span class="badge-green">${{ number_format($referral, 2) }}</span>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-user-plus"></i></div>
            <div style="font-weight:800; color:#fff; margin-bottom:8px;">No referrals yet</div>
            <div style="font-size:0.82rem; color:var(--text-muted);">Share your link above to start earning referral bonuses.</div>
        </div>
    @endif
</div>

<script>
function copyRef() {
    const input = document.getElementById('referralLink');
    input.select();
    document.execCommand('copy');
    alert('Referral link copied!');
}
</script>

@include('user.investment-broker.layout.footer')
