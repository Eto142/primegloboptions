@include('home.header')

<!-- Page Hero -->
<section class="bk-page-hero">
  <div class="bk-wrap">
    <h1>Our Services</h1>
    <p>Investment brokerage and digital banking services tailored for individuals, traders, and businesses worldwide.</p>
    <div class="bk-breadcrumb"><a href="/">Home</a> <span>/</span> Services</div>
  </div>
</section>

<!-- ============================================================
     INVESTMENT BROKERAGE SERVICES
     ============================================================ -->
<section class="bk-page-section">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Investment Services</span>
      <h2 class="bk-title">Global Investment Brokerage</h2>
      <p class="bk-desc">Access every major global market from one account stocks, forex, crypto, and managed funds with real-time data, expert guidance, and professional-grade execution tools.</p>
    </div>
    <div class="bk-cards-grid">
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-stock-line"></i></div>
        <h3>Stocks &amp; Equity Trading</h3>
        <p>Trade shares in thousands of publicly listed companies across NYSE, NASDAQ, LSE, and 20+ global exchanges. Real-time prices, market orders, limit orders, and stop-loss protection included.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Start Trading <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-exchange-funds-line"></i></div>
        <h3>Forex &amp; Currency Trading</h3>
        <p>Trade 80+ currency pairs majors like EUR/USD and GBP/JPY, minors, and exotics with tight spreads, live FX rate feeds, and institutional-grade execution on every order.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Trade Forex <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-bitcoin-line"></i></div>
        <h3>Cryptocurrency Markets</h3>
        <p>Buy, sell, and hold Bitcoin, Ethereum, and 50+ leading digital assets. Spot trading with live depth charts, real-time P&amp;L tracking, and no hidden commissions on select plans.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Explore Crypto <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-pie-chart-2-line"></i></div>
        <h3>Mutual Funds &amp; ETFs</h3>
        <p>Invest in diversified, professionally managed mutual fund portfolios and passive ETF strategies tailored to your risk appetite and investment timeline.</p>
        <a href="{{ route('register') }}" class="bk-card-link">View Funds <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-funds-box-line"></i></div>
        <h3>Portfolio &amp; Wealth Management</h3>
        <p>Work directly with our certified investment advisors to build a personalised wealth strategy from asset allocation and rebalancing to long-term capital growth planning.</p>
        <a href="{{ url('contact') }}" class="bk-card-link">Talk to an Advisor <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-target-line"></i></div>
        <h3>Savings Goals &amp; Plans</h3>
        <p>Create structured, goal-based savings plans with competitive interest rates. Track progress in real time and automate contributions toward your financial milestones.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Set a Goal <i class="ri-arrow-right-line"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     BANKING SERVICES
     ============================================================ -->
<section class="bk-page-section--alt">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Banking Services</span>
      <h2 class="bk-title">Full-Service Digital Banking</h2>
      <p class="bk-desc">Everything you expect from a modern bank with zero hidden fees, 24/7 access, and seamless integration with your investment account.</p>
    </div>
    <div class="bk-cards-grid">
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-exchange-dollar-line"></i></div>
        <h3>Global Money Transfer</h3>
        <p>Send and receive funds internationally across 50+ countries with competitive exchange rates, fast settlement, and full transparency on all fees.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Send Money <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-bank-line"></i></div>
        <h3>Personal &amp; Business Accounts</h3>
        <p>Personal checking and savings accounts plus full business current accounts and corporate treasury tools all with zero monthly maintenance fees.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Open Account <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-bank-card-line"></i></div>
        <h3>Debit &amp; Credit Cards</h3>
        <p>Multi-currency virtual and physical cards for global spending, online purchases, and ATM withdrawals zero annual fees, instant card controls.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Apply Now <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-hand-coin-line"></i></div>
        <h3>Personal &amp; Commercial Loans</h3>
        <p>Flexible personal loans, business credit lines, and financing solutions with competitive interest rates and customisable repayment terms.</p>
        <a href="{{ url('contact') }}" class="bk-card-link">Apply for a Loan <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-safe-line"></i></div>
        <h3>Fixed &amp; Tenured Deposits</h3>
        <p>Lock in guaranteed high returns on structured term deposits with fixed interest rates and flexible maturity periods from 30 days to 5 years.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Start Depositing <i class="ri-arrow-right-line"></i></a>
      </div>
      <div class="bk-card sr">
        <div class="bk-card-icon"><i class="ri-smartphone-line"></i></div>
        <h3>Mobile Banking &amp; Dashboard</h3>
        <p>Manage every aspect of your bank account and investment portfolio from any device real-time balances, transaction history, and instant alerts.</p>
        <a href="{{ route('register') }}" class="bk-card-link">Get Started <i class="ri-arrow-right-line"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="bk-page-section">
  <div class="bk-wrap">
    <div class="bk-section-top">
      <span class="bk-label">Why PRIMEGLOBOPTIONS</span>
      <h2 class="bk-title">The Advantage of One Unified Platform</h2>
      <p class="bk-desc">Most people need a broker and a bank. We give you both under the same roof, with one login and one world-class support team.</p>
    </div>
    <div class="bk-page-grid-4">
      <div class="bk-info-card sr">
        <i class="ri-global-line"></i>
        <h4>Global Market Access</h4>
        <p>Trade stocks, forex, and crypto across 20+ international exchanges and market venues from one account.</p>
      </div>
      <div class="bk-info-card sr">
        <i class="ri-user-star-line"></i>
        <h4>Certified Advisors 24/7</h4>
        <p>Dedicated investment and banking specialists available around the clock to support your financial decisions.</p>
      </div>
      <div class="bk-info-card sr">
        <i class="ri-lock-line"></i>
        <h4>Bank-Grade Security</h4>
        <p>256-bit encryption, active fraud monitoring, and multi-factor authentication on all accounts and trades.</p>
      </div>
      <div class="bk-info-card sr">
        <i class="ri-price-tag-3-line"></i>
        <h4>Zero Hidden Fees</h4>
        <p>Transparent pricing with clearly disclosed spreads, commissions, and banking charges across every service.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="bk-cta">
  <div class="bk-wrap">
    <div class="bk-cta-box sr">
      <div class="bk-cta-content">
        <h2>Start Banking and Investing Today</h2>
        <p>Open your PRIMEGLOBOPTIONS account in under 5 minutes and access every service from day one.</p>
        <div class="bk-cta-btns">
          <a href="{{ route('register') }}" class="bk-btn bk-btn--white">Open an Account <i class="ri-arrow-right-line"></i></a>
          <a href="{{ url('contact') }}" class="bk-btn bk-btn--glass">Contact an Advisor <i class="ri-phone-line"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

@include('home.footer')
