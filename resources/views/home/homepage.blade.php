@include('home.header')

<!-- ============================================================
     HERO CAROUSEL
     ============================================================ -->
<section class="bk-hero">
  <div class="bk-hero-slides" id="bkHeroTrack">
    <!-- Slide 1 Investment Broker -->
    <div class="bk-hero-slide">
      <div class="bk-hero-bg" style="background-image:url('{{ asset('frontassets/images/banner/hero-slide-1-new.jpg') }}')"></div>
      <div class="bk-wrap">
        <div class="bk-hero-body">
          <span class="bk-hero-label"><i class="ri-line-chart-fill"></i> Global Investment Broker</span>
          <h1>Invest in Markets That <em>Move</em> the World</h1>
          <p>PRIMEGLOBOPTIONS gives you institutional-grade access to global stocks, forex, crypto, and commodities backed by 256-bit security, real-time market data, and 24/7 expert support.</p>
          <div class="bk-hero-actions">
            <a href="{{ route('register') }}" class="bk-btn bk-btn--white">Start Investing <i class="ri-arrow-right-line"></i></a>
            <a href="{{ url('services') }}" class="bk-btn bk-btn--glass">Explore Markets <i class="ri-stock-line"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!-- Slide 2 Online Banking -->
    <div class="bk-hero-slide">
      <div class="bk-hero-bg" style="background-image:url('{{ asset('frontassets/images/banner/hero-slide-2-new.jpg') }}')"></div>
      <div class="bk-wrap">
        <div class="bk-hero-body">
          <span class="bk-hero-label"><i class="ri-bank-fill"></i> Full-Service Digital Banking</span>
          <h1>One Account. <em>Every</em> Financial Need Covered.</h1>
          <p>Personal savings, business accounts, credit cards, international transfers, and high-yield fixed deposits all managed from a single unified dashboard built to grow with you.</p>
          <div class="bk-hero-actions">
            <a href="{{ route('register') }}" class="bk-btn bk-btn--white">Open an Account <i class="ri-arrow-right-line"></i></a>
            <a href="{{ url('services') }}" class="bk-btn bk-btn--glass">Our Services <i class="ri-arrow-right-line"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!-- Slide 3 Stocks & Forex Trading -->
    <div class="bk-hero-slide">
      <div class="bk-hero-bg" style="background-image:url('{{ asset('frontassets/images/banner/hero-slide-3-new.jpg') }}')"></div>
      <div class="bk-wrap">
        <div class="bk-hero-body">
          <span class="bk-hero-label"><i class="ri-exchange-funds-fill"></i> Stocks, Forex &amp; Crypto Trading</span>
          <h1>Trade Global Assets with <em>Confidence</em></h1>
          <p>Access live price feeds on thousands of instruments from NYSE blue chips to major forex pairs and leading cryptocurrencies. Advanced order types, no hidden spreads, zero commissions on select plans.</p>
          <div class="bk-hero-actions">
            <a href="{{ route('register') }}" class="bk-btn bk-btn--white">Start Trading <i class="ri-arrow-right-line"></i></a>
            <a href="{{ url('contact') }}" class="bk-btn bk-btn--glass">Talk to an Advisor <i class="ri-customer-service-2-line"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!-- Slide 4 Wealth Growth -->
    <div class="bk-hero-slide">
      <div class="bk-hero-bg" style="background-image:url('{{ asset('frontassets/images/banner/hero-slide-4-new.jpg') }}')"></div>
      <div class="bk-wrap">
        <div class="bk-hero-body">
          <span class="bk-hero-label"><i class="ri-funds-box-fill"></i> Wealth Management &amp; Savings</span>
          <h1>Grow Your Wealth While Your <em>Money</em> Works</h1>
          <p>Combine high-yield tenured deposits, structured mutual funds, and personalised savings goals into a single wealth strategy managed by our certified financial advisors.</p>
          <div class="bk-hero-actions">
            <a href="{{ route('register') }}" class="bk-btn bk-btn--white">Build My Portfolio <i class="ri-arrow-right-line"></i></a>
            <a href="{{ url('about') }}" class="bk-btn bk-btn--glass">Learn More <i class="ri-information-line"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <button class="bk-hero-arr bk-hero-arr--prev" onclick="bkSlide(-1)" aria-label="Previous slide"><i class="ri-arrow-left-s-line"></i></button>
  <button class="bk-hero-arr bk-hero-arr--next" onclick="bkSlide(1)" aria-label="Next slide"><i class="ri-arrow-right-s-line"></i></button>
  <div class="bk-hero-dots" id="bkDots">
    <button class="active" onclick="bkGo(0)" aria-label="Go to slide 1"></button>
    <button onclick="bkGo(1)" aria-label="Go to slide 2"></button>
    <button onclick="bkGo(2)" aria-label="Go to slide 3"></button>
    <button onclick="bkGo(3)" aria-label="Go to slide 4"></button>
  </div>
  <div class="bk-hero-progress"><div class="bk-hero-progress-bar" id="bkProgress"></div></div>
</section>

<!-- ============================================================
     FEATURE TICKER
     ============================================================ -->
<div class="bk-ticker" aria-hidden="true">
  <div class="bk-ticker-track">
    <span class="bk-ticker-item"><i class="ri-line-chart-fill"></i> Live Stock &amp; Forex Trading</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-bitcoin-fill"></i> Crypto Asset Trading</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-shield-check-fill"></i> 256-Bit Bank-Grade Encryption</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-flashlight-fill"></i> Instant Global Transfers</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-global-fill"></i> 50+ Countries Reached</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-customer-service-2-fill"></i> 24/7 Dedicated Support</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-bank-card-fill"></i> Zero Hidden Fee Banking</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-percent-fill"></i> High-Yield Tenured Savings</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-pie-chart-fill"></i> Managed Mutual Funds</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-exchange-dollar-fill"></i> Real-Time Live FX Rates</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-funds-box-fill"></i> Portfolio Wealth Management</span>
    <span class="bk-ticker-sep"></span>
    <!-- duplicate for seamless loop -->
    <span class="bk-ticker-item"><i class="ri-line-chart-fill"></i> Live Stock &amp; Forex Trading</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-bitcoin-fill"></i> Crypto Asset Trading</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-shield-check-fill"></i> 256-Bit Bank-Grade Encryption</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-flashlight-fill"></i> Instant Global Transfers</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-global-fill"></i> 50+ Countries Reached</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-customer-service-2-fill"></i> 24/7 Dedicated Support</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-bank-card-fill"></i> Zero Hidden Fee Banking</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-percent-fill"></i> High-Yield Tenured Savings</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-pie-chart-fill"></i> Managed Mutual Funds</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-exchange-dollar-fill"></i> Real-Time Live FX Rates</span>
    <span class="bk-ticker-sep"></span>
    <span class="bk-ticker-item"><i class="ri-funds-box-fill"></i> Portfolio Wealth Management</span>
    <span class="bk-ticker-sep"></span>
  </div>
</div>

<!-- ============================================================
     TRUST STRIP
     ============================================================ -->
<section class="bk-trust">
  <div class="bk-wrap">
    <div class="bk-trust-grid">
      <div class="bk-trust-item">
        <div class="bk-trust-icon"><i class="ri-lock-2-line"></i></div>
        <div><strong>256-bit Encryption</strong><span>Every session, fully protected</span></div>
      </div>
      <div class="bk-trust-item">
        <div class="bk-trust-icon"><i class="ri-line-chart-line"></i></div>
        <div><strong>Global Markets Access</strong><span>Stocks, Forex, Crypto &amp; More</span></div>
      </div>
      <div class="bk-trust-item">
        <div class="bk-trust-icon"><i class="ri-customer-service-2-line"></i></div>
        <div><strong>24/7 Support</strong><span>Real advisors, always available</span></div>
      </div>
      <div class="bk-trust-item">
        <div class="bk-trust-icon"><i class="ri-flashlight-line"></i></div>
        <div><strong>Instant Settlement</strong><span>Money and trades move in real time</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     DUAL PLATFORM INTRO Banking + Investing
     ============================================================ -->
<section class="bk-section" id="platform">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Two Platforms. One Login.</span>
      <h2 class="bk-title">Everything You Need to <em>Bank</em> and <em>Invest</em></h2>
      <p class="bk-desc">PRIMEGLOBOPTIONS uniquely combines a fully licensed digital bank with an institutional-grade investment brokerage giving you a single account to manage your money and grow your wealth.</p>
    </div>
    <div class="bk-split" style="align-items:stretch; gap:32px; margin-top:40px">
      <!-- Banking Card -->
      <div class="bk-card" style="flex:1; border-top: 4px solid var(--blue); padding:36px 32px;">
        <div class="bk-card-icon" style="margin-bottom:20px"><i class="ri-bank-line"></i></div>
        <h3 style="font-size:1.3rem; margin-bottom:12px">Digital Banking</h3>
        <p style="margin-bottom:20px">A complete online bank in your pocket. Manage savings, current accounts, cards, loans, international transfers, and deposits with zero hidden fees.</p>
        <ul style="list-style:none;padding:0;margin:0 0 24px;display:flex;flex-direction:column;gap:10px">
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:var(--blue)"></i> Personal &amp; Business Accounts</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:var(--blue)"></i> Instant Global Money Transfers</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:var(--blue)"></i> Multi-Currency Debit &amp; Credit Cards</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:var(--blue)"></i> Fixed Deposits &amp; High-Yield Savings</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:var(--blue)"></i> Personal &amp; Business Loans</li>
        </ul>
        <a href="{{ route('register') }}" class="bk-card-link">Open a Bank Account <i class="ri-arrow-right-line"></i></a>
      </div>
      <!-- Brokerage Card -->
      <div class="bk-card bk-card--featured" style="flex:1; border-top: 4px solid #f59e0b; padding:36px 32px;">
        <span class="bk-card-badge">Investment Broker</span>
        <div class="bk-card-icon" style="margin-bottom:20px"><i class="ri-line-chart-line"></i></div>
        <h3 style="font-size:1.3rem; margin-bottom:12px">Investment Brokerage</h3>
        <p style="margin-bottom:20px">Access global financial markets with professional-grade tools. Trade equities, forex pairs, crypto, and ETFs with real-time data and expert guidance.</p>
        <ul style="list-style:none;padding:0;margin:0 0 24px;display:flex;flex-direction:column;gap:10px">
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:#f59e0b"></i> Stocks, ETFs &amp; Equity Trading</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:#f59e0b"></i> Forex &amp; Currency Pairs</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:#f59e0b"></i> Cryptocurrency Markets</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:#f59e0b"></i> Managed Mutual Funds</li>
          <li style="display:flex;align-items:center;gap:10px;font-size:.9rem;color:var(--txt-m)"><i class="ri-checkbox-circle-fill" style="color:#f59e0b"></i> Goals-Based Savings &amp; Wealth Plans</li>
        </ul>
        <a href="{{ route('register') }}" class="bk-card-link">Start Investing <i class="ri-arrow-right-line"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SERVICES / FEATURES BENTO GRID
     ============================================================ -->
<section class="bk-section bk-section--gray" id="services">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Our Services</span>
      <h2 class="bk-title">Banking &amp; Investment Services Built Around <em>You</em></h2>
      <p class="bk-desc">From personal checking accounts to live stock trading and portfolio management, every financial need is covered under one roof.</p>
    </div>
    <div class="bk-cards-grid bk-cards-grid--bento">
      <div class="bk-card bk-card--featured sr">
        <span class="bk-card-badge">Most Popular</span>
        <div class="bk-card-icon"><i class="ri-stock-line"></i></div>
        <h3>Stocks &amp; Equity Trading</h3>
        <p>Buy and sell shares in leading global companies across NYSE, NASDAQ, LSE, and more with real-time prices, market depth, and advanced order types.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Start Trading <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-exchange-funds-line"></i></div>
        <h3>Forex &amp; Currency Trading</h3>
        <p>Trade major, minor, and exotic forex pairs with competitive spreads, live FX rates, and institutional-grade execution on every order.</p>
        <a href="{{ url('services') }}" class="bk-card-link">Learn More <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-bitcoin-line"></i></div>
        <h3>Cryptocurrency Markets</h3>
        <p>Trade Bitcoin, Ethereum, and 50+ digital assets against major fiat pairs. Spot trading with real-time depth charts and zero hidden commissions.</p>
        <a href="{{ url('services') }}" class="bk-card-link">Learn More <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-exchange-dollar-line"></i></div>
        <h3>International Bank Transfers</h3>
        <p>Move money across borders in seconds with real-time exchange rates, bank-level security, and transparent fees that stay refreshingly low.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Get Started <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-pie-chart-2-line"></i></div>
        <h3>Mutual Funds &amp; Wealth Plans</h3>
        <p>Invest in professionally managed mutual fund portfolios and structured wealth plans tailored to your risk appetite and long-term goals.</p>
        <a href="{{ url('services') }}" class="bk-card-link">Learn More <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-bank-line"></i></div>
        <h3>Personal &amp; Business Banking</h3>
        <p>Everyday checking and savings accounts, business current accounts, payroll tools, and corporate treasury zero monthly maintenance fees.</p>
        <a href="{{ url('services') }}" class="bk-card-link">Learn More <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card bk-card--cta sr">
        <div class="bk-card-icon"><i class="ri-question-answer-line"></i></div>
        <h3>Speak to a Financial Advisor</h3>
        <p>Our certified advisors and investment specialists are available 24/7 to help you build a strategy, open an account, or select the right products.</p>
        <a href="{{ url('contact') }}" class="bk-card-link">Talk to an Advisor <i class="ri-arrow-right-line"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     HOW IT WORKS
     ============================================================ -->
<section class="bk-section">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">How It Works</span>
      <h2 class="bk-title">Open Your Account and Start in <em>Minutes</em></h2>
      <p class="bk-desc">Getting started with PRIMEGLOBOPTIONS takes under five minutes. Three simple steps stand between you and a fully functional banking and investment account.</p>
    </div>
    <div class="bk-steps">
      <div class="bk-step sr">
        <div class="bk-step-num">01</div>
        <h3>Create Account</h3>
        <p>Register online in under 5 minutes just a valid government ID and your basic details. No branch visits, no waiting.</p>
      </div>
      <div class="bk-step-line"></div>
      <div class="bk-step sr">
        <div class="bk-step-num">02</div>
        <h3>Verify &amp; Fund</h3>
        <p>Our automated, bank-grade KYC verification secures your account instantly. Deposit funds via bank transfer, card, or crypto.</p>
      </div>
      <div class="bk-step-line"></div>
      <div class="bk-step sr">
        <div class="bk-step-num">03</div>
        <h3>Bank &amp; Invest</h3>
        <p>Transfer money globally, trade live markets, build savings goals, and manage your entire financial life from one dashboard.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     INVESTMENT + BANKING FEATURES (dark section)
     ============================================================ -->
<section class="bk-features-dark" id="features">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label bk-label--light">Platform Features</span>
      <h2 class="bk-title bk-title--white">One Platform. <em>Total</em> Control Over Your Finances.</h2>
      <p class="bk-desc bk-desc--light">We fused institutional investment infrastructure with modern digital banking tools to give you an experience no traditional broker or bank can match alone.</p>
    </div>
    <div class="bk-fd-grid">
      <div class="bk-fd-item">
        <div class="bk-fd-icon"><i class="ri-line-chart-line"></i></div>
        <h4>Live Market Data</h4>
        <p>Real-time prices, charts, and depth data across stocks, forex, crypto, and commodities all in one dashboard.</p>
      </div>
      <div class="bk-fd-item">
        <div class="bk-fd-icon"><i class="ri-send-plane-fill"></i></div>
        <h4>Instant Bank Transfers</h4>
        <p>Send domestic and international payments in seconds with immediate confirmation and low fees.</p>
      </div>
      <div class="bk-fd-item">
        <div class="bk-fd-icon"><i class="ri-funds-box-line"></i></div>
        <h4>Portfolio Management</h4>
        <p>Track your investment portfolio in real time. Allocate assets, monitor performance, and rebalance with ease.</p>
      </div>
      <div class="bk-fd-item">
        <div class="bk-fd-icon"><i class="ri-fingerprint-line"></i></div>
        <h4>Biometric Security</h4>
        <p>Log in securely with fingerprint or facial identification, backed by hardware-level authentication on all devices.</p>
      </div>
      <div class="bk-fd-item">
        <div class="bk-fd-icon"><i class="ri-notification-3-line"></i></div>
        <h4>Real-Time Alerts</h4>
        <p>Receive instant SMS and email notifications for trade executions, fund movements, and account balance changes.</p>
      </div>
      <div class="bk-fd-item">
        <div class="bk-fd-icon"><i class="ri-shield-star-line"></i></div>
        <h4>AI Fraud Protection</h4>
        <p>AI-driven security monitors all transactions and trades 24/7 to detect and flag suspicious activity immediately.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     ABOUT / WHY CHOOSE US split with image
     ============================================================ -->
<section class="bk-section" id="about">
  <div class="bk-wrap">
    <div class="bk-split">
      <div class="bk-split-media sr">
        <div class="bk-img-stack">
          <img src="{{ asset('frontassets/images/banner/about-finance-new.jpg') }}" alt="PRIMEGLOBOPTIONS - Investment &amp; Banking" class="bk-img-main">
          <div class="bk-img-badge">
            <span class="bk-img-badge-num">15+</span>
            <span class="bk-img-badge-txt">Years of<br>Excellence</span>
          </div>
        </div>
      </div>
      <div class="bk-split-text sr">
        <span class="bk-label">Why Choose Us</span>
        <h2 class="bk-title">A Broker and a Bank Built on <em>Trust</em></h2>
        <p class="bk-desc" style="margin:0 0 20px">For over a decade, PRIMEGLOBOPTIONS has been redefining how people invest and bank pairing cutting-edge trading infrastructure with full-service digital banking, all secured by the highest financial-grade standards.</p>
        <div class="bk-check-list">
          <div class="bk-check-item">
            <i class="ri-checkbox-circle-fill"></i>
            <div>
              <strong>Regulated &amp; Transparent</strong>
              <p>No hidden spreads, no surprise maintenance charges honest pricing across every product we offer.</p>
            </div>
          </div>
          <div class="bk-check-item">
            <i class="ri-checkbox-circle-fill"></i>
            <div>
              <strong>Bank-Grade Multi-Layer Security</strong>
              <p>Multi-factor authentication, SSL encryption, and 24/7 continuous monitoring protect all your funds and positions.</p>
            </div>
          </div>
          <div class="bk-check-item">
            <i class="ri-checkbox-circle-fill"></i>
            <div>
              <strong>Expert Financial Advisors</strong>
              <p>Access certified investment advisors and banking specialists around the clock to help you make informed decisions.</p>
            </div>
          </div>
        </div>
        <a href="{{ url('about') }}" class="bk-btn bk-btn--fill" style="margin-top:20px">More About Us <i class="ri-arrow-right-line"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     INVESTMENT MARKETS PREVIEW
     ============================================================ -->
<section class="bk-section bk-section--gray" id="markets">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Markets We Cover</span>
      <h2 class="bk-title">Trade Across All Major <em>Global Markets</em></h2>
      <p class="bk-desc">One brokerage account unlocks access to equities, currencies, digital assets, and more with transparent pricing and real-time execution.</p>
    </div>
    <div class="bk-page-grid-4" style="margin-top:36px">
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 16px"><i class="ri-stock-line"></i></div>
        <h3>Equities</h3>
        <p>Trade shares of publicly listed companies across 20+ global exchanges including NYSE, NASDAQ, and the LSE.</p>
      </div>
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 16px"><i class="ri-exchange-funds-line"></i></div>
        <h3>Forex</h3>
        <p>Access 80+ currency pairs majors, minors, and exotics with tight spreads and institutional-grade execution.</p>
      </div>
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 16px"><i class="ri-bitcoin-line"></i></div>
        <h3>Cryptocurrency</h3>
        <p>Spot-trade Bitcoin, Ethereum, and 50+ digital assets with live market depth, transparent fees, and no hidden commissions.</p>
      </div>
      <div class="bk-info-card sr" style="text-align:center">
        <div class="bk-ic-icon" style="margin:0 auto 16px"><i class="ri-funds-box-line"></i></div>
        <h3>Mutual Funds &amp; ETFs</h3>
        <p>Invest in diversified, professionally managed funds from passive index trackers to actively managed growth portfolios.</p>
      </div>
    </div>
    <div style="text-align:center;margin-top:32px">
      <a href="{{ route('register') }}" class="bk-btn bk-btn--fill">Open Trading Account <i class="ri-arrow-right-line"></i></a>
    </div>
  </div>
</section>

<!-- ============================================================
     WHY SWITCH / COMPARISON
     ============================================================ -->
<section class="bk-section">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Why Switch</span>
      <h2 class="bk-title">See the <em>Difference</em> for Yourself</h2>
      <p class="bk-desc">No waiting rooms, no fragmented accounts banking and investing under one roof, exactly how it should work.</p>
    </div>
    <div class="bk-compare sr">
      <div class="bk-compare-row bk-compare-row--head">
        <div class="bk-compare-label">Feature</div>
        <div class="bk-compare-col bk-compare-col--us">PRIMEGLOBOPTIONS</div>
        <div class="bk-compare-col">Traditional Brokers &amp; Banks</div>
      </div>
      <div class="bk-compare-row">
        <div class="bk-compare-label">Account Opening</div>
        <div class="bk-compare-col bk-compare-col--us"><i class="ri-checkbox-circle-fill"></i> Under 5 mins, fully online</div>
        <div class="bk-compare-col"><i class="ri-close-circle-line"></i> Days or weeks, branch visit</div>
      </div>
      <div class="bk-compare-row">
        <div class="bk-compare-label">Investment &amp; Banking Together</div>
        <div class="bk-compare-col bk-compare-col--us"><i class="ri-checkbox-circle-fill"></i> Single unified platform</div>
        <div class="bk-compare-col"><i class="ri-close-circle-line"></i> Separate accounts &amp; logins</div>
      </div>
      <div class="bk-compare-row">
        <div class="bk-compare-label">Global Transfer Speed</div>
        <div class="bk-compare-col bk-compare-col--us"><i class="ri-checkbox-circle-fill"></i> Real-time / Instant</div>
        <div class="bk-compare-col"><i class="ri-close-circle-line"></i> 3 – 5 business days</div>
      </div>
      <div class="bk-compare-row">
        <div class="bk-compare-label">Customer Support</div>
        <div class="bk-compare-col bk-compare-col--us"><i class="ri-checkbox-circle-fill"></i> 24/7 Live Advisors</div>
        <div class="bk-compare-col"><i class="ri-close-circle-line"></i> Business hours only</div>
      </div>
      <div class="bk-compare-row">
        <div class="bk-compare-label">Monthly Fees</div>
        <div class="bk-compare-col bk-compare-col--us"><i class="ri-checkbox-circle-fill"></i> $0 Zero Fees</div>
        <div class="bk-compare-col"><i class="ri-close-circle-line"></i> $10 – $35+ Recurring</div>
      </div>
      <div class="bk-compare-row">
        <div class="bk-compare-label">Fraud Monitoring</div>
        <div class="bk-compare-col bk-compare-col--us"><i class="ri-checkbox-circle-fill"></i> Real-time AI detection</div>
        <div class="bk-compare-col"><i class="ri-close-circle-line"></i> Delayed manual checks</div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     EXCHANGE RATES
     ============================================================ -->
<section class="bk-section bk-section--gray" id="rates">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Live FX Rates</span>
      <h2 class="bk-title">Real-Time Currency Rates, <em>No Markups</em></h2>
      <p class="bk-desc">Refreshed continuously in real time, giving you full visibility on exchange rates before you send funds or place an FX trade.</p>
    </div>
    <div class="bk-rates-wrap sr">
      <table class="bk-rates-table">
        <thead>
          <tr>
            <th>Currency Pair</th>
            <th>Buy Rate (USD)</th>
            <th>Sell Rate (USD)</th>
            <th>24h Change</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><div class="bk-cur"><img src="https://flagcdn.com/w40/gb.png" alt="GBP"><div><b>GBP</b><small>British Pound</small></div></div></td>
            <td class="bk-mono">1.2645</td>
            <td class="bk-mono">1.2590</td>
            <td><span class="bk-badge bk-badge--up">+0.12%</span></td>
            <td><a href="{{ route('register') }}" class="bk-btn-xs">Trade <i class="ri-exchange-funds-line"></i></a></td>
          </tr>
          <tr>
            <td><div class="bk-cur"><img src="https://flagcdn.com/w40/eu.png" alt="EUR"><div><b>EUR</b><small>Euro</small></div></div></td>
            <td class="bk-mono">1.0842</td>
            <td class="bk-mono">1.0790</td>
            <td><span class="bk-badge bk-badge--up">+0.08%</span></td>
            <td><a href="{{ route('register') }}" class="bk-btn-xs">Trade <i class="ri-exchange-funds-line"></i></a></td>
          </tr>
          <tr>
            <td><div class="bk-cur"><img src="https://flagcdn.com/w40/jp.png" alt="JPY"><div><b>JPY</b><small>Japanese Yen</small></div></div></td>
            <td class="bk-mono">0.00671</td>
            <td class="bk-mono">0.00665</td>
            <td><span class="bk-badge bk-badge--down">-0.15%</span></td>
            <td><a href="{{ route('register') }}" class="bk-btn-xs">Trade <i class="ri-exchange-funds-line"></i></a></td>
          </tr>
          <tr>
            <td><div class="bk-cur"><img src="https://flagcdn.com/w40/ca.png" alt="CAD"><div><b>CAD</b><small>Canadian Dollar</small></div></div></td>
            <td class="bk-mono">0.7410</td>
            <td class="bk-mono">0.7365</td>
            <td><span class="bk-badge bk-badge--up">+0.05%</span></td>
            <td><a href="{{ route('register') }}" class="bk-btn-xs">Trade <i class="ri-exchange-funds-line"></i></a></td>
          </tr>
          <tr>
            <td><div class="bk-cur"><img src="https://flagcdn.com/w40/ch.png" alt="CHF"><div><b>CHF</b><small>Swiss Franc</small></div></div></td>
            <td class="bk-mono">1.1290</td>
            <td class="bk-mono">1.1235</td>
            <td><span class="bk-badge bk-badge--down">-0.03%</span></td>
            <td><a href="{{ route('register') }}" class="bk-btn-xs">Trade <i class="ri-exchange-funds-line"></i></a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
<section class="bk-section" id="testimonials">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Client Reviews</span>
      <h2 class="bk-title">Trusted by Investors &amp; Customers <em>Worldwide</em></h2>
      <p class="bk-desc">Thousands of individuals and businesses across 50+ countries bank and invest with PRIMEGLOBOPTIONS every day.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:36px">

      <!-- Rating summary -->
      <div class="bk-info-card sr" style="text-align:center;padding:36px 28px">
        <div style="font-size:3rem;font-weight:800;color:var(--blue);line-height:1">4.9</div>
        <div style="color:#f59e0b;font-size:1.2rem;margin:8px 0">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p style="font-size:.9rem;color:var(--txt-m)">Average rating across 12,000+ verified client reviews</p>
      </div>

      <!-- Testimonial 1 -->
      <div class="bk-info-card sr" style="padding:28px">
        <div style="color:#f59e0b;font-size:1rem;margin-bottom:12px">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p style="font-size:.9rem;color:var(--txt-m);line-height:1.65;margin-bottom:16px">"Having my brokerage account and bank account in one place has completely changed how I manage money. I trade forex in the morning and pay my bills in the same dashboard it's seamless."</p>
        <div style="display:flex;align-items:center;gap:12px">
          <div style="width:40px;height:40px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem">JW</div>
          <div><strong style="font-size:.9rem">James Whitfield</strong><br><small style="color:var(--txt-m)">Private Investor, United Kingdom</small></div>
        </div>
      </div>

      <!-- Testimonial 2 -->
      <div class="bk-info-card sr" style="padding:28px">
        <div style="color:#f59e0b;font-size:1rem;margin-bottom:12px">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p style="font-size:.9rem;color:var(--txt-m);line-height:1.65;margin-bottom:16px">"The investment advisor team helped me set up a diversified portfolio across equities and mutual funds. Combined with the instant transfer feature for my business, this is the only platform I need."</p>
        <div style="display:flex;align-items:center;gap:12px">
          <div style="width:40px;height:40px;border-radius:50%;background:#10b981;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem">SM</div>
          <div><strong style="font-size:.9rem">Sarah Mitchell</strong><br><small style="color:var(--txt-m)">Business Owner, Canada</small></div>
        </div>
      </div>

      <!-- Testimonial 3 -->
      <div class="bk-info-card sr" style="padding:28px">
        <div style="color:#f59e0b;font-size:1rem;margin-bottom:12px">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p style="font-size:.9rem;color:var(--txt-m);line-height:1.65;margin-bottom:16px">"PRIMEGLOBOPTIONS gave me access to crypto and stock markets I never thought I could reach as someone based in West Africa. The international transfers are instant and the fees are absolutely fair."</p>
        <div style="display:flex;align-items:center;gap:12px">
          <div style="width:40px;height:40px;border-radius:50%;background:#8b5cf6;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem">DG</div>
          <div><strong style="font-size:.9rem">David George</strong><br><small style="color:var(--txt-m)">Crypto Trader, Nigeria</small></div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============================================================
     FINAL CTA BANNER
     ============================================================ -->
<section class="bk-cta">
  <div class="bk-wrap">
    <div class="bk-cta-box sr">
      <div class="bk-cta-content">
        <h2>Ready to Invest Smarter and Bank Better?</h2>
        <p>Join thousands of investors and customers who manage their full financial life with PRIMEGLOBOPTIONS one account, endless possibilities.</p>
        <div class="bk-cta-btns">
          <a href="{{ route('register') }}" class="bk-btn bk-btn--white">Open Free Account <i class="ri-arrow-right-line"></i></a>
          <a href="{{ url('contact') }}" class="bk-btn bk-btn--glass">Contact an Advisor <i class="ri-customer-service-2-line"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

@include('home.footer')
