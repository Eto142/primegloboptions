<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::all();
        return view('admin.manage_payment', compact('wallets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'method' => 'required|string',
            'status' => 'required|string',
            'bitcoin_address' => 'nullable|string',
            'ethereum_address' => 'nullable|string',
            'usdt_address' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'iban' => 'nullable|string',
            'swift' => 'nullable|string',
            'cashapp_tag' => 'nullable|string',
        ]);

        Wallet::create($validated);

        return redirect()->back()->with('status', 'Payment method added successfully!');
    }

 
    // Delete Wallet
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->delete();

        return redirect()->back()->with('status', 'Payment method deleted successfully.');
    }

    // Update Wallet
    public function update(Request $request, $id)
    {
        $wallet = Wallet::findOrFail($id);

        $request->validate([
            'method' => 'required|in:crypto,bank,cashapp',
            'status' => 'required|in:active,inactive',
            'bitcoin_address' => 'nullable|string',
            'ethereum_address' => 'nullable|string',
            'usdt_address' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'iban' => 'nullable|string',
            'swift' => 'nullable|string',
            'cashapp_tag' => 'nullable|string',
        ]);

        $wallet->update([
            'method' => $request->method,
            'status' => $request->status,
            'bitcoin_address' => $request->bitcoin_address,
            'ethereum_address' => $request->ethereum_address,
            'usdt_address' => $request->usdt_address,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'iban' => $request->iban,
            'swift' => $request->swift,
            'cashapp_tag' => $request->cashapp_tag,
        ]);

        return redirect()->back()->with('status', 'Payment method updated successfully.');
    }
}

