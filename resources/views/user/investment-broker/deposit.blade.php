@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-wallet"></i> Fund Account</div>
</div>

{{-- ── DEPOSIT FORM ─────────────────────────────────────────── --}}
<div class="ib-card" style="max-width:520px;margin:0 auto 32px;">
    <div class="ib-card-title"><i class="fas fa-arrow-down me-2" style="color:var(--gold);"></i>Deposit Funds</div>
    <p style="color:var(--text-muted);font-size:0.83rem;margin-bottom:24px;">
        Enter an amount and choose a destination, then proceed to select your preferred payment method.
    </p>

    @if (session('status'))
        <div class="alert border-0 rounded-3 mb-3" style="background:rgba(0,211,149,0.1);border:1px solid rgba(0,211,149,0.2) !important;color:#00d395;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('user.investments.deposit.get') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Amount (USD)</label>
            <input type="number" name="amount" class="form-ib" placeholder="0.00" min="10" step="0.01" required
                   value="{{ old('amount') }}">
            @error('amount')
                <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Destination</label>
            <select name="trading_name" class="form-ib" required>
                <option value="Trading"             {{ old('trading_name') == 'Trading'             ? 'selected' : '' }}>Trading</option>
                <option value="Bitcoin Mining"      {{ old('trading_name') == 'Bitcoin Mining'      ? 'selected' : '' }}>Bitcoin Mining</option>
                <option value="Ethereum Mining"     {{ old('trading_name') == 'Ethereum Mining'     ? 'selected' : '' }}>Ethereum Mining</option>
                <option value="Dogecoin Mining"     {{ old('trading_name') == 'Dogecoin Mining'     ? 'selected' : '' }}>Dogecoin Mining</option>
                <option value="Binance Coin Mining" {{ old('trading_name') == 'Binance Coin Mining' ? 'selected' : '' }}>Binance Coin Mining</option>
            </select>
            @error('trading_name')
                <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-gold w-100 mt-2" style="padding:13px;">
            <i class="fas fa-arrow-right me-2"></i>Proceed
        </button>
    </form>
</div>

{{-- ── DEPOSIT HISTORY ──────────────────────────────────────── --}}
<div class="section-head">
    <div class="section-title"><i class="fas fa-history"></i> Deposit History</div>
</div>

<div class="ib-card" style="padding:0;overflow:hidden;">
    @if($deposits->count() > 0)
        <div style="overflow-x:auto;">
            <table class="ib-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deposits as $dep)
                        <tr>
                            <td>
                                <span style="font-family:'JetBrains Mono',monospace;font-size:0.8rem;color:var(--gold);">
                                    #{{ $dep->transaction_id ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-gold">
                                    {{ ucfirst($dep->deposit_type ?? 'Crypto') }}
                                </span>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:700;color:#fff;">
                                ${{ number_format($dep->amount, 2) }}
                            </td>
                            <td>
                                @if($dep->status == 1)
                                    <span class="badge-green">Approved</span>
                                @elseif($dep->status == 2)
                                    <span class="badge-red">Declined</span>
                                @else
                                    <span class="badge-yellow">Pending</span>
                                @endif
                            </td>
                            <td style="font-size:0.78rem;color:var(--text-muted);">
                                {{ $dep->created_at->format('M j, Y g:i A') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
            <div style="font-weight:700;color:#fff;margin-bottom:6px;">No deposits yet</div>
            <div style="font-size:0.82rem;color:var(--text-muted);">
                Your deposit history will appear here once you make your first deposit.
            </div>
        </div>
    @endif
</div>

@include('user.investment-broker.layout.footer')
