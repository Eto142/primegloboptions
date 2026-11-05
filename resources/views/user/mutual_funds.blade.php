@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-4">
        <div>
            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2">
                <i class="fas fa-layer-group me-1"></i> INVESTMENTS
            </span>
            <h2 class="fw-bold text-dark mb-1">Mutual Funds</h2>
            <p class="text-muted mb-0">Browse fund categories and submit a buy or redemption request.</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3" role="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3" role="alert">
            <strong>We could not submit that fund request.</strong>
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
            <strong>Illustrative categories only; requests are not executed.</strong>
            <p class="mb-0">No fund provider, prospectus, NAV data or execution is connected. Requests remain pending and do not change your balance or create holdings.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">Sample fund categories</h5>
            <span class="small text-muted"><i class="fas fa-circle text-secondary me-1" style="font-size: 0.45rem;"></i> NAV unavailable</span>
        </div>
        <div class="row g-3">
            @foreach ($funds as $symbol => $fund)
                <div class="col-12 col-md-6 col-xl-3">
                    <button
                        type="button"
                        class="investment-asset bg-white w-100 h-100 p-3 text-start"
                        data-bs-toggle="modal"
                        data-bs-target="#fundOrderModal"
                        data-fund-symbol="{{ $symbol }}"
                        data-fund-name="{{ $fund['name'] }}"
                    >
                        <span class="d-flex align-items-center gap-3">
                            <span class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                                <i class="fas fa-layer-group"></i>
                            </span>
                            <span class="flex-grow-1">
                                <span class="d-block fw-bold text-dark">{{ $fund['name'] }}</span>
                                <span class="small text-muted">{{ $symbol }}</span>
                            </span>
                            <span class="small text-muted text-end">Request<br><i class="fas fa-chevron-right"></i></span>
                        </span>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
            <h5 class="fw-bold text-dark mb-0">Your fund requests</h5>
            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">{{ $trades->count() }} recent</span>
        </div>

        @forelse ($trades as $trade)
            <div class="border rounded-4 p-3 mb-2">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary me-1">{{ $trade->asset_symbol }}</span>
                        <strong class="text-dark">{{ $trade->asset_name }}</strong>
                        <div class="small text-muted mt-2">
                            {{ $trade->type === 'sell' ? 'Redeem' : 'Buy' }} request ·
                            ${{ number_format($trade->amount_usd, 2) }} · {{ number_format($trade->quantity, 6) }} units
                        </div>
                        <div class="small text-muted mt-1">{{ $trade->created_at->format('M j, Y g:i A') }}</div>
                    </div>
                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning-emphasis">{{ ucfirst($trade->status) }}</span>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i class="fas fa-layer-group fs-2 mb-2"></i>
                <p class="mb-0">No fund requests yet. Choose a category above to submit a request.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="fundOrderModal" tabindex="-1" aria-labelledby="fundOrderModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form method="POST" action="{{ route('user.investment.order') }}">
                @csrf
                <input type="hidden" name="asset_symbol" id="fundSymbolInput">
                <input type="hidden" name="order_type" value="market">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="fundOrderModalTitle">Fund Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fundRequestType" class="form-label fw-semibold">Request type</label>
                        <select class="form-select" name="type" id="fundRequestType" required>
                            <option value="buy">Buy</option>
                            <option value="sell">Redeem</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fundRequestAmount" class="form-label fw-semibold">Amount (USD)</label>
                        <input type="number" name="amount_usd" id="fundRequestAmount" class="form-control" min="0.01" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="mb-3">
                        <label for="fundRequestQuantity" class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" id="fundRequestQuantity" class="form-control" min="0.000001" step="0.000001" placeholder="0.000000" required>
                    </div>
                    <div class="small text-muted">Fund NAVs are unavailable. This request will remain pending; no order will be executed and no balance will be changed.</div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary rounded-pill w-100">Submit Fund Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('fundOrderModal').addEventListener('show.bs.modal', function (event) {
            const fund = event.relatedTarget;
            document.getElementById('fundSymbolInput').value = fund.dataset.fundSymbol;
            document.getElementById('fundOrderModalTitle').textContent =
                `Request ${fund.dataset.fundName} (${fund.dataset.fundSymbol})`;
        });
    });
</script>

@include('user.footer')
