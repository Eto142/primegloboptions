@include('admin.header')
<div class="main-content p-3 p-md-4" id="mainContent">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="h3 mb-0">Transaction History</h1>
        <div>
            <button class="btn btn-primary btn-sm">
                <i class="fas fa-download me-2"></i>Export Transactions
            </button>
        </div>
    </div>

    <!-- Transactions Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Recent Transactions</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search transactions...">
                <button class="btn btn-sm btn-outline-secondary text-nowrap">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table custom-table table-hover align-middle mb-0 text-nowrap" id="highlightRowColumn">
                    <thead class="table-light">
                        <tr>
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Transaction Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user_transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_ref }}</td>
                            <td>{{ $transaction->user?->first_name }} {{ $transaction->user?->last_name }} <small class="text-muted">({{ $transaction->user?->email ?? 'User unavailable' }})</small></td>
                            <td>{{ $transaction->transaction_type }}</td>
                            <td>{{ $transaction->transaction_description }}</td>
                            <td>{{ number_format($transaction->transaction_amount, 2, '.', ',') }}</td>
                            <td>
                                @if ($transaction->transaction_status == '1')
                                <span class="badge bg-success">Completed</span>
                                @elseif($transaction->transaction_status == '0')
                                <span class="badge bg-warning">Pending</span>
                                @elseif($transaction->transaction_status == '2')
                                <span class="badge bg-danger">Declined</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('D, M j, Y g:i A') }}</td>
                        </tr>
                        @endforeach
                        
                        @if($user_transactions->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-4">No transactions found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <!-- Unified Pagination -->
            @if($user_transactions->hasPages())
            <div class="card-footer">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0 text-muted small">
                        Showing 
                        <span class="fw-semibold">{{ $user_transactions->firstItem() ?? 0 }}</span> 
                        to 
                        <span class="fw-semibold">{{ $user_transactions->lastItem() ?? 0 }}</span> 
                        of 
                        <span class="fw-semibold">{{ $user_transactions->total() }}</span> 
                        entries
                    </div>
                    
                    <div class="pagination-container">
                        {{ $user_transactions->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom pagination styles to match your design */
    .pagination-container .pagination {
        margin-bottom: 0;
    }
    
    .pagination-container .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .pagination-container .page-link {
        color: #0d6efd;
        padding: 0.375rem 0.75rem;
    }
    
    .pagination-container .page-item:first-child .page-link,
    .pagination-container .page-item:last-child .page-link {
        border-radius: 0.25rem;
    }
</style>

@include('admin.footer')