@include('user.header')

<style>
    .bill-tile {
        min-height: 140px;
        border: 0;
        border-radius: 20px;
        background: #f8fafc;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .bill-tile:hover,
    .bill-tile:focus-visible {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.1);
    }

    .bill-tile i {
        color: #007875;
        font-size: 1.8rem;
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="mb-4">
        <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 mb-2">
            <i class="fas fa-file-invoice-dollar me-1"></i> BILL PAYMENTS
        </span>
        <h2 class="fw-bold text-dark mb-1">Pay Bills</h2>
        <p class="text-muted mb-0">Select a biller below to proceed.</p>
    </div>

    <div class="row g-3">
        @php
            $billCategories = [
                ['name' => 'Electricity', 'icon' => 'fa-bolt'],
                ['name' => 'Water', 'icon' => 'fa-tint'],
                ['name' => 'Internet', 'icon' => 'fa-wifi'],
                ['name' => 'Mobile Top-Up', 'icon' => 'fa-mobile-alt'],
                ['name' => 'Cable TV', 'icon' => 'fa-tv'],
                ['name' => 'Gas', 'icon' => 'fa-fire'],
            ];
        @endphp

        @foreach ($billCategories as $category)
            <div class="col-6 col-md-4">
                <button
                    type="button"
                    class="bill-tile w-100 p-3 text-center shadow-sm"
                    data-bill-type="{{ $category['name'] }}"
                    data-bs-toggle="modal"
                    data-bs-target="#billInstructionModal"
                >
                    <i class="fas {{ $category['icon'] }} d-block mb-3" aria-hidden="true"></i>
                    <span class="fw-semibold text-dark">{{ $category['name'] }}</span>
                </button>
            </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="billInstructionModal" tabindex="-1" aria-labelledby="billInstructionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 me-2">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h5 class="modal-title fw-bold" id="billInstructionTitle">Payment instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-muted" id="billInstructionMessage"></div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const billModal = document.getElementById('billInstructionModal');

        billModal.addEventListener('show.bs.modal', function (event) {
            const billType = event.relatedTarget.dataset.billType;
            document.getElementById('billInstructionMessage').textContent =
                `You will receive ${billType} payment instructions soon. Please check your email or phone for details. Thank you for your patience.`;
        });
    });
</script>

@include('user.footer')
