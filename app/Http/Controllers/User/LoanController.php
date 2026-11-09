<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Transaction;
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

    public function LoanUser(Request $request)
    {
        $loanData = $request->session()->get('loan_application');

        if (!$loanData) {
            return redirect()->route('user.loans.loan')->with('error', 'Start a loan application before uploading documents.');
        }

        return view('user.loanuser', ['data' => $loanData]);
    }


     
     public function makeLoan(Request $request)
      { 
         $validated = $request->validate([
             'amount' => 'required|numeric|min:1',
             'reason' => 'required|string|max:255',
         ]);

         $amount = $validated['amount'];



        // Check if the user has already made a pending loan request
         $existingLoanRequest = Loan::where('user_id', Auth::user()->id)
             ->where('status', '0')
             ->first();
    
         if ($existingLoanRequest) {
             return back()->with('error', 'You already have a pending loan request.');
         }

         

       
         if($amount > Auth::user()->eligible_loan)
         {
             return back()->with('error', ' You are not eligible, please check your Eligibility or contact our administrator for more info!!');
         }

         $request->session()->put('loan_application', [
             'amount' => $amount,
             'reason' => $validated['reason'],
         ]);

         return redirect()->route('user.loans.loan-user');
     }




     public function ContinueLoan(Request $request)
{
         $loanData = $request->session()->get('loan_application');
         if (!$loanData) {
             return redirect()->route('user.loans.loan')->with('error', 'Start a loan application before uploading documents.');
         }

         $rules = [
             'license' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
             'photoID' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
             'selfie' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ];

    if (Auth::user()->country === 'United States') {
        $rules['ssn'] = 'required|string|max:30';
        $rules['credit_score'] = 'required|numeric|min:0|max:900';
    } else {
        $rules['ssn'] = 'nullable|string|max:30';
        $rules['credit_score'] = 'nullable|numeric|min:0|max:900';
    }

    $request->validate($rules);

    $ref = rand(76503737, 12344994);   

    $loan = new Loan();
    $loan->transaction_id = $ref;
    $loan->user_id = Auth::id();
    $loan->amount = $loanData['amount'];
    $loan->reason = $loanData['reason'];
    $loan->ssn = $request->input('ssn');
    $loan->credit_score = $request->input('credit_score');
    $loan->email = Auth::user()->email;
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
    $transaction->transaction_amount = $loanData['amount'];
    $transaction->transaction_description = "Requested for a loan of " . $loanData['amount'];
    $transaction->transaction_status = 0;
    $transaction->save();

    $data['data'] = $request->session()->get('loan_application');
    $request->session()->forget('loan_application');
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
