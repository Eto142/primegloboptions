@include('user.header')

<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-extrabold text-dark mb-1">Account Profile & Security</h3>
            <p class="text-muted small mb-0">Manage your personal credentials, contact info, security settings, and KYC identity verification.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary rounded-pill px-3.5 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0284c7, #C9A227); border: none;" data-bs-toggle="modal" data-bs-target="#kycModal">
                <i class="fas fa-id-card"></i> KYC Verification Portal
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-exclamation-circle fs-4 text-danger"></i>
            <div><strong>Error:</strong> {{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 p-3 mb-4" role="alert">
            <i class="fas fa-check-circle fs-4 text-success"></i>
            <div><strong>Profile Updated:</strong> {{ session('status') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- User Profile Header Card -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4 bg-white">
        <div class="p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 40%, #023635 80%, #C9A227 100%); min-height: 140px; position: relative;">
            <div style="position: absolute; right: 20px; bottom: 10px; color: rgba(255,255,255,0.05); font-size: 3rem; font-weight: 900; pointer-events: none;">PROFILE</div>
        </div>

        <div class="card-body p-4 pt-0 position-relative">
            <div class="d-flex align-items-end flex-wrap gap-4" style="margin-top: -60px;">
                <div class="position-relative">
                    <img src="{{ Auth::user()->display_picture ? Storage::url(Auth::user()->display_picture) : asset('uploads/display/avatar.jpg') }}" class="rounded-circle border border-4 border-white shadow-lg bg-white" alt="Avatar" style="width: 120px; height: 120px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute bottom-0 end-0 p-2" onclick="document.getElementById('profileDpInput').click();" title="Change Avatar">
                        <i class="fas fa-camera text-primary"></i>
                    </button>
                    <form id="dpForm" action="{{ route('user.personal.dp') }}" method="POST" enctype="multipart/form-data" class="d-none">
                        @csrf
                        <input type="file" id="profileDpInput" name="image" accept="image/*" onchange="document.getElementById('dpForm').submit();" />
                    </form>
                </div>

                <div class="flex-grow-1 mb-2">
                    <h4 class="fw-extrabold text-dark mb-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill font-monospace fw-bold">{{ Auth::user()->account_type }} Account</span>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-bold"><i class="fas fa-shield-alt me-1"></i> Account Active</span>
                        <span class="text-muted small font-monospace"><i class="far fa-credit-card me-1"></i> {{ Auth::user()->account_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs & Content -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs nav-fill border-0" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-3.5 fw-bold" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab"><i class="fas fa-user-circle me-1.5"></i> Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3.5 fw-bold" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab"><i class="fas fa-edit me-1.5"></i> Edit Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3.5 fw-bold" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab"><i class="fas fa-lock me-1.5"></i> Password & Security</button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="tab-content" id="profileTabContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-4">Personal Information Summary</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Full Name</span>
                                <span class="fw-bold text-dark fs-6">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Email Address</span>
                                <span class="fw-bold text-dark fs-6">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Phone Number</span>
                                <span class="fw-bold text-dark fs-6">{{ Auth::user()->phone_number ?? Auth::user()->phone ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Date of Birth</span>
                                <span class="fw-bold text-dark fs-6">{{ Auth::user()->dob ? \Carbon\Carbon::parse(Auth::user()->dob)->format('M d, Y') : 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Gender</span>
                                <span class="fw-bold text-dark fs-6 text-capitalize">{{ Auth::user()->gender ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Country / Nationality</span>
                                <span class="fw-bold text-dark fs-6">{{ Auth::user()->country ?? 'Not specified' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3.5 rounded-3 bg-light border">
                                <span class="text-muted small d-block mb-1">Residential Address</span>
                                <span class="fw-bold text-dark fs-6">{{ Auth::user()->address ?? 'Not specified' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile Tab -->
                <div class="tab-pane fade" id="edit" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-4">Update Contact & Personal Information</h5>
                    <form action="{{ route('user.personal.details') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase">First Name</label>
                                <input type="text" name="first_name" class="form-control py-2.5" value="{{ Auth::user()->first_name }}" required />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase">Last Name</label>
                                <input type="text" name="last_name" class="form-control py-2.5" value="{{ Auth::user()->last_name }}" required />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase">Email Address</label>
                                <input type="email" name="email" class="form-control py-2.5" value="{{ Auth::user()->email }}" required />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase">Phone Number</label>
                                <input type="tel" name="user_phone" class="form-control py-2.5" value="{{ Auth::user()->phone_number ?? Auth::user()->phone }}" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase">Date of Birth</label>
                                <input type="date" name="dob" class="form-control py-2.5" value="{{ Auth::user()->dob }}" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark small text-uppercase">Gender</label>
                                <select name="gender" class="form-select py-2.5">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small text-uppercase">Residential Address</label>
                                <textarea name="user_address" class="form-control py-2.5" rows="3">{{ Auth::user()->address }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary rounded-3 px-4 py-2.5 fw-bold" style="background: linear-gradient(135deg, #0284c7, #C9A227); border: none;">
                                <i class="fas fa-save me-1.5"></i> Save Profile Details
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Password & Security Tab -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <h5 class="fw-bold text-dark mb-4">Change Account Security Password</h5>
                    <form action="{{ route('user.update-password') }}" method="POST">
                        @csrf
                        <div class="row g-3 max-w-lg">
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small text-uppercase">Current Password</label>
                                <input type="password" name="old_password" class="form-control py-2.5" required />
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small text-uppercase">New Password</label>
                                <input type="password" name="new_password" class="form-control py-2.5" required />
                                <small class="text-muted mt-1 d-block">Minimum 8 characters with letters, numbers & symbols.</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark small text-uppercase">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control py-2.5" required />
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success rounded-3 px-4 py-2.5 fw-bold" style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                                <i class="fas fa-key me-1.5"></i> Update Security Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KYC Modal -->
<div class="modal fade" id="kycModal" tabindex="-1" aria-labelledby="kycModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-4" style="background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10">
                        <i class="fas fa-id-card text-info fs-5"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mb-0" id="kycModalTitle">Identity Verification (KYC)</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('user.upload.kyc') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">Driver's License Document</label>
                        <input type="file" name="driver_license" class="form-control py-2" accept="image/*,.pdf" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small text-uppercase">International Passport</label>
                        <input type="file" name="pass" class="form-control py-2" accept="image/*,.pdf" required />
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark small text-uppercase">National Residence ID Card</label>
                        <input type="file" name="card" class="form-control py-2" accept="image/*,.pdf" required />
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3 py-2.5" style="background: linear-gradient(135deg, #0284c7 0%, #C9A227 100%); border: none;">
                            <i class="fas fa-upload me-1.5"></i> Submit Documents for Verification
                        </button>
                        <button type="button" class="btn btn-light fw-bold text-muted py-2.5" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('user.footer')