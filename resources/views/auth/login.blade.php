<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Sign In - PRIMEGLOBOPTIONS</title>
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

/* Main Layout Grid */
.auth-wrapper {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 32px 16px;
}

.auth-card {
  width: 100%;
  max-width: 1040px;
  background: var(--card-bg);
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(15,23,42,.08), 0 1px 3px rgba(0,0,0,.05);
  border: 1px solid var(--border);
  display: grid;
  grid-template-columns: 1fr 1.15fr;
  overflow: hidden;
}

/* Left Brand Panel */
.brand-panel {
  background: linear-gradient(135deg, var(--navy) 0%, var(--navy-dark) 100%);
  color: #fff;
  padding: 48px 36px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  position: relative;
  overflow: hidden;
}

.brand-panel::before {
  content: '';
  position: absolute;
  top: -100px; left: -100px;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: rgba(201,162,39,.30);
  filter: blur(60px);
  pointer-events: none;
}
.brand-panel::after {
  content: '';
  position: absolute;
  bottom: -80px; right: -80px;
  width: 280px; height: 280px;
  border-radius: 50%;
  background: rgba(158,124,20,.30);
  filter: blur(60px);
  pointer-events: none;
}

.brand-panel-content { position: relative; z-index: 2; }
.brand-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11.5px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  background: rgba(201,162,39,.20);
  color: var(--primary-light);
  border: 1px solid rgba(201,162,39,.35);
  padding: 6px 14px;
  border-radius: 50px;
  margin-bottom: 20px;
}
.brand-panel h2 {
  font-family: 'Manrope', sans-serif;
  font-size: 32px;
  font-weight: 800;
  line-height: 1.2;
  margin-bottom: 12px;
}
.brand-panel p {
  font-size: 14.5px;
  color: rgba(255,255,255,.70);
  line-height: 1.6;
  margin-bottom: 28px;
}

/* Virtual Card Display */
.v-card {
  background: linear-gradient(135deg, #C9A227 0%, #C9A227 60%, #0f172a 100%);
  border-radius: 16px;
  padding: 24px;
  color: #fff;
  box-shadow: 0 16px 36px rgba(0,0,0,.35);
  position: relative;
  overflow: hidden;
  margin-bottom: 32px;
  border: 1px solid rgba(255,255,255,.15);
}
.v-card::before {
  content: '';
  position: absolute;
  top: -50%; right: -50%;
  width: 200%; height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,.15) 0%, transparent 60%);
  pointer-events: none;
}
.v-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.v-card-chip {
  width: 38px; height: 28px;
  border-radius: 6px;
  background: linear-gradient(135deg, #fef08a, #ca8a04);
  position: relative;
}
.v-card-chip::after {
  content: '';
  position: absolute;
  inset: 4px;
  border: 1px solid rgba(0,0,0,.2);
  border-radius: 3px;
}
.v-card-logo { font-size: 15px; font-weight: 800; letter-spacing: .5px; }
.v-card-num { font-family: monospace; font-size: 17px; letter-spacing: 2.5px; margin-bottom: 18px; }
.v-card-bottom { display: flex; justify-content: space-between; align-items: flex-end; font-size: 11px; text-transform: uppercase; color: rgba(255,255,255,.75); }
.v-card-name { font-weight: 700; color: #fff; font-size: 13px; }

/* Features List */
.brand-feats { list-style: none; display: flex; flex-direction: column; gap: 12px; }
.brand-feats li { display: flex; align-items: center; gap: 10px; font-size: 13px; color: rgba(255,255,255,.8); }
.brand-feats i { color: var(--primary-light); font-size: 16px; flex-shrink: 0; }

/* Right Form Panel */
.form-panel {
  padding: 48px 44px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.form-panel-head { text-align: center; margin-bottom: 28px; }
.form-panel-head img { height: 50px; width: auto; margin-bottom: 14px; }
.form-panel-head h1 { font-family: 'Manrope', sans-serif; font-size: 24px; font-weight: 800; color: var(--txt); margin-bottom: 6px; }
.form-panel-head p { font-size: 13.5px; color: var(--txt-muted); }

/* Inputs & Form */
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 13px; font-weight: 600; color: var(--txt); margin-bottom: 6px; }
.input-wrap { position: relative; display: flex; align-items: center; }
.input-wrap i.input-icon { position: absolute; left: 14px; color: #94a3b8; font-size: 16px; transition: color .2s; }
.form-control {
  width: 100%;
  padding: 12px 14px 12px 42px;
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
.form-control:focus + .input-icon,
.input-wrap:focus-within i.input-icon { color: var(--primary); }

.toggle-pwd {
  position: absolute; right: 14px;
  background: none; border: none;
  color: #94a3b8; cursor: pointer;
  font-size: 16px; transition: color .2s;
}
.toggle-pwd:hover { color: var(--primary); }

.form-meta { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; font-size: 13px; }
.remember-label { display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--txt-muted); }
.remember-label input { accent-color: var(--primary); width: 16px; height: 16px; cursor: pointer; }
.forgot-link { color: var(--primary); text-decoration: none; font-weight: 600; transition: color .2s; }
.forgot-link:hover { text-decoration: underline; color: var(--primary-dark); }

.btn-submit {
  width: 100%;
  padding: 13px 20px;
  font-size: 14.5px;
  font-weight: 700;
  font-family: 'Inter', sans-serif;
  color: #fff;
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  border: none;
  border-radius: 10px;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(201,162,39,.30);
  transition: all .25s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}
.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(201,162,39,.40);
}
.btn-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }

.error-txt { color: var(--error); font-size: 12px; margin-top: 4px; font-weight: 500; }

.auth-footer-note {
  text-align: center;
  margin-top: 24px;
  font-size: 13.5px;
  color: var(--txt-muted);
}
.auth-footer-note a { color: var(--primary); font-weight: 700; text-decoration: none; }
.auth-footer-note a:hover { text-decoration: underline; }

.security-box {
  margin-top: 24px;
  padding: 14px;
  background: var(--bg-light);
  border-radius: 10px;
  border-left: 3px solid var(--primary);
  font-size: 12px;
  color: var(--txt-muted);
}
.security-box strong { color: var(--txt); display: flex; align-items: center; gap: 6px; margin-bottom: 4px; }

/* Page Spinner */
.btn-spinner {
  display: none;
  width: 16px; height: 16px;
  border: 2px solid rgba(255,255,255,.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Footer */
footer { text-align: center; padding: 16px; font-size: 12px; color: var(--txt-muted); border-top: 1px solid var(--border); background: var(--card-bg); }

@media (max-width: 840px) {
  .auth-card { grid-template-columns: 1fr; }
  .brand-panel { display: none; }
  .form-panel { padding: 36px 24px; }
}
</style>
</head>
<body>

  <!-- Top Navigation Header -->
  <header class="auth-header">
    <a href="/" class="auth-header-logo">
      <img src="{{ asset('home/asset/img/logo.png') }}" alt="PRIMEGLOBOPTIONS">
    </a>
    <a href="{{ route('register') }}" class="auth-header-action">
      <i class="ri-user-add-line"></i> Enroll / Open Account
    </a>
  </header>

  <!-- Main Container -->
  <main class="auth-wrapper">
    <div class="auth-card">

      <!-- Left Brand Showcase Panel -->
      <div class="brand-panel">
        <div class="brand-panel-content">
          <span class="brand-badge"><i class="ri-shield-check-fill"></i> Bank-Grade Protection</span>
          <h2>Secure Digital Banking Portal</h2>
          <p>Access your accounts, initiate instant global transfers, and manage high-interest savings securely.</p>

          <!-- Virtual Card -->
          <div class="v-card">
            <div class="v-card-top">
              <div class="v-card-chip"></div>
              <span class="v-card-logo">PRIMEGLOBOPTIONS</span>
            </div>
            <div class="v-card-num">•••• •••• •••• 4092</div>
            <div class="v-card-bottom">
              <div>
                <span style="font-size:9px;display:block;opacity:.7">CARDHOLDER</span>
                <span class="v-card-name">VALUED CLIENT</span>
              </div>
              <i class="ri-visa-line" style="font-size:24px;"></i>
            </div>
          </div>

          <ul class="brand-feats">
            <li><i class="ri-checkbox-circle-fill"></i> 256-Bit End-to-End SSL Encryption</li>
            <li><i class="ri-checkbox-circle-fill"></i> Real-Time Global Wire Transfers</li>
            <li><i class="ri-checkbox-circle-fill"></i> 24/7 Dedicated Support Desk</li>
          </ul>
        </div>
      </div>

      <!-- Right Login Form Panel -->
      <div class="form-panel">
        <div class="form-panel-head">
          <img src="{{ asset('home/asset/img/logo.png') }}" alt="PRIMEGLOBOPTIONS">
          <h1>Welcome Back</h1>
          <p>Sign in to your online banking dashboard</p>
        </div>

        <div id="alert-area">
          @if (session('status'))
            <div role="status" style="margin-bottom:16px;padding:12px;border-radius:8px;background:#ecfdf5;color:#047857;font-size:13px;">
              {{ session('status') }}
            </div>
          @endif
        </div>

        <form id="loginForm">
          @csrf

          <div class="form-group">
            <label class="form-label" for="email">Online ID (Email or Phone)</label>
            <div class="input-wrap">
              <i class="ri-user-3-line input-icon"></i>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter your email or phone" required autocomplete="username">
            </div>
            <div class="error-txt" id="error-email"></div>
          </div>

          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
              <i class="ri-lock-2-line input-icon"></i>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
              <button type="button" class="toggle-pwd" id="togglePasswordBtn" aria-label="Toggle password visibility">
                <i class="far fa-eye"></i>
              </button>
            </div>
            <div class="error-txt" id="error-password"></div>
          </div>

          <div class="form-meta">
            <label class="remember-label">
              <input type="checkbox" id="remember" name="remember">
              <span>Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn-submit" id="loginButton">
            <span class="btn-spinner" id="spinner"></span>
            <i class="ri-login-box-line"></i> Sign In to Account
          </button>

          <div class="security-box">
            <strong><i class="ri-shield-flash-line" style="color:var(--primary)"></i> Security Reminder</strong>
            Never share your online banking password or PIN with anyone. PRIMEGLOBOPTIONS will never ask for your password via phone or email.
          </div>

          <div class="auth-footer-note">
            Don't have a banking account yet? <a href="{{ route('register') }}">Enroll Now</a>
          </div>
        </form>
      </div>

    </div>
  </main>

  <footer>
    <p>&copy; {{ date('Y') }} PRIMEGLOBOPTIONS. All rights reserved. Encrypted &amp; Secure Digital Banking.</p>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('loginForm');
      const alertArea = document.getElementById('alert-area');
      const loginButton = document.getElementById('loginButton');
      const spinner = document.getElementById('spinner');
      const togglePasswordBtn = document.getElementById('togglePasswordBtn');
      const passwordInput = document.getElementById('password');

      // Toggle password visibility
      if(togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
          const icon = this.querySelector('i');
          if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
          } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
          }
        });
      }

      // Check remembered email
      if (localStorage.getItem('rememberedEmail')) {
        document.getElementById('email').value = localStorage.getItem('rememberedEmail');
        document.getElementById('remember').checked = true;
      }

      // AJAX form submission
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        loginButton.disabled = true;
        spinner.style.display = 'inline-block';

        document.getElementById('error-email').textContent = '';
        document.getElementById('error-password').textContent = '';
        alertArea.innerHTML = '';

        fetch("{{ route('login') }}", {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
          },
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw response;
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            if (document.getElementById('remember').checked) {
              localStorage.setItem('rememberedEmail', document.getElementById('email').value);
            } else {
              localStorage.removeItem('rememberedEmail');
            }

            alertArea.innerHTML = `
              <div style="padding: 12px; border-radius: 10px; background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; font-size: 13px; display: flex; align-items: center; gap: 8px; margin-bottom: 18px;">
                <i class="ri-checkbox-circle-fill" style="font-size: 16px;"></i>
                ${data.message}
              </div>
            `;

            setTimeout(() => {
              window.location.href = data.redirect;
            }, 800);
          } else {
            alertArea.innerHTML = `
              <div style="padding: 12px; border-radius: 10px; background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 13px; display: flex; align-items: center; gap: 8px; margin-bottom: 18px;">
                <i class="ri-error-warning-fill" style="font-size: 16px;"></i>
                ${data.message}
              </div>
            `;

            if (data.errors) {
              if (data.errors.email) {
                document.getElementById('error-email').textContent = data.errors.email[0];
              }
              if (data.errors.password) {
                document.getElementById('error-password').textContent = data.errors.password[0];
              }
            }
          }
        })
        .catch(async (error) => {
          let errorMessage = 'An unexpected error occurred. Please try again.';
          try {
            const errorData = await error.json();
            if (errorData.message) {
              errorMessage = errorData.message;
            }
          } catch (e) {
            console.error('Error parsing error response:', e);
          }

          alertArea.innerHTML = `
            <div style="padding: 12px; border-radius: 10px; background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-size: 13px; display: flex; align-items: center; gap: 8px; margin-bottom: 18px;">
              <i class="ri-error-warning-fill" style="font-size: 16px;"></i>
              ${errorMessage}
            </div>
          `;
        })
        .finally(() => {
          loginButton.disabled = false;
          spinner.style.display = 'none';
        });
      });

      document.getElementById('email').focus();
    });
  </script>
</body>
</html>