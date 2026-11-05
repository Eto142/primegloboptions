<!-- Bottom Navigation Dock -->
<nav class="bottom-dock" aria-label="Main Navigation">
    <a href="{{ route('user.home') }}" class="dock-item {{ request()->routeIs('user.home') ? 'dock-item--active' : '' }}">
        <span class="dock-icon-wrap">
            <i class="fas fa-home"></i>
        </span>
        <span class="dock-label">Home</span>
    </a>

    <a href="{{ route('user.transfer.bank') }}" class="dock-item {{ request()->routeIs('user.transfer*') ? 'dock-item--active' : '' }}">
        <span class="dock-icon-wrap">
            <i class="fas fa-paper-plane"></i>
        </span>
        <span class="dock-label">Transfer</span>
    </a>

    <!-- Centre action button -->
    <a href="{{ route('user.deposit.index') }}" class="dock-item dock-item--center {{ request()->routeIs('user.deposit*') ? 'dock-item--active' : '' }}" aria-label="Deposit">
        <span class="dock-center-btn">
            <i class="fas fa-plus"></i>
        </span>
        <span class="dock-label">Deposit</span>
    </a>

    <a href="{{ route('user.transactions') }}" class="dock-item {{ request()->routeIs('user.transactions') ? 'dock-item--active' : '' }}">
        <span class="dock-icon-wrap">
            <i class="fas fa-clock-rotate-left"></i>
        </span>
        <span class="dock-label">Activity</span>
    </a>

    <a href="{{ route('user.profile') }}" class="dock-item {{ request()->routeIs('user.profile') ? 'dock-item--active' : '' }}">
        <span class="dock-icon-wrap">
            <i class="fas fa-user"></i>
        </span>
        <span class="dock-label">Profile</span>
    </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.toggle-btn');
        const overlay = document.querySelector('.overlay');
        const balanceToggle = document.getElementById('balanceToggle');
        const balanceDisplay = document.querySelector('.balance-display');
        const animateElements = document.querySelectorAll('.animate-fadein');
        
        // Toggle sidebar
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.classList.toggle('no-scroll');
            syncDock();
        });

        // Sync bottom dock left offset with sidebar state (desktop only)
        function syncDock() {
            const dock = document.querySelector('.bottom-dock');
            if (!dock) return;
            if (window.innerWidth <= 1199) {
                dock.style.left = '0';
                return;
            }
            dock.style.left = sidebar.classList.contains('collapsed')
                ? 'var(--sidebar-collapsed, 80px)'
                : 'var(--sidebar-width, 280px)';
        }

        // Run once on load so the dock is correctly positioned immediately
        syncDock();
        window.addEventListener('resize', syncDock);
        
        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.classList.remove('no-scroll');
        });
        
        // Balance toggle functionality
        if (balanceToggle && balanceDisplay) {
            balanceToggle.addEventListener('change', function() {
                if(this.checked) {
                    balanceDisplay.textContent = '{{ Auth::user()->currency }}{{ number_format($balance ?? Auth::user()->balance ?? 0, 2) }}';
                    balanceDisplay.classList.remove('balance-hidden');
                } else {
                    balanceDisplay.textContent = '••••••••';
                    balanceDisplay.classList.add('balance-hidden');
                }
            });
        }
        
        // Auto-hide sidebar on mobile when clicking a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if(window.innerWidth <= 1199) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.classList.remove('no-scroll');
                }
            });
        });
        
        // Initialize animations
        setTimeout(() => {
            animateElements.forEach(el => {
                el.style.opacity = '1';
            });
        }, 100);
        
        // Initialize spending chart
        const spendingChart = document.getElementById('spendingChart');
        if (spendingChart) {
            new Chart(spendingChart.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Transfers', 'Withdrawals', 'Payments', 'Deposits'],
                    datasets: [{
                        data: [35, 25, 20, 20],
                        backgroundColor: [
                            '#4e54c8',
                            '#11998e',
                            '#f46b45',
                            '#6c757d'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                padding: 20
                            }
                        }
                    }
                }
            });
        }
    });
    
    function triggerFileInput() {
        document.getElementById('profilePictureInput').click();
    }

    function uploadProfilePicture() {
        document.getElementById('uploadForm').submit();
    }
</script>

<style>
    /* Improved responsive styles */
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .dashboard-card {
        padding: 1.25rem;
        border-radius: 12px;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 0;
        height: 100%;
    }
    
    .card-title {
        font-size: 1.1rem;
        color: var(--secondary);
    }
    
    .balance-display {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
        transition: all 0.3s ease;
    }
    
    .account-status {
        font-size: 0.8rem;
        color: var(--success);
    }
    
    /* Card styles */
    .card-block {
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    /* Quick actions */
    .quick-actions-scroll {
        overflow-x: auto;
        padding-bottom: 10px;
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        min-width: 500px;
    }
    
    .quick-action {
        background: var(--white);
        border-radius: 8px;
        padding: 12px 8px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
        color: var(--secondary);
        text-decoration: none;
    }
    
    .quick-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        color: var(--primary);
    }
    
    .action-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        color: white;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        font-size: 1rem;
    }
    
    .action-label {
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    /* Transaction list */
    .transaction-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .transaction-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: white;
    }
    
    .icon-transfer {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    }
    
    .icon-loan {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }
    
    .icon-card {
        background: linear-gradient(135deg, #6610f2 0%, #6f42c1 100%);
    }
    
    .icon-crypto {
        background: linear-gradient(135deg, #f7931a 0%, #ff9500 100%);
    }
    
    .icon-paypal {
        background: linear-gradient(135deg, #003087 0%, #009cde 100%);
    }
    
    .icon-skrill {
        background: linear-gradient(135deg, #7acb4a 0%, #5a9e2f 100%);
    }
    
    .icon-default {
        background: linear-gradient(135deg, #adb5bd 0%, #6c757d 100%);
    }
    
    .transaction-title {
        font-size: 0.95rem;
        margin-bottom: 2px;
        color: var(--dark);
    }
    
    .transaction-meta {
        font-size: 0.75rem;
        color: var(--gray);
    }
    
    .transaction-amount {
        font-weight: 600;
        text-align: right;
    }
    
    .amount-positive {
        color: var(--success);
    }
    
    .amount-negative {
        color: var(--danger);
    }
    
    .transaction-status {
        display: block;
        font-size: 0.7rem;
        font-weight: 500;
        margin-top: 2px;
    }
    
    .status-completed {
        color: var(--success);
    }
    
    .status-pending {
        color: var(--warning);
    }
    
    .status-failed {
        color: var(--danger);
    }
    
    /* Chart container */
    .chart-container {
        position: relative;
        height: 200px;
        margin: 0 auto;
    }
    
    /* Carousel */
    .carousel-advert {
        height: 150px;
        background-size: cover;
        background-position: center;
    }
    
    .carousel-control-prev, 
    .carousel-control-next {
        width: 30px;
        height: 30px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.2);
        border-radius: 50%;
    }
    
    /* ── Bottom Navigation Dock ─────────────────────────────── */
    .bottom-dock {
        position: fixed;
        bottom: 0;
        /* On desktop, start after the sidebar so nothing is hidden under it */
        left: var(--sidebar-width, 280px);
        right: 0;
        height: 68px;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border-top: 1px solid rgba(201, 162, 39, 0.14);
        box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.07);
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 0 6px;
        z-index: 1040;
        transition: left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* When sidebar is collapsed, shrink the dock's left offset to match */
    #sidebar.collapsed ~ * .bottom-dock,
    body.sidebar-collapsed .bottom-dock {
        left: var(--sidebar-collapsed, 80px);
    }

    /* On mobile (sidebar is hidden off-canvas), dock spans full width */
    @media (max-width: 1199px) {
        .bottom-dock {
            left: 0 !important;
        }
    }

    .dock-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        flex: 1;
        text-decoration: none !important;
        color: #94a3b8;
        padding: 6px 2px;
        border-radius: 14px;
        transition: color 0.2s ease, background 0.2s ease;
        position: relative;
        -webkit-tap-highlight-color: transparent;
    }

    /* Active top-pill indicator */
    .dock-item--active::after {
        content: '';
        position: absolute;
        top: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 28px;
        height: 3px;
        border-radius: 0 0 6px 6px;
        background: #C9A227;
        box-shadow: 0 2px 8px rgba(201, 162, 39, 0.45);
    }

    /* Regular icon pill */
    .dock-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        font-size: 1rem;
        transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dock-item--active .dock-icon-wrap {
        background: linear-gradient(135deg, #C9A227, #9E7C14);
        color: #fff;
        box-shadow: 0 4px 14px rgba(201, 162, 39, 0.35);
        transform: translateY(-3px);
    }

    .dock-item:hover .dock-icon-wrap {
        background: rgba(201, 162, 39, 0.12);
        color: #C9A227;
        transform: translateY(-2px);
    }

    .dock-item--active {
        color: #9E7C14;
    }

    /* Centre FAB button */
    .dock-item--center {
        /* slightly wider tap zone */
        flex: 1.2;
    }

    .dock-center-btn {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        background: linear-gradient(135deg, #C9A227 0%, #9E7C14 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        box-shadow: 0 6px 18px rgba(201, 162, 39, 0.40);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: -6px; /* lift above bar */
    }

    .dock-item--center:hover .dock-center-btn,
    .dock-item--center.dock-item--active .dock-center-btn {
        transform: translateY(-4px) scale(1.06);
        box-shadow: 0 10px 24px rgba(201, 162, 39, 0.5);
    }

    /* Suppress default active indicator on centre item */
    .dock-item--center::after {
        display: none !important;
    }

    .dock-label {
        font-size: 0.66rem;
        font-weight: 700;
        letter-spacing: 0.2px;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        line-height: 1;
        transition: color 0.2s ease;
    }

    .dock-item--active .dock-label {
        color: #9E7C14;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767px) {
        .balance-display {
            font-size: 1.5rem;
        }
        
        .quick-actions-grid {
            grid-template-columns: repeat(6, 1fr);
            min-width: 100%;
        }
        
        .action-icon {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }
        
        .action-label {
            font-size: 0.7rem;
        }
        
        .transaction-icon {
            width: 36px;
            height: 36px;
            margin-right: 8px;
        }
        
        .transaction-title {
            font-size: 0.85rem;
        }
        
        .transaction-meta {
            font-size: 0.7rem;
        }
        
        .transaction-amount {
            font-size: 0.9rem;
        }
    }
    
    @media (min-width: 768px) {
        .carousel-advert {
            height: 200px;
        }
    }
</style>
</body>
</html>

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{asset('vendor/global/global.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('vendor/chart.js/Chart.bundle.min.js')}}"></script>

<!-- Datatable -->
<script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('js/deznav-init.js')}}"></script>
<script src="{{asset('js/demo.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--<script src="js/styleSwitcher.js"></script>-->
<script src="{{asset('js/app/app.js')}}"></script>

<script>
    (function($) {
        var table = $('#example5').DataTable({
            searching: false,
            paging: true,
            select: false,
            //info: false,         
            lengthChange: false

        });
        $('#example tbody').on('click', 'tr', function() {
            var data = table.row(this).data();

        });
    })(jQuery);
</script>


</body>

</html>