@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-clock-rotate-left"></i> Account History</div>
    <div style="font-size:0.78rem;color:var(--text-muted);">All your deposits, withdrawals and transactions in one place</div>
</div>

{{-- ── SUMMARY STATS ─────────────────────────────────────────── --}}
<div class="stat-grid" style="margin-bottom:28px;">
    <div class="stat-card">
        <div class="stat-label">Total Deposited</div>
        <div class="stat-value">${{ number_format($deposits->sum('amount'), 2) }}</div>
        <div class="stat-change neutral"><i class="fas fa-arrow-down me-1"></i>{{ $deposits->count() }} deposit(s)</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Withdrawn</div>
        <div class="stat-value" style="color:var(--danger);">${{ number_format($withdrawals->sum('amount'), 2) }}</div>
        <div class="stat-change neutral"><i class="fas fa-arrow-up me-1"></i>{{ $withdrawals->count() }} withdrawal(s)</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending Deposits</div>
        <div class="stat-value">${{ number_format($deposits->where('status', 0)->sum('amount'), 2) }}</div>
        <div class="stat-change neutral"><i class="fas fa-clock me-1"></i>Awaiting approval</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Transactions</div>
        <div class="stat-value">{{ $transactions->count() }}</div>
        <div class="stat-change neutral"><i class="fas fa-list me-1"></i>Total entries</div>
    </div>
</div>

{{-- ── TABS ──────────────────────────────────────────────────── --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    <button class="tab-btn active" onclick="switchTab('deposits', this)">
        <i class="fas fa-arrow-down me-1"></i> Deposits
        <span class="tab-count">{{ $deposits->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchTab('withdrawals', this)">
        <i class="fas fa-arrow-up me-1"></i> Withdrawals
        <span class="tab-count">{{ $withdrawals->count() }}</span>
    </button>
    <button class="tab-btn" onclick="switchTab('transactions', this)">
        <i class="fas fa-list me-1"></i> All Transactions
        <span class="tab-count">{{ $transactions->count() }}</span>
    </button>
</div>

<style>
.tab-btn {
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border);
    color: var(--text-muted);
    border-radius: 10px;
    padding: 9px 18px;
    font-size: 0.83rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.tab-btn:hover { color: var(--gold); border-color: rgba(201,162,39,0.3); }
.tab-btn.active {
    background: linear-gradient(135deg, rgba(201,162,39,0.15), rgba(158,124,20,0.08));
    border-color: rgba(201,162,39,0.4);
    color: var(--gold);
}
.tab-count {
    background: rgba(201,162,39,0.15);
    color: var(--gold);
    border-radius: 20px;
    padding: 1px 8px;
    font-size: 0.72rem;
}
.tab-panel { display: none; }
.tab-panel.active { display: block; }
</style>

{{-- ── DEPOSITS TAB ──────────────────────────────────────────── --}}
<div id="tab-deposits" class="tab-panel active">
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
                                <td><span class="badge-gold">{{ ucfirst($dep->deposit_type ?: 'Crypto') }}</span></td>
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
                <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:20px;">Fund your account to get started.</div>
                <a href="{{ route('user.investments.deposit') }}" class="btn-gold" style="padding:10px 24px;">
                    <i class="fas fa-plus me-1"></i> Make a Deposit
                </a>
            </div>
        @endif
    </div>
</div>

{{-- ── WITHDRAWALS TAB ───────────────────────────────────────── --}}
<div id="tab-withdrawals" class="tab-panel">
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
                                <td><span class="badge-gold">{{ $w->mode ?? '—' }}</span></td>
                                <td style="font-size:0.78rem;color:var(--text-muted);">
                                    @if($w->mode === 'Crypto Currency')
                                        {{ $w->crypto_type }} — {{ Str::limit($w->wallet_address ?? '', 22) }}
                                    @else
                                        {{ $w->bank_name ?? '—' }} {{ $w->account_number ? '(' . $w->account_number . ')' : '' }}
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                <div style="font-weight:700;color:#fff;margin-bottom:6px;">No withdrawals yet</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">Your withdrawal requests will appear here.</div>
            </div>
        @endif
    </div>
</div>

{{-- ── ALL TRANSACTIONS TAB ──────────────────────────────────── --}}
<div id="tab-transactions" class="tab-panel">
    <div class="ib-card" style="padding:0;overflow:hidden;">
        @if($transactions->count() > 0)
            <div style="overflow-x:auto;">
                <table class="ib-table">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Wallet</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $tx)
                            <tr>
                                <td>
                                    <span style="font-family:'JetBrains Mono',monospace;font-size:0.8rem;color:var(--gold);">
                                        #{{ $tx->transaction_id }}
                                    </span>
                                </td>
                                <td>
                                    @if(strtolower($tx->transaction_type) === 'credit')
                                        <span class="badge-green"><i class="fas fa-arrow-down me-1"></i>Credit</span>
                                    @else
                                        <span class="badge-red"><i class="fas fa-arrow-up me-1"></i>Debit</span>
                                    @endif
                                </td>
                                <td style="font-family:'JetBrains Mono',monospace;font-weight:700;
                                    color:{{ strtolower($tx->transaction_type) === 'credit' ? 'var(--success)' : 'var(--danger)' }};">
                                    {{ strtolower($tx->transaction_type) === 'credit' ? '+' : '-' }}${{ number_format($tx->transaction_amount ?? 0, 2) }}
                                </td>
                                <td style="font-size:0.78rem;color:var(--text-muted);max-width:200px;">
                                    {{ Str::limit($tx->transaction_description ?? $tx->transaction ?? '—', 40) }}
                                </td>
                                <td style="font-size:0.78rem;color:var(--text-muted);">
                                    {{ $tx->wallet_type ?? '—' }}
                                </td>
                                <td>
                                    @if($tx->transaction_status === 'approved' || $tx->transaction_status == 1)
                                        <span class="badge-green">Approved</span>
                                    @elseif($tx->transaction_status === 'declined' || $tx->transaction_status == 2)
                                        <span class="badge-red">Declined</span>
                                    @else
                                        <span class="badge-yellow">Pending</span>
                                    @endif
                                </td>
                                <td style="font-size:0.78rem;color:var(--text-muted);">
                                    {{ $tx->created_at->format('M j, Y g:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-list"></i></div>
                <div style="font-weight:700;color:#fff;margin-bottom:6px;">No transactions yet</div>
                <div style="font-size:0.82rem;color:var(--text-muted);">Transactions will appear here as you deposit and withdraw.</div>
            </div>
        @endif
    </div>
</div>

<script>
function switchTab(name, btn) {
    // hide all panels
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    // deactivate all buttons
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    // show selected
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

@include('user.investment-broker.layout.footer')
