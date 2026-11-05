<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use App\Models\Loan;
use App\Models\Debit;
use App\Models\Credit;
use App\Models\Wallet;
use App\Models\Deposit;
use App\Models\Transfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    //

   public function index()
{
    $userId = Auth::id();

    // Fetch active wallets
    $wallets = Wallet::where('status', 'active')->get();

    // Transactions summary
    $creditTransfers = Transaction::where('user_id', $userId)
        ->where('transaction_status', '1')
        ->where('transaction_type', 'Credit')
        ->sum('transaction_amount');

    $debitTransfers = Transaction::where('user_id', $userId)
        ->where('transaction_status', '1')
        ->where('transaction_type', 'Debit')
        ->sum('transaction_amount');

    // Other financial data
    $data = [
        'credit_transfers' => $creditTransfers,
        'debit_transfers'  => $debitTransfers,
        'user_deposits'    => Deposit::where('user_id', $userId)->where('status', '1')->sum('amount'),
        'user_loans'       => Loan::where('user_id', $userId)->where('status', '1')->sum('amount'),
        'user_transfer'    => Transfer::where('user_id', $userId)->sum('amount'),
        'user_credit'      => Credit::where('user_id', $userId)->where('status', '1')->sum('amount'),
        'user_debit'       => Debit::where('user_id', $userId)->where('status', '1')->sum('amount'),
        'balance'          => $creditTransfers - $debitTransfers,
    ];

   return view('user.payment.index', compact('wallets'))->with($data);
}

}
