@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-star"></i> My Watchlist</div>
</div>

<div class="ib-card">
    @if (session('status'))
        <div class="alert border-0 rounded-3 mb-3" style="background:rgba(201,162,39,0.08);color:var(--gold);">
            <i class="fas fa-info-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close float-end" onclick="this.parentElement.style.display='none'"></button>
        </div>
    @endif
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-star"></i></div>
        <div style="font-weight:800; color:#fff; margin-bottom:8px;">Your watchlist is empty</div>
        <div style="font-size:0.82rem; color:var(--text-muted);margin-bottom:20px;">Browse markets and tap the star icon to add assets here.</div>
        <a href="{{ route('user.investments.markets') }}" class="btn-gold"><i class="fas fa-globe me-1"></i> Browse Markets</a>
    </div>
</div>

@include('user.investment-broker.layout.footer')
