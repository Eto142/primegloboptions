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

class WithdrawalController extends Controller
{
    //
    public function Crypto(){

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
    
        return view('user.crypto', $data);
    }




     public function Paypal(){

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
    
        return view('user.paypal', $data);
    }


    //withdrawal code

    public function WithdrawalCode(){

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
    
        return view('user.withdrawal_code', $data);
    }



     public function cryptoWithdrawal(Request $request)
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
    // Mail::to($email)->send(new approveTransactionEmail($data));
     return redirect()->route('user.withdrawal.code');
    //    return redirect()->route('withdrawal_completed');
    }




    public function PaypalWithdrawal(Request $request)
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
    // Mail::to($email)->send(new approveTransactionEmail($data));
          return redirect()->route('user.withdrawal.code');
    }




// withdrawal code verification (normal form submission)
public function verifyWithdrawalCode(Request $request)
{
    $request->validate([
        'withdrawal_code' => 'required|string|max:6',
    ]);

    $user = Auth::user();

    if ($request->withdrawal_code !== $user->withdrawal_code) {
        return redirect()->back()->withErrors(['withdrawal_code' => 'Invalid withdrawal code. Please contact support.']);
    }

    return redirect()->route('user.withdrawal.withdrawal.completed')->with('success', 'Withdrawal code verified successfully. Proceeding...');
}



 
    public function Completed()
{
    return view('user.withdrawal_completed');
}


}
