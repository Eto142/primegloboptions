<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

class InvestmentController extends Controller
{
    private const ASSETS = [
        'AAPL' => ['name' => 'Apple Inc.', 'category' => 'stocks'],
        'AMZN' => ['name' => 'Amazon.com', 'category' => 'stocks'],
        'MSFT' => ['name' => 'Microsoft Corp.', 'category' => 'stocks'],
        'GOOGL' => ['name' => 'Alphabet Inc.', 'category' => 'stocks'],
        'NVDA' => ['name' => 'NVIDIA Corp.', 'category' => 'stocks'],
        'META' => ['name' => 'Meta Platforms', 'category' => 'stocks'],
        'BTC' => ['name' => 'Bitcoin', 'category' => 'crypto'],
        'ETH' => ['name' => 'Ethereum', 'category' => 'crypto'],
        'SOL' => ['name' => 'Solana', 'category' => 'crypto'],
        'BNB' => ['name' => 'BNB', 'category' => 'crypto'],
        'XRP' => ['name' => 'XRP', 'category' => 'crypto'],
        'ADA' => ['name' => 'Cardano', 'category' => 'crypto'],
        'EUR/USD' => ['name' => 'Euro / US Dollar', 'category' => 'forex'],
        'GBP/USD' => ['name' => 'British Pound / US Dollar', 'category' => 'forex'],
        'USD/JPY' => ['name' => 'US Dollar / Japanese Yen', 'category' => 'forex'],
        'USD/CHF' => ['name' => 'US Dollar / Swiss Franc', 'category' => 'forex'],
        'AUD/USD' => ['name' => 'Australian Dollar / US Dollar', 'category' => 'forex'],
        'USD/CAD' => ['name' => 'US Dollar / Canadian Dollar', 'category' => 'forex'],
        'USIDX' => ['name' => 'US Equity Index Fund', 'category' => 'mutual_funds'],
        'GLBND' => ['name' => 'Global Bond Fund', 'category' => 'mutual_funds'],
        'BALNC' => ['name' => 'Balanced Allocation Fund', 'category' => 'mutual_funds'],
        'MMKT' => ['name' => 'Money Market Fund', 'category' => 'mutual_funds'],
    ];

    public function index(): View
    {
        $userId = request()->user()->id;
        $creditTransfers = Transaction::where('user_id', $userId)
            ->where('transaction_status', '1')
            ->where('transaction_type', 'Credit')
            ->sum('transaction_amount');
        $debitTransfers = Transaction::where('user_id', $userId)
            ->where('transaction_status', '1')
            ->where('transaction_type', 'Debit')
            ->sum('transaction_amount');

        $trades = Trade::where('user_id', $userId)
            ->whereNotIn('asset_symbol', self::mutualFundSymbols())
            ->latest()
            ->limit(20)
            ->get();

        return view('user.investment', [
            'assets' => array_filter(self::ASSETS, fn (array $asset): bool => $asset['category'] !== 'mutual_funds'),
            'balance' => $creditTransfers - $debitTransfers,
            'trades' => $trades,
        ]);
    }

    public function mutualFunds(Request $request): View
    {
        $fundSymbols = self::mutualFundSymbols();
        $funds = array_intersect_key(self::ASSETS, array_flip($fundSymbols));
        $trades = Trade::where('user_id', $request->user()->id)
            ->whereIn('asset_symbol', $fundSymbols)
            ->latest()
            ->limit(20)
            ->get();

        return view('user.mutual_funds', [
            'funds' => $funds,
            'trades' => $trades,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'asset_symbol' => ['required', 'string', Rule::in(array_keys(self::ASSETS))],
            'type' => ['required', Rule::in(['buy', 'sell'])],
            'order_type' => ['required', Rule::in(['market', 'limit', 'stop'])],
            'amount_usd' => ['required', 'numeric', 'min:0.01', 'decimal:0,2'],
            'quantity' => ['required', 'numeric', 'min:0.000001', 'decimal:0,6'],
            'limit_price' => [
                Rule::requiredIf(in_array($request->input('order_type'), ['limit', 'stop'], true)),
                'nullable',
                'numeric',
                'gt:0',
                'decimal:0,6',
            ],
        ]);

        $asset = self::ASSETS[$validated['asset_symbol']];

        Trade::create([
            'user_id' => $request->user()->id,
            'transaction_id' => (string) Str::uuid(),
            'asset_symbol' => $validated['asset_symbol'],
            'asset_name' => $asset['name'],
            'type' => $validated['type'],
            'order_type' => $validated['order_type'],
            'amount_usd' => $validated['amount_usd'],
            'quantity' => $validated['quantity'],
            'limit_price' => $validated['limit_price'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route($asset['category'] === 'mutual_funds' ? 'user.mutual-funds' : 'user.investment')
            ->with('status', 'Your order request was saved as pending. It has not been executed or deducted from your balance.');
    }

    private static function mutualFundSymbols(): array
    {
        return array_keys(array_filter(
            self::ASSETS,
            fn (array $asset): bool => $asset['category'] === 'mutual_funds',
        ));
    }
}
