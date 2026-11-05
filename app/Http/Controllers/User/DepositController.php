<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;




class DepositController extends Controller
{

    public function index(){

            // Load the dashboard view
     $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
    $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
    $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    // $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
     $data['user_transfer']= Transfer::where('user_id',Auth::user()->id)->sum('amount');
    $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    $data['balance'] = $data['credit_transfers'] - $data['debit_transfers'];
    
        return view('user.deposit.index', $data);
    }



public function makeDeposit(Request $request)
{
    // Validate input
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'email' => 'required|email',
        'transaction_pin' => 'required|digits:4',
        'front_cheque' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        'license' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
    ]);

    try {
        // Verify transaction pin
        if ($request->input('transaction_pin') !== Auth::user()->transaction_pin) {
            return back()->with('error', 'Incorrect Transaction Pin number!');
        }

        // Generate proper random reference
        $ref = rand(12344994, 76503737);

        // Create deposit
        $deposit = new Deposit();
        $deposit->transaction_id = $ref;
        $deposit->user_id = Auth::id();
        $deposit->amount = $request->input('amount');
        $deposit->email = $request->input('email');
        $deposit->status = 0;

        // Store files securely
        if ($request->hasFile('front_cheque')) {
            $chequeFile = $request->file('front_cheque');
            $filename = 'cheque_' . uniqid() . '.' . $chequeFile->getClientOriginalExtension();
            $chequeFile->storeAs('private/deposits', $filename);
            $deposit->front_cheque = $filename;
        }

        if ($request->hasFile('license')) {
            $licenseFile = $request->file('license');
            $licenseName = 'license_' . uniqid() . '.' . $licenseFile->getClientOriginalExtension();
            $licenseFile->storeAs('private/deposits', $licenseName);
            $deposit->license = $licenseName;
        }

        // Save deposit
        $deposit->saveOrFail();

        // Create transaction record
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->transaction_id = $ref;
        $transaction->transaction_ref = "LN" . $ref;
        $transaction->transaction_type = "Credit";
        $transaction->transaction = "Deposit";
        $transaction->transaction_amount = $request->input('amount');
        $transaction->transaction_description = "Check Deposit of " . $request->input('amount');
        $transaction->transaction_status = 0;

        // Save transaction
        $transaction->saveOrFail();

        // Optional: debug output
        // dd($deposit->toArray(), $transaction->toArray());

        return back()->with('status', 'Mobile Check Deposit detected, please wait for approval by the administrator');

    } catch (\Exception $e) {
        // Catch any errors and display them
        return back()->with('error', 'Deposit failed: ' . $e->getMessage());
    }
}












    public function check()
{
     $checks = Deposit::where('user_id', Auth::id())
        ->select('front_check', 'back_check', 'amount')
        ->get();

    return view('user.deposit.check', ['checks' => $checks]);
}


    public function crypto()
    {
        return view('user.deposit.crypto');
    }











public function store(Request $request)
{

     $transaction_pin = $request->input('transaction_pin');
        if ($transaction_pin != Auth::user()->transaction_pin) {
        return back()->with('error', ' Incorrect Transaction Pin number!');
        }  

    $user = Auth::user();

    $validated = $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'crypto_type' => 'nullable|string',
        'front_check' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'back_check' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);


    

    // Determine deposit type
    $isCheckDeposit = $request->hasFile('front_check') && $request->hasFile('back_check');
    $isCryptoDeposit = $request->filled('crypto_type');

    if (!$isCheckDeposit && !$isCryptoDeposit) {
        return back()->withErrors(['type' => 'Either a check or crypto deposit must be provided.']);
    }

    // Handle check uploads
    if ($isCheckDeposit) {
        $validated['front_check'] = $request->file('front_check')->store('deposits/checks', 'public');
        $validated['back_check'] = $request->file('back_check')->store('deposits/checks', 'public');
        $validated['crypto_type'] = null; // ensure crypto_type null for checks
    }

    // Handle crypto deposit
    if ($isCryptoDeposit) {
        $validated['front_check'] = null;
        $validated['back_check'] = null;
    }

    $validated['user_id'] = $user->id;
    $validated['amount'] = $request->input('amount');

    // Generate a transaction id (random)
    $ref = rand(76503737, 12344994);
    $validated['transaction_id'] = $ref;
    $validated['status'] = 0; // pending status

    // Create deposit record
    $deposit = Deposit::create($validated);

    // Create transaction record
    $transaction = new Transaction();
    $transaction->user_id = $user->id;
    $transaction->transaction_id = $ref;
    $transaction->transaction_ref = "LN" . $ref;
    $transaction->transaction_type = "Credit";
     $transaction->debit=  "0";
    $transaction->credit = $request['amount'];
    $transaction->transaction = "Deposit";
    $transaction->transaction_amount = $validated['amount'];
    $transaction->transaction_description = $isCheckDeposit 
        ? "Check Deposit of " . $validated['amount'] 
        : "Crypto Deposit of " . $validated['amount'];
    $transaction->transaction_status = 0; // pending
    $transaction->save();

    return redirect()->back()->with('success', 'Deposit submitted successfully.');
}


   
}
