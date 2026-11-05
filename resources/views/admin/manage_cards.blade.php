@include('admin.header')

<div class="main-content p-3 p-md-4" id="mainContent">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="h4 mb-2 mb-md-0">My Cards</h1>
        <button class="btn btn-primary btn-sm">
            <i class="fas fa-download me-2"></i>Export Cards
        </button>
    </div>

    <div class="row g-3">
        @forelse($user_cards as $index => $detail)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="card-block p-3 position-relative" style="background-color: #305C89; border-radius: 15px; color: #fff;">
                
                <!-- Number Badge -->
                <span class="position-absolute top-0 start-0 badge-number">{{ $index + 1 }}</span>

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <img src="{{ asset('mastercard.png') }}" alt="MasterCard" class="card-logo">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="site-logo">
                </div>

                <h6 class="fw-semibold mb-2">{{ Auth::guard('admin')->user()->email ?? 'Admin' }}</h6>

                <div class="card-number mb-2">
                    <small class="text-light">Card Number</small><br>
                    <strong>{{ implode(' ', str_split($detail->card_number, 4)) }}</strong>
                </div>

                <div class="d-flex justify-content-between small mb-2">
                    <div>
                        <span class="d-block text-light">Expiry</span>
                        {{ \Carbon\Carbon::parse($detail->card_expiry)->format('m/y') }}
                    </div>
                    <div class="text-end">
                        <span class="d-block text-light">CCV</span>
                        {{ $detail->card_cvc }}
                    </div>
                </div>

                <hr style="border-color: rgba(255,255,255,0.2); margin: 0.5rem 0;">

                <div class="d-flex justify-content-between small">
                    {{-- <div><strong>₦{{ number_format($detail->amount, 2, '.', ',') }}</strong></div> --}}
                    <div>
                        @if($detail->status == '1')
                            <span class="badge bg-success">Approved</span>
                        @elseif($detail->status == '0')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @else
                            <span class="badge bg-danger">Declined</span>
                        @endif
                    </div>
                </div>

                <div class="mt-2 small text-light">
                    <div><strong>ID:</strong> {{ $detail->transaction_id }}</div>
                    <div><strong>Date:</strong> {{ \Carbon\Carbon::parse($detail->created_at)->format('M j, Y g:i A') }}</div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No cards found.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($user_cards->hasPages())
    <div class="card-footer mt-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-2 mb-md-0 text-muted small">
                Showing 
                <span class="fw-semibold">{{ $user_cards->firstItem() ?? 0 }}</span> 
                to 
                <span class="fw-semibold">{{ $user_cards->lastItem() ?? 0 }}</span> 
                of 
                <span class="fw-semibold">{{ $user_cards->total() }}</span> 
                entries
            </div>
            <div class="pagination-container">
                {{ $user_cards->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.card-block {
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    transition: transform .3s ease, box-shadow .3s ease;
    height: 100%;
}
.card-block:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.3);
}

.card-number strong {
    font-size: 1rem;
    letter-spacing: 2px;
}

.card-logo {
    width: 45px;
    height: auto;
}
.site-logo {
    width: 45px;
    height: auto;
    opacity: 0.9;
}

.badge {
    font-size: 0.7rem;
    padding: 0.3em 0.6em;
    border-radius: 8px;
}

.badge-number {
    background: #ffce00;
    color: #000;
    font-weight: bold;
    padding: 0.25rem 0.5rem;
    border-radius: 50%;
    font-size: 0.8rem;
}

@media (max-width: 768px) {
    .card-number strong {
        font-size: 0.95rem;
    }
    .card-logo, .site-logo {
        width: 40px;
    }
}
</style>

@include('admin.footer')
