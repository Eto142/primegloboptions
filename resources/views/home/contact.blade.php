@include('home.header')

<!-- Page Hero -->
<section class="bk-page-hero">
  <div class="bk-wrap">
    <h1>Contact Us</h1>
    <p>Our banking support team and certified investment advisors are available 24/7. Reach out and we'll get back to you right away.</p>
    <div class="bk-breadcrumb"><a href="/">Home</a> <span>/</span> Contact Us</div>
  </div>
</section>

<!-- Contact Content -->
<section class="bk-page-section">
  <div class="bk-wrap">
    <div class="bk-page-grid-2">
      <!-- Contact Info -->
      <div class="sr">
        <span class="bk-label">Get In Touch</span>
        <h2 class="bk-title" style="text-align:left;margin-bottom:16px">How Can We Help You?</h2>
        <p style="font-size:.95rem;color:var(--txt-m);line-height:1.65;margin-bottom:24px">Whether you have questions about opening a trading account, understanding an investment product, making an international transfer, or choosing the right deposit plan our team is standing by.</p>

        <div class="bk-feat-item">
          <div class="bk-fi-icon"><i class="ri-mail-line"></i></div>
          <div>
            <h4>Email Support</h4>
            <p><a href="mailto:support@primegloboptions.com" style="color:var(--blue);font-weight:600">support@primegloboptions.com</a></p>
          </div>
        </div>

        <div class="bk-feat-item">
          <div class="bk-fi-icon"><i class="ri-line-chart-line"></i></div>
          <div>
            <h4>Investment Advisory</h4>
            <p>Certified investment advisors available 24/7 to help with portfolio building, market analysis, and wealth planning.</p>
          </div>
        </div>

        <div class="bk-feat-item">
          <div class="bk-fi-icon"><i class="ri-shield-check-line"></i></div>
          <div>
            <h4>Security &amp; Fraud Assistance</h4>
            <p>24/7 automated account monitoring and a rapid response team for any security concern.</p>
          </div>
        </div>

        <div class="bk-feat-item">
          <div class="bk-fi-icon"><i class="ri-time-line"></i></div>
          <div>
            <h4>Operating Hours</h4>
            <p>Platform &amp; Markets: 24 Hours / 7 Days a Week<br>Banking &amp; Investment Support: Always Available</p>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="sr">
        <div class="bk-info-card" style="padding:32px 28px">
          <h3 style="font-size:1.15rem;font-weight:700;margin-bottom:6px">Send Us a Message</h3>
          <p style="font-size:.88rem;color:var(--txt-m);margin-bottom:20px">For account enquiries, investment guidance, or general support we respond to all messages within one business hour.</p>

          @if(session('status'))
            <div class="bk-alert bk-alert--success">{{ session('status') }}</div>
          @endif
          @if(session('error'))
            <div class="bk-alert bk-alert--error">{{ session('error') }}</div>
          @endif

          <form method="POST" action="{{ url('contact') }}">
            @csrf
            <div class="bk-form-group">
              <label for="email">Your Email Address</label>
              <input type="email" name="email" id="email" class="bk-input" placeholder="name@example.com" required>
            </div>
            <div class="bk-form-group">
              <label for="subject">Subject</label>
              <input type="text" name="subject" id="subject" class="bk-input" placeholder="e.g. Account inquiry, trade support, transfer issue..." required>
            </div>
            <div class="bk-form-group">
              <label for="message">Message Details</label>
              <textarea name="message" id="message" class="bk-input" placeholder="Describe your question or issue in as much detail as possible..." required></textarea>
            </div>
            <button type="submit" class="bk-btn bk-btn--fill" style="width:100%;justify-content:center;padding:12px 20px">Send Message <i class="ri-send-plane-line"></i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Info Cards Row -->
<section class="bk-page-section--alt">
  <div class="bk-wrap">
    <div class="bk-page-grid-3">
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 14px"><i class="ri-bank-line"></i></div>
        <h3>Banking Support</h3>
        <p>For account issues, transfers, deposits, card requests, and loan queries our banking team responds instantly.</p>
      </div>
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 14px"><i class="ri-stock-line"></i></div>
        <h3>Investment Advisory</h3>
        <p>Speak to a certified advisor about trading strategies, portfolio allocation, mutual funds, or market opportunities.</p>
      </div>
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 14px"><i class="ri-shield-check-line"></i></div>
        <h3>Security &amp; Compliance</h3>
        <p>Report any suspicious activity or compliance concern and our security team will respond with the highest priority.</p>
      </div>
    </div>
  </div>
</section>

@include('home.footer')
