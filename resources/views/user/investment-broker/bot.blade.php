@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-robot"></i> QAI Protect — Trading Bot</div>
</div>

@if (Auth::user()->bot_status == '1')
    <div class="ib-card text-center" style="background:linear-gradient(135deg, rgba(0,211,149,0.08), rgba(0,211,149,0.02));border-color:rgba(0,211,149,0.2);">
        <div style="width:80px;height:80px;border-radius:20px;background:rgba(0,211,149,0.15);display:flex;align-items:center;justify-content:center;font-size:2rem;color:var(--success);margin:0 auto 20px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h5 class="fw-bold mb-2" style="color:var(--success);">Bot Activated</h5>
        <div style="color:var(--text-muted);">Your QAI Protect trading bot is active and running.</div>
    </div>
@else
    <div class="ib-card text-center" style="background:linear-gradient(135deg, rgba(245,158,11,0.08), rgba(245,158,11,0.02));border-color:rgba(245,158,11,0.2);">
        <div style="width:80px;height:80px;border-radius:20px;background:rgba(245,158,11,0.15);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fbbf24;margin:0 auto 20px;">
            <i class="fas fa-robot"></i>
        </div>
        <h5 class="fw-bold mb-2" style="color:#fbbf24;">Bot Not Activated</h5>
        <div style="color:var(--text-muted);margin-bottom:24px;">Activate the QAI Protect trading bot for $3,500 to automate your trades.</div>
        <button class="btn-gold" data-bs-toggle="modal" data-bs-target="#botModal"><i class="fas fa-bolt me-1"></i> Activate Bot</button>
    </div>
@endif

<div class="modal fade" id="botModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background:var(--dark2);border:1px solid var(--border);border-radius:20px;">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
                <h5 class="modal-title fw-bold" style="color:#fff;">Activate Trading Bot — $3,500</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('user.investments.deposit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:var(--text-muted);">Upload Proof of Payment</label>
                        <input type="file" name="image" class="form-ib" accept="image/*" required style="padding:10px;">
                    </div>
                    <button type="submit" class="btn-gold w-100"><i class="fas fa-upload me-1"></i> Upload & Activate</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('user.investment-broker.layout.footer')
