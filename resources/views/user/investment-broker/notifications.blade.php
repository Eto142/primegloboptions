@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-bell"></i> Notifications</div>
    <form action="{{ route('user.investments.mark-all-read') }}" method="POST">
        @csrf
        <button type="submit" class="btn-outline-gold" style="padding:6px 16px;font-size:0.8rem;"><i class="fas fa-check-double me-1"></i> Mark All Read</button>
    </form>
</div>

<div class="ib-card">
    @if (isset($notifications) && $notifications->count() > 0)
        @foreach ($notifications as $n)
        <div class="d-flex align-items-start gap-3 p-3 mb-2" style="background:rgba(255,255,255,0.02);border-radius:12px;@if(!$n->is_read)border-left:3px solid var(--gold);@endif">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,162,39,0.1);display:flex;align-items:center;justify-content:center;color:var(--gold);flex-shrink:0;">
                <i class="fas fa-bell"></i>
            </div>
            <div class="flex-grow-1">
                <div style="color:#fff;font-weight:600;">{{ $n->message }}</div>
                <div class="small" style="color:var(--text-muted);">{{ $n->created_at->diffForHumans() }}</div>
            </div>
            @if (!$n->is_read) <span class="badge-gold">New</span> @endif
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
            <div style="font-weight:800; color:#fff; margin-bottom:8px;">No notifications</div>
            <div style="font-size:0.82rem; color:var(--text-muted);">You're all caught up.</div>
        </div>
    @endif
</div>

@include('user.investment-broker.layout.footer')
