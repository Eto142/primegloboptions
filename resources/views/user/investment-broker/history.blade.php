<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PGO Invest — Investment History</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --gold: #C9A227;
            --gold-light: #E8C14A;
            --gold-dark: #9E7C14;
            --dark: #060b18;
            --dark2: #0d1525;
            --dark3: #111c30;
            --card-bg: #0f1d35;
            --border: rgba(201,162,39,0.15);
            --text-muted: #6b7fa3;
            --success: #00d395;
            --danger: #ff4d6a;
            --radius: 16px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark);
            color: #e2e8f0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        a { text-decoration: none; transition: var(--transition); }

        .invest-nav {
            background: rgba(6, 11, 24, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .invest-brand { display: flex; align-items: center; gap: 10px; }
        .invest-brand .brand-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff; font-weight: 800;
        }
        .invest-brand .brand-name { font-weight: 800; font-size: 1.1rem; color: #fff; letter-spacing: -0.3px; }
        .invest-brand .brand-name span { color: var(--gold); }

        .nav-right { display: flex; align-items: center; gap: 12px; }

        .balance-pill {
            background: rgba(201,162,39,0.1);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 6px 16px;
            font-size: 0.83rem;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
            color: var(--gold);
        }

        .back-btn {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: #94a3b8;
            border-radius: 10px;
            padding: 7px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }
        .back-btn:hover { background: rgba(255,255,255,0.1); color: #e2e8f0; }

        .invest-content { padding: 32px; max-width: 1100px; margin: 0 auto; }

        .page-header { margin-bottom: 28px; }
        .page-header h2 { font-weight: 800; color: #fff; font-size: 1.5rem; margin-bottom: 4px; }
        .page-header p { color: var(--text-muted); font-size: 0.88rem; }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .stat-label { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 10px; }
        .stat-value { font-size: 1.4rem; font-weight: 800; font-family: 'JetBrains Mono', monospace; color: #fff; }
        .stat-value.green { color: var(--success); }

        .history-table-wrap {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .history-table-wrap table { width: 100%; border-collapse: collapse; }
        .history-table-wrap thead { background: rgba(255,255,255,0.02); }
        .history-table-wrap th {
            text-align: left;
            padding: 14px 20px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }
        .history-table-wrap td {
            padding: 14px 20px;
            font-size: 0.84rem;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }
        .history-table-wrap tr:last-child td { border-bottom: none; }
        .history-table-wrap tr:hover td { background: rgba(201,162,39,0.03); }

        .status-badge {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-block;
        }
        .status-active    { background: rgba(0,211,149,0.12); color: var(--success); }
        .status-pending   { background: rgba(245,158,11,0.12); color: #fbbf24; }
        .status-completed { background: rgba(59,130,246,0.12); color: #60a5fa; }
        .status-cancelled { background: rgba(239,68,68,0.12); color: var(--danger); }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state .empty-icon {
            width: 64px; height: 64px; border-radius: 18px;
            background: rgba(201,162,39,0.08);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: var(--gold); margin: 0 auto 16px;
        }

        .pagination { margin-top: 24px; }
        .pagination .page-link {
            background: var(--card-bg);
            border: 1px solid var(--border);
            color: #e2e8f0;
            border-radius: 8px !important;
            margin: 0 3px;
            font-weight: 600;
        }
        .pagination .page-link:hover { background: rgba(201,162,39,0.1); color: var(--gold); }
        .pagination .active .page-link { background: var(--gold); border-color: var(--gold); color: #fff; }

        @media (max-width: 991px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .invest-content { padding: 20px 16px; }
            .history-table-wrap { overflow-x: auto; }
        }

        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--dark); }
        ::-webkit-scrollbar-thumb { background: rgba(201,162,39,0.3); border-radius: 10px; }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="invest-nav">
    <div class="invest-brand">
        <a href="{{ route('user.investments') }}" style="display:flex; align-items:center; gap:10px;">
            <div class="brand-icon">P</div>
            <div class="brand-name">PGO<span>Invest</span></div>
        </a>
    </div>
    <div class="nav-right">
        <div class="balance-pill">
            <i class="fas fa-wallet me-1"></i>
            {{ Auth::user()->currency ?? '$' }}{{ number_format(Auth::user()->balance ?? 0, 2) }}
        </div>
        <a href="{{ route('user.investments') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span class="d-none d-sm-inline">Invest</span>
        </a>
        <a href="{{ route('user.home') }}" class="back-btn">
            <i class="fas fa-home"></i>
            <span class="d-none d-sm-inline">Dashboard</span>
        </a>
    </div>
</nav>

<div class="invest-content">

    {{-- Header --}}
    <div class="page-header">
        <h2><i class="fas fa-history me-2" style="color:var(--gold);"></i> Investment History</h2>
        <p>Complete record of all your investment plan purchases and their status.</p>
    </div>

    {{-- Stats --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-label">Total Invested</div>
            <div class="stat-value">${{ number_format($total_invested ?? 0, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Net Profit</div>
            <div class="stat-value green">${{ number_format($profit ?? 0, 2) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Plans</div>
            <div class="stat-value">{{ $active_plans ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Earnings</div>
            <div class="stat-value green">${{ number_format($earnings ?? 0, 2) }}</div>
        </div>
    </div>

    {{-- History Table --}}
    <div class="history-table-wrap">
        @if ($plans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>ROI</th>
                        <th>Duration</th>
                        <th>Est. Return</th>
                        <th>Maturity</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>
                                <strong style="color:#fff;">{{ $plan->plan_name }}</strong>
                                <div style="font-size:0.7rem; color:var(--text-muted); font-family:'JetBrains Mono',monospace;">
                                    #{{ $plan->transaction_id }}
                                </div>
                            </td>
                            <td style="font-family:'JetBrains Mono',monospace; font-weight:700;">
                                ${{ number_format($plan->amount, 2) }}
                            </td>
                            <td style="color:var(--success); font-weight:700;">
                                {{ number_format($plan->roi_percent, 1) }}%
                            </td>
                            <td style="color:var(--text-muted);">{{ $plan->plan_duration }}</td>
                            <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:var(--success);">
                                +${{ number_format($plan->return_amount, 2) }}
                            </td>
                            <td style="font-size:0.78rem; color:var(--text-muted);">
                                {{ $plan->matures_at ? $plan->matures_at->format('M j, Y') : '—' }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $plan->status }}">{{ $plan->status }}</span>
                            </td>
                            <td style="font-size:0.76rem; color:var(--text-muted);">
                                {{ $plan->created_at->format('M j, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-chart-line"></i></div>
                <div style="font-weight:800; color:#fff; margin-bottom:8px; font-size:1.1rem;">No investment history</div>
                <div style="font-size:0.84rem; color:var(--text-muted); margin-bottom:24px;">
                    You haven't purchased any investment plans yet.
                </div>
                <a href="{{ route('user.investments') }}" class="back-btn" style="background:linear-gradient(135deg, var(--gold-dark), var(--gold)); border:none; color:#fff; padding:10px 28px; font-weight:700;">
                    <i class="fas fa-bolt me-1"></i> Browse Plans
                </a>
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    @if ($plans->hasPages())
        <div class="d-flex justify-content-center">
            {{ $plans->links() }}
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
