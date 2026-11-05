@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-cubes"></i> Investment Plans</div>
</div>

<div class="row g-3">
    @php $plans = [
        ['PREMIUM', '8.5%', 'daily / 10 days', '$10,000 - $99,999', 'rgba(201,162,39,0.15)', 'var(--gold)'],
        ['BUSINESS', '4.5%', '30 days', '$20,000', 'rgba(139,92,246,0.15)', '#a78bfa'],
        ['STANDARD', '4.9%', '10 days', '$500 - $4,999', 'rgba(59,130,246,0.15)', '#60a5fa'],
        ['PRO', '7%', '10 days', '$5,000 - $9,999', 'rgba(245,158,11,0.15)', '#fbbf24'],
    ];
    @endphp
    @foreach ($plans as $p)
    <div class="col-12 col-md-6 col-xl-3">
        <div class="ib-card h-100 text-center" style="border-top:3px solid {{ $p[5] }};">
            <h6 class="fw-bold mb-2" style="color:{{ $p[5] }};">{{ $p[0] }}</h6>
            <div class="fs-1 fw-extrabold mb-1" style="color:#fff;font-family:'JetBrains Mono',monospace;">{{ $p[1] }}</div>
            <div class="small mb-2" style="color:var(--text-muted);">{{ $p[2] }}</div>
            <div class="small mb-3" style="color:var(--text-muted);">{{ $p[3] }}</div>
            <a href="{{ route('user.investments.deposit') }}" class="btn-outline-gold w-100 d-block"><i class="fas fa-check me-1"></i> SELECT PLAN</a>
        </div>
    </div>
    @endforeach
</div>

@include('user.investment-broker.layout.footer')
