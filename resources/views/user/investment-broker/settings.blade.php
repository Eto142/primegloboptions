@include('user.investment-broker.layout.header')

<div class="section-head">
    <div class="section-title"><i class="fas fa-cog"></i> Account Settings</div>
</div>

<div class="row g-3">
    <div class="col-12 col-md-6">
        <div class="ib-card">
            <div class="ib-card-title"><i class="fas fa-user me-2" style="color:var(--gold);"></i>Personal Information</div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">First Name</label><input type="text" class="form-ib" value="{{ Auth::user()->first_name ?? '' }}"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Last Name</label><input type="text" class="form-ib" value="{{ Auth::user()->last_name ?? '' }}"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Email</label><input type="email" class="form-ib" value="{{ Auth::user()->email ?? '' }}"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Phone</label><input type="text" class="form-ib" value="{{ Auth::user()->phone ?? '' }}"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Country</label><input type="text" class="form-ib" value="{{ Auth::user()->country ?? '' }}"></div>
            <button class="btn-gold w-100"><i class="fas fa-save me-1"></i> Save Changes</button>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="ib-card">
            <div class="ib-card-title"><i class="fas fa-lock me-2" style="color:var(--gold);"></i>Change Password</div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Current Password</label><input type="password" class="form-ib" placeholder="••••••••"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">New Password</label><input type="password" class="form-ib" placeholder="••••••••"></div>
            <div class="mb-3"><label class="form-label small" style="color:var(--text-muted);">Confirm Password</label><input type="password" class="form-ib" placeholder="••••••••"></div>
            <button class="btn-outline-gold w-100"><i class="fas fa-key me-1"></i> Update Password</button>
        </div>
    </div>
</div>

@include('user.investment-broker.layout.footer')
