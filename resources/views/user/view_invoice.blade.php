@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            @foreach($invoice as $item)
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4" id="printableReceipt">
                    <!-- Bank Official Header -->
                    <div class="card-header p-4 p-md-5 border-0 text-white position-relative" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #023635 80%, #C9A227 100%);">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative z-1">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-30 rounded-pill px-3 py-1 font-monospace fw-bold">
                                        <i class="fas fa-check-circle me-1"></i> OFFICIAL BANK STATEMENT RECEIPT
                                    </span>
                                </div>
                                <h3 class="fw-extrabold text-white mb-1">Transaction Invoice</h3>
                                <p class="text-white-50 font-monospace small mb-0">Ref #: {{ $item->transaction_ref }}</p>
                            </div>
                            <div class="text-end">
                                <h4 class="fw-extrabold text-white font-manrope mb-0">TOP SAVER TRUST</h4>
                                <span class="text-white-50 small">Customer Account Services</span>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Content Body -->
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4 mb-4 pb-4 border-bottom">
                            <div class="col-sm-6">
                                <span class="text-muted small text-uppercase font-monospace d-block mb-1">Account Holder</span>
                                <h6 class="fw-bold text-dark mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                                <p class="text-muted small mb-0">{{ Auth::user()->address ?? 'Customer Registered Address' }}</p>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <span class="text-muted small text-uppercase font-monospace d-block mb-1">Receipt Date & Status</span>
                                <h6 class="fw-bold text-dark mb-1">{{ \Carbon\Carbon::parse($item->created_at)->format('F j, Y • h:i A') }}</h6>
                                <span class="badge bg-success text-white px-3 py-1 font-monospace fw-bold">COMPLETED</span>
                            </div>
                        </div>

                        <!-- Amount Display -->
                        <div class="p-4 rounded-4 bg-light border text-center mb-4">
                            <span class="text-muted small text-uppercase font-monospace d-block mb-1">Total Transaction Amount</span>
                            <h1 class="display-5 fw-extrabold text-dark font-monospace mb-0" style="color: #C9A227 !important;">
                                {{ Auth::user()->currency }}{{ number_format($item->amount, 2) }}
                            </h1>
                        </div>

                        <!-- Details Table -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="font-monospace text-muted small">TRANSACTION DESCRIPTION</th>
                                        <th class="font-monospace text-muted small">REFERENCE CODE</th>
                                        <th class="font-monospace text-muted small text-end">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $item->transaction_description ?? $item->transaction ?? 'Transaction' }}</td>
                                        <td class="font-monospace text-dark">{{ $item->transaction_ref }}</td>
                                        <td class="fw-extrabold font-monospace text-dark text-end">{{ Auth::user()->currency }}{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Security & Verification Stamp -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-3.5 rounded-3 bg-light border">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-shield-check text-success fs-2"></i>
                                <div>
                                    <div class="fw-bold text-dark small">Digitally Encrypted & Verified</div>
                                    <div class="text-muted small">Top Saver Trust Bank Digital Signature Secured</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-bold" onclick="window.print();">
                                    <i class="fas fa-print me-1.5"></i> Print Invoice
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@include('user.footer')
