<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalCodeUpdated;

class WithdrawalController extends Controller
{
    //


public function updateWithdrawalCode(Request $request)
{
    // Validate the request
    $request->validate([
        'id' => 'required|exists:users,id',
        'withdrawal_code' => 'required|numeric', // TAC code
    ]);

    // Find the user
    $user = User::findOrFail($request->id);

    // Update the withdrawal_code
    $user->withdrawal_code = $request->withdrawal_code;
    $user->save();

    // Send email to the user
    Mail::to($user->email)->send(new WithdrawalCodeUpdated($user));

    return back()->with('status', 'Foreign Code updated and email sent to ' . $user->first_name);
}


//update payment status

public function updatePaymentStatus(Request $request)
{
    // Validate the request
    $request->validate([
        'id' => 'required|exists:users,id',
        'payment_status' => 'required|in:0,1', // only 0 or 1 allowed
    ]);

    // Find the user
    $user = User::findOrFail($request->id);

    // Update the payment_status
    $user->payment_status = $request->payment_status;
    $user->save();

    // Optional: send email notification if needed
    // Mail::to($user->email)->send(new PaymentStatusUpdated($user));

    return back()->with('status', 'Payment status updated successfully for ' . $user->first_name);
}


}
