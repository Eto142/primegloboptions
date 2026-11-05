@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-history"></i> Trading History</div>
</div>

<div class="ib-card">
    <table class="ib-table">
        <thead><tr><th>ID</th><th>Investment Amount</th><th>Transaction ID</th><th>Comment</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            <tr><td colspan="7" class="text-center" style="color:var(--text-muted);padding:30px;">No trading history yet</td></tr>
        </tbody>
    </table>
    <div class="text-center mt-3">
        <a href="{{ route('user.investments.deposit') }}" class="btn-gold"><i class="fas fa-bolt me-1"></i> Start a new Investment plan</a>
    </div>
</div>

@include('user.investment-broker.layout.footer')
