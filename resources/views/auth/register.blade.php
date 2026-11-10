<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Account Registration - PRIMEGLOBOPTIONS</title>
<link rel="shortcut icon" href="{{ asset('home/asset/img/logo.png') }}" type="image/png">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">

<!-- Remix Icons & Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
  --primary: #C9A227;
  --primary-dark: #9E7C14;
  --primary-light: #E8C14A;
  --accent: #C9A227;
  --navy: #0f172a;
  --navy-dark: #082f49;
  --txt: #0f172a;
  --txt-muted: #64748b;
  --bg-light: #f8fafc;
  --card-bg: #ffffff;
  --border: #e2e8f0;
  --error: #ef4444;
  --success: #10b981;
  --radius: 14px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background-color: var(--bg-light);
  color: var(--txt);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Header */
.auth-header {
  background: var(--card-bg);
  border-bottom: 1px solid var(--border);
  padding: 14px 28px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.auth-header-logo img { height: 48px; width: auto; }
.auth-header-action {
  font-size: 13.5px;
  font-weight: 600;
  color: var(--primary);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 18px;
  border-radius: 10px;
  border: 1.5px solid rgba(201,162,39,.35);
  transition: all .25s ease;
}
.auth-header-action:hover {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
}

/* Main Container */
.reg-wrapper {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 32px 16px;
}

.reg-card {
  width: 100%;
  max-width: 900px;
  background: var(--card-bg);
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(15,23,42,.08), 0 1px 3px rgba(0,0,0,.05);
  border: 1px solid var(--border);
  overflow: hidden;
}

/* Card Header & Wizard Steps */
.reg-card-head {
  background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
  color: #fff;
  padding: 32px 36px 24px;
}
.reg-card-head h1 { font-family: 'Manrope', sans-serif; font-size: 26px; font-weight: 800; margin-bottom: 6px; }
.reg-card-head p { font-size: 14px; color: rgba(255,255,255,.7); }

/* Progress Bar */
.wizard-progress {
  display: flex;
  background: #f1f5f9;
  border-bottom: 1px solid var(--border);
  padding: 14px 24px;
  overflow-x: auto;
  gap: 12px;
}
.wiz-step {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--txt-muted);
  white-space: nowrap;
  opacity: .65;
  transition: all .25s ease;
}
.wiz-step.active { color: var(--primary); opacity: 1; }
.wiz-step.completed { color: var(--success); opacity: 1; }
.wiz-step-num {
  width: 24px; height: 24px;
  border-radius: 50%;
  background: #cbd5e1;
  color: #fff;
  font-size: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}
.wiz-step.active .wiz-step-num { background: var(--primary); }
.wiz-step.completed .wiz-step-num { background: var(--success); }
.wiz-step-sep { color: #cbd5e1; font-size: 12px; }

/* Wizard Form Body */
.reg-card-body { padding: 36px 36px 28px; }
.form-step { display: none; }
.form-step.active { display: block; animation: fadeIn .3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

.step-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--txt);
  margin-bottom: 6px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.step-title i { color: var(--primary); }
.step-desc { font-size: 13.5px; color: var(--txt-muted); margin-bottom: 24px; }

/* Form Grids & Inputs */
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 13px; font-weight: 600; color: var(--txt); margin-bottom: 6px; }
.form-label span.req { color: var(--error); margin-left: 2px; }

.form-control {
  width: 100%;
  padding: 11px 14px;
  font-size: 14px;
  font-family: 'Inter', sans-serif;
  color: var(--txt);
  background: var(--bg-light);
  border: 1.5px solid var(--border);
  border-radius: 10px;
  transition: all .2s ease;
}
.form-control:focus {
  outline: none;
  background: #fff;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(201,162,39,.14);
}

select.form-control {
  appearance: none;
  background-image: url("data:image/svg+xml;utf8,<svg fill='%2300a9a4' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 16px;
}

.input-wrap { position: relative; display: flex; align-items: center; }
.toggle-pwd {
  position: absolute; right: 14px;
  background: none; border: none;
  color: #94a3b8; cursor: pointer;
  font-size: 16px; transition: color .2s;
}
.toggle-pwd:hover { color: var(--primary); }

.error-txt { color: var(--error); font-size: 12px; margin-top: 4px; font-weight: 500; }

/* Password Strength Meter */
.pwd-strength { margin-top: 8px; }
.pwd-strength-bar { height: 4px; width: 100%; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 4px; }
.pwd-strength-fill { height: 100%; width: 0%; transition: width .3s, background-color .3s; }
.pwd-strength-label { font-size: 11.5px; font-weight: 600; color: var(--txt-muted); }

/* File Upload Zone */
.upload-box {
  border: 2px dashed var(--border);
  background: var(--bg-light);
  border-radius: 14px;
  padding: 32px 20px;
  text-align: center;
  cursor: pointer;
  transition: all .25s ease;
  position: relative;
}
.upload-box:hover { border-color: var(--primary); background: rgba(201,162,39,.04); }
.upload-icon { font-size: 38px; color: var(--primary); margin-bottom: 10px; }
.upload-box p { font-size: 13.5px; color: var(--txt-muted); margin-bottom: 12px; }
.upload-file-btn {
  display: inline-flex; align-items: center; gap: 6px;
  font-size: 13px; font-weight: 600;
  color: #fff; background: var(--primary);
  padding: 8px 18px; border-radius: 8px; cursor: pointer;
}
.upload-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.preview-img { max-width: 110px; max-height: 110px; border-radius: 50%; object-fit: cover; margin: 12px auto 0; border: 3px solid var(--primary); display: none; }

/* Checkbox Label */
.terms-label { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 13.5px; color: var(--txt); }
.terms-label input { accent-color: var(--primary); width: 18px; height: 18px; margin-top: 2px; flex-shrink: 0; }

/* Buttons & Navigation */
.wiz-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 28px;
  padding-top: 20px;
  border-top: 1px solid var(--border);
}
.btn-wiz {
  padding: 12px 24px;
  font-size: 14px;
  font-weight: 700;
  font-family: 'Inter', sans-serif;
  border-radius: 10px;
  cursor: pointer;
  transition: all .25s ease;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.btn-wiz-prev { background: #e2e8f0; color: var(--txt); }
.btn-wiz-prev:hover { background: #cbd5e1; }
.btn-wiz-next { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: #fff; box-shadow: 0 4px 14px rgba(201,162,39,.30); }
.btn-wiz-next:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(201,162,39,.40); }

.btn-spinner {
  display: none;
  width: 16px; height: 16px;
  border: 2px solid rgba(255,255,255,.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.auth-footer-note { text-align: center; margin-top: 20px; font-size: 13.5px; color: var(--txt-muted); }
.auth-footer-note a { color: var(--primary); font-weight: 700; text-decoration: none; }

footer { text-align: center; padding: 16px; font-size: 12px; color: var(--txt-muted); border-top: 1px solid var(--border); background: var(--card-bg); }

@media (max-width: 768px) {
  .reg-card-body { padding: 24px 20px; }
  .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
  .reg-card-head { padding: 24px 20px; }
  .reg-card-head h1 { font-size: 22px; }
}
</style>
</head>
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '5ae069ee92abadaeac7e584b5df3bf32c9b0ed59';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript>Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>

<body>

  <!-- Header Navigation -->
  <header class="auth-header">
    <a href="/" class="auth-header-logo">
      <img src="{{ asset('home/asset/img/logo.png') }}" alt="PRIMEGLOBOPTIONS">
    </a>
    <a href="{{ route('login') }}" class="auth-header-action">
      <i class="ri-login-box-line"></i> Already a Client? Sign In
    </a>
  </header>

  <!-- Main Enrollment Wrapper -->
  <main class="reg-wrapper">
    <div class="reg-card">

      <!-- Header Title -->
      <div class="reg-card-head">
        <h1>Investment &amp; Banking Account Enrollment</h1>
        <p>Complete the application below to open your PRIMEGLOBOPTIONS investment broker and online banking account in minutes.</p>
      </div>

      <!-- Step Wizard Progress Bar -->
      <div class="wizard-progress">
        <div class="wiz-step active" id="wiz-step-1">
          <span class="wiz-step-num">1</span> Personal Details
        </div>
        <span class="wiz-step-sep"><i class="ri-arrow-right-s-line"></i></span>
        <div class="wiz-step" id="wiz-step-2">
          <span class="wiz-step-num">2</span> Account &amp; PIN
        </div>
        <span class="wiz-step-sep"><i class="ri-arrow-right-s-line"></i></span>
        <div class="wiz-step" id="wiz-step-3">
          <span class="wiz-step-num">3</span> Security
        </div>
        <span class="wiz-step-sep"><i class="ri-arrow-right-s-line"></i></span>
        <div class="wiz-step" id="wiz-step-4">
          <span class="wiz-step-num">4</span> Next of Kin
        </div>
        <span class="wiz-step-sep"><i class="ri-arrow-right-s-line"></i></span>
        <div class="wiz-step" id="wiz-step-5">
          <span class="wiz-step-num">5</span> Photo &amp; Terms
        </div>
      </div>

      <!-- Form Body -->
      <div class="reg-card-body">

        @if($errors->any())
          <div style="padding: 12px 16px; border-radius: 10px; background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 13px; margin-bottom: 24px;">
            <strong style="display:flex;align-items:center;gap:6px;margin-bottom:4px;"><i class="ri-error-warning-fill"></i> Please fix the following errors:</strong>
            <ul style="padding-left: 18px; margin: 0;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="registrationForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data" novalidate>
          @csrf

          <!-- STEP 1: PERSONAL INFORMATION -->
          <div class="form-step active" id="step-1">
            <div class="step-title"><i class="ri-user-settings-line"></i> Step 1: Personal Information</div>
            <div class="step-desc">Enter your basic identification details as shown on your official government ID.</div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">First Name <span class="req">*</span></label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g. John" value="{{ old('first_name') }}" required>
                <div class="error-txt" id="err-first_name"></div>
              </div>
              <div class="form-group">
                <label class="form-label">Last Name <span class="req">*</span></label>
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g. Smith" value="{{ old('last_name') }}" required>
                <div class="error-txt" id="err-last_name"></div>
              </div>
            </div>

            <div class="form-grid-3">
              <div class="form-group">
                <label class="form-label">Gender <span class="req">*</span></label>
                <select name="gender" id="gender" class="form-control" required>
                  <option value="">Select Gender</option>
                  <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                  <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                <div class="error-txt" id="err-gender"></div>
              </div>
              <div class="form-group">
                <label class="form-label">Email Address <span class="req">*</span></label>
                <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com" value="{{ old('email') }}" required autocomplete="email">
                <div class="error-txt" id="err-email"></div>
              </div>
              <div class="form-group">
                <label class="form-label">Phone Number <span class="req">*</span></label>
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="+1 (555) 000-0000" value="{{ old('phone') }}" required>
                <div class="error-txt" id="err-phone"></div>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Date of Birth <span class="req">*</span></label>
              <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" required>
              <div class="error-txt" id="err-dob"></div>
            </div>
          </div>

          <!-- STEP 2: ACCOUNT PREFERENCES -->
          <div class="form-step" id="step-2">
            <div class="step-title"><i class="ri-bank-card-line"></i> Step 2: Account Preferences &amp; Security PIN</div>
            <div class="step-desc">Choose your preferred account type, currency, and create a 4-digit transfer PIN.</div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Account Type <span class="req">*</span></label>
                <select name="account_type" id="account_type" class="form-control" required>
                  <option value="">Select Account Type</option>
                  <option value="Savings Account" {{ old('account_type') == 'Savings Account' ? 'selected' : '' }}>Personal Savings Account</option>
                  <option value="Checking Account" {{ old('account_type') == 'Checking Account' ? 'selected' : '' }}>Checking / Everyday Account</option>
                  <option value="Corporate Account" {{ old('account_type') == 'Corporate Account' ? 'selected' : '' }}>Corporate &amp; Business Account</option>
                  <option value="Fixed Deposit Account" {{ old('account_type') == 'Fixed Deposit Account' ? 'selected' : '' }}>Tenured Fixed Deposit Account</option>
                </select>
                <div class="error-txt" id="err-account_type"></div>
              </div>

              <div class="form-group">
                <label class="form-label">Country of Residence <span class="req">*</span></label>
                <select name="country" id="country" class="form-control" required>
                  <option value="">Select Country</option>
                  <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                  <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                  <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                  <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                  <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                  <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                  <option value="Switzerland" {{ old('country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                  <option value="Japan" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                  <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other International</option>
                </select>
                <div class="error-txt" id="err-country"></div>
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Base Account Currency <span class="req">*</span></label>
                <select name="currency" id="currency" class="form-control" required>
                  <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - United States Dollar ($)</option>
                  <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro (�)</option>
                  <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound (�)</option>
                  <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar (C$)</option>
                  <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar (A$)</option>
                  <option value="CHF" {{ old('currency') == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc (CHF)</option>
                </select>
                <div class="error-txt" id="err-currency"></div>
              </div>

              <div class="form-group">
                <label class="form-label">4-Digit Transaction Security PIN <span class="req">*</span></label>
                <input type="password" name="transaction_pin" id="transaction_pin" class="form-control" placeholder="e.g. 4812" maxlength="4" pattern="\d{4}" required>
                <div class="error-txt" id="err-transaction_pin"></div>
              </div>
            </div>
          </div>

          <!-- STEP 3: SECURITY & PASSWORD -->
          <div class="form-step" id="step-3">
            <div class="step-title"><i class="ri-lock-password-line"></i> Step 3: Account Password Setup</div>
            <div class="step-desc">Set up a strong password to protect your online banking dashboard session.</div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Password <span class="req">*</span></label>
                <div class="input-wrap">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Min. 8 characters" required autocomplete="new-password">
                  <button type="button" class="toggle-pwd" data-target="password"><i class="far fa-eye"></i></button>
                </div>
                <div class="pwd-strength">
                  <div class="pwd-strength-bar"><div class="pwd-strength-fill" id="pwd-fill"></div></div>
                  <span class="pwd-strength-label" id="pwd-txt">Password Strength</span>
                </div>
                <div class="error-txt" id="err-password"></div>
              </div>

              <div class="form-group">
                <label class="form-label">Confirm Password <span class="req">*</span></label>
                <div class="input-wrap">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-enter password" required autocomplete="new-password">
                  <button type="button" class="toggle-pwd" data-target="password_confirmation"><i class="far fa-eye"></i></button>
                </div>
                <div class="error-txt" id="err-password_confirmation"></div>
              </div>
            </div>
          </div>

          <!-- STEP 4: NEXT OF KIN -->
          <div class="form-step" id="step-4">
            <div class="step-title"><i class="ri-parent-line"></i> Step 4: Next of Kin Information</div>
            <div class="step-desc">Required regulatory emergency contact details for beneficiary safety.</div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Full Name of Next of Kin <span class="req">*</span></label>
                <input type="text" name="kin_full_name" id="kin_full_name" class="form-control" placeholder="Full legal name" value="{{ old('kin_full_name') }}" required>
                <div class="error-txt" id="err-kin_full_name"></div>
              </div>

              <div class="form-group">
                <label class="form-label">Relationship <span class="req">*</span></label>
                <input type="text" name="kin_relationship" id="kin_relationship" class="form-control" placeholder="e.g. Spouse, Brother, Parent" value="{{ old('kin_relationship') }}" required>
                <div class="error-txt" id="err-kin_relationship"></div>
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Next of Kin Phone <span class="req">*</span></label>
                <input type="tel" name="kin_phone" id="kin_phone" class="form-control" placeholder="Phone number" value="{{ old('kin_phone') }}" required>
                <div class="error-txt" id="err-kin_phone"></div>
              </div>

              <div class="form-group">
                <label class="form-label">Next of Kin Email (Optional)</label>
                <input type="email" name="kin_email" id="kin_email" class="form-control" placeholder="Email address" value="{{ old('kin_email') }}">
                <div class="error-txt" id="err-kin_email"></div>
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Next of Kin Address <span class="req">*</span></label>
                <input type="text" name="kin_address" id="kin_address" class="form-control" placeholder="Residential address" value="{{ old('kin_address') }}" required>
                <div class="error-txt" id="err-kin_address"></div>
              </div>

              <div class="form-group">
                <label class="form-label">How Did You Hear About Us? (Optional)</label>
                <select name="referral_source" id="referral_source" class="form-control">
                  <option value="">Select Option</option>
                  <option value="Search Engine (Google, Bing)">Search Engine</option>
                  <option value="Social Media">Social Media</option>
                  <option value="Friend or Family Referral">Friend or Family</option>
                  <option value="Advertisement">Advertisement</option>
                </select>
              </div>
            </div>
          </div>

          <!-- STEP 5: PHOTO & TERMS -->
          <div class="form-step" id="step-5">
            <div class="step-title"><i class="ri-shield-check-line"></i> Step 5: Verification Photo &amp; Terms Agreement</div>
            <div class="step-desc">Upload a profile/ID photo (optional) and accept our digital banking terms to activate your account.</div>

            <div class="form-group">
              <label class="form-label">Profile / ID Picture (Optional)</label>
              <div class="upload-box" id="dropZone">
                <i class="ri-image-add-line upload-icon"></i>
                <p>Drag &amp; drop your profile image here, or click to browse</p>
                <span class="upload-file-btn"><i class="ri-folder-open-line"></i> Choose Photo</span>
                <input type="file" name="display_picture" id="display_picture" class="upload-input" accept="image/jpeg,image/png,image/jpg">
                <img id="imagePreview" class="preview-img" alt="Preview Image">
              </div>
            </div>

            <div class="form-group" style="margin-top:24px;">
              <label class="terms-label">
                <input type="checkbox" name="terms_agree" id="terms_agree" value="1" required>
                <span>I confirm that the information provided is accurate, and I agree to the <a href="{{ url('terms') }}" target="_blank" style="color:var(--primary);font-weight:700;">PRIMEGLOBOPTIONS Terms of Service</a> and Privacy Governance. <span class="req">*</span></span>
              </label>
              <div class="error-txt" id="err-terms_agree"></div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="wiz-actions">
            <button type="button" class="btn-wiz btn-wiz-prev" id="btnPrev" style="display:none;">
              <i class="ri-arrow-left-line"></i> Back
            </button>
            <div></div>
            <button type="button" class="btn-wiz btn-wiz-next" id="btnNext">
              Next Step <i class="ri-arrow-right-line"></i>
            </button>
            <button type="submit" class="btn-wiz btn-wiz-next" id="btnSubmit" style="display:none;">
              <span class="btn-spinner" id="submitSpinner"></span>
              <i class="ri-checkbox-circle-line"></i> Complete Enrollment
            </button>
          </div>

          <div class="auth-footer-note">
            Already have an account? <a href="{{ route('login') }}">Sign In to Portal</a>
          </div>

        </form>
      </div>

    </div>
  </main>

  <footer>
    <p>&copy; {{ date('Y') }} PRIMEGLOBOPTIONS. All rights reserved. Licensed Investment Broker &amp; Regulated Digital Banking Services.</p>
  </footer>

  <!-- Wizard JavaScript Logic -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let currentStep = 1;
      const totalSteps = 5;

      const btnNext = document.getElementById('btnNext');
      const btnPrev = document.getElementById('btnPrev');
      const btnSubmit = document.getElementById('btnSubmit');
      const submitSpinner = document.getElementById('submitSpinner');
      const regForm = document.getElementById('registrationForm');

      function updateWizardUI() {
        // Update Step displays
        for (let i = 1; i <= totalSteps; i++) {
          const stepEl = document.getElementById(`step-${i}`);
          const wizStepEl = document.getElementById(`wiz-step-${i}`);

          if (i === currentStep) {
            stepEl.classList.add('active');
            wizStepEl.classList.add('active');
            wizStepEl.classList.remove('completed');
          } else if (i < currentStep) {
            stepEl.classList.remove('active');
            wizStepEl.classList.remove('active');
            wizStepEl.classList.add('completed');
          } else {
            stepEl.classList.remove('active');
            wizStepEl.classList.remove('active');
            wizStepEl.classList.remove('completed');
          }
        }

        // Update Nav Buttons
        if (currentStep === 1) {
          btnPrev.style.display = 'none';
        } else {
          btnPrev.style.display = 'inline-flex';
        }

        if (currentStep === totalSteps) {
          btnNext.style.display = 'none';
          btnSubmit.style.display = 'inline-flex';
        } else {
          btnNext.style.display = 'inline-flex';
          btnSubmit.style.display = 'none';
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      function validateStep(stepNumber) {
        let isValid = true;
        const currentStepEl = document.getElementById(`step-${stepNumber}`);
        const inputs = currentStepEl.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
          const errDiv = document.getElementById(`err-${input.name}`);
          const isBlankRequired = input.required && input.value.trim() === '';
          if (!input.checkValidity() || isBlankRequired) {
            isValid = false;
            input.style.borderColor = 'var(--error)';
            if (errDiv) {
              errDiv.textContent = isBlankRequired || input.validity.valueMissing
                ? 'This field is required.'
                : input.validationMessage;
            }
          } else {
            input.style.borderColor = 'var(--border)';
            if (errDiv) errDiv.textContent = '';
          }
        });

        // Special password match validation on step 3
        if (stepNumber === 3) {
          const pwd = document.getElementById('password').value;
          const pwdConfirm = document.getElementById('password_confirmation').value;
          const errConfirm = document.getElementById('err-password_confirmation');

          if (pwd.length < 8) {
            isValid = false;
            document.getElementById('err-password').textContent = 'Password must be at least 8 characters.';
          }
          if (pwd !== pwdConfirm) {
            isValid = false;
            if (errConfirm) errConfirm.textContent = 'Passwords do not match.';
          }
        }

        return isValid;
      }

      function validateCurrentStep() {
        return validateStep(currentStep);
      }

      btnNext.addEventListener('click', function() {
        if (validateCurrentStep()) {
          if (currentStep < totalSteps) {
            currentStep++;
            updateWizardUI();
          }
        }
      });

      btnPrev.addEventListener('click', function() {
        if (currentStep > 1) {
          currentStep--;
          updateWizardUI();
        }
      });

      // Password Toggle
      document.querySelectorAll('.toggle-pwd').forEach(btn => {
        btn.addEventListener('click', function() {
          const targetId = this.getAttribute('data-target');
          const targetInput = document.getElementById(targetId);
          const icon = this.querySelector('i');
          if (targetInput.type === 'password') {
            targetInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
          } else {
            targetInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
          }
        });
      });

      // Password Strength Meter
      const pwdInput = document.getElementById('password');
      const pwdFill = document.getElementById('pwd-fill');
      const pwdTxt = document.getElementById('pwd-txt');

      if (pwdInput) {
        pwdInput.addEventListener('input', function() {
          const val = this.value;
          let score = 0;
          if (val.length >= 8) score += 30;
          if (/[A-Z]/.test(val)) score += 20;
          if (/[0-9]/.test(val)) score += 25;
          if (/[^A-Za-z0-9]/.test(val)) score += 25;

          pwdFill.style.width = score + '%';
          if (score < 40) {
            pwdFill.style.backgroundColor = 'var(--error)';
            pwdTxt.textContent = 'Weak Password';
            pwdTxt.style.color = 'var(--error)';
          } else if (score < 75) {
            pwdFill.style.backgroundColor = '#f59e0b';
            pwdTxt.textContent = 'Medium Password';
            pwdTxt.style.color = '#f59e0b';
          } else {
            pwdFill.style.backgroundColor = 'var(--success)';
            pwdTxt.textContent = 'Strong Password';
            pwdTxt.style.color = 'var(--success)';
          }
        });
      }

      // Profile Picture Image Preview
      const fileInput = document.getElementById('display_picture');
      const imagePreview = document.getElementById('imagePreview');

      if (fileInput) {
        fileInput.addEventListener('change', function() {
          const file = this.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
              imagePreview.src = e.target.result;
              imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
          }
        });
      }

      // Form submit handler
      regForm.addEventListener('submit', function(e) {
        for (let step = 1; step <= totalSteps; step++) {
          if (!validateStep(step)) {
            e.preventDefault();
            currentStep = step;
            updateWizardUI();
            const invalidInput = document.getElementById(`step-${step}`)
              .querySelector(':invalid');
            if (invalidInput) invalidInput.focus();
            return;
          }
        }
        btnSubmit.disabled = true;
        submitSpinner.style.display = 'inline-block';
      });

    });
  </script>
</body>
</html>