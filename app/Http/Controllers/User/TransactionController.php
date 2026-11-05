<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction; // Make sure you have this model
use Maatwebsite\Excel\Facades\Excel; // If you're exporting with Laravel Excel
use App\Exports\TransactionsExport;



class TransactionController extends Controller
{
    // Show all transactions
    public function index()
{
    // Get the currently authenticated user
    $user = auth()->user();

    // Fetch all transactions for this user, ordered by latest
    $allTransactions = Transaction::where('user_id', $user->id)
                                  ->latest()
                                  ->get();

    return view('user.transactions.index', compact('allTransactions'));
}


    // Show a specific transaction
    public function show(Transaction $transaction)
    {
        // Optional: Ensure user can only view their own transactions
        abort_unless($transaction->user_id == auth()->id(), 403);

        return view('user.transactions.show', compact('transaction'));
    }

    // Export transactions (assumes Laravel Excel package is used)
    public function export()
    {
        return Excel::download(new TransactionsExport(auth()->id()), 'transactions.xlsx');
    }
}


