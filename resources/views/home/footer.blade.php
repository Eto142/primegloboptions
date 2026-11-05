<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="bk-footer">
  <div class="bk-wrap">
    <div class="bk-footer-grid">
      <!-- Brand -->
      <div class="bk-footer-about">
        <a href="/"><img src="{{ asset('home/asset/img/logo-white.png') }}" alt="PRIMEGLOBOPTIONS" class="bk-footer-logo" style="height:50px; width:auto;"></a>
        <p>PRIMEGLOBOPTIONS is a global investment broker and digital bank empowering individuals and businesses to trade markets, manage money, and grow wealth from one unified platform.</p>
        <div class="bk-footer-socials">
          <a href="#" aria-label="Facebook"><i class="ri-facebook-fill"></i></a>
          <a href="#" aria-label="Twitter"><i class="ri-twitter-x-line"></i></a>
          <a href="#" aria-label="LinkedIn"><i class="ri-linkedin-fill"></i></a>
          <a href="#" aria-label="Instagram"><i class="ri-instagram-line"></i></a>
        </div>
      </div>
      <!-- Quick Links -->
      <div class="bk-footer-col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="{{ url('about') }}">About Us</a></li>
          <li><a href="{{ url('services') }}">Our Services</a></li>
          <li><a href="{{ url('terms') }}">Terms of Service</a></li>
          <li><a href="{{ url('contact') }}">Contact Us</a></li>
          <li><a href="{{ url('faq') }}">Help &amp; FAQ</a></li>
        </ul>
      </div>
      <!-- Services -->
      <div class="bk-footer-col">
        <h4>Our Services</h4>
        <ul>
          <li><a href="{{ url('services') }}">Stocks &amp; Equity Trading</a></li>
          <li><a href="{{ url('services') }}">Forex &amp; Currency Trading</a></li>
          <li><a href="{{ url('services') }}">Cryptocurrency Markets</a></li>
          <li><a href="{{ url('services') }}">Mutual Funds &amp; ETFs</a></li>
          <li><a href="{{ url('services') }}">Personal &amp; Business Banking</a></li>
          <li><a href="{{ url('services') }}">Global Money Transfers</a></li>
          <li><a href="{{ url('services') }}">Loans &amp; Fixed Deposits</a></li>
        </ul>
      </div>
      <!-- Contact -->
      <div class="bk-footer-col">
        <h4>Get in Touch</h4>
        <div class="bk-footer-contact-item">
          <i class="ri-mail-line"></i>
          <div><small>Email Support</small><p><a href="mailto:support@primegloboptions.com">support@primegloboptions.com</a></p></div>
        </div>
        <div class="bk-footer-contact-item">
          <i class="ri-shield-check-line"></i>
          <div><small>Security</small><p>256-Bit SSL Encrypted</p></div>
        </div>
      </div>
    </div>
  </div>
  <div class="bk-footer-bottom">
    <div class="bk-wrap">
      <div class="bk-footer-bottom-inner">
        <p>&copy; {{ date('Y') }} PRIMEGLOBOPTIONS. All rights reserved.</p>
        <div class="bk-footer-bottom-links">
          <a href="{{ url('terms') }}">Terms</a>
          <a href="{{ url('terms') }}">Privacy</a>
          <a href="{{ url('faq') }}">Security</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Scroll to Top -->
<button class="bk-scroll-top" id="bkScrollTop" aria-label="Scroll to top"><i class="ri-arrow-up-line"></i></button>

<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<script>
(function(){
  /* --- Preloader --- */
  (function(){
    var preloader = document.getElementById('bkPreloader');
    var fill      = document.getElementById('bkPlFill');
    var pctEl     = document.getElementById('bkPlPct');
    var msgEl     = document.getElementById('bkPlMsg');
    var msgs = [
      'Initializing secure connection…',
      'Loading market data…',
      'Verifying encryption…',
      'Almost ready…'
    ];
    var count = 0;
    var dismissed = false;

    function dismiss(){
      if(dismissed) return;
      dismissed = true;
      if(fill)  fill.style.width  = '100%';
      if(pctEl) pctEl.textContent = '100%';
      setTimeout(function(){
        if(preloader) preloader.classList.add('done');
        setTimeout(function(){ if(preloader) preloader.style.display = 'none'; }, 800);
      }, 300);
    }

    var timer = setInterval(function(){
      count = Math.min(count + Math.floor(Math.random() * 4) + 1, 99);
      if(fill)  fill.style.width  = count + '%';
      if(pctEl) pctEl.textContent = count + '%';
      if(msgEl) msgEl.textContent = msgs[Math.floor(count / 25)];
    }, 28);

    window.addEventListener('load', function(){
      clearInterval(timer);
      dismiss();
    });
    setTimeout(function(){ clearInterval(timer); dismiss(); }, 4000);
  })();

  /* --- Sticky Header --- */
  var header = document.getElementById('bkHeader');
  window.addEventListener('scroll', function(){
    if(window.scrollY > 40){ header.classList.add('stuck'); }
    else { header.classList.remove('stuck'); }
  });

  /* --- Mobile Drawer --- */
  var burger = document.getElementById('bkBurger');
  var drawer = document.getElementById('bkDrawer');
  var overlay = document.getElementById('bkOverlay');
  var closeBtn = document.getElementById('bkDrawerClose');
  function openDrawer(){ drawer.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow='hidden'; }
  function closeDrawer(){ drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow=''; }
  if(burger) burger.addEventListener('click', openDrawer);
  if(closeBtn) closeBtn.addEventListener('click', closeDrawer);
  if(overlay) overlay.addEventListener('click', closeDrawer);

  /* --- Hero Carousel --- */
  var cur = 0, timer, INTERVAL = 6000;
  var track = document.getElementById('bkHeroTrack');
  var slides = track ? track.querySelectorAll('.bk-hero-slide') : [];
  var total = slides.length || 4;
  var dots = document.querySelectorAll('#bkDots button');
  var progress = document.getElementById('bkProgress');

  function go(i){
    cur = ((i % total) + total) % total;
    if(track) track.style.transform = 'translateX(-' + (cur * 100) + '%)';
    dots.forEach(function(d,idx){ d.classList.toggle('active', idx===cur); });
    resetProgress();
  }
  function resetProgress(){
    if(!progress) return;
    progress.style.transition = 'none';
    progress.style.width = '0%';
    void progress.offsetWidth;
    progress.style.transition = 'width ' + INTERVAL + 'ms linear';
    progress.style.width = '100%';
  }
  function auto(){ timer = setInterval(function(){ go(cur+1); }, INTERVAL); }
  function stopAuto(){ clearInterval(timer); }
  window.bkSlide = function(d){ stopAuto(); go(cur+d); auto(); };
  window.bkGo = function(i){ stopAuto(); go(i); auto(); };
  resetProgress(); auto();

  /* --- Scroll Top Button --- */
  var stb = document.getElementById('bkScrollTop');
  window.addEventListener('scroll', function(){
    if(stb){ stb.classList.toggle('show', window.scrollY > 350); }
  });
  if(stb) stb.addEventListener('click', function(){ window.scrollTo({top:0,behavior:'smooth'}); });

  /* --- Scroll Reveal --- */
  var srEls = document.querySelectorAll('.sr');
  if('IntersectionObserver' in window){
    var obs = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){ e.target.classList.add('in'); obs.unobserve(e.target); }
      });
    }, { threshold: 0.1 });
    srEls.forEach(function(el){ obs.observe(el); });
  } else {
    srEls.forEach(function(el){ el.classList.add('in'); });
  }
})();
</script>
</body>
</html>