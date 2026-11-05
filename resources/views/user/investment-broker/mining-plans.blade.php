@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-microchip"></i> Mining Contracts</div>
</div>

<div class="row g-3">
    @php $plans = [
        ['1 Week Contract', '$500', '100 GH/s', 'rgba(59,130,246,0.15)', '#60a5fa'],
        ['2 Weeks Contract', '$1,000 - $2,499', '300 GH/s', 'rgba(139,92,246,0.15)', '#a78bfa'],
        ['5 Weeks Contract', '$2,500 - $5,499', '500 GH/s', 'rgba(245,158,11,0.15)', '#fbbf24'],
        ['4 Weeks Contract', '$5,500', '900 GH/s', 'rgba(239,68,68,0.15)', '#f97316'],
    ];
    @endphp
    @foreach ($plans as $plan)
    <div class="col-12 col-md-6 col-xl-3">
        <div class="ib-card h-100 text-center" style="border-top: 3px solid {{ $plan[4] }};">
            <div style="width:56px;height:56px;border-radius:14px;background:{{ $plan[3] }};display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:{{ $plan[4] }};margin:0 auto 16px;">
                <i class="fas fa-microchip"></i>
            </div>
            <h6 class="fw-bold mb-1" style="color:#fff;">{{ $plan[0] }}</h6>
            <div class="fs-4 fw-extrabold mb-1" style="color:{{ $plan[4] }};font-family:'JetBrains Mono',monospace;">{{ $plan[1] }}</div>
            <div class="small mb-3" style="color:var(--text-muted);">{{ $plan[2] }}</div>
            <a href="{{ route('user.investments.deposit') }}" class="btn-outline-gold w-100 d-block">
                <i class="fas fa-shopping-cart me-1"></i> Purchase Plan
            </a>
        </div>
    </div>
    @endforeach
</div>

@include('user.investment-broker.layout.footer')
