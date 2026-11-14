@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-arrow-up"></i> Request Withdrawal</div>
</div>

{{-- ── WITHDRAWAL FORM ──────────────────────────────────────── --}}
<div class="ib-card" style="max-width:580px;margin:0 auto 32px;">
    <div class="ib-card-title"><i class="fas fa-paper-plane me-2" style="color:var(--gold);"></i>Withdrawal Request</div>
    <p style="color:var(--text-muted);font-size:0.83rem;margin-bottom:24px;">
        Submit a withdrawal request. Admin will review and process it within 24–48 hours.
    </p>

    @if(session('success'))
        <div class="alert border-0 rounded-3 mb-3" style="background:rgba(0,211,149,0.1);border:1px solid rgba(0,211,149,0.2) !important;color:#00d395;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('status'))
        <div class="alert border-0 rounded-3 mb-3" style="background:rgba(59,130,246,0.1);color:#60a5fa;">
            {{ session('status') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('user.investments.withdrawals.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Amount (USD)</label>
            <input type="number" name="amount" class="form-ib" placeholder="0.00" min="1" step="0.01" max="{{ max(0, $balance) }}" required value="{{ old('amount') }}">
            @error('amount') <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small" style="color:var(--text-muted);">Payment Mode</label>
            <select name="mode" id="modeSelect" class="form-ib" onchange="toggleMode()" required>
                <option value="Bank Transfer" {{ old('mode', $selectedMode) == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="Crypto Currency" {{ old('mode', $selectedMode) == 'Crypto Currency' ? 'selected' : '' }}>Crypto Currency</option>
                <option value="PayPal" {{ old('mode', $selectedMode) == 'PayPal' ? 'selected' : '' }}>PayPal</option>
            </select>
            @error('mode') <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div> @enderror
        </div>

        {{-- Bank fields --}}
        <div id="bankBlock">
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Account Number</label>
                <input type="text" name="account_number" class="form-ib" value="{{ old('account_number') }}">
            </div>
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Account Name</label>
                <input type="text" name="account_name" class="form-ib" value="{{ old('account_name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Bank Name</label>
                <input type="text" name="bank_name" class="form-ib" value="{{ old('bank_name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">SWIFT / BIC</label>
                <input type="text" name="swift" class="form-ib" value="{{ old('swift') }}">
            </div>
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Routing Number</label>
                <input type="text" name="bank_routing_number" class="form-ib" value="{{ old('bank_routing_number') }}">
            </div>
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Country</label>
                <input type="text" name="bank_country" class="form-ib" value="{{ old('bank_country') }}">
            </div>
        </div>

        {{-- Crypto fields --}}
        <div id="cryptoBlock" style="display:none;">
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Crypto Type</label>
                <select name="crypto_type" class="form-ib">
                    <option value="BTC" {{ old('crypto_type') == 'BTC' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                    <option value="ETH" {{ old('crypto_type') == 'ETH' ? 'selected' : '' }}>Ethereum (ETH)</option>
                    <option value="USDT" {{ old('crypto_type') == 'USDT' ? 'selected' : '' }}>Tether (USDT)</option>
                    <option value="LTC" {{ old('crypto_type') == 'LTC' ? 'selected' : '' }}>Litecoin (LTC)</option>
                </select>
                @error('crypto_type') <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">Wallet Address</label>
                <input type="text" name="wallet_address" class="form-ib" value="{{ old('wallet_address') }}">
                @error('wallet_address') <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div> @enderror
            </div>
        </div>

        <div id="paypalBlock" style="display:none;">
            <div class="mb-3">
                <label class="form-label small" style="color:var(--text-muted);">PayPal Email</label>
                <input type="email" name="email" class="form-ib" value="{{ old('email') }}">
                @error('email') <div class="small mt-1" style="color:var(--danger);">{{ $message }}</div> @enderror
            </div>
        </div>

        <button type="submit" class="btn-gold w-100" style="padding:13px;">
            <i class="fas fa-paper-plane me-1"></i> Submit Withdrawal Request
        </button>
    </form>
</div>

{{-- ── WITHDRAWAL HISTORY ───────────────────────────────────── --}}
<div class="section-head">
    <div class="section-title"><i class="fas fa-history"></i> Withdrawal History</div>
</div>

<div class="ib-card" style="padding:0;overflow:hidden;">
    @if($withdrawals->count() > 0)
        <div style="overflow-x:auto;">
            <table class="ib-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $w)
                        <tr>
                            <td>
                                <span style="font-family:'JetBrains Mono',monospace;font-size:0.8rem;color:var(--gold);">
                                    #{{ $w->transaction_id }}
                                </span>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace;font-weight:700;color:#fff;">
                                ${{ number_format($w->amount, 2) }}
                            </td>
                            <td>
                                <span class="badge-gold">{{ $w->mode ?? '—' }}</span>
                            </td>
                            <td style="font-size:0.78rem;color:var(--text-muted);">
                                @if($w->mode === 'Crypto Currency')
                                    {{ $w->crypto_type }} — {{ Str::limit($w->wallet_address, 20) }}
                                @elseif($w->mode === 'PayPal')
                                    {{ $w->email }}
                                @else
                                    {{ $w->bank_name }} — {{ $w->account_number }}
                                @endif
                            </td>
                            <td>
                                @if($w->status == 1)
                                    <span class="badge-green">Approved</span>
                                @elseif($w->status == 2)
                                    <span class="badge-red">Declined</span>
                                @else
                                    <span class="badge-yellow">Pending</span>
                                @endif
                            </td>
                            <td style="font-size:0.78rem;color:var(--text-muted);">
                                {{ $w->created_at->format('M j, Y g:i A') }}
                            </td>
                            <td>
                                @if((int) $w->status === 0)
                                    <a class="btn-outline-gold" style="padding:6px 10px;font-size:0.75rem;" href="{{ route('user.investments.withdrawal-code', $w->id) }}">Continue verification</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
            <div style="font-weight:700;color:#fff;margin-bottom:6px;">No withdrawals yet</div>
            <div style="font-size:0.82rem;color:var(--text-muted);">
                Your withdrawal history will appear here once you submit a request.
            </div>
        </div>
    @endif
</div>

<script>
function toggleMode() {
    const mode = document.getElementById('modeSelect').value;
    document.getElementById('bankBlock').style.display   = mode === 'Bank Transfer'   ? 'block' : 'none';
    document.getElementById('cryptoBlock').style.display = mode === 'Crypto Currency' ? 'block' : 'none';
    document.getElementById('paypalBlock').style.display = mode === 'PayPal' ? 'block' : 'none';
}
// Apply on page load in case of old() repopulation
toggleMode();
</script>

@include('user.investment-broker.layout.footer')
