@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-user"></i> My Profile</div>
</div>

<div class="row g-3">
    <div class="col-12 col-md-4">
        <div class="ib-card text-center">
            @if (Auth::user()->display_picture)
                <img src="{{ Storage::url(Auth::user()->display_picture) }}" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid var(--gold);margin-bottom:16px;" alt="Profile">
            @else
                <div style="width:100px;height:100px;border-radius:50%;background:rgba(201,162,39,0.12);display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--gold);margin:0 auto 16px;"><i class="fas fa-user"></i></div>
            @endif
            <h5 class="fw-bold" style="color:#fff;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
            <div class="small" style="color:var(--text-muted);">{{ Auth::user()->email }}</div>
            @php $kyc = Auth::user()->kyc_status; @endphp
            @if ($kyc == '1') <span class="badge-green mt-2 d-inline-block">KYC Verified</span>
            @elseif ($kyc == '2') <span class="badge-red mt-2 d-inline-block">KYC Rejected</span>
            @else <span class="badge-yellow mt-2 d-inline-block">KYC Pending</span> @endif
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div class="ib-card">
            <div class="ib-card-title"><i class="fas fa-info-circle me-2" style="color:var(--gold);"></i>Account Information</div>
            <table class="ib-table">
                <tr><td style="color:var(--text-muted);width:40%;">Full Name</td><td style="color:#fff;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</td></tr>
                <tr><td style="color:var(--text-muted);">Email</td><td style="color:#fff;">{{ Auth::user()->email }}</td></tr>
                <tr><td style="color:var(--text-muted);">Phone</td><td style="color:#fff;">{{ Auth::user()->phone ?? '—' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Country</td><td style="color:#fff;">{{ Auth::user()->country ?? '—' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Account Number</td><td style="color:#fff;font-family:'JetBrains Mono',monospace;">{{ Auth::user()->account_number ?? '—' }}</td></tr>
            </table>
        </div>
        <div class="ib-card">
            <div class="ib-card-title"><i class="fas fa-wallet me-2" style="color:var(--gold);"></i>Financial Summary</div>
            <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
                <div><div class="stat-label">Balance</div><div class="stat-value" style="font-size:1.1rem;">${{ number_format($user_balance ?? 0, 2) }}</div></div>
                <div><div class="stat-label">Profit</div><div class="stat-value green" style="font-size:1.1rem;">${{ number_format($profit ?? 0, 2) }}</div></div>
                <div><div class="stat-label">Deposit</div><div class="stat-value" style="font-size:1.1rem;">${{ number_format($deposit ?? 0, 2) }}</div></div>
            </div>
            <a href="{{ route('user.investments.settings') }}" class="btn-outline-gold d-inline-block"><i class="fas fa-edit me-1"></i> Edit Profile</a>
        </div>
    </div>
</div>

@include('user.investment-broker.layout.footer')
