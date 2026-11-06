@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-history"></i> Trading History</div>
    <a href="{{ route('user.investments.account-history') }}" class="btn-outline-gold" style="padding:7px 16px;font-size:0.8rem;">
        <i class="fas fa-clock-rotate-left me-1"></i> Full Account History
    </a>
</div>

<div class="ib-card" style="padding:0;overflow:hidden;">
    @if(isset($transactions) && $transactions->count() > 0)
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
                            <td style="font-size:0.78rem;color:var(--text-muted);">
                                {{ Str::limit($tx->transaction_description ?? $tx->transaction ?? '—', 45) }}
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
            <div class="empty-icon"><i class="fas fa-chart-line"></i></div>
            <div style="font-weight:700;color:#fff;margin-bottom:6px;">No trading history yet</div>
            <div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:20px;">
                Your transactions will appear here once you make a deposit or trade.
            </div>
            <a href="{{ route('user.investments.deposit') }}" class="btn-gold" style="padding:10px 24px;">
                <i class="fas fa-bolt me-1"></i> Start Investing
            </a>
        </div>
    @endif
</div>

@include('user.investment-broker.layout.footer')
