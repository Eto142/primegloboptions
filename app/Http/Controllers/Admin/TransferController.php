<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    //

      public function usersTransfer(){

        $user_transfers = Transfer::where('user_id', auth()->id())
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(10); // or whatever number you prefer
        return view('admin.manage_transfers', compact('user_transfers'));
    }


    public function approveTransfer(Request $request, $id)
{
    // Get the transfer with the given ID
    $transfer = Transfer::findOrFail($id);

    // Update the status of the transfer
    $transfer->status = 1;
    $transfer->save();

    // Update the status of the corresponding transaction
    Transaction::where('transaction_id', $transfer->transaction_id)
        ->update(['transaction_status' => 1]);

    $email = $transfer->user->email ?? null; // assuming relation to User
    $amount = $transfer->amount;
    $beneficiary = $transfer->beneficiary_name;
    $bank = $transfer->bank_name;

    $data = "Your transfer of $$amount to $beneficiary ($bank) has been approved successfully!";

    // Mail::to($email)->send(new ApproveTransferEmail($data));
    return redirect()->back()->with('message', 'Transfer has been approved successfully.');
}


public function declineTransfer(Request $request, $id)
{
    // Get the transfer with the given ID
    $transfer = Transfer::findOrFail($id);

    // Update the status of the transfer
    $transfer->status = 2;
    $transfer->save();

    // Update the status of the corresponding transaction
    Transaction::where('transaction_id', $transfer->transaction_id)
        ->update(['transaction_status' => 2]);

    $email = $transfer->user->email ?? null; // assuming relation to User
    $amount = $transfer->amount;
    $beneficiary = $transfer->beneficiary_name;
    $bank = $transfer->bank_name;

    $data = "Your transfer of $$amount to $beneficiary ($bank) has been declined.";

    // Mail::to($email)->send(new DeclineTransferEmail($data));
    return redirect()->back()->with('message', 'Transfer has been declined successfully.');
}

}
