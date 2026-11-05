@include('admin.header')
<div class="main-content p-3 p-md-4" id="mainContent">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-extrabold text-dark mb-1">Transfer History & Wire Logs</h2>
            <p class="text-muted small mb-0">Track interbank wire transfers and outgoing customer payments.</p>
        </div>
    </div>

    <!-- Transactions Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Recent Transfers</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search transfers...">
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
                            <th>Amount</th>
                            <th>Beneficiary</th>
                            <th>Bank Details</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user_transfers as $transfer)
                        <tr>
                            <td>{{ $transfer->transaction_id }}</td>
                            <td>{{ number_format($transfer->amount, 2, '.', ',') }}</td>
                            <td>
                                <strong>{{ $transfer->beneficiary_name }}</strong><br>
                                A/C: {{ $transfer->account_number }}
                            </td>
                            <td>
                                {{ $transfer->bank_name }}<br>
                                @if($transfer->swift_code)
                                    SWIFT: {{ $transfer->swift_code }}
                                @endif
                            </td>
                            <td>{{ $transfer->payment_purpose }}</td>
                            <td>
                                @if ($transfer->status == 1)
                                    <span class="badge bg-success">Completed</span>
                                @elseif($transfer->status == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($transfer->status == 2)
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($transfer->status) }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('D, M j, Y g:i A') }}</td>
                        </tr>
                        @endforeach
                        
                        @if($user_transfers->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-4">No transfers found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <!-- Unified Pagination -->
            @if($user_transfers->hasPages())
            <div class="card-footer">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0 text-muted small">
                        Showing 
                        <span class="fw-semibold">{{ $user_transfers->firstItem() ?? 0 }}</span> 
                        to 
                        <span class="fw-semibold">{{ $user_transfers->lastItem() ?? 0 }}</span> 
                        of 
                        <span class="fw-semibold">{{ $user_transfers->total() }}</span> 
                        entries
                    </div>
                    
                    <div class="pagination-container">
                        {{ $user_transfers->onEachSide(1)->links('pagination::bootstrap-4') }}
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