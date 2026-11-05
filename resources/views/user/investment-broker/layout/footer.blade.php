    </div>{{-- /ib-content --}}
</div>{{-- /ib-main --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ticker scroll
    (function () {
        const bar = document.getElementById('tickerBar');
        if (!bar) return;
        let clone = bar.innerHTML;
        bar.innerHTML += clone;
        let pos = 0;
        setInterval(() => {
            pos -= 1;
            if (Math.abs(pos) >= bar.scrollWidth / 2) pos = 0;
            bar.style.transform = `translateX(${pos}px)`;
        }, 20);
    })();

    // Close sidebar on route change (mobile)
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-close sidebar when clicking a link on mobile
        document.querySelectorAll('.ib-sidebar .ib-nav-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    document.getElementById('ibSidebar').classList.remove('show');
                    document.getElementById('ibOverlay').classList.remove('show');
                }
            });
        });
    });
</script>
</body>
</html>
