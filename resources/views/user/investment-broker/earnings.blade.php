@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-coins"></i> My Investment Earnings</div>
</div>

<div class="stat-grid mb-4">
    <div class="stat-card">
        <div class="stat-label">Total Earnings</div>
        <div class="stat-value green">${{ number_format($earnings ?? 0, 2) }}</div>
        <div class="stat-change up"><i class="fas fa-chart-line"></i> All-time</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Referral Bonus</div>
        <div class="stat-value">${{ number_format($referral ?? 0, 2) }}</div>
        <div class="stat-change neutral"><i class="fas fa-users"></i> From referrals</div>
    </div>
</div>

<div class="ib-card">
    <div class="ib-card-title"><i class="fas fa-list me-2" style="color:var(--gold);"></i>Earnings History</div>
    <table class="ib-table">
        <thead><tr><th>ID</th><th>Earnings</th><th>Type</th><th>Date</th></tr></thead>
        <tbody>
            <tr><td colspan="4" class="text-center" style="color:var(--text-muted);padding:30px;">No earnings recorded yet</td></tr>
        </tbody>
    </table>
    <div class="text-center mt-3">
        <a href="{{ route('user.investments.deposit') }}" class="btn-gold"><i class="fas fa-bolt me-1"></i> Start a new Investment plan</a>
    </div>
</div>

@include('user.investment-broker.layout.footer')
