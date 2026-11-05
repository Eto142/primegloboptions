@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-cubes"></i> Trading Plans</div>
</div>

<div class="row g-3">
    @php $planData = [
        ['Starter', '$500', '500', 'rgba(59,130,246,0.15)', '#60a5fa', 'Junior Traders Available To Copy'],
        ['Pro', '$3,000', '3000', 'rgba(139,92,246,0.15)', '#a78bfa', 'Pro Traders Available To Copy'],
        ['Master', '$6,000', '6000', 'rgba(245,158,11,0.15)', '#fbbf24', 'Master Traders Available To Copy'],
        ['Premium', '$10,000', '10000', 'rgba(239,68,68,0.15)', '#f97316', 'Expert Traders Available To Copy'],
    ];
    @endphp
    @foreach ($planData as $p)
    <div class="col-12 col-md-6 col-xl-3">
        <div class="ib-card h-100" style="border-top: 3px solid {{ $p[4] }};">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;border-radius:12px;background:{{ $p[3]}};display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:{{ $p[4] }};">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h6 class="fw-bold mb-0" style="color:#fff;">{{ $p[0] }}</h6>
            </div>
            <div class="fs-4 fw-extrabold mb-1" style="color:{{ $p[4] }}; font-family:'JetBrains Mono',monospace;">{{ $p[1] }}</div>
            <div class="small mb-3" style="color:var(--text-muted);">Minimum deposit</div>
            <div class="small mb-4" style="color:var(--text-muted);">{{ $p[5] }}</div>
            <a href="{{ route('user.investments.deposit') }}" class="btn-outline-gold w-100 d-block text-center">
                <i class="fas fa-shopping-cart me-1"></i> Purchase Plan
            </a>
        </div>
    </div>
    @endforeach
</div>

@include('user.investment-broker.layout.footer')
