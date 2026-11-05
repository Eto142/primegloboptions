<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CreditEmail;
use App\Mail\DebitEmail;
use App\Mail\TransactionNotification;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CreditDebitController extends Controller
{
    
// credit user 
public function creditUser(Request $request)
{
    // ✅ Validate incoming data
    $request->validate([
        'id' => 'required|integer',
        'amount' => 'required|numeric|min:1',
        'email' => 'required|email',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'account_number' => 'required|string',
        'currency' => 'required|string',
        'sender_name' => 'required|string',
        'sender_account' => 'required|string',
        'date' => 'required|date',
    ]);

    $ref = rand(12344994, 76503737);

    // ✅ Create credit record
    $credit = new Credit;
    $credit->user_id = $request->id;
    $credit->amount = (float) $request->amount;
    $credit->description = $request->description;
       // ✅ SAVE SENDER NAME + ACCOUNT IN THE DB
    $credit->sender_name = $request->sender_name;
    $credit->sender_account = $request->sender_account;
    $credit->status = 1;
    $credit->created_at = Carbon::parse($request->date); // use custom date
    $credit->save();

    // ✅ Create transaction record
    $transaction = new Transaction;
    $transaction->user_id = $request->id;
    $transaction->transaction_id = $credit->id;
    $transaction->transaction_ref = "CD" . $ref;
    $transaction->transaction_type = "Credit";
    $transaction->transaction = "Credit";
    $transaction->transaction_amount = (float) $request->amount;
    $transaction->transaction_description = $request->description ?? "Credit transaction";
    $transaction->transaction_status = 1;
    $transaction->created_at = Carbon::parse($request->date); // custom date too

   // ✅ SAVE SENDER NAME + ACCOUNT IN THE DB
$transaction->sender_name = $request->sender_name;
$transaction->sender_account = $request->sender_account;
    $transaction->save();

    // ✅ Prepare user data for the credit email
    $user = [
        'account_number' => $request->account_number,
        'full_name' => $request->first_name . ' ' . $request->last_name,
        'description' => $request->description,
        'amount' => (float) $request->amount,
        'date' => Carbon::parse($request->date)->format('Y-m-d H:i:s'),
        'balance' => (float) $request->balance + (float) $request->amount,
        'currency' => $request->currency,
        'ref' => "CD" . $ref,
        'sender_name' => $request->sender_name,
        'sender_account' => $request->sender_account,
    ];

    // ✅ Send credit notification email
    try {
        Mail::to($request->email)->send(new CreditEmail($user));
    } catch (\Exception $e) {
        \Log::error('Mail sending failed: ' . $e->getMessage());
        // continue even if mail fails
    }

    return back()->with('status', 'User account credited successfully.');
}




public function debitUser(Request $request)
{
    // Use correct order in rand()
    $ref = rand(12344994, 76503737);

    // Create new debit record
    $debit = new Debit;
    $debit->user_id = $request->id;
    $debit->amount = (float) $request->amount;
    $debit->description = $request->description;
    $debit->status = 1;
    $debit->save();

    // Record the transaction
    $transaction = new Transaction;
    $transaction->user_id = $request->id;
    $transaction->transaction_id = $debit->id;
    $transaction->transaction_ref = "DB" . $ref;
    $transaction->transaction_type = "Debit";
    $transaction->transaction = "Debit";
    $transaction->transaction_amount = (float) $request->amount;
    $transaction->transaction_description = "Debit Transaction";
    $transaction->transaction_status = 1;
    $transaction->save();

    // Prepare user data for mail
    $full_name = $request->name;
    $email = $request->email;
    $amount = (float) $request->amount;
    $date = Carbon::now();

    // Safely calculate balance
    $balance = (float) $request->balance - $amount;

    $description = $request->description;
    $a_number = $request->a_number;
    $currency = $request->currency;

    $user = [
        'account_number' => $a_number,
        'account_name' => $full_name,
        'full_name' => $full_name,
        'description' => $description,
        'amount' => $amount,
        'date' => $date,
        'balance' => $balance,
        'currency' => $currency,
        'ref' => "DB" . $ref,
    ];

    Mail::to($email)->send(new DebitEmail($user));

    return back()->with('status', 'User account debited successfully');
}


}
