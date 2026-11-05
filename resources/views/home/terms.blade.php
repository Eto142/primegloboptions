@include('home.header')

<!-- Page Hero -->
<section class="bk-page-hero">
  <div class="bk-wrap">
    <h1>Terms of Service</h1>
    <p>Please read these terms and conditions carefully before using our digital banking services.</p>
    <div class="bk-breadcrumb"><a href="/">Home</a> <span>/</span> Terms of Service</div>
  </div>
</section>

<!-- Terms Content -->
<section class="bk-page-section">
  <div class="bk-wrap">
    <div class="bk-text-page sr">

      <h2>1. Acceptance of Terms</h2>
      <p>By accessing or using the digital banking services, website, or portal of PRIMEGLOBOPTIONS ("the Bank"), you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you must refrain from using our services.</p>

      <h2>2. Account Eligibility &amp; Verification</h2>
      <p>To open an account with PRIMEGLOBOPTIONS, you must be at least 18 years of age and present valid government identification. You agree to provide accurate, truthful, and complete information during registration and keep your account details updated.</p>

      <h2>3. Account Protection &amp; Security Credentials</h2>
      <p>You are solely responsible for maintaining the confidentiality of your login credentials, passwords, and security PINs. You agree to notify PRIMEGLOBOPTIONS immediately of any unauthorized account access or security breach.</p>
      <p>The Bank uses 256-bit SSL encryption and automated fraud controls to safeguard user sessions, but users must also practice basic account security precautions.</p>

      <h2>4. Digital Banking Services &amp; Transfers</h2>
      <p>PRIMEGLOBOPTIONS provides checking, savings, tenured fixed deposits, domestic wire, and global transfer services. Processing times, exchange rates, and limits are subject to verified account status and regulatory compliance checks.</p>

      <h2>5. Transparency &amp; Fee Structure</h2>
      <p>PRIMEGLOBOPTIONS is committed to transparent banking with zero hidden fees. Applicable transaction fees, transfer charges, or exchange rate markups are clearly displayed prior to transaction confirmation.</p>

      <h2>6. Privacy &amp; Data Governance</h2>
      <p>Your personal and financial data is handled in strict compliance with international data protection laws. We never sell or misuse your personal financial records.</p>

      <h2>7. Amendments</h2>
      <p>PRIMEGLOBOPTIONS reserves the right to amend or update these Terms of Service at any time. Updated terms will be published on this page and take effect upon posting.</p>

      <h2>8. Contact Us</h2>
      <p>If you have any questions regarding these Terms of Service, please contact our support team at <a href="mailto:support@primegloboptions.com" style="color:var(--blue);font-weight:600">support@primegloboptions.com</a> or visit our <a href="{{ url('contact') }}" style="color:var(--blue)">Contact Page</a>.</p>

    </div>
  </div>
</section>

<!-- CTA -->
<section class="bk-cta">
  <div class="bk-wrap">
    <div class="bk-cta-box sr">
      <div class="bk-cta-content">
        <h2>Have Questions Regarding Terms?</h2>
        <p>Our support specialists are happy to clarify any of our policies.</p>
        <div class="bk-cta-btns">
          <a href="{{ url('contact') }}" class="bk-btn bk-btn--white">Contact Support <i class="ri-arrow-right-line"></i></a>
          <a href="{{ url('faq') }}" class="bk-btn bk-btn--glass">View FAQ <i class="ri-question-line"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

@include('home.footer')
