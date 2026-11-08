<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\SavingsGoal;
use App\Models\Trade;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageUserController extends Controller
{
    public function ManageUsers()
    {
        $users = User::paginate(10);
        
        if (request()->ajax()) {
            return response()->json([
                'html' => view('admin.partials.users_table', ['users' => $users])->render(),
                'pagination' => $users->links()->render()
            ]);
        }
        
        return view('admin.manage_users', ['users' => $users]);
    }

    public function userProfile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        $data = [
            'userProfile'       => $user,
            'credit_transfers'  => Transaction::where('user_id', $id)
                                        ->where('transaction_status', '1')
                                        ->where('transaction_type', 'Credit')
                                        ->sum('transaction_amount'),

            'debit_transfers'   => Transaction::where('user_id', $id)
                                        ->where('transaction_status', '1')
                                        ->where('transaction_type', 'Debit')
                                        ->sum('transaction_amount'),

            'user_deposits'     => Deposit::where('user_id', $id)
                                        ->where('status', '1')
                                        ->sum('amount'),
                                        

            'user_loans'        => Loan::where('user_id', $id)
                                        ->where('status', '1')
                                        ->sum('amount'),

            'user_credit'       => Credit::where('user_id', $id)
                                        ->where('status', '1')
                                        ->sum('amount'),

            'user_debit'        => Debit::where('user_id', $id)
                                        ->where('status', '1')
                                        ->sum('amount'),

            'loan'              => Loan::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

            'user_deposits_list'=> Deposit::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

              'user_transfers_list'=> Transfer::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),


            'user_loans_list'   => Loan::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

             'user_cards_list'   => Card::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

            'user_transactions' => Transaction::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

            'user_savings_goals' => SavingsGoal::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

            'user_trades' => Trade::where('user_id', $id)
                                        ->latest()
                                        ->get(),

            'user_credits_list' => Credit::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),

            'user_debits_list'  => Debit::where('user_id', $id)
                                        ->orderBy('id', 'desc')
                                        ->get(),
        ];

        // ── Investment broker data ──────────────────────────────────────
        $uid = $user->id;
        $investPlans            = \App\Models\InvestPlan::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investProfits          = \App\Models\InvestProfit::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investDebitProfits     = \App\Models\InvestDebitProfit::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investEarnings         = \App\Models\InvestEarning::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investReferrals        = \App\Models\InvestReferral::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investKycs             = \App\Models\InvestKyc::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investNotifications    = \App\Models\InvestNotification::where('user_id', $uid)->orderBy('created_at', 'desc')->get();
        $investWithdrawals     = \App\Models\Withdrawal::where('user_id', $uid)->orderBy('created_at', 'desc')->get();

        $investAddProfit        = \App\Models\InvestProfit::where('user_id', $uid)->sum('amount');
        $investTotalDebitProfit = \App\Models\InvestDebitProfit::where('user_id', $uid)->sum('amount');
        $investTotalDeposit    = \App\Models\Deposit::where('user_id', $uid)->where('status', '1')->sum('amount');
        $investTotalProfit      = $investAddProfit - $investTotalDebitProfit;
        $investTotalEarning     = \App\Models\InvestEarning::where('user_id', $uid)->sum('amount');
        $investTotalBonus       = \App\Models\InvestReferral::where('user_id', $uid)->sum('amount');
        $investTotalWithdrawal  = \App\Models\Withdrawal::where('user_id', $uid)->sum('amount') ?? 0;
        $investTotalInvested    = \App\Models\InvestPlan::where('user_id', $uid)->whereIn('status', ['active', 'completed'])->sum('amount');
        $investBalance          = $investTotalDeposit + $investTotalEarning + $investTotalProfit + $investTotalBonus - $investTotalWithdrawal;

        // Plan status breakdown for the broker summary
        $investPlanPending     = \App\Models\InvestPlan::where('user_id', $uid)->where('status', 'pending')->count();
        $investPlanActive      = \App\Models\InvestPlan::where('user_id', $uid)->where('status', 'active')->count();
        $investPlanCompleted   = \App\Models\InvestPlan::where('user_id', $uid)->where('status', 'completed')->count();

        $data['investPlans']            = $investPlans;
        $data['investProfits']          = $investProfits;
        $data['investDebitProfits']     = $investDebitProfits;
        $data['investEarnings']         = $investEarnings;
        $data['investReferrals']        = $investReferrals;
        $data['investKycs']             = $investKycs;
        $data['investNotifications']    = $investNotifications;
        $data['investWithdrawals']      = $investWithdrawals;
        $data['investAddProfit']        = $investAddProfit;
        $data['investTotalDebitProfit'] = $investTotalDebitProfit;
        $data['investTotalDeposit']     = $investTotalDeposit;
        $data['investTotalProfit']      = $investTotalProfit;
        $data['investTotalEarning']     = $investTotalEarning;
        $data['investTotalBonus']       = $investTotalBonus;
        $data['investTotalWithdrawal']  = $investTotalWithdrawal;
        $data['investTotalInvested']    = $investTotalInvested;
        $data['investBalance']          = $investBalance;
        $data['investPlanPending']      = $investPlanPending;
        $data['investPlanActive']       = $investPlanActive;
        $data['investPlanCompleted']    = $investPlanCompleted;

        return view('admin.user_data', $data);
    }



        public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();


            return back()->with('status', 'User deleted successfully');
    }



    public function clearAccount($id)
    {
        $user = User::find($id);
        if ($user) {

            // Delete related records (posts, comments, likes) associated with the user
            // $user->profits()->delete();
            $user->deposits()->delete();
             $user->credits()->delete();
            $user->debits()->delete();
            $user->loans()->delete();
            $user->transactions()->delete();
            // $user->earnings()->delete();
            // $user->withdrawals()->delete();

            return back()->with('status', 'Records deleted successfully');
        } else {
            return back()->with('status', 'User Not Found');
        }
    }



    //update payment status

    public function updatePaymentStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|exists:users,id',
            'payment_status' => 'required|in:0,1', // only 0 or 1 allowed
        ]);

        // Find the user
        $user = User::findOrFail($request->id);

        // Update the payment_status
        $user->payment_status = $request->payment_status;
        $user->save();

        // Optional: send email notification if needed
        // Mail::to($user->email)->send(new PaymentStatusUpdated($user));

        return back()->with('status', 'Payment status updated successfully for ' . $user->first_name);
    }

    public function updateAccountStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status_type' => 'required|in:suspended,on_hold,frozen',
            'status' => 'required|in:0,1',
        ]);

        $statusColumns = [
            'suspended' => 'is_suspended',
            'on_hold' => 'is_on_hold',
            'frozen' => 'is_frozen',
        ];
        $statusLabels = [
            'suspended' => 'Suspension',
            'on_hold' => 'Account hold',
            'frozen' => 'Account freeze',
        ];

        $user->{$statusColumns[$validated['status_type']]} = $validated['status'] === '1';
        $user->save();

        $action = $validated['status'] === '1' ? 'enabled' : 'removed';

        return back()->with('status', $statusLabels[$validated['status_type']] . ' ' . $action . ' for ' . $user->first_name);
    }

    public function updateLoanEligibility(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = User::findOrFail($id);
        $user->eligible_loan = $validated['amount'];
        $user->save();

        return back()->with('status', 'Loan eligibility updated successfully for ' . $user->first_name);
    }

    // ── Investment broker management (per-user) ─────────────────────────

    // Update withdrawal tax code (investment broker account control)
    public function WithdrawalTaxCode(Request $request, $id)
    {
        $request->validate(['withdrawal_tax_code' => 'nullable|string|max:255']);
        $user = User::findOrFail($id);
        $user->withdrawal_tax_code = $request->withdrawal_tax_code;
        $user->save();
        return back()->with('success', 'Withdrawal tax code updated successfully.');
    }

    // Update withdrawal percentage (investment broker account control)
    public function updateWithdrawalPercentage(Request $request, $id)
    {
        $request->validate(['withdrawal_percentage' => 'required|numeric|min:0']);
        $user = User::findOrFail($id);
        $user->withdrawal_percentage = $request->withdrawal_percentage;
        $user->save();
        return back()->with('success', 'Withdrawal percentage updated successfully.');
    }

    // Update withdrawal tax amount (investment broker account control)
    public function updateWithdrawalTaxAmount(Request $request, $id)
    {
        $request->validate(['withdrawal_tax_amount' => 'required|numeric|min:0']);
        $user = User::findOrFail($id);
        $user->withdrawal_tax_amount = $request->withdrawal_tax_amount;
        $user->save();
        return back()->with('success', 'Withdrawal tax amount updated successfully.');
    }

    // Top up a user's investment profit
    public function addInvestProfit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);
        $transaction_id = rand(10000000, 99999999);
        \App\Models\InvestProfit::create([
            'user_id' => $request->user_id,
            'transaction_id' => $transaction_id,
            'plan_name' => $request->description ?? 'Manual Profit',
            'amount' => $request->amount,
            'plan_type' => 'manual',
        ]);
        return back()->with('success', 'Investment profit added successfully.');
    }

    // Debit a user's investment profit
    public function debitInvestProfit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);
        $transaction_id = rand(10000000, 99999999);
        \App\Models\InvestDebitProfit::create([
            'user_id' => $request->user_id,
            'transaction_id' => $transaction_id,
            'amount' => $request->amount,
            'note' => $request->description,
        ]);
        return back()->with('success', 'Investment profit debited successfully.');
    }

    // Add investment earning (referral/bonus)
    public function addInvestEarning(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|string|max:40',
            'narration' => 'required|string|max:120',
        ]);
        $transaction_id = rand(10000000, 99999999);
        \App\Models\InvestEarning::create([
            'user_id' => $request->user_id,
            'transaction_id' => $transaction_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'narration' => $request->narration,
        ]);
        return back()->with('success', 'Earning added successfully.');
    }

    // Add referral bonus
    public function addInvestReferral(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);
        $transaction_id = rand(10000000, 99999999);
        \App\Models\InvestReferral::create([
            'user_id' => $request->user_id,
            'transaction_id' => $transaction_id,
            'amount' => $request->amount,
        ]);
        return back()->with('success', 'Referral bonus added successfully.');
    }

    // Update signal strength
    public function updateSignalStrength(Request $request, $id)
    {
        $request->validate(['signal_strength' => 'required|integer|min:0|max:100']);
        $user = \App\Models\User::findOrFail($id);
        $user->signal_strength = $request->signal_strength;
        $user->save();
        return back()->with('success', 'Signal strength updated successfully.');
    }

    // Update notification
    public function updateNotification(Request $request, $id)
    {
        $request->validate(['update_notification' => 'required|string']);
        $user = \App\Models\User::findOrFail($id);
        $user->update_notification = $request->update_notification;
        $user->save();
        return back()->with('success', 'Notification updated successfully.');
    }

    // Update withdrawal code
    public function updateWithdrawalCode(Request $request, $id)
    {
        $request->validate(['withdrawal_code' => 'required|string']);
        $user = \App\Models\User::findOrFail($id);
        $user->withdrawal_code = $request->withdrawal_code;
        $user->save();
        return back()->with('success', 'Withdrawal code updated successfully.');
    }

    // Update withdrawal amount
    public function updateWithdrawalAmount(Request $request, $id)
    {
        $request->validate(['withdrawal_amount' => 'required|numeric|min:0']);
        $user = \App\Models\User::findOrFail($id);
        $user->withdrawal_amount = $request->withdrawal_amount;
        $user->save();
        return back()->with('success', 'Withdrawal amount updated successfully.');
    }

    // Toggle KYC notice
    public function toggleKycNotice(Request $request, $id)
    {
        $request->validate(['show_kyc_notice' => 'required|in:0,1']);
        $user = \App\Models\User::findOrFail($id);
        $user->show_kyc_notice = $request->show_kyc_notice;
        $user->save();
        return back()->with('success', 'KYC notice display updated.');
    }

    // Toggle signal display
    public function toggleSignalDisplay(Request $request, $id)
    {
        $request->validate(['show_signal_strength' => 'required|in:0,1']);
        $user = \App\Models\User::findOrFail($id);
        $user->show_signal_strength = $request->show_signal_strength;
        $user->save();
        return back()->with('success', 'Signal display updated.');
    }

    // Update profit limit status
    public function updateProfitLimitStatus(Request $request, $id)
    {
        $request->validate(['profit_limit_status' => 'required|in:0,1']);
        $user = \App\Models\User::findOrFail($id);
        $user->profit_limit_status = $request->profit_limit_status;
        $user->save();
        return back()->with('success', 'Profit limit status updated.');
    }

    // Push notification to user
    public function addInvestNotification(Request $request, $id)
    {
        $request->validate(['update_notification' => 'required|string']);
        \App\Models\InvestNotification::create([
            'user_id' => $id,
            'message' => $request->update_notification,
        ]);
        return back()->with('success', 'Notification sent successfully.');
    }

    // Delete a notification
    public function deleteInvestNotification($id)
    {
        \App\Models\InvestNotification::findOrFail($id)->delete();
        return back()->with('success', 'Notification deleted.');
    }

    // Accept KYC
    public function acceptKyc($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->kyc_status = '1';
        $user->save();
        return back()->with('success', 'KYC approved successfully.');
    }

    // Reject KYC
    public function rejectKyc($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->kyc_status = '2';
        $user->save();
        return back()->with('success', 'KYC rejected.');
    }


}
