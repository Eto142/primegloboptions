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

class TransferController extends Controller
{



    public function index() {

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
    
        return view('user.bank', $data);
    }

    public function skrill()
    {
        $userId = Auth::id();
        $creditTransfers = Transaction::where('user_id', $userId)
            ->where('transaction_status', '1')
            ->where('transaction_type', 'Credit')
            ->sum('transaction_amount');
        $debitTransfers = Transaction::where('user_id', $userId)
            ->where('transaction_status', '1')
            ->where('transaction_type', 'Debit')
            ->sum('transaction_amount');
        $userDeposits = Deposit::where('user_id', $userId)->where('status', '1')->sum('amount');
        $userLoans = Loan::where('user_id', $userId)->where('status', '1')->sum('amount');
        $userCards = Card::where('user_id', $userId)->sum('amount');

        $balance = $userDeposits + $creditTransfers + $userLoans - $debitTransfers - $userCards;

        return view('user.skrill', compact('balance'));
    }





    // Show recent transfers
public function Transfer()
{
    $user = Auth::user();

    // Fetch latest 5 transfers for the authenticated user
    $recentTransfers = Transfer::where('user_id', $user->id)
                        ->latest()
                        ->take(5)
                        ->get();

    return view('user.transfer.index', compact('recentTransfers'));
}



public function UserTransfer(Request $request)
{
    // First verify transaction pin
    $transaction_pin = $request->input('transaction_pin');
    if ($transaction_pin != Auth::user()->transaction_pin) {
        return back()->with('error', 'Incorrect Transaction Pin number!');
    }

    $user = Auth::user();

    // Calculate user balance
    $credit_transfers = Transaction::where('user_id', $user->id)
        ->where('transaction_status', '1')
        ->where('transaction_type', 'Credit')
        ->sum('transaction_amount');
    
    $debit_transfers = Transaction::where('user_id', $user->id)
        ->where('transaction_status', '1')
        ->where('transaction_type', 'Debit')
        ->sum('transaction_amount');
    
    $balance = $credit_transfers - $debit_transfers;

    // Manual balance check before validation
    if ($request->amount > $balance) {
        return back()->with('error', 'Insufficient balance for this transfer!');
    }

    // Validate other fields
    $validated = $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'account_number' => 'nullable|string',
        'bank_name' => 'nullable|string',
        'beneficiary_name' => 'nullable|string',
        'bank_address' => 'nullable|string',
        'routing' => 'nullable|string',
        'payment_purpose' => 'nullable|string',
        'swift_code' => 'nullable|string',
    ]);

    // Generate a random transaction ID
    $ref = rand(12344994, 76503737);
    
    // Create the transfer
    $transfer = Transfer::create([
        'user_id' => $user->id,
        'transaction_id' => $ref,
        'status' => 0,
        'amount' => $validated['amount'],
        'account_number' => $validated['account_number'] ?? null,
        'bank_name' => $validated['bank_name'] ?? null,
        'beneficiary_name' => $validated['beneficiary_name'] ?? null,
        'bank_address' => $validated['bank_address'] ?? null,
        'routing' => $validated['routing'] ?? null,
        'payment_purpose' => $validated['payment_purpose'] ?? null,
        'swift_code' => $validated['swift_code'] ?? null,
    ]);

    // Create the transaction record
    Transaction::create([
        'user_id' => $user->id,
        'transaction_id' => $ref,
        'transaction_ref' => "LN" . $ref,
        'transaction_type' => "Debit",
        'credit' => 0,
        'debit' => $validated['amount'],
        'transaction' => "Transfer",
        'transaction_amount' => $validated['amount'],
        'transaction_description' => "Bank Transfer of " . $validated['amount'],
        'transaction_status' => 0,
    ]);

    return redirect()->back()->with('success', 'Transfer request submitted successfully and is pending approval.');
}







     //    bank transfer
    public function bankTransfer(Request $request)
    {
                  
        $otp = $request->input('otp');
        $amount = $request->input('amount');
        $user = Auth::user();

        if ($user->user_status == 1) {
            return view('user.frozen'); // Return a view indicating the account is frozen
        }

        if ($user->user_activity == 1) {
            return view('user.moneylaundering'); // Return a view indicating the account is suspected for fraud
        }
    

        $otp = $request->input('otp');
        $amount = $request->input('amount');

    //      if($otp!=Auth::user()->otp)
    //      {
    //          return back()->with('error', ' incorrect Transfer Authorization Code!');
    //  }

        
        $transaction_pin = $request->input('transaction_pin');
        if ($transaction_pin != Auth::user()->transaction_pin) {
        return back()->with('error', ' Incorrect Transaction Pin number!');
        }


        $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
       $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
        $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
        $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['balance'] = $data['user_deposits'] + $data['credit_transfers']+ $data['user_loans']- $data['debit_transfers']- $data['user_card'];
        
        if($amount > $data['balance'])
        {
            return back()->with('error', ' Your account balance is insufficient, contact our administrator for more info!!');
        }
        


        $ref = rand(76503737, 12344994);
        $transaction = new Transaction;
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_id = "TR".$ref;
        $transaction->transaction_ref = "TR".$ref;

        $transaction->transaction_amount =  $request['amount'];
        $transaction->credit =  "0";
        $transaction->debit =  $request['amount'];;

        $transaction->transaction_type = "Debit";
        $transaction->transaction = "Bank Transfer";
        $transaction->transaction_amount = $request['amount'];
        $transaction->credit =  "0";
        $transaction->debit = $request['amount'];
        $transaction->email = Auth::user()->email;
        $transaction->transaction_description = "Transfer to ".$request['account_name'];
        $transaction->account_name = $request['account_name'];
        $transaction->account_number = $request['account_number'];
        $transaction->account_type = $request['account_type'];
        $transaction->bank_name = $request['bank_name'];
         $transaction->routing_number = $request['routing_number'];
        $transaction->transaction_status = 0;
        
        
        $email = Auth::user()->email;
        $first_name = Auth::user()->first_name;
         $currency = Auth::user()->currency;
        // $token = rand(7650, 1234);
        //  $user = Auth::user();
        // $user->otp = $token;
        // $user->save();

    //     $data = [
    //     'first_name' => Auth::user()->first_name,
    //   'token' =>  $token];
    //    Mail::to($email)->send(new SendTokenEmail($token, $first_name));
        $transaction->save();

    
    // return redirect()->route('token.page')->with('success', 'Token sent to your email. Please check your inbox.');
    
     $email = $transaction->email; // Assuming there's a user relationship in the transactions table
    $amount = $transaction->transaction_amount;
    $transactionType = $transaction->transaction; // Assuming this is the correct property name
    $transactionId = $transaction->transaction_id;
        // Compose the email message
    $data = "Your " . $currency . " " . $amount . " for " . $transactionType . " with the transaction ID " . $transactionId . " has been transfered successfully!";

    // Send the email notification
    // Mail::to($email)->send(new approveTransactionEmail($data));
    //    return redirect()->route('user.withdrawal_completed');
        return redirect()->route('user.withdrawal.code');
    }




// paypal transfer
    public function paypalTransfer(Request $request)
    {
                

        $user = Auth::user();

        if ($user->user_status == 1) {
            return view('user.frozen'); // Return a view indicating the account is frozen
        }
    
        if ($user->user_activity == 1) {
            return view('user.moneylaundering'); // Return a view indicating the account is suspected for fraud
        }

        $otp = $request->input('otp');
        $amount = $request->input('amount');

    //      if($otp!=Auth::user()->otp)
    //      {
    //          return back()->with('error', ' incorrect Transfer Authorization Code!');
    //  }


        
        $transaction_pin = $request->input('transaction_pin');
        if ($transaction_pin != Auth::user()->account_pin) {
        return back()->with('error', ' Incorrect Transaction Pin number!');
        }

   $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
       $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
        $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
        $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['balance'] = $data['user_deposits'] + $data['credit_transfers']+ $data['user_loans']- $data['debit_transfers']- $data['user_card'];
        
        
        if($amount > $data['balance'])
        {
            return back()->with('error', ' Your account balance is insufficient, contact our administrator for more info!!');
        }


        $ref = rand(76503737, 12344994);


        $transaction = new Transaction;
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_id = "PAY".$ref;
        $transaction->transaction_ref = "PAY".$ref;
        $transaction->transaction_type = "Debit";
        $transaction->email = Auth::user()->email;
        $transaction->transaction = "Paypal Withdrawal";
        $transaction->transaction_amount = $request['amount'];
        $transaction->transaction_description = "Paypal transaction";
        $transaction->transaction_status = 0;
        
        
        
         $email = Auth::user()->email;
        $first_name = Auth::user()->first_name;
        // $token = rand(7650, 1234);
        //  $user = Auth::user();
        // $user->otp = $token;
        // $user->save();

    //     $data = [
    //     'first_name' => Auth::user()->first_name,
    //   'token' =>  $token];
    //    Mail::to($email)->send(new SendTokenEmail($token, $first_name));
        $transaction->save();

        
    //     $email = Auth::user()->email;
    //     $first_name = Auth::user()->first_name;
    //     $token = rand(7650, 1234);

    //     $data = [
    //   'first_name' => Auth::user()->first_name,
    //   'token' =>  $token,
    //    ];
    // Mail::to($email)->send(new SendTokenEmail($token, $first_name));

    // return redirect()->route('token.page')->with('success', 'Token sent to your email. Please check your inbox.');
    
     $email = $transaction->email; // Assuming there's a user relationship in the transactions table
    $amount = $transaction->transaction_amount;
    $transactionType = $transaction->transaction; // Assuming this is the correct property name
    $transactionId = $transaction->transaction_id;
        // Compose the email message
    $data = "Your $" . $amount . " for " . $transactionType . " with the transaction ID " . $transactionId . " has been transfered successfully!";

    // Send the email notification
    Mail::to($email)->send(new approveTransactionEmail($data));
       return redirect()->route('withdrawal_completed');
    }


    public function skrillTransfer(Request $request)
    {
                
        $otp = $request->input('otp');
        $amount = $request->input('amount');
        $user = Auth::user();

        if ($user->user_status == 1) {
            return view('user.frozen'); // Return a view indicating the account is frozen
        }
        if ($user->user_activity == 1) {
            return view('user.moneylaundering'); // Return a view indicating the account is suspected for fraud
        }

        $otp = $request->input('otp');
        $amount = $request->input('amount');

    //      if($otp!=Auth::user()->otp)
    //      {
    //          return back()->with('error', ' incorrect Transfer Authorization Code!');
    //  }


         
        $transaction_pin = $request->input('transaction_pin');
        if ($transaction_pin != Auth::user()->account_pin) {
        return back()->with('error', ' Incorrect Transaction Pin number!');
        }
         $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
       $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
        $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
        $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['balance'] = $data['user_deposits'] + $data['credit_transfers']+ $data['user_loans']- $data['debit_transfers']- $data['user_card'];
        
        if($amount > $data['balance'])
        {
            return back()->with('error', ' Your account balance is insufficient, contact our administrator for more info!!');
        }


        $ref = rand(76503737, 12344994);


        $transaction = new Transaction;
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_id = "SKR".$ref;
        $transaction->transaction_ref = "SKR".$ref;
        $transaction->transaction_type = "Debit";
        $transaction->transaction = "Skrill Withdrawal";
        $transaction->email = Auth::user()->email;
        $transaction->transaction_amount = $request['amount'];
        $transaction->transaction_description = "Skrill Withdrawal transaction";
        $transaction->transaction_status = 0;
        
         $email = Auth::user()->email;
        $first_name = Auth::user()->first_name;
        // $token = rand(7650, 1234);
        //  $user = Auth::user();
        // $user->otp = $token;
        // $user->save();

    //     $data = [
    //     'first_name' => Auth::user()->first_name,
    //   'token' =>  $token];
    //    Mail::to($email)->send(new SendTokenEmail($token, $first_name));
        $transaction->save();

        
       
       

    // return redirect()->route('token.page')->with('success', 'Token sent to your email. Please check your inbox.');
    
     $email = $transaction->email; // Assuming there's a user relationship in the transactions table
    $amount = $transaction->transaction_amount;
    $transactionType = $transaction->transaction; // Assuming this is the correct property name
    $transactionId = $transaction->transaction_id;
        // Compose the email message
    $data = "Your $" . $amount . " for " . $transactionType . " with the transaction ID " . $transactionId . " has been transfered successfully!";

    // Send the email notification
    Mail::to($email)->send(new approveTransactionEmail($data));
       return redirect()->route('withdrawal_completed');
    }








    
    public function cryptoTransfer(Request $request)
    {
                
        $otp = $request->input('otp');
        $amount = $request->input('amount');
        
        $user = Auth::user();

        if ($user->user_status == 1) {
            return view('user.frozen'); // Return a view indicating the account is frozen
        }
    
        if ($user->user_activity == 1) {
            return view('user.moneylaundering'); // Return a view indicating the account is suspected for fraud
        }

        $otp = $request->input('otp');
        $amount = $request->input('amount');

    //      if($otp!=Auth::user()->otp)
    //      {
    //          return back()->with('error', ' incorrect Transfer Authorization Code!');
    //  }




        $transaction_pin = $request->input('transaction_pin');
        if ($transaction_pin != Auth::user()->account_pin) {
        return back()->with('error', ' Incorrect Transaction Pin number!');
        }



        $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
       $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
        $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
        $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['balance'] = $data['user_deposits'] + $data['credit_transfers']+ $data['user_loans']- $data['debit_transfers']- $data['user_card'];
        
        
         if($amount > $data['balance'])
         {
             return back()->with('error', ' Your account balance is insufficient, contact our administrator for more info!!');
     }


        $ref = rand(76503737, 12344994);


        $transaction = new Transaction;
        $transaction->user_id = Auth::user()->id;
        $transaction->transaction_id = "CRP".$ref;
        $transaction->transaction_ref = "CRP".$ref;


        $transaction->transaction_type = "Debit";
        $transaction->credit = "0";
        $transaction->transaction_amount = $request['amount'];
        $transaction->debit = $request['amount'];
        $transaction->transaction = "Crypto Withdrawal";
        $transaction->email = Auth::user()->email;
        $transaction->wallet_type = $request['wallet_type'];
        $transaction->wallet_address = $request['wallet_address'];
        $transaction->transaction_description = "Crypto Withdrawal transaction";
        $transaction->transaction_status = 0;


    
        
        $email = Auth::user()->email;
        $currency = Auth::user()->currency;
        $first_name = Auth::user()->first_name;
        // $token = rand(7650, 1234);
        //  $user = Auth::user();
        // $user->otp = $token;
    //     $user->save();

    //     $data = [
    //     'first_name' => Auth::user()->first_name,
    //   'token' =>  $token];
    //    Mail::to($email)->send(new SendTokenEmail($token, $first_name));

        $transaction->save();

        // return view('dashboard.token');
        // return redirect()->route('token.page')->with('success', 'Token sent to your email. Please check your inbox.');
        
         $email = $transaction->email; // Assuming there's a user relationship in the transactions table
    $amount = $transaction->transaction_amount;
    $transactionType = $transaction->transaction; // Assuming this is the correct property name
    $transactionId = $transaction->transaction_id;
        // Compose the email message
    $data = "Your " . $currency . " " . $amount . " for " . $transactionType . " with the transaction ID " . $transactionId . " has been transfered successfully!";

    // Send the email notification
    Mail::to($email)->send(new approveTransactionEmail($data));
       return redirect()->route('withdrawal_completed');
    }
 


}