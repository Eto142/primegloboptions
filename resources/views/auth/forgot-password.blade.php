<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password - PRIMEGLOBOPTIONS</title>
<link rel="shortcut icon" href="{{ asset('home/asset/img/logo.png') }}" type="image/png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

<style>
:root {
  --primary: #C9A227;
  --primary-dark: #9E7C14;
  --primary-light: #E8C14A;
  --navy: #0f172a;
  --navy-dark: #082f49;
  --txt: #0f172a;
  --txt-muted: #64748b;
  --bg-light: #f8fafc;
  --card-bg: #ffffff;
  --border: #e2e8f0;
  --error: #ef4444;
  --success: #10b981;
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
  justify-content: center;
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
  font-size: 30px;
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

.lock-icon-wrap {
  width: 80px; height: 80px;
  border-radius: 20px;
  background: rgba(201,162,39,.18);
  border: 1px solid rgba(201,162,39,.35);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 38px;
  color: var(--primary-light);
  margin-bottom: 28px;
}

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
.form-panel-head p { font-size: 13.5px; color: var(--txt-muted); line-height: 1.5; }

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
.input-wrap:focus-within i.input-icon { color: var(--primary); }

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

.error-txt { color: var(--error); font-size: 12px; margin-top: 4px; font-weight: 500; }

.message-box {
  padding: 12px 16px;
  border-radius: 10px;
  background: #ecfdf5;
  color: #047857;
  border: 1px solid #a7f3d0;
  font-size: 13px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.auth-footer-note {
  text-align: center;
  margin-top: 24px;
  font-size: 13.5px;
  color: var(--txt-muted);
}
.auth-footer-note a { color: var(--primary); font-weight: 700; text-decoration: none; }
.auth-footer-note a:hover { text-decoration: underline; }

footer { text-align: center; padding: 16px; font-size: 12px; color: var(--txt-muted); border-top: 1px solid var(--border); background: var(--card-bg); }

@media (max-width: 840px) {
  .auth-card { grid-template-columns: 1fr; }
  .brand-panel { display: none; }
  .form-panel { padding: 36px 24px; }
}
</style>
</head>
<body>

  <header class="auth-header">
    <a href="/" class="auth-header-logo">
      <img src="{{ asset('home/asset/img/logo.png') }}" alt="PRIMEGLOBOPTIONS">
    </a>
    <a href="{{ route('login') }}" class="auth-header-action">
      <i class="ri-login-box-line"></i> Back to Sign In
    </a>
  </header>

  <main class="auth-wrapper">
    <div class="auth-card">

      <!-- Left Brand Panel -->
      <div class="brand-panel">
        <div class="brand-panel-content">
          <span class="brand-badge"><i class="ri-line-chart-fill"></i> Investment Broker &amp; Online Banking</span>

          <div class="lock-icon-wrap">
            <i class="ri-lock-password-line"></i>
          </div>

          <h2>Secure Password Recovery</h2>
          <p>We take your account security seriously. Enter your registered email and we'll send a secure reset link to restore access to your investment and banking portal.</p>

          <ul class="brand-feats">
            <li><i class="ri-checkbox-circle-fill"></i> Live Forex, Stocks &amp; Crypto Trading</li>
            <li><i class="ri-checkbox-circle-fill"></i> Managed Investment Plans &amp; Portfolios</li>
            <li><i class="ri-checkbox-circle-fill"></i> Real-Time Global Wire Transfers</li>
            <li><i class="ri-checkbox-circle-fill"></i> 256-Bit End-to-End SSL Encryption</li>
            <li><i class="ri-checkbox-circle-fill"></i> 24/7 Dedicated Support Desk</li>
          </ul>
        </div>
      </div>

      <!-- Right Form Panel -->
      <div class="form-panel">
        <div class="form-panel-head">
          <img src="{{ asset('home/asset/img/logo.png') }}" alt="PRIMEGLOBOPTIONS">
          <h1>Forgot Your Password?</h1>
          <p>Enter the email address linked to your account and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
          <div class="message-box">
            <i class="ri-checkbox-circle-fill" style="font-size:16px;"></i>
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <div class="input-wrap">
              <i class="ri-mail-line input-icon"></i>
              <input type="email" id="email" name="email" class="form-control" placeholder="Enter your registered email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            @error('email')
              <div class="error-txt">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn-submit">
            <i class="ri-send-plane-fill"></i> Send Reset Link
          </button>
        </form>

        <div class="auth-footer-note">
          Remember your password? <a href="{{ route('login') }}">Sign In</a>
        </div>
        <div class="auth-footer-note" style="margin-top:10px;">
          Don't have an account? <a href="{{ route('register') }}">Enroll Now</a>
        </div>
      </div>

    </div>
  </main>

  <footer>
    <p>&copy; {{ date('Y') }} PRIMEGLOBOPTIONS. All rights reserved. Licensed Investment Broker &amp; Secure Digital Banking Services.</p>
  </footer>

</body>
</html>
