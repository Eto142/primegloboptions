@include('user.header')
<style>
    /* ---------- Payment Methods User Styles ---------- */
    .payment-methods-user {
        padding: 20px 0;
    }

    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }

    .user-header h2 {
        color: var(--text-primary);
        margin: 0;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .user-header p {
        color: var(--text-secondary);
        margin: 8px 0 0 0;
        font-size: 1rem;
    }

    .balance-display {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 12px;
        text-align: center;
        min-width: 200px;
    }

    .balance-display .label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 5px;
    }

    .balance-display .amount {
        font-size: 1.5rem;
        font-weight: 700;
    }

    /* Payment Methods Grid */
    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .payment-method-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .payment-method-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .payment-method-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    }

    .payment-method-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .payment-method-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .payment-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .payment-details h3 {
        margin: 0 0 6px 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1.3rem;
    }

    .payment-details p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .payment-status {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.2);
    }

    .status-inactive {
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .payment-method-body {
        margin-bottom: 25px;
    }

    .payment-specs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
        background: rgba(0, 0, 0, 0.02);
        padding: 16px;
        border-radius: 12px;
    }

    .spec-item {
        display: flex;
        flex-direction: column;
    }

    .spec-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-bottom: 4px;
        font-weight: 500;
    }

    .spec-value {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .payment-details-section {
        margin-bottom: 20px;
    }

    .details-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .wallet-addresses, .bank-details {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .wallet-item, .bank-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .wallet-type, .bank-field {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.85rem;
        min-width: 80px;
    }

    .wallet-address, .bank-value {
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
        color: var(--text-secondary);
        word-break: break-all;
        text-align: right;
        flex: 1;
        margin: 0 10px;
    }

    .copy-btn {
        background: var(--primary);
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .copy-btn:hover {
        background: var(--primary-dark);
    }

    .copy-btn.copied {
        background: var(--success);
    }

    .cashapp-tag {
        text-align: center;
        padding: 15px;
        background: linear-gradient(135deg, #00D64B 0%, #00B83C 100%);
        color: white;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.4rem;
        letter-spacing: 1px;
        margin: 10px 0;
        box-shadow: 0 4px 12px rgba(0, 214, 75, 0.3);
    }

    .paypal-email {
        text-align: center;
        padding: 15px;
        background: linear-gradient(135deg, #0070BA 0%, #00457C 100%);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 10px 0;
        box-shadow: 0 4px 12px rgba(0, 112, 186, 0.3);
    }

    .payment-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .payment-features li {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: var(--text-secondary);
        padding: 6px 0;
    }

    .payment-features li i {
        margin-right: 10px;
        font-size: 0.9rem;
        width: 18px;
        text-align: center;
        color: var(--success);
    }

    .payment-method-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }

    .method-actions {
        display: flex;
        gap: 12px;
    }

    .btn-deposit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-deposit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(12, 116, 83, 0.3);
    }

    .btn-deposit:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-details {
        background: white;
        border: 1px solid var(--border);
        color: var(--text-secondary);
        padding: 12px 16px;
        border-radius: 10px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-details:hover {
        background: var(--background);
        color: var(--text-primary);
        border-color: var(--text-secondary);
    }

    .processing-info {
        font-size: 0.85rem;
        color: var(--text-secondary);
        text-align: right;
        max-width: 200px;
    }

    /* Popular Badge */
    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Information Section */
    .info-section {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 16px;
        padding: 30px;
        margin-top: 40px;
        border: 1px solid #bae6fd;
    }

    .info-section h3 {
        color: var(--primary);
        margin-bottom: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-section p {
        color: var(--text-secondary);
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .info-tips {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .info-tip {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-tip i {
        color: var(--primary);
        font-size: 1.2rem;
        margin-top: 2px;
    }

    .info-tip h4 {
        margin: 0 0 6px 0;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .info-tip p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    /* Deposit Instructions */
    .deposit-instructions {
        background: rgba(12, 116, 83, 0.05);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        border-left: 4px solid var(--primary);
    }

    .deposit-instructions h4 {
        color: var(--primary);
        margin-bottom: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .instructions-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .instructions-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .instructions-list li:last-child {
        margin-bottom: 0;
    }

    .instructions-list li .step-number {
        background: var(--primary);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 600;
        margin-right: 10px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .payment-methods-grid {
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .payment-methods-grid {
            grid-template-columns: 1fr;
        }
        
        .user-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        
        .balance-display {
            width: 100%;
        }
        
        .payment-specs {
            grid-template-columns: 1fr;
        }
        
        .payment-method-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .processing-info {
            text-align: left;
        }
        
        .method-actions {
            width: 100%;
            justify-content: space-between;
        }
    }

    @media (max-width: 480px) {
        .payment-method-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .payment-status {
            align-self: flex-start;
        }
        
        .payment-method-info {
            width: 100%;
        }
        
        .method-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-deposit, .btn-details {
            width: 100%;
            justify-content: center;
        }
        
        .wallet-item, .bank-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .wallet-address, .bank-value {
            text-align: left;
            margin: 0;
        }
        
        .copy-btn {
            align-self: flex-end;
        }
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <div class="payment-methods-user">
            <!-- Header Section -->
            <div class="user-header">
                <div>
                    <h2>Payment Methods</h2>
                    <p>Send payments to any of these accounts to activate withdrawal code                </div>
                <div class="balance-display">
                    <div class="label">Account Balance</div>
                    <div class="amount" style="color:white">{{ Auth::user()->currency ?? '$' }}{{ number_format($balance ?? 0, 2, '.', ',') }}</div>
                </div>
            </div>

            <!-- Payment Methods Grid -->
            <div class="payment-methods-grid">
                @forelse($wallets as $index => $wallet)
                    @if($wallet->status == 'active')
                        <div class="payment-method-card">
                            @if($index == 0)
                                <div class="popular-badge">Most Popular</div>
                            @endif
                            
                            <div class="payment-method-header">
                                <div class="payment-method-info">
                                    <div class="payment-icon" 
                                         style="background: 
                                         {{ $wallet->method == 'crypto' ? 'linear-gradient(135deg, #F7931A 0%, #E2780C 100%)' : 
                                            ($wallet->method == 'bank' ? 'linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)' : 
                                            'linear-gradient(135deg, #00D64B 0%, #00B83C 100%)') }};">
                                        @if($wallet->method == 'crypto')
                                            <i class="fab fa-bitcoin"></i>
                                        @elseif($wallet->method == 'bank')
                                            <i class="fas fa-university"></i>
                                        @else
                                            <i class="fas fa-dollar-sign"></i>
                                        @endif
                                    </div>
                                    <div class="payment-details">
                                        <h3>{{ ucfirst($wallet->method) }}</h3>
                                        <p>
                                            @if($wallet->method == 'crypto')
                                                Send Bitcoin, Ethereum, or USDT to our wallets
                                            @elseif($wallet->method == 'bank')
                                                Send wire transfers or ACH payments
                                            @else
                                                Send payments to our Cash App account
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="payment-status">
                                    <span class="status-badge status-active">Available</span>
                                </div>
                            </div>
                            
                            <div class="payment-method-body">
                                <div class="payment-specs">
                                    <div class="spec-item">
                                        <span class="spec-label">Processing Time</span>
                                        <span class="spec-value">
                                            @if($wallet->method == 'crypto')
                                                2-24 hours
                                            @elseif($wallet->method == 'bank')
                                                2-3 business days
                                            @else
                                                Instant
                                            @endif
                                        </span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">Minimum Deposit</span>
                                        <span class="spec-value">
                                            @if($wallet->method == 'crypto')
                                                $25
                                            @elseif($wallet->method == 'bank')
                                                $50
                                            @else
                                                $10
                                            @endif
                                        </span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">Transaction Fee</span>
                                        <span class="spec-value">
                                            @if($wallet->method == 'crypto')
                                                User pays
                                            @elseif($wallet->method == 'bank')
                                                $0 (we cover fees)
                                            @else
                                                0% (Free)
                                            @endif
                                        </span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">Daily Limit</span>
                                        <span class="spec-value">
                                            @if($wallet->method == 'crypto')
                                                No limit
                                            @elseif($wallet->method == 'bank')
                                                $10,000
                                            @else
                                                $1,000
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="payment-details-section">
                                    <div class="details-title">
                                        <i class="fas fa-wallet"></i>
                                        @if($wallet->method == 'crypto')
                                            Send Crypto To These Wallets
                                        @elseif($wallet->method == 'bank')
                                            Send To These Bank Details
                                        @else
                                            Send To This Cash App Tag
                                        @endif
                                    </div>
                                    
                                    @if($wallet->method == 'crypto')
                                        <div class="wallet-addresses">
                                            @if($wallet->bitcoin_address)
                                                <div class="wallet-item">
                                                    <span class="wallet-type">Bitcoin (BTC)</span>
                                                    <span class="wallet-address">{{ $wallet->bitcoin_address }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->bitcoin_address }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                            @if($wallet->ethereum_address)
                                                <div class="wallet-item">
                                                    <span class="wallet-type">Ethereum (ETH)</span>
                                                    <span class="wallet-address">{{ $wallet->ethereum_address }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->ethereum_address }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                            @if($wallet->usdt_address)
                                                <div class="wallet-item">
                                                    <span class="wallet-type">USDT (ERC20)</span>
                                                    <span class="wallet-address">{{ $wallet->usdt_address }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->usdt_address }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($wallet->method == 'bank')
                                        <div class="bank-details">
                                            @if($wallet->bank_name)
                                                <div class="bank-item">
                                                    <span class="bank-field">Bank Name</span>
                                                    <span class="bank-value">{{ $wallet->bank_name }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->bank_name }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                            @if($wallet->account_name)
                                                <div class="bank-item">
                                                    <span class="bank-field">Account Name</span>
                                                    <span class="bank-value">{{ $wallet->account_name }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->account_name }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                            @if($wallet->account_number)
                                                <div class="bank-item">
                                                    <span class="bank-field">Account Number</span>
                                                    <span class="bank-value">{{ $wallet->account_number }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->account_number }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                            @if($wallet->iban)
                                                <div class="bank-item">
                                                    <span class="bank-field">IBAN</span>
                                                    <span class="bank-value">{{ $wallet->iban }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->iban }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                            @if($wallet->swift)
                                                <div class="bank-item">
                                                    <span class="bank-field">SWIFT Code</span>
                                                    <span class="bank-value">{{ $wallet->swift }}</span>
                                                    <button class="copy-btn" data-address="{{ $wallet->swift }}">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="cashapp-tag">
                                            {{ $wallet->cashapp_tag ?? 'Cash App Tag' }}
                                        </div>
                                        <div style="text-align: center; margin-top: 10px;">
                                            <button class="copy-btn" data-address="{{ $wallet->cashapp_tag ?? '' }}" style="padding: 8px 16px;">
                                                <i class="fas fa-copy"></i> Copy Cash Tag
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="deposit-instructions">
                                    <h4><i class="fas fa-info-circle"></i> Important Instructions</h4>
                                    <ul class="instructions-list">
                                        @if($wallet->method == 'crypto')
                                            <li>
                                                <div class="step-number">1</div>
                                                <div>Send only the supported cryptocurrencies to these addresses</div>
                                            </li>
                                            <li>
                                                <div class="step-number">2</div>
                                                <div>Include your User ID in the memo/description field when sending</div>
                                            </li>
                                            <li>
                                                <div class="step-number">3</div>
                                                <div>Funds will be credited after 2 network confirmations</div>
                                            </li>
                                            <li>
                                                <div class="step-number">4</div>
                                                <div>Contact support if deposit doesn't appear within 24 hours</div>
                                            </li>
                                        @elseif($wallet->method == 'bank')
                                            <li>
                                                <div class="step-number">1</div>
                                                <div>Use exact bank details provided above</div>
                                            </li>
                                            <li>
                                                <div class="step-number">2</div>
                                                <div>Include your User ID in transfer description</div>
                                            </li>
                                            <li>
                                                <div class="step-number">3</div>
                                                <div>Keep your bank receipt/confirmation</div>
                                            </li>
                                            <li>
                                                <div class="step-number">4</div>
                                                <div>Email receipt to support@topsavertbc.online</div>
                                            </li>
                                        @else
                                            <li>
                                                <div class="step-number">1</div>
                                                <div>Send payment to {{ $wallet->cashapp_tag ?? 'Cash App Tag' }} on Cash App</div>
                                            </li>
                                            <li>
                                                <div class="step-number">2</div>
                                                <div>Include your User ID in the "For" section</div>
                                            </li>
                                            <li>
                                                <div class="step-number">3</div>
                                                <div>Screenshot the completed transaction</div>
                                            </li>
                                            <li>
                                                <div class="step-number">4</div>
                                                <div>Submit the screenshot in the deposit form</div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <ul class="payment-features">
                                    @if($wallet->method == 'crypto')
                                        <li><i class="fas fa-check"></i> Support for BTC, ETH, USDT</li>
                                        <li><i class="fas fa-check"></i> No deposit limits</li>
                                        <li><i class="fas fa-check"></i> Lower fees for large amounts</li>
                                        <li><i class="fas fa-check"></i> Blockchain transparency</li>
                                    @elseif($wallet->method == 'bank')
                                        <li><i class="fas fa-check"></i> Direct from your bank account</li>
                                        {{-- <li><i class="fas fa-check"></i> $10,000 daily deposit limit</li> --}}
                                        <li><i class="fas fa-check"></i> Full transaction audit trail</li>
                                        <li><i class="fas fa-check"></i> Bank-level security</li>
                                    @else
                                        <li><i class="fas fa-check"></i> Instant processing</li>
                                        {{-- <li><i class="fas fa-check"></i> $1,000 daily deposit limit</li> --}}
                                        <li><i class="fas fa-check"></i> Available 24/7 including weekends</li>
                                        <li><i class="fas fa-check"></i> No transaction fees</li>
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="payment-method-footer">
                                <div class="processing-info">
                                    @if($wallet->method == 'crypto')
                                        Processing depends on network congestion
                                    @elseif($wallet->method == 'bank')
                                        Processed on business days only
                                    @else
                                        Funds credited instantly after verification
                                    @endif
                                </div>
                                <div class="method-actions">
                                    <button class="btn-details">
                                        <i class="fas fa-info-circle"></i>
                                        Details
                                    </button>
                                    {{-- <button class="btn-deposit" data-method="{{ $wallet->method }}">
                                        <i class="fas fa-arrow-right"></i>
                                        Make Deposit
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <h4>No Payment Methods Available</h4>
                            <p>Currently there are no active payment methods. Please check back later or contact support.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Information Section -->
            <div class="info-section">
                <h3><i class="fas fa-info-circle"></i> Deposit Instructions</h3>
                <p>To ensure your deposit is processed quickly and accurately, please follow these guidelines:</p>
                
                <div class="info-tips">
                    <div class="info-tip">
                        <i class="fas fa-user-circle"></i>
                        <div>
                            <h4>Include Your User ID</h4>
                            <p>Always include your User ID ({{ Auth::id() }}) in the payment description/memo for identification</p>
                        </div>
                    </div>
                    <div class="info-tip">
                        <i class="fas fa-receipt"></i>
                        <div>
                            <h4>Keep Receipts</h4>
                            <p>Save transaction receipts and screenshots for verification purposes</p>
                        </div>
                    </div>
                    <div class="info-tip">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Processing Times</h4>
                            <p>Processing times vary by method. Crypto may take up to 24 hours during high network traffic</p>
                        </div>
                    </div>
                    <div class="info-tip">
                        <i class="fas fa-headset"></i>
                        <div>
                            <h4>Need Help?</h4>
                            <p>Contact support@topsavertbc.online if your deposit doesn't appear within expected time</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy functionality for wallet addresses, bank details, etc.
        const copyButtons = document.querySelectorAll('.copy-btn');
        
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-address');
                
                if (!textToCopy) return;
                
                // Use the Clipboard API to copy text
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // Change button text temporarily
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    this.classList.add('copied');
                    
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('copied');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = textToCopy;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    this.classList.add('copied');
                    
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('copied');
                    }, 2000);
                });
            });
        });
        
        // Deposit button functionality
        const depositButtons = document.querySelectorAll('.btn-deposit');
        
        depositButtons.forEach(button => {
            button.addEventListener('click', function() {
                const method = this.getAttribute('data-method');
                const card = this.closest('.payment-method-card');
                const methodName = card.querySelector('h3').textContent;
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening...';
                this.disabled = true;
                
                // Simulate opening deposit form
                setTimeout(() => {
                    // In a real application, you would redirect to a deposit form
                    // For now, we'll show an alert
                    alert(`Opening ${methodName} deposit form. Please follow the instructions carefully.\n\nYou will need to:\n1. Make payment using the details provided\n2. Include your User ID: {{ Auth::id() }}\n3. Submit proof of payment`);
                    
                    this.innerHTML = originalText;
                    this.disabled = false;
                    
                    // Redirect to deposit form (uncomment when you have the route)
                    // window.location.href = `/deposit/${method}`;
                }, 1000);
            });
        });
        
        // Details button functionality
        const detailsButtons = document.querySelectorAll('.btn-details');
        
        detailsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.payment-method-card');
                const methodName = card.querySelector('h3').textContent;
                const specs = card.querySelectorAll('.spec-item');
                
                let detailsMessage = `${methodName} Deposit Details:\n\n`;
                specs.forEach(spec => {
                    const label = spec.querySelector('.spec-label').textContent;
                    const value = spec.querySelector('.spec-value').textContent;
                    detailsMessage += `${label}: ${value}\n`;
                });
                
                // Add user ID reminder
                detailsMessage += `\nRemember to include your User ID: {{ Auth::id() }}`;
                
                alert(detailsMessage);
            });
        });
    });
</script>
@include('user.footer')