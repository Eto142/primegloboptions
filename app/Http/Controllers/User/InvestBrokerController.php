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
use App\Models\Wallet;
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

        $headerNotifications = InvestNotification::where('user_id', $uid)
            ->latest()
            ->limit(5)
            ->get();
        $unreadNotificationCount = InvestNotification::where('user_id', $uid)
            ->where('is_read', false)
            ->count();

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
            'header_notifications' => $headerNotifications,
            'unread_notification_count' => $unreadNotificationCount,
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
     * 19. Trading history — real transaction records for this user.
     */
    public function tradingHistory()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['transactions'] = Transaction::where('user_id', $uid)
                                            ->orderBy('created_at', 'desc')
                                            ->get();

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
     * 21. Deposit page — Step 1: amount + destination form.
     *     Also loads this user's deposit history for display below the form.
     */
    public function deposit()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['deposits'] = Deposit::where('user_id', $uid)
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('user.investment-broker.deposit', $data);
    }

    /**
     * 21a. Deposit Step 1 POST — validate input, store in session,
     *       redirect to method picker (Step 2).
     */
    public function getDeposit(Request $request)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:10',
            'trading_name' => 'required|string|max:60',
        ]);

        $request->session()->put('invest_deposit', [
            'amount'       => $request->input('amount'),
            'trading_name' => $request->input('trading_name'),
        ]);

        return redirect()->route('user.investments.deposit.method');
    }

    /**
     * 21b. Deposit Step 2 GET — payment method picker.
     */
    public function depositMethod(Request $request)
    {
        $sessionData = $request->session()->get('invest_deposit');

        if (!$sessionData) {
            return redirect()->route('user.investments.deposit')
                ->with('error', 'Please start your deposit from the beginning.');
        }

        $data         = $this->balanceData();
        $data['data'] = $sessionData;

        return view('user.investment-broker.deposit-method', $data);
    }

    /**
     * 21c. Deposit Step 2 POST — user picks BTC / USDT / ETH.
     *       Creates a Deposit + Transaction record (pending), then shows
     *       the wallet address (Step 3).
     */
    public function makeDeposit(Request $request)
    {
        $request->validate([
            'amount'       => 'required|numeric|min:10',
            'trading_name' => 'required|string|max:60',
            'item'         => 'required|in:Bitcoin,Usdt,Ethereum',
        ]);

        $transactionId = (string) rand(10000000, 99999999);

        // Map item label to wallet_type value
        $walletTypeMap = [
            'Bitcoin'  => 'BTC',
            'Usdt'     => 'USDT',
            'Ethereum' => 'ETH',
        ];

        DB::beginTransaction();
        try {
            // Record the pending deposit using actual table columns
            Deposit::create([
                'user_id'        => Auth::id(),
                'transaction_id' => $transactionId,
                'deposit_type'   => 'crypto',
                'amount'         => $request->input('amount'),
                'status'         => 0,
            ]);

            // Record the transaction ledger entry using actual table columns
            Transaction::create([
                'user_id'                 => Auth::id(),
                'transaction_id'          => $transactionId,
                'transaction_type'        => 'Credit',
                'transaction'             => 'Deposit',
                'transaction_amount'      => $request->input('amount'),
                'wallet_type'             => $walletTypeMap[$request->input('item')] ?? $request->input('item'),
                'transaction_description' => 'Crypto deposit — ' . $request->input('trading_name')
                                             . ' via ' . $request->input('item'),
                'transaction_status'      => 'pending',
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Could not record your deposit. Please try again.']);
        }

        // Store payment context in session for the address page
        $request->session()->put('invest_deposit', [
            'amount'       => $request->input('amount'),
            'trading_name' => $request->input('trading_name'),
            'item'         => $request->input('item'),
        ]);

        return redirect()->route('user.investments.deposit.address');
    }

    /**
     * 21d. Deposit Step 3 GET — show wallet address + QR + countdown.
     *      Loads the active crypto wallet rows from this project's wallets table.
     *      Merges all rows so addresses spread across multiple records are all found.
     */
    public function depositAddress(Request $request)
    {
        $sessionData = $request->session()->get('invest_deposit');

        if (!$sessionData || empty($sessionData['item'])) {
            return redirect()->route('user.investments.deposit')
                ->with('error', 'Session expired. Please start your deposit again.');
        }

        // Merge all active crypto rows into one object so we always find the right address
        $rows = Wallet::where('method', 'crypto')
                      ->where('status', 'active')
                      ->get();

        // Build a single merged wallet with the first non-empty value per field
        $merged = (object)[
            'bitcoin_address'  => $rows->first(fn($r) => !empty($r->bitcoin_address))?->bitcoin_address,
            'ethereum_address' => $rows->first(fn($r) => !empty($r->ethereum_address))?->ethereum_address,
            'usdt_address'     => $rows->first(fn($r) => !empty($r->usdt_address))?->usdt_address,
        ];

        $data           = $this->balanceData();
        $data['data']   = $sessionData;
        $data['wallet'] = $merged;

        return view('user.investment-broker.deposit-address', $data);
    }

    /**
     * 22. Withdrawals page — form + history for this user.
     */
    public function withdrawals()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['withdrawals'] = Withdrawal::where('user_id', $uid)
                                          ->orderBy('created_at', 'desc')
                                          ->get();

        return view('user.investment-broker.withdrawals', $data);
    }

    /**
     * 22a. Store a new withdrawal request.
     */
    public function makeWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'mode'   => 'required|string',
        ]);

        $transactionId = (string) rand(10000000, 99999999);

        Withdrawal::create([
            'user_id'            => Auth::id(),
            'transaction_id'     => $transactionId,
            'amount'             => $request->input('amount'),
            'mode'               => $request->input('mode'),
            'account_name'       => $request->input('account_name'),
            'account_number'     => $request->input('account_number'),
            'bank_name'          => $request->input('bank_name'),
            'swift'              => $request->input('swift'),
            'bank_routing_number'=> $request->input('bank_routing_number'),
            'bank_country'       => $request->input('bank_country'),
            'crypto_type'        => $request->input('crypto_type'),
            'wallet_address'     => $request->input('wallet_address'),
            'status'             => 0,
        ]);

        Transaction::create([
            'user_id'                 => Auth::id(),
            'transaction_id'          => $transactionId,
            'transaction_type'        => 'Debit',
            'transaction'             => 'Withdrawal',
            'transaction_amount'      => $request->input('amount'),
            'wallet_type'             => $request->input('crypto_type'),
            'wallet_address'          => $request->input('wallet_address'),
            'transaction_description' => 'Withdrawal via ' . $request->input('mode'),
            'transaction_status'      => 'pending',
        ]);

        return redirect()->route('user.investments.withdrawals')
                         ->with('success', 'Withdrawal request submitted successfully. Awaiting admin approval.');
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

    /**
     * 32. Combined account history — deposits, withdrawals, all transactions.
     */
    public function accountHistory()
    {
        $uid  = Auth::id();
        $data = $this->balanceData();

        $data['deposits']     = Deposit::where('user_id', $uid)
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        $data['withdrawals']  = Withdrawal::where('user_id', $uid)
                                           ->orderBy('created_at', 'desc')
                                           ->get();

        $data['transactions'] = Transaction::where('user_id', $uid)
                                            ->orderBy('created_at', 'desc')
                                            ->get();

        return view('user.investment-broker.account-history', $data);
    }
}
