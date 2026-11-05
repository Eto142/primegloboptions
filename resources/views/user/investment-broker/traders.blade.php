@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-users"></i> Expert Traders</div>
    <input type="text" id="traderSearch" class="form-ib" style="width:auto;" placeholder="Search traders...">
</div>

<div class="row g-3" id="tradersGrid">
    @forelse ($traders ?? [] as $trader)
    <div class="col-12 col-md-6 col-xl-4 trader-card" data-name="{{ strtolower($trader->name) }}">
        <div class="ib-card h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
                @if ($trader->image)
                    <img src="{{ asset('uploads/trader/' . $trader->image) }}" alt="{{ $trader->name }}" style="width:56px;height:56px;border-radius:14px;object-fit:cover;border:2px solid var(--gold);">
                @else
                    <div style="width:56px;height:56px;border-radius:14px;background:rgba(201,162,39,0.12);display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:var(--gold);"><i class="fas fa-user-tie"></i></div>
                @endif
                <div>
                    <h6 class="fw-bold mb-0" style="color:#fff;">{{ $trader->name }}</h6>
                    <div class="small" style="color:var(--text-muted);">{{ $trader->copier ?? 0 }} copiers</div>
                </div>
            </div>
            <div class="row text-center g-2 mb-3">
                <div class="col-6">
                    <div class="small" style="color:var(--text-muted);">Win Rate</div>
                    <div class="fw-bold" style="color:var(--success);">{{ $trader->win_rate }}%</div>
                </div>
                <div class="col-6">
                    <div class="small" style="color:var(--text-muted);">Profit Share</div>
                    <div class="fw-bold" style="color:var(--gold);">{{ $trader->profit_share }}%</div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-gold flex-fill" onclick="toggleCopy({{ $trader->id }})" id="copyBtn_{{ $trader->id }}">
                    <i class="fas fa-copy me-1"></i> <span id="copyText_{{ $trader->id }}">Copy Now</span>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-users"></i></div>
            <div style="font-weight:800; color:#fff; margin-bottom:8px;">No Traders Available</div>
            <div style="font-size:0.82rem; color:var(--text-muted);">Expert traders will appear here once added by admin.</div>
        </div>
    </div>
    @endforelse
</div>

<script>
function toggleCopy(id) {
    const btn = document.getElementById('copyBtn_' + id);
    const text = document.getElementById('copyText_' + id);
    const isCopying = localStorage.getItem('isTextCopying_' + id) === 'true';
    if (isCopying) {
        localStorage.removeItem('isTextCopying_' + id);
        text.textContent = 'Copy Now';
        btn.classList.remove('btn-outline-gold');
        btn.classList.add('btn-gold');
    } else {
        localStorage.setItem('isTextCopying_' + id, 'true');
        text.textContent = 'Cancel Copy';
        btn.classList.remove('btn-gold');
        btn.classList.add('btn-outline-gold');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.trader-card').forEach(function(card) {
        const id = card.querySelector('[id^="copyBtn_"]').id.replace('copyBtn_', '');
        if (localStorage.getItem('isTextCopying_' + id) === 'true') {
            const btn = document.getElementById('copyBtn_' + id);
            const text = document.getElementById('copyText_' + id);
            text.textContent = 'Cancel Copy';
            btn.classList.remove('btn-gold');
            btn.classList.add('btn-outline-gold');
        }
    });
    document.getElementById('traderSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.trader-card').forEach(function(card) {
            card.style.display = card.dataset.name.includes(q) ? '' : 'none';
        });
    });
});
</script>

@include('user.investment-broker.layout.footer')
