<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title_tag', 'Error | PRIMEGLOBOPTIONS')</title>
<link rel="icon" type="image/png" href="{{ asset('home/asset/img/logo.png') }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

<style>
/* ========================================================
   PRIMEGLOBOPTIONS — ERROR PAGE DESIGN SYSTEM
   ======================================================== */
:root {
  --primary: #00a9a4;
  --primary-dark: #007875;
  --primary-light: #20c9c3;
  --accent: #0284c7;
  --navy: #0f172a;
  --navy-mid: #1e293b;
  --navy-dark: #082f49;
  --txt: #0f172a;
  --txt-muted: #64748b;
  --bg: #f8fafc;
  --card-bg: #ffffff;
  --border: #e2e8f0;
  --error: #ef4444;
  --success: #10b981;
  --radius: 20px;
  --radius-sm: 12px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  background: var(--bg);
  color: var(--txt);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  overflow-x: hidden;
}

/* ========================
   ANIMATED BACKGROUND
   ======================== */
.err-bg {
  position: fixed;
  inset: 0;
  z-index: 0;
  overflow: hidden;
  background: linear-gradient(165deg, var(--navy) 0%, var(--navy-mid) 35%, #0f2a3e 60%, var(--bg) 100%);
}

.err-bg::before,
.err-bg::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.4;
  animation: errFloat 12s ease-in-out infinite;
}

.err-bg::before {
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
  top: -120px;
  right: -100px;
  animation-delay: 0s;
}

.err-bg::after {
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
  bottom: -80px;
  left: -60px;
  animation-delay: -6s;
}

.err-orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
  opacity: 0.2;
  animation: errFloat2 16s ease-in-out infinite;
}

.err-orb--a {
  width: 300px;
  height: 300px;
  background: var(--primary-light);
  top: 40%;
  left: 20%;
  animation-delay: -4s;
}

.err-orb--b {
  width: 250px;
  height: 250px;
  background: var(--accent);
  top: 20%;
  right: 30%;
  animation-delay: -8s;
}

@keyframes errFloat {
  0%, 100% { transform: translate(0, 0) scale(1); }
  33% { transform: translate(30px, -40px) scale(1.08); }
  66% { transform: translate(-20px, 20px) scale(0.95); }
}

@keyframes errFloat2 {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(-40px, 30px) scale(1.1); }
}

/* ========================
   MAIN WRAPPER
   ======================== */
.err-page {
  position: relative;
  z-index: 1;
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px 30px;
  min-height: 100vh;
}

/* ========================
   LOGO
   ======================== */
.err-logo {
  margin-bottom: 36px;
  animation: errFadeDown 0.7s ease-out both;
}

.err-logo img {
  height: 52px;
  width: auto;
  filter: brightness(0) invert(1);
  transition: transform 0.3s ease, filter 0.3s ease;
}

.err-logo:hover img {
  transform: scale(1.06);
  filter: brightness(0) invert(1) drop-shadow(0 0 8px rgba(0, 169, 164, 0.5));
}

/* ========================
   GLASSMORPHISM CARD
   ======================== */
.err-card {
  width: 100%;
  max-width: 520px;
  background: rgba(255, 255, 255, 0.07);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: var(--radius);
  padding: 48px 40px 40px;
  text-align: center;
  box-shadow:
    0 8px 32px rgba(0, 0, 0, 0.2),
    0 0 0 1px rgba(255, 255, 255, 0.05) inset;
  animation: errSlideUp 0.8s ease-out both;
  animation-delay: 0.15s;
}

/* ========================
   ERROR ICON
   ======================== */
.err-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 88px;
  height: 88px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(0, 169, 164, 0.15), rgba(2, 132, 199, 0.1));
  border: 2px solid rgba(0, 169, 164, 0.25);
  margin-bottom: 24px;
  animation: errPulseIcon 3s ease-in-out infinite;
}

.err-icon i {
  font-size: 38px;
  background: linear-gradient(135deg, var(--primary-light), var(--accent));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

@keyframes errPulseIcon {
  0%, 100% { box-shadow: 0 0 0 0 rgba(0, 169, 164, 0.2); transform: scale(1); }
  50% { box-shadow: 0 0 0 12px rgba(0, 169, 164, 0); transform: scale(1.04); }
}

/* ========================
   ERROR CODE
   ======================== */
.err-code {
  font-family: 'Manrope', 'Inter', sans-serif;
  font-size: 72px;
  font-weight: 800;
  line-height: 1;
  letter-spacing: -2px;
  background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 40%, var(--accent) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 12px;
  animation: errGradientShift 4s ease-in-out infinite;
  background-size: 200% 200%;
}

@keyframes errGradientShift {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

/* ========================
   ERROR TITLE & MESSAGE
   ======================== */
.err-title {
  font-family: 'Manrope', 'Inter', sans-serif;
  font-size: 22px;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 14px;
  letter-spacing: -0.3px;
}

.err-message {
  font-size: 15px;
  line-height: 1.7;
  color: rgba(255, 255, 255, 0.6);
  margin-bottom: 32px;
  max-width: 400px;
  margin-left: auto;
  margin-right: auto;
}

/* ========================
   ACTION BUTTONS
   ======================== */
.err-actions {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
}

.err-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: var(--radius-sm);
  font-family: 'Inter', sans-serif;
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: none;
  outline: none;
  letter-spacing: 0.01em;
}

.err-btn i {
  font-size: 17px;
  transition: transform 0.3s ease;
}

/* Filled button */
.err-btn--fill {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: #ffffff;
  box-shadow: 0 4px 14px rgba(0, 169, 164, 0.3);
}

.err-btn--fill:hover {
  background: linear-gradient(135deg, var(--primary-light), var(--primary));
  box-shadow: 0 6px 20px rgba(0, 169, 164, 0.45);
  transform: translateY(-2px);
}

.err-btn--fill:hover i {
  transform: translateX(-2px);
}

.err-btn--fill:active {
  transform: translateY(0);
  box-shadow: 0 2px 8px rgba(0, 169, 164, 0.3);
}

/* Ghost / outline button */
.err-btn--ghost {
  background: transparent;
  color: rgba(255, 255, 255, 0.8);
  border: 1.5px solid rgba(255, 255, 255, 0.2);
}

.err-btn--ghost:hover {
  background: rgba(255, 255, 255, 0.08);
  border-color: rgba(255, 255, 255, 0.35);
  color: #ffffff;
  transform: translateY(-2px);
}

.err-btn--ghost:hover i {
  transform: translateX(-2px);
}

.err-btn--ghost:active {
  transform: translateY(0);
}

/* ========================
   DECORATIVE DIVIDER
   ======================== */
.err-divider {
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, var(--primary), var(--accent));
  border-radius: 2px;
  margin: 28px auto 0;
  opacity: 0.5;
}

/* ========================
   FOOTER
   ======================== */
.err-footer {
  position: relative;
  z-index: 1;
  text-align: center;
  padding: 20px;
  animation: errFadeIn 1s ease-out both;
  animation-delay: 0.5s;
}

.err-footer p {
  font-size: 12.5px;
  color: rgba(255, 255, 255, 0.35);
  margin-bottom: 6px;
}

.err-footer a {
  font-size: 12.5px;
  color: var(--primary);
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
}

.err-footer a:hover {
  color: var(--primary-light);
}

/* ========================
   ENTRANCE ANIMATIONS
   ======================== */
@keyframes errFadeDown {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes errSlideUp {
  from { opacity: 0; transform: translateY(30px) scale(0.97); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes errFadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* ========================
   SECURITY BADGE
   ======================== */
.err-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: 20px;
  background: rgba(0, 169, 164, 0.08);
  border: 1px solid rgba(0, 169, 164, 0.15);
  font-size: 11.5px;
  font-weight: 500;
  color: var(--primary-light);
  margin-top: 24px;
}

.err-badge i {
  font-size: 13px;
}

/* ========================
   RESPONSIVE
   ======================== */
@media (max-width: 640px) {
  .err-card {
    padding: 36px 24px 32px;
    margin: 0 8px;
  }

  .err-code {
    font-size: 56px;
  }

  .err-title {
    font-size: 19px;
  }

  .err-message {
    font-size: 14px;
  }

  .err-icon {
    width: 72px;
    height: 72px;
  }

  .err-icon i {
    font-size: 30px;
  }

  .err-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .err-btn {
    justify-content: center;
    padding: 13px 20px;
  }

  .err-logo img {
    height: 42px;
  }
}

@media (max-width: 380px) {
  .err-card {
    padding: 28px 18px 24px;
  }

  .err-code {
    font-size: 46px;
  }

  .err-title {
    font-size: 17px;
  }
}

/* ========================
   PREFERS REDUCED MOTION
   ======================== */
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}

/* ========================
   PRINT STYLES
   ======================== */
@media print {
  .err-bg { display: none; }
  .err-card {
    background: #fff;
    color: #000;
    box-shadow: none;
    border: 1px solid #ccc;
  }
  .err-title { color: #000; }
  .err-message { color: #333; }
  .err-code {
    -webkit-text-fill-color: var(--primary);
    color: var(--primary);
  }
}
</style>
</head>
<body>

<!-- Animated Background -->
<div class="err-bg">
  <div class="err-orb err-orb--a"></div>
  <div class="err-orb err-orb--b"></div>
</div>

<!-- Main Content -->
<main class="err-page">

  <!-- Logo -->
  <a href="/" class="err-logo" aria-label="Go to PRIMEGLOBOPTIONS home">
    <img src="{{ asset('home/asset/img/logo.png') }}" alt="PRIMEGLOBOPTIONS">
  </a>

  <!-- Error Card -->
  <div class="err-card">
    <!-- Icon -->
    <div class="err-icon">
      @yield('icon')
    </div>

    <!-- Error Code -->
    <div class="err-code">@yield('code')</div>

    <!-- Title -->
    <h1 class="err-title">@yield('title')</h1>

    <!-- Message -->
    <p class="err-message">@yield('message')</p>

    <!-- Action Buttons -->
    <div class="err-actions">
      @yield('actions')
    </div>

    <!-- Decorative divider -->
    <div class="err-divider"></div>

    <!-- Security badge -->
    <div class="err-badge">
      <i class="ri-shield-check-line"></i>
      256-Bit SSL Protected
    </div>
  </div>

</main>

<!-- Footer -->
<footer class="err-footer">
  <p>&copy; {{ date('Y') }} PRIMEGLOBOPTIONS. All rights reserved.</p>
  <a href="mailto:support@primegloboptions.com"><i class="ri-mail-line"></i> Contact Support</a>
</footer>

</body>
</html>
