<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Trade;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ── User Statistics ──────────────────────────────────────────────
        $totalUsersCount   = User::count();
        $newUsersCount     = User::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $activeUsersCount  = User::where('updated_at', '>=', $now->copy()->subDays(30))->count();

        // ── Deposits ─────────────────────────────────────────────────────
        $totalDepositCount    = Deposit::bankSide()->count();
        $pendingDepositCount  = Deposit::bankSide()->where('status', 0)->count();
        $approvedDepositCount = Deposit::bankSide()->where('status', 1)->count();
        $totalDepositAmount   = Deposit::bankSide()->where('status', 1)->sum('amount');

        // ── Transfers ────────────────────────────────────────────────────
        $totalTransferCount    = Transfer::count();
        $pendingTransferCount  = Transfer::where('status', 0)->count();
        $completedTransferCount = Transfer::where('status', 1)->count();
        $totalTransferAmount   = Transfer::where('status', 1)->sum('amount');

        // ── Loans ────────────────────────────────────────────────────────
        $totalLoanCount    = Loan::count();
        $pendingLoanCount  = Loan::where('status', 0)->count();
        $approvedLoanCount = Loan::where('status', 1)->count();

        // ── Trades ───────────────────────────────────────────────────────
        $pendingTradeCount   = Trade::where('status', 'pending')->count();
        $totalTradeCount     = Trade::count();
        $completedTradeCount = Trade::where('status', 'completed')->count();
        $totalTradeVolume    = Trade::where('status', 'completed')->sum('amount_usd');

        // ── Withdrawals ──────────────────────────────────────────────────
        $totalWithdrawalCount    = Withdrawal::count();
        $pendingWithdrawalCount  = Withdrawal::where('status', 0)->count();
        $approvedWithdrawalCount = Withdrawal::where('status', 1)->count();
        $totalWithdrawalAmount   = Withdrawal::where('status', 1)->sum('amount');

        // ── Transactions ─────────────────────────────────────────────────
        $totalTransactionCount   = Transaction::count();
        $recentTransactions      = Transaction::with('user')->latest()->take(5)->get();

        // ── Recent Activity ───────────────────────────────────────────────
        $recentUsers    = User::latest()->take(6)->get();
        $recentDeposits = Deposit::bankSide()->with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            // Users
            'totalUsersCount',
            'newUsersCount',
            'activeUsersCount',
            // Deposits
            'totalDepositCount',
            'pendingDepositCount',
            'approvedDepositCount',
            'totalDepositAmount',
            // Transfers
            'totalTransferCount',
            'pendingTransferCount',
            'completedTransferCount',
            'totalTransferAmount',
            // Loans
            'totalLoanCount',
            'pendingLoanCount',
            'approvedLoanCount',
            // Trades
            'pendingTradeCount',
            'totalTradeCount',
            'completedTradeCount',
            'totalTradeVolume',
            // Withdrawals
            'totalWithdrawalCount',
            'pendingWithdrawalCount',
            'approvedWithdrawalCount',
            'totalWithdrawalAmount',
            // Transactions
            'totalTransactionCount',
            'recentTransactions',
            // Recent lists
            'recentUsers',
            'recentDeposits',
        ));
    }
}
