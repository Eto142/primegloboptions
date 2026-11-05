@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-bell"></i> All Notifications</div>
    <form action="{{ route('user.investments.mark-all-read') }}" method="POST">
        @csrf
        <button type="submit" class="btn-outline-gold" style="padding:6px 16px;font-size:0.8rem;"><i class="fas fa-check-double me-1"></i> Mark All Read</button>
    </form>
</div>

<div class="ib-card">
    @if (isset($notifications) && $notifications->count() > 0)
        <table class="ib-table">
            <thead><tr><th>Date</th><th>Message</th><th>Status</th></tr></thead>
            <tbody>
                @foreach ($notifications as $n)
                <tr>
                    <td style="color:var(--text-muted);white-space:nowrap;">{{ $n->created_at->format('M j, Y g:i A') }}</td>
                    <td style="color:#fff;">{{ $n->message }}</td>
                    <td>@if($n->is_read) <span class="badge-green">Read</span> @else <span class="badge-gold">Unread</span> @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
            <div style="font-weight:800; color:#fff; margin-bottom:8px;">No notifications</div>
            <div style="font-size:0.82rem; color:var(--text-muted);">You're all caught up.</div>
        </div>
    @endif
</div>

@include('user.investment-broker.layout.footer')
