<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DepositController extends Controller
{
    

     public function usersDeposit(){

        $user_deposits = Deposit::where('user_id', auth()->id())
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(10); // or whatever number you prefer
        return view('admin.manage_deposit', compact('user_deposits'));
    }


    
    public function approveDeposit(Request $request, $id)
{
    // Get the deposit with the given ID
    $deposit = Deposit::findOrFail($id);

    // Update the status of the deposit
    $deposit->status = 1;
    $deposit->save();

    // Update the status of the corresponding transaction
    Transaction::where('transaction_id', $deposit->transaction_id)->update(['transaction_status' => 1]);

     $email = $deposit->email; 
     $amount = $deposit->amount;
     $deposit_type = $deposit->deposit_type;

   $data = "Your check has been approved successfully!";

//    Mail::to($email)->send(new approveDepositEmail($data));
    return redirect()->back()->with('message', 'Your check Has Been Approved Successfully');
}




public function DeclineDeposit(Request $request, $id)
{
    // Get the deposit with the given ID
    $deposit = Deposit::findOrFail($id);

    // Update the status of the deposit
    $deposit->status = 2;
    $deposit->save();

    // Update the status of the corresponding transaction
    Transaction::where('transaction_id', $deposit->transaction_id)->update(['transaction_status' => 2]);
     $email = $deposit->email; 
     $amount = $deposit->amount;
     $reason = $deposit->reason;
    

    $data = "Your $" . $amount ." check has been declined!";

    // Mail::to($email)->send(new declineDepositEmail($data));
    return redirect()->back()->with('message', 'Deposit Has Been Declined Successfully');
}

    /**
     * Admin manually credits a deposit for a user (also records the transaction).
     */
    public function addUserDeposit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string|max:120',
            'deposit_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $transactionId = (string) rand(10000000, 99999999);
        $user = User::findOrFail($request->user_id);

        Deposit::create([
            'user_id'        => $request->user_id,
            'transaction_id' => $transactionId,
            'amount'         => $request->amount,
            'email'          => $user->email,
            'status'         => 1,
        ]);

        Transaction::create([
            'user_id'                 => $request->user_id,
            'transaction_id'          => $transactionId,
            'transaction_type'        => 'Credit',
            'transaction'             => 'Deposit',
            'transaction_amount'      => $request->amount,
            'transaction_description' => $request->description ?? 'Admin deposit',
            'transaction_status'      => '1',
        ]);

        return back()->with('success', 'Deposit added successfully.');
    }
}
