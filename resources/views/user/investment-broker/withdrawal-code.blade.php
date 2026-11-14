@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-shield-alt"></i> Withdrawal Code Verification</div>
</div>

<div class="ib-card" style="max-width:520px;margin:0 auto;">
    <div class="ib-card-title"><i class="fas fa-lock me-2" style="color:var(--gold);"></i>Verify Your Withdrawal</div>
    <p style="color:var(--text-muted);font-size:0.85rem;">
        Enter the withdrawal code provided by support to continue processing this request.
    </p>

    @if(session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif
    @if($errors->has('withdrawal_code'))
        <div class="alert alert-danger">{{ $errors->first('withdrawal_code') }}</div>
    @endif

    <div class="mb-3">
        <div class="small" style="color:var(--text-muted);">Transaction ID</div>
        <div style="font-family:'JetBrains Mono',monospace;color:var(--gold);">{{ $withdrawal->transaction_id }}</div>
    </div>
    <div class="mb-4">
        <div class="small" style="color:var(--text-muted);">Requested amount</div>
        <div class="fw-bold" style="color:#fff;">${{ number_format((float) $withdrawal->amount, 2) }}</div>
    </div>
    <div class="mb-4">
        <div class="small" style="color:var(--text-muted);">Configured withdrawal charge</div>
        <div class="fw-bold" style="color:var(--gold);">${{ number_format((float) (Auth::user()->withdrawal_amount ?? 0), 2) }}</div>
    </div>

    @if(!Auth::user()->withdrawal_code)
        <div class="alert alert-warning">A withdrawal code has not been configured for your account yet. Please contact support.</div>
    @endif

    <form action="{{ route('user.investments.withdrawal-code.verify', $withdrawal->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="withdrawal_code" class="form-label">Withdrawal code</label>
            <input id="withdrawal_code" name="withdrawal_code" type="text" class="form-ib" value="{{ old('withdrawal_code') }}" required autocomplete="one-time-code">
        </div>
        <button type="submit" class="btn-gold w-100" style="padding:12px;">Verify code</button>
    </form>

    <a class="d-inline-block mt-3" style="color:var(--text-muted);" href="{{ route('user.investments.withdrawals') }}">Return to withdrawals</a>
</div>

@include('user.investment-broker.layout.footer')
