<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SavingsGoal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SavingsGoalController extends Controller
{
    public function index(Request $request): View
    {
        $goals = SavingsGoal::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('user.savings_goals', compact('goals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'target_amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999999.99', 'decimal:0,2'],
            'target_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        SavingsGoal::create([
            ...$validated,
            'user_id' => $request->user()->id,
            'saved_amount' => '0.00',
        ]);

        return redirect()
            ->route('user.savings-goals.index')
            ->with('status', 'Your savings goal was created.');
    }

    public function contribute(Request $request, int $goal): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999999.99', 'decimal:0,2'],
        ]);

        DB::transaction(function () use ($request, $goal, $validated): void {
            $savingsGoal = SavingsGoal::query()
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->findOrFail($goal);

            $savedCents = self::toCents($savingsGoal->saved_amount);
            $targetCents = self::toCents($savingsGoal->target_amount);
            $contributionCents = self::toCents($validated['amount']);

            if ($savedCents >= $targetCents || $contributionCents > $targetCents - $savedCents) {
                throw ValidationException::withMessages([
                    'amount' => 'The contribution must not exceed the remaining amount for this goal.',
                ]);
            }

            $savingsGoal->saved_amount = self::fromCents($savedCents + $contributionCents);
            $savingsGoal->save();
        });

        return redirect()
            ->route('user.savings-goals.index')
            ->with('status', 'Your progress was updated. This tracker does not move money or change your account balance.');
    }

    private static function toCents(string $amount): int
    {
        [$whole, $fraction] = array_pad(explode('.', $amount, 2), 2, '0');

        return ((int) $whole * 100) + (int) str_pad($fraction, 2, '0');
    }

    private static function fromCents(int $amount): string
    {
        return intdiv($amount, 100) . '.' . str_pad((string) ($amount % 100), 2, '0', STR_PAD_LEFT);
    }
}
