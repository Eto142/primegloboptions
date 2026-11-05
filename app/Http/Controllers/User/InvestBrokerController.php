<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvestPlan;
use App\Models\InvestProfit;
use App\Models\InvestDebitProfit;
use App\Models\InvestEarning;
use App\Models\InvestReferral;
use App\Models\InvestTrader;
use App\Models\InvestKyc;
use App\Models\InvestNotification;
use App\Models\Transaction;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * InvestBrokerController
 *
 * Standalone investment-broker dashboard for authenticated users.
 * Ported from the nexglobmarket_ DashboardController, namespaced under
 * User and backed by the invest_* model set.
 *
 * Every page merges the shared balance figures from balanceData() with
 * any page-specific data, then renders a view under 'user.investment-broker.'.
 */
class InvestBrokerController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // Helper: portfolio balance figures for the authenticated user.
    // Shared by every method below.
    // ─────────────────────────────────────────────────────────────
    private function balanceData(): array
    {
        $uid = Auth::id();

        $addProfit   = InvestProfit::where('user_id', $uid)->sum('amount');
        $debitProfit = InvestDebitProfit::where('user_id', $uid)->sum('amount');
        $profit      = $addProfit - $debitProfit;

        $earnings   = InvestEarning::where('user_id', $uid)->sum('amount');
        $referral   = InvestReferral::where('user_id', $uid)->sum('amount');
        $deposit    = Deposit::where('user_id', $uid)->where('status', '1')->sum('amount');
        $withdrawal = Withdrawal::where('user_id', $uid)->sum('amount') ?? 0;

        $balance = $profit + $deposit + $earnings + $referral - $withdrawal;

        $totalInvested = InvestPlan::where('user_id', $uid)
            ->whereIn('status', ['active', 'completed'])
            ->sum('amount');

        $activePlans = InvestPlan::where('user_id', $uid)
            ->where('status', 'active')
            ->count();

        $nextPlan = InvestPlan::where('user_id', $uid)
            ->where('status', 'active')
            ->whereNotNull('matures_at')
            ->orderBy('matures_at')
            ->first();

        return [
            'profit'         => $profit,
            'add_profit'      => $addProfit,
            'debit_profit'   => $debitProfit,
            'earnings'       => $earnings,
            'referral'       => $referral,
            'deposit'        => $deposit,
            'withdrawal'     => $withdrawal,
            'balance'        => $balance,
            'user_balance'   => $balance,
            'total_invested' => $totalInvested,
            'active_plans'   => $activePlans,
            'next_plan'      => $nextPlan,
            'est_returns'    => round($profit + $earnings, 2),
        ];
    }

    // ═════════════════════════════════════════════════════════════
    //  Dashboard pages
    // ═════════════════════════════════════════════════════════════

    /**
     * 1. Dashboard home — active plans and recent profit activity.
     */
    public function index()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['plans'] = InvestPlan::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['profits'] = InvestProfit::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('user.investment-broker.index', $data);
    }

    /**
     * 2. Trading view — portfolio plus full profit & withdrawal history.
     */
    public function trading()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['plans'] = InvestPlan::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['profits'] = InvestProfit::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $data['profithistory'] = InvestProfit::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['withdrawalhistory'] = Withdrawal::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.investment-broker.trading', $data);
    }

    /**
     * 3. Plans overview.
     */
    public function plans()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.plans', $data);
    }

    /**
     * 4. Traders directory.
     */
    public function traders()
    {
        $data = $this->balanceData();

        $data['traders'] = InvestTrader::all();

        return view('user.investment-broker.traders', $data);
    }

    /**
     * 5. Markets overview.
     */
    public function markets()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.markets', $data);
    }

    /**
     * 6. Stocks overview.
     */
    public function stocks()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.stocks', $data);
    }

    /**
     * 7. Crypto overview.
     */
    public function crypto()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.crypto', $data);
    }

    /**
     * 8. Mining overview.
     */
    public function mining()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.mining', $data);
    }

    /**
     * 9. Mining plans.
     */
    public function miningPlans()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.mining-plans', $data);
    }

    /**
     * 10. Trading bot.
     */
    public function bot()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.bot', $data);
    }

    /**
     * 11. Binary options.
     */
    public function binary()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.binary', $data);
    }

    /**
     * 12. Wallet.
     */
    public function wallet()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.wallet', $data);
    }

    /**
     * 13. Watchlist.
     */
    public function watchlist()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.watchlist', $data);
    }

    /**
     * 14. Trading room.
     */
    public function tradingRoom()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.trading-room', $data);
    }

    /**
     * 15. Referral program.
     */
    public function referral()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.referral', $data);
    }

    /**
     * 16. Bonuses.
     */
    public function bonus()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.bonus', $data);
    }

    /**
     * 17. Support.
     */
    public function support()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.support', $data);
    }

    /**
     * 18. Earnings breakdown.
     */
    public function earnings()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.earnings', $data);
    }

    /**
     * 19. Trading history.
     */
    public function tradingHistory()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.trading-history', $data);
    }

    /**
     * 20. Investment history.
     */
    public function investmentHistory()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.investment-history', $data);
    }

    /**
     * 21. Deposit page.
     */
    public function deposit()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.deposit', $data);
    }

    /**
     * 22. Withdrawals page.
     */
    public function withdrawals()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.withdrawals', $data);
    }

    /**
     * 23. Withdrawal method selection.
     */
    public function withdrawalSelect()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.withdrawal-select', $data);
    }

    /**
     * 24. Paginated plan history.
     */
    public function history()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['plans'] = InvestPlan::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('user.investment-broker.history', $data);
    }

    // ═════════════════════════════════════════════════════════════
    //  Plan purchases
    // ═════════════════════════════════════════════════════════════

    /**
     * 25. Store a new plan purchase request.
     *     Keeps the existing behaviour: plan is created as pending and
     *     the user is redirected back to the dashboard with a success note.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_name'     => 'required|string|max:60',
            'amount'        => 'required|numeric|min:0.01',
            'roi_percent'   => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
        ]);

        $uid           = Auth::id();
        $transactionId = rand(10000000, 99999999);
        $durationDays   = (int) $request->input('duration_days');

        InvestPlan::create([
            'user_id'        => $uid,
            'transaction_id' => $transactionId,
            'amount'         => $request->input('amount'),
            'plan_name'      => $request->input('plan_name'),
            'plan_duration'  => $durationDays . ' days',
            'roi_percent'    => $request->input('roi_percent'),
            'status'         => 'pending',
            'matures_at'     => Carbon::now()->addDays($durationDays),
        ]);

        return redirect()->route('user.investments')
            ->with('success', 'Your investment request for "' . $request->input('plan_name') . '" has been submitted and is pending activation.');
    }

    /**
     * 26. Buy a plan outright — creates an active InvestPlan and records
     *     a credited Transaction in one go, then redirects back.
     */
    public function buyPlans(Request $request)
    {
        $request->validate([
            'amount'        => 'required|numeric|min:0.01',
            'plan_name'     => 'required|string|max:60',
            'plan_duration' => 'required|string|max:60',
        ]);

        $uid           = Auth::id();
        $transactionId = (string) rand(10000000, 99999999);

        DB::transaction(function () use ($request, $uid, $transactionId) {
            InvestPlan::create([
                'user_id'        => $uid,
                'transaction_id' => $transactionId,
                'amount'         => $request->input('amount'),
                'plan_name'      => $request->input('plan_name'),
                'plan_duration'  => $request->input('plan_duration'),
                'roi_percent'    => 0,
                'status'         => 'active',
                'matures_at'     => null,
            ]);

            Transaction::create([
                'user_id'                 => $uid,
                'transaction_id'          => $transactionId,
                'transaction_type'        => 'Credit',
                'transaction'             => 'Investment',
                'transaction_amount'      => $request->input('amount'),
                'transaction_description' => 'Plan purchased: ' . $request->input('plan_name'),
                'transaction_status'      => '1',
            ]);
        });

        return redirect()->back()->with('success', 'Plan purchased successfully!');
    }

    // ═════════════════════════════════════════════════════════════
    //  Account & notifications
    // ═════════════════════════════════════════════════════════════

    /**
     * 27. User profile.
     */
    public function profile()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.profile', $data);
    }

    /**
     * 28. Account settings.
     */
    public function settings()
    {
        $data = $this->balanceData();

        return view('user.investment-broker.settings', $data);
    }

    /**
     * 29. Latest notifications (inline panel).
     */
    public function notifications()
    {
        $data = $this->balanceData();

        $data['notifications'] = InvestNotification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.investment-broker.notifications', $data);
    }

    /**
     * 30. All notifications (full page).
     */
    public function allNotifications()
    {
        $data = $this->balanceData();

        $data['notifications'] = InvestNotification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.investment-broker.all-notifications', $data);
    }

    /**
     * 31. Mark every notification for the user as read.
     */
    public function markAllRead()
    {
        InvestNotification::where('user_id', Auth::id())
            ->update(['is_read' => 1]);

        return redirect()->back();
    }
}
