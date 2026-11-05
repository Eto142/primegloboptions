@include('admin.header')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* All previous CSS remains the same */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            width: 250px;
            background: linear-gradient(to bottom, #0c7453, #095c43);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .navbar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .navbar-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .nav-links {
            list-style: none;
        }

        .nav-links li {
            padding: 12px 20px;
            transition: all 0.3s;
        }

        .nav-links li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-links li.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        .admin-header h1 {
            color: #333;
            margin: 0;
            font-size: 1.8rem;
        }

        .admin-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: #0c7453;
            color: white;
        }

        .btn-primary:hover {
            background-color: #095c43;
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
        }

        /* Payment Methods Grid */
        .payment-methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .payment-method-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .payment-method-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .payment-method-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .payment-method-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .payment-details h4 {
            margin: 0 0 4px 0;
            font-weight: 600;
            color: #333;
        }

        .payment-details p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .payment-status {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active {
            background: rgba(5, 150, 105, 0.1);
            color: #059669;
        }

        .status-inactive {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }

        .payment-method-body {
            margin-bottom: 20px;
        }

        .payment-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 4px;
        }

        .stat-value {
            font-weight: 600;
            color: #333;
        }

        .payment-method-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .payment-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            background: white;
            color: #666;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            background: #f8f9fa;
            color: #333;
        }

        .btn-edit:hover {
            border-color: #0c7453;
            color: #0c7453;
        }

        .btn-delete:hover {
            border-color: #dc2626;
            color: #dc2626;
        }

        .last-updated {
            font-size: 0.8rem;
            color: #666;
        }

        /* NEW STYLES FOR PAYMENT DETAILS */
        .payment-details-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin-top: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            font-size: 0.8rem;
            color: #333;
            font-weight: 500;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #666;
            cursor: pointer;
            padding: 5px;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: #0c7453;
        }

        .form-select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            background: white;
            border: 1px solid #ddd;
            color: #666;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
        }

        .btn-save {
            background: #0c7453;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-save:hover {
            background: #095c43;
        }

        /* Payment Type Specific Fields */
        .payment-type-fields {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .payment-type-fields h5 {
            margin: 0 0 10px 0;
            font-size: 1rem;
            color: #333;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .navbar {
                width: 70px;
                overflow: hidden;
            }
            
            .navbar-header h2, .nav-links span {
                display: none;
            }
            
            .nav-links li {
                padding: 15px;
                text-align: center;
            }
            
            .nav-links a {
                justify-content: center;
            }
            
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
        }

        @media (max-width: 768px) {
            .payment-methods-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .admin-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .payment-stats {
                grid-template-columns: 1fr;
            }
            
            .payment-method-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .payment-actions {
                align-self: flex-end;
            }

            .modal-content {
                max-width: 95%;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                width: 100%;
                height: 60px;
                bottom: 0;
                top: auto;
                padding: 0;
            }
            
            .navbar-header {
                display: none;
            }
            
            .nav-links {
                display: flex;
                justify-content: space-around;
                height: 100%;
            }
            
            .nav-links li {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                border-left: none;
                border-top: 4px solid transparent;
            }
            
            .nav-links li.active {
                border-left: none;
                border-top: 4px solid white;
            }
            
            .main-content {
                margin-left: 0;
                margin-bottom: 60px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->

    <!-- Main Content -->
    <div class="main-content">
        <div class="admin-header">
            <div>
                <h1>Payment Methods</h1>
                <p>Manage cryptocurrency, bank transfer, and Cash App payment options</p>
            </div>
            <div class="admin-actions">
                <button class="btn btn-primary" id="addPaymentMethod">
                    <i class="fas fa-plus"></i> Add Payment Method
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif 

        <!-- Payment Methods Grid -->
        <div class="payment-methods-grid">
            @forelse ($wallets as $wallet)
                <div class="payment-method-card">
                    {{-- Header --}}
                    <div class="payment-method-header">
                        <div class="payment-method-info">
                            <div class="payment-icon" 
                                 style="background: 
                                 {{ $wallet->method == 'crypto' ? '#f7931a' : ($wallet->method == 'bank' ? '#0c7453' : '#00d64f') }};">
                                @if($wallet->method == 'crypto')
                                    <i class="fab fa-bitcoin"></i>
                                @elseif($wallet->method == 'bank')
                                    <i class="fas fa-university"></i>
                                @else
                                    <i class="fas fa-dollar-sign"></i>
                                @endif
                            </div>
                            <div class="payment-details">
                                <h4>{{ ucfirst($wallet->method) }}</h4>
                                <p>{{ ucfirst($wallet->status) }} • Updated {{ $wallet->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="payment-status">
                            <span class="status-badge {{ $wallet->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ ucfirst($wallet->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Body with organized payment details --}}
                    <div class="payment-method-body">
                        <div class="payment-details-grid">
                            @if($wallet->method == 'crypto')
                                @if($wallet->bitcoin_address)
                                    <div class="detail-row">
                                        <span class="detail-label">Bitcoin:</span>
                                        <span class="detail-value">{{ $wallet->bitcoin_address }}</span>
                                    </div>
                                @endif
                                @if($wallet->ethereum_address)
                                    <div class="detail-row">
                                        <span class="detail-label">Ethereum:</span>
                                        <span class="detail-value">{{ $wallet->ethereum_address }}</span>
                                    </div>
                                @endif
                                @if($wallet->usdt_address)
                                    <div class="detail-row">
                                        <span class="detail-label">USDT:</span>
                                        <span class="detail-value">{{ $wallet->usdt_address }}</span>
                                    </div>
                                @endif
                            @elseif($wallet->method == 'bank')
                                @if($wallet->bank_name)
                                    <div class="detail-row">
                                        <span class="detail-label">Bank:</span>
                                        <span class="detail-value">{{ $wallet->bank_name }}</span>
                                    </div>
                                @endif
                                @if($wallet->account_name)
                                    <div class="detail-row">
                                        <span class="detail-label">Account Name:</span>
                                        <span class="detail-value">{{ $wallet->account_name }}</span>
                                    </div>
                                @endif
                                @if($wallet->account_number)
                                    <div class="detail-row">
                                        <span class="detail-label">Account Number:</span>
                                        <span class="detail-value">{{ $wallet->account_number }}</span>
                                    </div>
                                @endif
                                @if($wallet->iban)
                                    <div class="detail-row">
                                        <span class="detail-label">IBAN:</span>
                                        <span class="detail-value">{{ $wallet->iban }}</span>
                                    </div>
                                @endif
                                @if($wallet->swift)
                                    <div class="detail-row">
                                        <span class="detail-label">SWIFT:</span>
                                        <span class="detail-value">{{ $wallet->swift }}</span>
                                    </div>
                                @endif
                            @elseif($wallet->method == 'cashapp')
                                @if($wallet->cashapp_tag)
                                    <div class="detail-row">
                                        <span class="detail-label">Cash App Tag:</span>
                                        <span class="detail-value">{{ $wallet->cashapp_tag }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="payment-method-footer">
                        <div class="last-updated">Updated {{ $wallet->updated_at->diffForHumans() }}</div>
                        <div class="payment-actions">
                            {{-- Edit Button --}}
                            <button class="btn-action btn-edit" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal{{ $wallet->id }}" 
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- Delete Form --}}
                            <form action="{{ route('admin.wallet.destroy', $wallet->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $wallet->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $wallet->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.wallet.update', $wallet->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $wallet->id }}">Edit Payment Method</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="method{{ $wallet->id }}">Method</label>
                                        <select name="method" id="method{{ $wallet->id }}" class="form-select" required>
                                            <option value="crypto" {{ $wallet->method == 'crypto' ? 'selected' : '' }}>Cryptocurrency</option>
                                            <option value="bank" {{ $wallet->method == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="cashapp" {{ $wallet->method == 'cashapp' ? 'selected' : '' }}>Cash App</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="status{{ $wallet->id }}">Status</label>
                                        <select name="status" id="status{{ $wallet->id }}" class="form-select" required>
                                            <option value="active" {{ $wallet->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $wallet->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <!-- Cryptocurrency Fields -->
                                    <div class="crypto-fields" style="{{ $wallet->method == 'crypto' ? '' : 'display:none;' }}">
                                        <div class="form-group">
                                            <label>Bitcoin Address</label>
                                            <input type="text" name="bitcoin_address" class="form-control" value="{{ $wallet->bitcoin_address }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Ethereum Address</label>
                                            <input type="text" name="ethereum_address" class="form-control" value="{{ $wallet->ethereum_address }}">
                                        </div>
                                        <div class="form-group">
                                            <label>USDT Address</label>
                                            <input type="text" name="usdt_address" class="form-control" value="{{ $wallet->usdt_address }}">
                                        </div>
                                    </div>

                                    <!-- Bank Fields -->
                                    <div class="bank-fields" style="{{ $wallet->method == 'bank' ? '' : 'display:none;' }}">
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <input type="text" name="bank_name" class="form-control" value="{{ $wallet->bank_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Account Name</label>
                                            <input type="text" name="account_name" class="form-control" value="{{ $wallet->account_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Account Number</label>
                                            <input type="text" name="account_number" class="form-control" value="{{ $wallet->account_number }}">
                                        </div>
                                        <div class="form-group">
                                            <label>IBAN</label>
                                            <input type="text" name="iban" class="form-control" value="{{ $wallet->iban }}">
                                        </div>
                                        <div class="form-group">
                                            <label>SWIFT</label>
                                            <input type="text" name="swift" class="form-control" value="{{ $wallet->swift }}">
                                        </div>
                                    </div>

                                    <!-- Cash App Fields -->
                                    <div class="cashapp-fields" style="{{ $wallet->method == 'cashapp' ? '' : 'display:none;' }}">
                                        <div class="form-group">
                                            <label>Cash App Tag</label>
                                            <input type="text" name="cashapp_tag" class="form-control" value="{{ $wallet->cashapp_tag }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            @empty
                <p>No payment methods available.</p>
            @endforelse
        </div>

        <!-- Add/Edit Payment Method Modal -->
        <div class="modal-overlay" id="paymentModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modalTitle">Add Payment Method</h3>
                    <button class="modal-close" id="closeModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.wallet.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Payment Method *</label>
                            <select class="form-select" name="method" id="methodType" required>
                                <option value="">Select Type</option>
                                <option value="crypto">Cryptocurrency</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="cashapp">Cash App</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select class="form-select" name="status" id="methodStatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        
                        {{-- CRYPTOCURRENCY --}}
                        <div class="payment-type-fields" id="cryptoFields" style="display: none;">
                            <h5>Cryptocurrency Details</h5>
                            <div class="form-group">
                                <label class="form-label">Bitcoin Address</label>
                                <input type="text" class="form-control" name="bitcoin_address" placeholder="Enter Bitcoin wallet address">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Ethereum Address</label>
                                <input type="text" class="form-control" name="ethereum_address" placeholder="Enter Ethereum wallet address">
                            </div>
                            <div class="form-group">
                                <label class="form-label">USDT Address</label>
                                <input type="text" class="form-control" name="usdt_address" placeholder="Enter USDT wallet address">
                            </div>
                        </div>
                        
                        {{-- BANK TRANSFER --}}
                        <div class="payment-type-fields" id="bankFields" style="display: none;">
                            <h5>Bank Transfer Details</h5>
                            <div class="form-group">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Enter bank name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Account Name</label>
                                <input type="text" class="form-control" name="account_name" placeholder="Enter account holder name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" name="account_number" placeholder="Enter account number">
                            </div>
                        </div>
                        
                        {{-- CASH APP --}}
                        <div class="payment-type-fields" id="cashappFields" style="display: none;">
                            <h5>Cash App Details</h5>
                            <div class="form-group">
                                <label class="form-label">Cash App Tag</label>
                                <input type="text" class="form-control" name="cashapp_tag" placeholder="Enter Cash App tag (e.g., $YourTag)">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Save Payment Method</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" id="cancelModal">Cancel</button>
                    <button type="button" class="btn btn-save" id="savePaymentMethod">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const methodSelect = document.getElementById('methodType');
            const fields = {
                crypto: document.getElementById('cryptoFields'),
                bank: document.getElementById('bankFields'),
                cashapp: document.getElementById('cashappFields'),
            };

            methodSelect.addEventListener('change', function() {
                // Hide all fields first
                Object.values(fields).forEach(div => div.style.display = 'none');
                // Show the selected type
                if (fields[this.value]) {
                    fields[this.value].style.display = 'block';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addPaymentMethodBtn = document.getElementById('addPaymentMethod');
            const paymentModal = document.getElementById('paymentModal');
            const closeModalBtn = document.getElementById('closeModal');
            const cancelModalBtn = document.getElementById('cancelModal');
            const savePaymentMethodBtn = document.getElementById('savePaymentMethod');
            const methodTypeSelect = document.getElementById('methodType');
            
            // Payment type fields
            const cryptoFields = document.getElementById('cryptoFields');
            const bankFields = document.getElementById('bankFields');
            const cashappFields = document.getElementById('cashappFields');
            
            // Open modal for adding new payment method
            addPaymentMethodBtn.addEventListener('click', function() {
                paymentModal.classList.add('active');
            });
            
            // Close modal
            function closeModal() {
                paymentModal.classList.remove('active');
            }
            
            closeModalBtn.addEventListener('click', closeModal);
            cancelModalBtn.addEventListener('click', closeModal);
            
            // Handle payment type change
            methodTypeSelect.addEventListener('change', function() {
                // Hide all fields first
                cryptoFields.style.display = 'none';
                bankFields.style.display = 'none';
                cashappFields.style.display = 'none';
                
                // Show relevant fields based on selection
                if (this.value === 'crypto') {
                    cryptoFields.style.display = 'block';
                } else if (this.value === 'bank') {
                    bankFields.style.display = 'block';
                } else if (this.value === 'cashapp') {
                    cashappFields.style.display = 'block';
                }
            });
            
            // Save payment method
            savePaymentMethodBtn.addEventListener('click', function() {
                const methodType = methodTypeSelect.value;
                
                if (!methodType) {
                    alert('Please select a payment method type');
                    return;
                }
                
                // In a real application, you would submit the form data to the server here
                alert(`Payment method "${methodType}" saved successfully!`);
                closeModal();
            });
            
            // Edit buttons
            const editButtons = document.querySelectorAll('.btn-edit');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // In a real application, you would populate the form with existing data
                    alert('Edit functionality would load existing data here');
                });
            });
            
            // Delete buttons
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete this payment method?')) {
                        // In a real application, you would send a delete request to the server
                        alert('Payment method deleted successfully!');
                    }
                });
            });
            
            // Close modal when clicking outside
            paymentModal.addEventListener('click', function(e) {
                if (e.target === paymentModal) {
                    closeModal();
                }
            });
        });
    </script>

    <script>
        document.getElementById('methodType').addEventListener('change', function () {
            const value = this.value;
            document.querySelectorAll('.payment-type-fields').forEach(div => div.style.display = 'none');

            if (value === 'crypto') document.getElementById('cryptoFields').style.display = 'block';
            if (value === 'bank') document.getElementById('bankFields').style.display = 'block';
            if (value === 'cashapp') document.getElementById('cashappFields').style.display = 'block';
        });
    </script>

    <!-- Optional JS to switch fields inside the modal dynamically -->
    <script>
        document.querySelectorAll('.modal').forEach(modal => {
            const methodSelect = modal.querySelector('select[name="method"]');
            methodSelect.addEventListener('change', function() {
                const crypto = modal.querySelector('.crypto-fields');
                const bank = modal.querySelector('.bank-fields');
                const cashapp = modal.querySelector('.cashapp-fields');

                crypto.style.display = this.value === 'crypto' ? 'block' : 'none';
                bank.style.display = this.value === 'bank' ? 'block' : 'none';
                cashapp.style.display = this.value === 'cashapp' ? 'block' : 'none';
            });
        });
    </script>

</body>
</html>

@include('admin.footer')