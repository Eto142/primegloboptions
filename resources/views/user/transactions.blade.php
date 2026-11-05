@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-extrabold text-dark mb-1">Transaction History & Statements</h3>
            <p class="text-muted small mb-0">View comprehensive logs of all your account deposits, wire transfers, withdrawals, and debit card activity.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-dark rounded-pill px-3.5 py-2 fw-bold text-muted small" onclick="window.print();">
                <i class="fas fa-print me-1"></i> Print Statement
            </button>
        </div>
    </div>

    <!-- Main Transaction Table Card -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4">
        <!-- Card Header -->
        <div class="card-header border-0 p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #023635 80%, #C9A227 100%);">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 text-white">
                <div>
                    <span class="badge rounded-pill px-3 py-1.5 mb-2 font-monospace" style="background: rgba(201,162,39, 0.2); color: #E8C14A; border: 1px solid rgba(201,162,39, 0.4);">
                        <i class="fas fa-list me-1"></i> Real-time Ledger
                    </span>
                    <h4 class="fw-extrabold mb-0 text-white">All Account Activity</h4>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <input type="text" id="transactionSearchInput" class="form-control form-control-sm bg-white bg-opacity-10 text-white border-white border-opacity-25 rounded-pill px-3 py-2" placeholder="Search reference, amount..." style="min-width: 220px;" />
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="transactionTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small font-monospace">TYPE</th>
                            <th class="py-3 text-muted small font-monospace">REFERENCE</th>
                            <th class="py-3 text-muted small font-monospace">DESCRIPTION / BENEFICIARY</th>
                            <th class="py-3 text-muted small font-monospace">DATE & TIME</th>
                            <th class="py-3 text-muted small font-monospace">AMOUNT</th>
                            <th class="pe-4 py-3 text-end text-muted small font-monospace">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($allTransactions ?? $transaction ?? []) as $details)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: rgba(201,162,39, 0.1); color: #C9A227;">
                                            @if(str_contains(strtolower($details->transaction_type ?? ''), 'deposit'))
                                                <i class="fas fa-arrow-down text-success"></i>
                                            @elseif(str_contains(strtolower($details->transaction_type ?? ''), 'transfer') || str_contains(strtolower($details->transaction_type ?? ''), 'wire'))
                                                <i class="fas fa-paper-plane text-info"></i>
                                            @elseif(str_contains(strtolower($details->transaction_type ?? ''), 'card'))
                                                <i class="fas fa-credit-card text-purple"></i>
                                            @else
                                                <i class="fas fa-exchange-alt text-primary"></i>
                                            @endif
                                        </div>
                                        <span class="fw-bold text-dark text-capitalize small">{{ $details->transaction_type ?? 'Transaction' }}</span>
                                    </div>
                                </td>

                                <td class="font-monospace fw-bold text-dark small">
                                    {{ $details->transaction_ref }}
                                </td>

                                <td class="text-muted small">
                                    {{ $details->description ?? $details->account_name ?? 'Account Transaction' }}
                                </td>

                                <td class="text-muted small">
                                    {{ \Carbon\Carbon::parse($details->transaction_created_at)->format('M d, Y • h:i A') }}
                                </td>

                                <td class="fw-extrabold font-monospace text-dark">
                                    {{ Auth::user()->currency }}{{ number_format($details->transaction_amount, 2) }}
                                </td>

                                <td class="pe-4 text-end">
                                    @if($details->transaction_status == '1' || strtolower($details->transaction_status ?? '') == 'completed')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1.5 fw-bold"><i class="fas fa-check-circle me-1"></i> Completed</span>
                                    @elseif($details->transaction_status == '0' || strtolower($details->transaction_status ?? '') == 'pending')
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1.5 fw-bold"><i class="fas fa-clock me-1"></i> Pending</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1.5 fw-bold"><i class="fas fa-times-circle me-1"></i> Failed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-receipt fs-2 mb-2 text-muted opacity-50 d-block"></i>
                                    No transactions recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('user.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('transactionSearchInput');
        const tableRows = document.querySelectorAll('#transactionTable tbody tr');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });
</script>
