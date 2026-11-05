<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestDebitProfit;
use App\Models\InvestEarning;
use App\Models\InvestPlan;
use App\Models\InvestProfit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageInvestmentController extends Controller
{
    /**
     * List all user investment plans.
     */
    public function index(Request $request)
    {
        $query = InvestPlan::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('transaction_id', 'like', "%{$search}%")
              ->orWhere('plan_name', 'like', "%{$search}%");
        }

        $plans = $query->paginate(25);

        $stats = [
            'total'       => InvestPlan::count(),
            'active'       => InvestPlan::where('status', 'active')->count(),
            'pending'      => InvestPlan::where('status', 'pending')->count(),
            'completed'    => InvestPlan::where('status', 'completed')->count(),
            'total_amount' => InvestPlan::whereIn('status', ['active', 'completed'])->sum('amount'),
        ];

        return view('admin.manage_investments', compact('plans', 'stats'));
    }

    /**
     * Activate a pending plan.
     */
    public function activate($id)
    {
        $plan = InvestPlan::findOrFail($id);

        if ($plan->status !== 'pending') {
            return back()->with('error', 'Only pending plans can be activated.');
        }

        $plan->update(['status' => 'active']);

        return back()->with('success', "Plan \"{$plan->plan_name}\" has been activated for {$plan->user->first_name} {$plan->user->last_name}.");
    }

    /**
     * Complete a plan and credit the profit to the user.
     */
    public function complete($id)
    {
        $plan = InvestPlan::with('user')->findOrFail($id);

        if ($plan->status !== 'active') {
            return back()->with('error', 'Only active plans can be marked as completed.');
        }

        $returnAmount = $plan->return_amount;
        $transactionId = rand(10000000, 99999999);

        // Record the profit
        InvestProfit::create([
            'user_id'        => $plan->user_id,
            'transaction_id' => $transactionId,
            'plan_name'      => $plan->plan_name,
            'amount'         => $returnAmount,
            'plan_type'      => 'investment',
        ]);

        $plan->update(['status' => 'completed']);

        return back()->with('success', "Plan \"{$plan->plan_name}\" completed. Profit of \${$returnAmount} credited to {$plan->user->first_name}.");
    }

    /**
     * Cancel a plan.
     */
    public function cancel($id)
    {
        $plan = InvestPlan::findOrFail($id);

        $plan->update(['status' => 'cancelled']);

        return back()->with('success', "Plan \"{$plan->plan_name}\" has been cancelled.");
    }

    /**
     * Manually add profit to a user.
     */
    public function addProfit(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'amount'   => 'required|numeric|min:0.01',
            'plan_name' => 'nullable|string|max:60',
        ]);

        $transactionId = rand(10000000, 99999999);

        InvestProfit::create([
            'user_id'        => $request->input('user_id'),
            'transaction_id' => $transactionId,
            'plan_name'      => $request->input('plan_name', 'Manual Profit'),
            'amount'         => $request->input('amount'),
            'plan_type'      => 'manual',
        ]);

        $user = User::find($request->input('user_id'));

        return back()->with('success', "Profit of \${$request->input('amount')} added to {$user->first_name} {$user->last_name}.");
    }

    /**
     * Manually add earning (referral/bonus) to a user.
     */
    public function addEarning(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|exists:users,id',
            'amount'   => 'required|numeric|min:0.01',
            'type'     => 'required|string|max:40',
            'narration' => 'required|string|max:120',
        ]);

        $transactionId = rand(10000000, 99999999);

        InvestEarning::create([
            'user_id'        => $request->input('user_id'),
            'transaction_id' => $transactionId,
            'amount'         => $request->input('amount'),
            'type'           => $request->input('type'),
            'narration'      => $request->input('narration'),
        ]);

        $user = User::find($request->input('user_id'));

        return back()->with('success', "Earning of \${$request->input('amount')} ({$request->input('type')}) added to {$user->first_name} {$user->last_name}.");
    }
}
