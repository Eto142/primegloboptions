@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-gift"></i> Bonus Package</div>
</div>

<div class="ib-card text-center mb-4" style="background:linear-gradient(135deg, rgba(201,162,39,0.08), rgba(201,162,39,0.02));">
    <p style="color:var(--text-muted);font-size:0.85rem;max-width:600px;margin:0 auto;">Our bonus package rewards loyal investors with additional funds based on their deposit tier. Select a plan to get started.</p>
</div>

<div class="row g-3">
    @php $bonuses = [
        ['Basic', '$5,000', '$3,000', '30%', 'rgba(59,130,246,0.15)', '#60a5fa', false],
        ['Silver', '$20,000', '$7,000', '45%', 'rgba(139,92,246,0.15)', '#a78bfa', false],
        ['Premium', '$30,000', '$15,000', '50%', 'rgba(201,162,39,0.15)', 'var(--gold)', true],
        ['VIP', '$40,000', '$20,000', '65%', 'rgba(239,68,68,0.15)', '#f97316', false],
    ];
    @endphp
    @foreach ($bonuses as $b)
    <div class="col-12 col-md-6 col-xl-3">
        <div class="ib-card h-100 text-center {{ $b[6] ? '' : '' }}" style="@if($b[6])border-color:var(--gold);box-shadow:0 0 20px rgba(201,162,39,0.15);@endif border-top:3px solid {{ $b[5] }};">
            @if ($b[6]) <div class="badge-gold mb-2">Featured</div> @endif
            <div style="width:56px;height:56px;border-radius:14px;background:{{ $b[4] }};display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:{{ $b[5] }};margin:0 auto 16px;">
                <i class="fas fa-gift"></i>
            </div>
            <h6 class="fw-bold mb-1" style="color:#fff;">{{ $b[0] }}</h6>
            <div class="fs-4 fw-extrabold mb-1" style="color:{{ $b[5] }};font-family:'JetBrains Mono',monospace;">{{ $b[1] }}</div>
            <div class="small mb-2" style="color:var(--text-muted);">Min deposit: {{ $b[2] }}</div>
            <div class="fs-5 fw-bold mb-3" style="color:var(--success);">{{ $b[3] }} Bonus</div>
            <a href="{{ route('user.investments.deposit') }}" class="btn-outline-gold w-100 d-block"><i class="fas fa-check me-1"></i> Select Plan</a>
        </div>
    </div>
    @endforeach
</div>

@include('user.investment-broker.layout.footer')
