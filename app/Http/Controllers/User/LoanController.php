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

class LoanController extends Controller
{
     public function index()
    {
        return view('user.loan.index');
    }

     public function loan()
    {
        $data['outstanding_loan']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
       $data['pending_loan']= Loan::where('user_id', Auth::user()->id)->where('status','0')->sum('amount');
       $data['transaction']= Transaction::where('user_id', Auth::user()->id)->where('transaction','Loan')->get();
        $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->sum('transaction_amount');
        $data['debit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->sum('transaction_amount');
        $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
        $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['balance'] = $data['user_deposits'] + $data['credit_transfers']+ $data['user_loans']- $data['debit_transfers']- $data['user_card'];
        return view('user.loan', $data);
    }


     
     public function makeLoan(Request $request)
      { 
         $amount = $request->input('amount');
         $reason = $request->input('reason');

         



        // Check if the user has already made a pending loan request
         $existingLoanRequest = Loan::where('user_id', Auth::user()->id)
             ->where('status', 'pending')
             ->first();
    
         if ($existingLoanRequest) {
             return back()->with('error', 'You already have a pending loan request.');
         }

         

       
         if($amount > Auth::user()->eligible_loan)
         {
             return back()->with('error', ' You are not eligible, please check your Eligibility or contact our administrator for more info!!');
         }

         $data['user_transfers']= Transfer::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
         $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
         $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
         $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
         $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
          $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
         $data['balance'] = $data['user_deposits']+  $data['user_credit'] + $data['user_loans']- $data['user_debit'] - $data['user_card'];

         $data['data'] =  $request->all();
       $formData =  $request->all();
         $request->session()->put('data', $formData);

           return view('user.loanuser',$data);
     }




     public function ContinueLoan(Request $request)
{
    // Validate inputs
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'reason' => 'required|string|max:255',
        'ssn' => 'required|string|max:30',
        'credit_score' => 'required|numeric|min:0|max:900',
        'email' => 'required|email',
        'license' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        'photoID' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        'selfie' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $ref = rand(76503737, 12344994);   

    $loan = new Loan();
    $loan->transaction_id = $ref;
    $loan->user_id = Auth::id();
    $loan->amount = $request->input('amount');
    $loan->reason = $request->input('reason');
    $loan->ssn = $request->input('ssn');
    $loan->credit_score = $request->input('credit_score');
    $loan->email = $request->input('email');
    $loan->status = 0;

    // Secure file storage
    if ($request->hasFile('license')) {
        $licenseFile = $request->file('license');
        $licenseName = 'license_' . uniqid() . '.' . $licenseFile->getClientOriginalExtension();
        $licenseFile->storeAs('private/loan', $licenseName);
        $loan->license = $licenseName;
    }

    if ($request->hasFile('photoID')) {
        $photoIDFile = $request->file('photoID');
        $photoIDName = 'photoID_' . uniqid() . '.' . $photoIDFile->getClientOriginalExtension();
        $photoIDFile->storeAs('private/loan', $photoIDName);
        $loan->photoID = $photoIDName;
    }

    if ($request->hasFile('selfie')) {
        $selfieFile = $request->file('selfie');
        $selfieName = 'selfie_' . uniqid() . '.' . $selfieFile->getClientOriginalExtension();
        $selfieFile->storeAs('private/loan', $selfieName);
        $loan->selfie = $selfieName;
    }

    $loan->save();

    // Create transaction record
    $transaction = new Transaction();
    $transaction->user_id = Auth::id();
    $transaction->transaction_id = $ref;
    $transaction->transaction_ref = "LN" . $ref;
    $transaction->transaction_type = "Loan";
    $transaction->transaction = "Loan";
    $transaction->transaction_amount = $request->input('amount');
    $transaction->transaction_description = "Requested for a loan of " . $request->input('amount');
    $transaction->transaction_status = 0;
    $transaction->save();

    $data['data'] = $request->session()->get('data');
    return view('user.loan_completed', $data);
}





//     public function RequestLoan(Request $request)
// {
//     $user = Auth::user();

//     $validated = $request->validate([
//         'amount' => 'required|numeric|min:0.01',
//         'loan_reason' => 'nullable|string',
//     ]);

//     // Attach additional info
//     $validated['user_id'] = $user->id;

//     // Generate a random transaction ID
//     $ref = rand(12344994, 76503737); // Make sure min is less than max
//     $validated['transaction_id'] = $ref;
//     $validated['status'] = 0; // pending status

//     // Create the transfer
//     $transfer = Loan::create($validated);

//     // Create the transaction record
//     $transaction = new Transaction();
//     $transaction->user_id = $user->id;
//     $transaction->transaction_id = $ref;
//     $transaction->transaction_ref = "LN" . $ref;
//     $transaction->transaction_type = "Credit";
//     $transaction->debit = 0;
//     $transaction->credit = $validated['amount'];
//     $transaction->transaction = "Loan";
//     $transaction->transaction_amount = $validated['amount'];
//     $transaction->transaction_description = "Loan Request of " . $validated['amount'];
//     $transaction->transaction_status = 0; // pending
//     $transaction->save();

//      return redirect()->back()->with('success', 'Loan request submitted successfully and is pending approval.');
// }

}
