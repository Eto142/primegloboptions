<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\approveTransactionEmail;
use App\Mail\declineTransactionEmail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // <-- Add this line
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    
    public function usersTransaction(){

        $user_transactions = Transaction::with('user')
                                  ->latest()
                                  ->paginate(10); // or whatever number you prefer
        return view('admin.manage_transactions', compact('user_transactions'));
    }

    


    /**
     * Update the transaction date.
     */
    public function updateTransactionDate(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'new_date' => 'required|date',
        ]);

        // Find the transaction
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found.');
        }

        // Update the transaction date
        $transaction->created_at = Carbon::parse($request->new_date);
        $transaction->updated_at = Carbon::now(); // optional, Laravel will update automatically
        $transaction->save();

    //     return redirect()->back()->with('success', 'Transaction date updated successfully.');
 
      return back()->with('status', 'Transaction date updated successfully.');
    }




 /**
     * Approve a transaction and send email notification.
     */
    public function approveTransaction(Request $request, $id)
    {
        // Fetch transaction
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        }

        // Update status
        $transaction->transaction_status = 1; // Approved
        $transaction->save();

        // Prepare email
        $data = [
            'amount' => $transaction->transaction_amount,
            'transactionType' => $transaction->transaction_type,
            'transactionId' => $transaction->transaction_id,
        ];

        // Send email
        Mail::to($transaction->email)->send(new ApproveTransactionEmail($data));

        // return redirect()->back()->with('success', 'Transaction approved successfully.');
         return back()->with('status', 'Transaction approved successfully.');
    }

    /**
     * Decline a transaction and send email notification.
     */
    public function declineTransaction(Request $request, $id)
    {
        // Fetch transaction
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        }

        // Update status
        $transaction->transaction_status = 2; // Declined
        $transaction->save();

        // Prepare email
        $data = [
            'amount' => $transaction->transaction_amount,
            'transactionType' => $transaction->transaction_type,
            'transactionId' => $transaction->transaction_id,
        ];

        // Send email
        Mail::to($transaction->email)->send(new DeclineTransactionEmail($data));


         return back()->with('status', 'Transaction declined successfully.');
        // return redirect()->back()->with('success', 'Transaction declined successfully.');
    }


}
