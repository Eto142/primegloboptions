@include('user.header')

<style>
    .investment-asset {
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .investment-asset:hover,
    .investment-asset:focus-visible {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
        <div>
            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2">
                <i class="fas fa-chart-line me-1"></i> INVESTMENTS
            </span>
            <h2 class="fw-bold text-dark mb-1">Markets</h2>
            <p class="text-muted mb-0">Browse stocks, crypto and forex, then submit a buy or sell order request.</p>
        </div>
        <div class="d-flex align-items-center gap-2 bg-white p-3 rounded-3 shadow-sm border">
            <i class="fas fa-wallet text-primary"></i>
            <span class="text-muted small">Available balance</span>
            <span class="fw-bold font-monospace text-dark">{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}</span>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3" role="alert">
            <strong>We could not submit that order.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-start gap-3 p-3 p-md-4 mb-4" role="status">
        <i class="fas fa-info-circle fs-4 text-warning"></i>
        <div>
            <strong>Orders are requests, not executed trades.</strong>
            <p class="mb-0">Live quotes and broker execution are not connected. Submitted orders remain pending; no funds are deducted and no holdings are created.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4 mb-4">
        <ul class="nav nav-pills gap-2 mb-4" id="marketTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill" id="stocks-tab" data-bs-toggle="pill" data-bs-target="#stocks" type="button" role="tab" aria-controls="stocks" aria-selected="true">Stocks</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill" id="crypto-tab" data-bs-toggle="pill" data-bs-target="#crypto" type="button" role="tab" aria-controls="crypto" aria-selected="false">Crypto</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill" id="forex-tab" data-bs-toggle="pill" data-bs-target="#forex" type="button" role="tab" aria-controls="forex" aria-selected="false">Forex</button>
            </li>
        </ul>

        <div class="tab-content" id="marketTabsContent">
            @foreach (['stocks' => 'Popular Stocks', 'crypto' => 'Popular Cryptos', 'forex' => 'Major Currency Pairs'] as $category => $title)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $category }}" role="tabpanel" aria-labelledby="{{ $category }}-tab" tabindex="0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">{{ $title }}</h5>
                        <span class="small text-muted"><i class="fas fa-circle text-secondary me-1" style="font-size: 0.45rem;"></i> Quotes unavailable</span>
                    </div>
                    <div class="row g-3">
                        @foreach ($assets as $symbol => $asset)
                            @if ($asset['category'] === $category)
                                <div class="col-12 col-md-6 col-xl-4">
                                    <button
                                        type="button"
                                        class="investment-asset bg-white w-100 h-100 p-3 text-start"
                                        data-bs-toggle="modal"
                                        data-bs-target="#tradeModal"
                                        data-asset-symbol="{{ $symbol }}"
                                        data-asset-name="{{ $asset['name'] }}"
                                    >
                                        <span class="d-flex align-items-center gap-3">
                                            <span class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                                @if ($category === 'crypto')
                                                    <i class="fab fa-bitcoin"></i>
                                                @elseif ($category === 'forex')
                                                    <i class="fas fa-globe"></i>
                                                @else
                                                    <i class="fas fa-chart-line"></i>
                                                @endif
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-block fw-bold text-dark">{{ $asset['name'] }}</span>
                                                <span class="small text-muted">{{ $symbol }}</span>
                                            </span>
                                            <span class="small text-muted text-end">Trade<br><i class="fas fa-chevron-right"></i></span>
                                        </span>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
            <h5 class="fw-bold text-dark mb-0">Your investment orders</h5>
            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">{{ $trades->count() }} recent</span>
        </div>

        @forelse ($trades as $trade)
            <div class="border rounded-4 p-3 mb-2">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary me-1">{{ $trade->asset_symbol }}</span>
                        <strong class="text-dark">{{ $trade->asset_name }}</strong>
                        <div class="small text-muted mt-2">
                            {{ ucfirst($trade->type) }} · {{ ucfirst($trade->order_type) }} order ·
                            ${{ number_format($trade->amount_usd, 2) }} · {{ number_format($trade->quantity, 6) }} units
                            @if ($trade->limit_price)
                                · Trigger price ${{ number_format($trade->limit_price, 6) }}
                            @endif
                        </div>
                        <div class="small text-muted mt-1">{{ $trade->created_at->format('M j, Y g:i A') }}</div>
                    </div>
                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning-emphasis">{{ ucfirst($trade->status) }}</span>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i class="fas fa-chart-line fs-2 mb-2"></i>
                <p class="mb-0">No investment orders yet. Choose an asset above to submit an order request.</p>
            </div>
        @endforelse
    </div>

    <p class="small text-muted mt-3 mb-0">
        <i class="fas fa-exclamation-triangle me-1"></i>
        Investments involve risk, including possible loss of principal. Market data and investment execution are not provided by this page.
    </p>
</div>

<div class="modal fade" id="tradeModal" tabindex="-1" aria-labelledby="tradeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form method="POST" action="{{ route('user.investment.order') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="tradeModalTitle">Trade Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="asset_symbol" id="assetSymbolInput">

                    <div class="mb-3">
                        <label for="tradeType" class="form-label fw-semibold">Order side</label>
                        <select class="form-select" name="type" id="tradeType" required>
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tradeAmount" class="form-label fw-semibold">Amount (USD)</label>
                        <input type="number" name="amount_usd" id="tradeAmount" class="form-control" min="0.01" step="0.01" placeholder="0.00" required>
                    </div>

                    <div class="mb-3">
                        <label for="tradeQuantity" class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" id="tradeQuantity" class="form-control" min="0.000001" step="0.000001" placeholder="0.000000" required>
                    </div>

                    <div class="mb-3" id="orderTypeContainer">
                        <label for="orderType" class="form-label fw-semibold">Order type</label>
                        <select class="form-select" name="order_type" id="orderType" required>
                            <option value="market">Market Order</option>
                            <option value="limit">Limit Order</option>
                            <option value="stop">Stop Order</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="triggerPriceContainer">
                        <label for="triggerPrice" class="form-label fw-semibold">Limit / stop price (USD)</label>
                        <input type="number" name="limit_price" id="triggerPrice" class="form-control" min="0.000001" step="0.000001" placeholder="0.000000">
                    </div>

                    <div class="small text-muted">
                        <span id="orderDisclaimer">This request will be saved as pending. No trade will be executed and no balance will be changed.</span>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary rounded-pill w-100">Submit Order Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tradeModal = document.getElementById('tradeModal');
        const orderType = document.getElementById('orderType');
        const priceContainer = document.getElementById('triggerPriceContainer');
        const triggerPrice = document.getElementById('triggerPrice');

        tradeModal.addEventListener('show.bs.modal', function (event) {
            const asset = event.relatedTarget;
            document.getElementById('assetSymbolInput').value = asset.dataset.assetSymbol;
            document.getElementById('tradeModalTitle').textContent =
                `Trade ${asset.dataset.assetName} (${asset.dataset.assetSymbol})`;
        });

        orderType.addEventListener('change', function () {
            const needsPrice = ['limit', 'stop'].includes(orderType.value);
            priceContainer.classList.toggle('d-none', !needsPrice);
            triggerPrice.required = needsPrice;
            if (!needsPrice) {
                triggerPrice.value = '';
            }
        });
    });
</script>

@include('user.footer')
