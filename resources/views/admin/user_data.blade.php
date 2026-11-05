@include('admin.header')

<!-- Main Content -->
<div class="main-content p-3 p-md-4" id="mainContent">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 mb-1">User Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $userProfile->first_name }}</li>
                </ol>
            </nav>

            
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                <i class="fas fa-plus-circle me-1"></i> Credit User
            </button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#debitTransactionModal">
                <i class="fas fa-plus-circle me-1"></i>Debit User
            </button>

             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateLoanModal">
                <i class="fas fa-plus-circle me-1"></i>Update Loan Eligibilty
            </button>

             <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updateForeignModal">
                <i class="fas fa-plus-circle me-1"></i>Generate Foreign Code
            </button>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updatePaymentModal">
                <i class="fas fa-money-bill-wave me-1"></i> Update Payment Status
            </button>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDepositModal">
                <i class="fas fa-money-bill-wave me-1"></i> Add Deposit
            </button>
            {{-- <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addLoanModal">
                <i class="fas fa-hand-holding-usd me-1"></i> Add Loan
            </button> --}}
            <form action="{{ route('admin.clear.account', $userProfile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to clear this account?');" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-info">
        <i class="fas fa-broom me-1"></i> Clear Account
    </button>
</form>


        </div>
    </div>
    @if(session('status') || session('message'))
    <div class="alert-container">
        <div class="alert alert-{{ session('status') ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
            <div class="alert-content">
                <div class="alert-icon">
                    @if(session('status'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    @endif
                </div>
                <div class="alert-text">
                    {{ session('status') ?? session('message') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="alert-progress"></div>
        </div>
    </div>
@endif


    <div class="row">
        <!-- Left Column - Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="position-relative mb-3 mx-auto" style="width: 150px; height: 150px;">
                        <img src="{{ $userProfile->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($userProfile->first_name).'&background=random' }}" 
                             class="rounded-circle shadow w-100 h-100 object-cover" alt="Profile Photo">
                        <span class="position-absolute bottom-0 end-0 bg-{{ $userProfile->email_verified_at ? 'success' : 'warning' }} rounded-circle p-2 border border-3 border-white">
                            <i class="fas fa-{{ $userProfile->email_verified_at ? 'check' : 'clock' }} text-white"></i>
                        </span>
                    </div>

                      <div class="mb-4">
    <h5 class="text-muted">Payment Status</h5>
    <h3 class="mb-1" 
        style="font-size: 2rem; font-weight: 600; color: {{ $userProfile->payment_status == 1 ? 'green' : 'red' }};">
        {{ $userProfile->payment_status == 1 ? 'Activated' : 'Deactivated' }}
    </h3>
</div>

                    <h3 class="mb-1">{{ $userProfile->first_name }}</h3>
                    <p class="text-muted mb-3">{{ $userProfile->email }}</p>
                      <p class="text-muted mb-3">Account Number:{{ $userProfile->account_number }}</p>
                        <p class="text-muted mb-3">Account Type:{{ $userProfile->account_type }}</p>
                          <p class="text-muted mb-3">Transaction Pin:{{ $userProfile->transaction_pin }}</p>
                    
                    <div class="d-flex justify-content-center flex-wrap gap-2 mb-3">
                        <a href="mailto:{{ $userProfile->email }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-envelope me-1"></i> Email
                        </a>
                        @if($userProfile->phone)
                        <a href="tel:{{ $userProfile->phone }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-phone me-1"></i> Call
                        </a>
                        @endif
                        <a href="#" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit me-1"></i> Edit
                        </a>
                        
                        
                        
                         <form action="{{route('admin.delete', $userProfile->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $userProfile->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                    </div>
                    
                    <hr>
                    
                    <!-- Financial Summary Cards -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title text-success mb-1">Total Credits</h6>
                                    <p class="card-text fw-bold fs-5 mb-0">{{ $userProfile->currency }}{{ $credit_transfers }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-danger bg-opacity-10 border-danger">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title text-danger mb-1">Total Debits</h6>
                                    <p class="card-text fw-bold fs-5 mb-0">{{ $userProfile->currency }}{{ $debit_transfers }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title text-primary mb-1">Total Deposits</h6>
                                    <p class="card-text fw-bold fs-5 mb-0">{{ $userProfile->currency }}{{ $user_deposits }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-warning bg-opacity-10 border-warning">
                                <div class="card-body p-2 text-center">
                                    <h6 class="card-title text-warning mb-1">Total Loans</h6>
                                    <p class="card-text fw-bold fs-5 mb-0">{{ $userProfile->currency }}{{ $user_loans }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                 

                    
                    <!-- Net Balance -->
                   <div class="bg-light p-2 rounded mb-0">
    <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bold">Net Balance:</span>
        <span class="fw-bold fs-5">
            {{ $userProfile->currency }}{{ number_format(($credit_transfers) - ($debit_transfers), 2) }}
        </span>
    </div>
</div>

 <!-- Net Balance -->
                   <div class="bg-light p-2 rounded mb-0">
    <div class="d-flex justify-content-between align-items-center">
        <span class="fw-bold">Foreign Code:</span>
        <span class="fw-bold fs-5">
            {{ $userProfile->withdrawal_code ?? 'Not updated yet' }}
        </span>
    </div>
</div>
                </div>
            </div>
        </div>
        
<div class="col-lg-8">
    <!-- Combined Information Card -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">User Information</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <!-- Personal Information -->
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Personal Information</h6>
                    <div class="mb-2">
                        <small class="text-muted">Full Name</small>
                        <div class="fw-semibold">{{ $userProfile->first_name }} {{ $userProfile->last_name }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Email Address</small>
                        <div class="fw-semibold d-flex align-items-center">
                            {{ $userProfile->email }}
                            <span class="badge bg-{{ $userProfile->email_verified_at ? 'success' : 'warning' }} ms-2">
                                {{ $userProfile->email_verified_at ? 'Verified' : 'Unverified' }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Gender</small>
                        <div class="fw-semibold">{{ $userProfile->gender ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Phone Number</small>
                        <div class="fw-semibold">{{ $userProfile->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Country</small>
                        <div class="fw-semibold">{{ $userProfile->country ?? 'Not provided' }}</div>
                    </div>
                </div>

                <!-- Card Delivery Information -->
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted">Card Delivery Information</h6>
                    <div class="mb-2">
                        <small class="text-muted">Full Name</small>
                        <div class="fw-semibold">{{ $userProfile->fname ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Delivery Address</small>
                        <div class="fw-semibold">{{ $userProfile->delivery_address ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Phone Number</small>
                        <div class="fw-semibold">{{ $userProfile->delivery_phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">Email Address</small>
                        <div class="fw-semibold">{{ $userProfile->emailAddress ?? 'Not provided' }}</div>
                    </div>
                </div>

            </div>
        </div>
 

<!-- Account Activity Section -->
<div class="card">
    <div class="card-header bg-white p-0">
        <ul class="nav nav-tabs card-header-tabs flex-nowrap overflow-auto" id="activityTabs" role="tablist" style="border-bottom: none;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-4 py-3 fw-bold text-primary border-primary" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button" role="tab" style="border-bottom: 3px solid !important;">
                    <i class="fas fa-exchange-alt me-2"></i> Transactions
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-bold text-success hover-border-success" id="transfers-tab" data-bs-toggle="tab" data-bs-target="#transfers" type="button" role="tab">
                    <i class="fas fa-money-bill-wave me-2"></i> Transfers
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-bold text-info hover-border-info" id="cards-tab" data-bs-toggle="tab" data-bs-target="#cards" type="button" role="tab">
                    <i class="fas fa-credit-card me-2"></i> Cards
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-bold text-success hover-border-success" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits" type="button" role="tab">
                    <i class="fas fa-money-bill-wave me-2"></i> Deposits
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-bold text-warning hover-border-warning" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab">
                    <i class="fas fa-hand-holding-usd me-2"></i> Loans
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-bold text-primary" id="savings-goals-tab" data-bs-toggle="tab" data-bs-target="#savings-goals" type="button" role="tab">
                    <i class="fas fa-bullseye me-2"></i> Savings Goals
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-3 fw-bold text-info" id="investment-orders-tab" data-bs-toggle="tab" data-bs-target="#investment-orders" type="button" role="tab">
                    <i class="fas fa-chart-line me-2"></i> Investment Orders
                </button>
            </li>
        </ul>
    </div>

    <style>
        .hover-border-success:hover {
            color: #198754 !important;
            border-bottom: 3px solid #198754 !important;
        }
        .hover-border-warning:hover {
            color: #ffc107 !important;
            border-bottom: 3px solid #ffc107 !important;
        }
        .hover-border-info:hover {
            color: #0dcaf0 !important;
            border-bottom: 3px solid #0dcaf0 !important;
        }
    </style>
                
    <div class="card-body p-0">
        <div class="tab-content p-3" id="activityTabsContent">
            <!-- Transactions Tab -->
            <div class="tab-pane fade show active" id="transactions" role="tabpanel">
                @if(count($user_transactions) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Update Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_transactions as $transaction)
                                <tr>
                                    <!-- Date -->
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}</td>

                                    <!-- Transaction Type -->
                                    <td>
                                        <span class="badge bg-{{ $transaction->transaction_type == 'Credit' ? 'success' : 'danger' }}">
                                            {{ $transaction->transaction_type }}
                                        </span>
                                    </td>

                                    <!-- Amount -->
                                    <td class="fw-bold">{{ $transaction->transaction_amount }}</td>

                                    <!-- Description -->
                                    <td>{{ $transaction->description ?? 'N/A' }}</td>

                                    <!-- Status -->
                                    <td>
                                        <span class="badge bg-{{ $transaction->transaction_status == '1' ? 'success' : 'warning' }}">
                                            {{ $transaction->transaction_status == '1' ? 'Completed' : 'Pending' }}
                                        </span>
                                    </td>

                                    <!-- Update Date -->
                                    <td>
                                        <form action="{{ route('admin.transaction.updateDate', $transaction->id) }}" method="POST">
                                            @csrf
                                            <input type="datetime-local" name="new_date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d\TH:i') }}">
                                            <button type="submit" class="btn btn-primary btn-sm mt-1 mt-sm-0">Update Date</button>
                                        </form>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <!-- Approve Button -->
                                            <form action="{{ route('admin.transaction.approve', $transaction->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-1">
                                                    <i class="bi bi-check"></i> Approve
                                                </button>
                                            </form>

                                            <!-- Decline Button -->
                                            <form action="{{ route('admin.transaction.decline', $transaction->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                    <i class="bi bi-x"></i> Decline
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Transaction pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No transactions found for this user.
                    </div>
                @endif
            </div>
            
            <!-- Transfers Tab -->
            <div class="tab-pane fade" id="transfers" role="tabpanel">
                @if(count($user_transfers_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Beneficiary</th>
                                    <th>Bank</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_transfers_list as $transfer)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transfer->created_at)->format('M d, Y h:i A') }}</td>
                                    <td class="fw-bold">${{ number_format($transfer->amount, 2) }}</td>
                                    <td>{{ $transfer->beneficiary_name }}</td>
                                    <td>{{ $transfer->bank_name }}</td>
                                    <td><code>{{ $transfer->transaction_id ?? 'N/A' }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $transfer->status == '1' ? 'success' : ($transfer->status == '2' ? 'danger' : 'warning') }}">
                                            @if($transfer->status == '1') Approved
                                            @elseif($transfer->status == '2') Declined
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.approve-transfer', $transfer->id) }}" method="POST" class="me-2 d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                            <input type="hidden" name="email" value="{{ $userProfile->email }}">
                                            <input type="hidden" name="amount" value="{{ $transfer->amount }}">
                                            <button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Decline Button -->
                                        <form action="{{ route('admin.decline-transfer', $transfer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{ $userProfile->id }}">
                                            <input type="hidden" name="email" value="{{ $userProfile->email }}">
                                            <input type="hidden" name="amount" value="{{ $transfer->amount }}">
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Decline">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Transfers pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No transfers found for this user.
                    </div>
                @endif
            </div>

            <!-- Cards Tab -->
            <div class="tab-pane fade" id="cards" role="tabpanel">
                @if(count($user_cards_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Card Number</th>
                                    <th>Expiry Date</th>
                                    <th>CVC</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_cards_list as $card)
                                <tr>
                                    <td>
                                        <code>**** **** **** {{ substr($card->card_number, -4) }}</code>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($card->card_expiry)->format('M Y') }}</td>
                                    <td>***</td>
                                    <td>
                                        <span class="badge bg-{{ $card->status == '1' ? 'success' : 'danger' }}">
                                            {{ $card->status == '1' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($card->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($card->status == '1')
                                                <form action="{{ route('admin.card.decline', $card->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                                                        <i class="fas fa-ban"></i> Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.card.approve', $card->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-1">
                                                        <i class="fas fa-check"></i> Activate
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.card.delete', $card->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Cards pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No cards found for this user.
                    </div>
                @endif
            </div>
            
            <!-- Deposits Tab -->
            <div class="tab-pane fade" id="deposits" role="tabpanel">
                @if(count($user_deposits_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_deposits_list as $deposit)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y h:i A') }}</td>
                                    <td class="fw-bold">{{ $deposit->amount }}</td>
                                    <td>{{ $deposit->method ?? 'N/A' }}</td>
                                    <td><code>{{ $deposit->reference ?? 'N/A' }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $deposit->status == '1' ? 'success' : ($deposit->status == '2' ? 'danger' : 'warning') }}">
                                            @if($deposit->status == '1') Approved
                                            @elseif($deposit->status == '2') Declined
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.approve-deposit', $deposit->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$deposit->amount}}">
                                            <input type="hidden" name="deposit_type" value="{{$deposit->deposit_type}}">
                                            <button class="btn btn-sm btn-success me-1" data-bs-toggle="tooltip" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.decline-deposit', $deposit->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="status" value="2">
                                            <input type="hidden" name="user_id" value="{{$userProfile->id}}">
                                            <input type="hidden" name="email" value="{{$userProfile->email}}">
                                            <input type="hidden" name="amount" value="{{$deposit->amount}}">
                                            <input type="hidden" name="deposit_type" value="{{$deposit->deposit_type}}">
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Decline">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Deposit pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No deposits found for this user.
                    </div>
                @endif
            </div>
                        
            <!-- Loans Tab -->
            <div class="tab-pane fade" id="loans" role="tabpanel">
                @if(count($user_loans_list) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Interest</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_loans_list as $loan)
                                <tr class="{{ \Carbon\Carbon::parse($loan->due_date)->isPast() && $loan->status == '1' ? 'table-danger' : '' }}">
                                    <td>{{ \Carbon\Carbon::parse($loan->created_at)->format('M d, Y h:i A') }}</td>
                                    <td class="fw-bold">{{ $loan->amount }}</td>
                                    <td>{{ $loan->interest_rate }}%</td>
                                    <td>
                                        @if($loan->due_date)
                                            {{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}
                                            @if(\Carbon\Carbon::parse($loan->due_date)->isPast() && $loan->status == '1')
                                                <span class="badge bg-danger ms-1">Overdue</span>
                                            @endif
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $loan->status == '1' ? 'success' : ($loan->status == '2' ? 'danger' : 'warning') }}">
                                            @if($loan->status == '1') Active
                                            @elseif($loan->status == '2') Declined
                                            @else Pending
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($loan->status == '0')
                                        <button class="btn btn-sm btn-success me-1" data-bs-toggle="tooltip" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Decline">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        @else
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($loan->status == '1')
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="Mark as Paid">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <nav aria-label="Loan pagination">
                            <ul class="pagination pagination-sm">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No loans found for this user.
                    </div>
                @endif
            </div>

            <!-- Savings Goals Tab -->
            <div class="tab-pane fade" id="savings-goals" role="tabpanel" aria-labelledby="savings-goals-tab">
                @if($user_savings_goals->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Goal</th>
                                    <th>Target Amount</th>
                                    <th>Saved Amount</th>
                                    <th>Progress</th>
                                    <th>Target Date</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_savings_goals as $goal)
                                    @php($progress = min(100, (int) round(((float) $goal->saved_amount / (float) $goal->target_amount) * 100)))
                                    <tr>
                                        <td class="fw-semibold">{{ $goal->name }}</td>
                                        <td>{{ $userProfile->currency }}{{ number_format((float) $goal->target_amount, 2) }}</td>
                                        <td>{{ $userProfile->currency }}{{ number_format((float) $goal->saved_amount, 2) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" role="progressbar" aria-label="Savings goal progress" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="height: 8px; min-width: 70px;">
                                                    <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <small class="text-muted">{{ $progress }}%</small>
                                            </div>
                                        </td>
                                        <td>{{ $goal->target_date?->format('M d, Y') ?? 'No target date' }}</td>
                                        <td>{{ $goal->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0">Savings goals are progress trackers only; contributions do not move funds or change the user's account balance.</p>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No savings goals found for this user.
                    </div>
                @endif
            </div>

            <!-- Investment Orders Tab -->
            <div class="tab-pane fade" id="investment-orders" role="tabpanel" aria-labelledby="investment-orders-tab">
                @if($user_trades->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Asset</th>
                                    <th>Side</th>
                                    <th>Order Type</th>
                                    <th>Amount (USD)</th>
                                    <th>Quantity</th>
                                    <th>Limit Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user_trades as $trade)
                                    <tr>
                                        <td>{{ $trade->created_at->format('M d, Y h:i A') }}</td>
                                        <td><code>{{ $trade->transaction_id }}</code></td>
                                        <td>{{ $trade->asset_name }} <span class="text-muted">({{ $trade->asset_symbol }})</span></td>
                                        <td><span class="badge bg-{{ $trade->type === 'buy' ? 'success' : 'danger' }}">{{ ucfirst($trade->type) }}</span></td>
                                        <td>{{ ucfirst($trade->order_type) }}</td>
                                        <td>${{ number_format((float) $trade->amount_usd, 2) }}</td>
                                        <td>{{ number_format((float) $trade->quantity, 6) }}</td>
                                        <td>{{ $trade->limit_price !== null ? '$' . number_format((float) $trade->limit_price, 6) : 'Market' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $trade->status === 'pending' ? 'warning' : ($trade->status === 'executed' ? 'success' : 'secondary') }}">
                                                {{ ucfirst($trade->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0">Order requests are recorded here; pending orders have not been executed or deducted from the user's balance.</p>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i> No investment orders found for this user.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
    </div>
    </div>
</div>

<!-- Credit User Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Credit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
          <form action="{{ route('admin.credit.user') }}" method="POST">
    @csrf

    <!-- Recipient Info (hidden) -->
    <input type="hidden" name="email" value="{{ $userProfile->email }}">
    <input type="hidden" name="first_name" value="{{ $userProfile->first_name }}">
    <input type="hidden" name="last_name" value="{{ $userProfile->last_name }}">
    <input type="hidden" name="id" value="{{ $userProfile->id }}">
    <input type="hidden" name="balance" value="{{ ($credit_transfers) - ($debit_transfers) }}">
    <input type="hidden" name="account_number" value="{{ $userProfile->account_number }}">
    <input type="hidden" name="currency" value="{{ $userProfile->currency }}">

    <div class="modal-body">
        <!-- Sender/Admin Name -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Sender Name</label>
            <input type="text" class="form-control" name="sender_name"
                value=""
                placeholder="Enter sender name" required>
        </div>

        <!-- Sender/Admin Account Number -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Sender Account Number</label>
            <input type="text" class="form-control" name="sender_account"
                placeholder="Enter sender account number" required>
        </div>

        <!-- Amount Input -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Amount</label>
            <input type="number" class="form-control" name="amount"
                placeholder="Enter amount" required min="1">
        </div>

        <!-- Description Input -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea class="form-control" name="description" rows="3"
                placeholder="Transaction description (optional)"></textarea>
        </div>

        <!-- Date Input -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Date</label>
            <input type="date" class="form-control" name="date"
                value="{{ now()->format('Y-m-d') }}" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Credit User</button>
    </div>
</form>


        </div>
    </div>
</div>






<!--update Tac Code -->
<div class="modal fade" id="updateLoanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Loan Eligiblity Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.debit.user') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{$userProfile->email}}"/>
                <input type="hidden" name="name" value="{{$userProfile->first_name}}"/>
                <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                <input type="hidden" name="balance" value="{{ number_format(($credit_transfers) - ($debit_transfers), 2) }}"/>
                <input type="hidden" name="a_number" value="{{$userProfile->account_number}}"/>
                <input type="hidden" name="currency" value="{{$userProfile->currency}}"/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Update Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount" required>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Update Loan Amount</button>
                </div>
            </form>
        </div>
    </div>
</div>










<!-- Update Payment Status Modal -->
<div class="modal fade" id="updatePaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Payment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updatepaymentstatus') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $userProfile->id }}"/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="1" {{ $userProfile->payment_status == 1 ? 'selected' : '' }}>Activate</option>
                            <option value="0" {{ $userProfile->payment_status == 0 ? 'selected' : '' }}>Deactivate</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>






<!--update Foreign Code -->
<div class="modal fade" id="updateForeignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Foreign Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updatewithdrawalcode') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Update Foreign Code</label>
                        <input type="number" class="form-control" name="withdrawal_code" placeholder="Enter Foreign Code" required>
                    </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Update Foreign Code</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Debit User Modal -->
<div class="modal fade" id="debitTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Debit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.debit.user') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{$userProfile->email}}"/>
                <input type="hidden" name="name" value="{{$userProfile->first_name}}"/>
                <input type="hidden" name="id" value="{{$userProfile->id}}"/>
                <input type="hidden" name="balance" value="{{ number_format(($credit_transfers) - ($debit_transfers), 2) }}"/>
                <input type="hidden" name="a_number" value="{{$userProfile->account_number}}"/>
                <input type="hidden" name="currency" value="{{$userProfile->currency}}"/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Transaction description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Debit User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Deposit Modal -->
<div class="modal fade" id="addDepositModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Deposit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Enter deposit amount" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date">
                    </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Deposit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Loan Modal -->
<div class="modal fade" id="addLoanModal" tabindex="-1" aria-labelledby="addLoanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLoanModalLabel">Add New Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loanForm">
                    <div class="mb-3">
                        <label for="loanAmount" class="form-label">Loan Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="loanAmount" placeholder="Enter loan amount" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="loanDate" class="form-label">Loan Date</label>
                        <input type="date" class="form-control" id="loanDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="loanNotes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="loanNotes" rows="3" placeholder="Any additional notes about the loan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="submitLoan">Submit Loan</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm User Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> This action will permanently delete the user account and all associated data.
                </div>
                <div class="mb-3">
                    <label class="form-label">User Details</label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="{{ $userProfile->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($userProfile->first_name).'&background=random' }}" 
                                     class="rounded-circle me-3" width="40" height="40" alt="Profile Photo">
                                <div>
                                    <h6 class="mb-0">{{ $userProfile->first_name }}</h6>
                                    <small class="text-muted">{{ $userProfile->email }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Action</label>
                    <input type="text" class="form-control" name="confirmation" placeholder="Type 'DELETE' to confirm" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Initialize tooltips -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>

<style>

    /* Alert System */
.alert-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    width: 100%;
    max-width: 400px;
    padding: 0 15px;
}

.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 1rem;
}

.alert-content {
    display: flex;
    align-items: center;
    padding: 15px;
    position: relative;
}

.alert-icon {
    margin-right: 12px;
    display: flex;
    align-items: center;
}

.alert-icon svg {
    width: 20px;
    height: 20px;
}

.alert-text {
    flex: 1;
    font-size: 14px;
    line-height: 1.4;
}

.btn-close {
    background: none;
    border: none;
    padding: 0;
    margin-left: 12px;
    opacity: 0.7;
    cursor: pointer;
    transition: opacity 0.2s;
}

.btn-close:hover {
    opacity: 1;
}

.btn-close svg {
    width: 16px;
    height: 16px;
}

.alert-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.3);
    animation: progressBar 5s linear forwards;
}

@keyframes progressBar {
    0% { width: 100%; }
    100% { width: 0%; }
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .alert-container {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }
    
    .alert-content {
        padding: 12px;
    }
    
    .alert-text {
        font-size: 13px;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
            alert.style.transform = 'translateX(100%)';
            alert.style.opacity = '0';
            
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
        
        // Pause animation on hover
        alert.addEventListener('mouseenter', () => {
            alert.querySelector('.alert-progress').style.animationPlayState = 'paused';
        });
        
        alert.addEventListener('mouseleave', () => {
            alert.querySelector('.alert-progress').style.animationPlayState = 'running';
        });
    });
});
</script>


@include('admin.footer')