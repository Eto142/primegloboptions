<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Show the email composition form
     */
    public function compose($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.mail.compose', compact('user'));
    }

    /**
     * Send the composed email
     */
   public function send(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'attachments.*' => 'file|max:5120',
    ]);

    try {
        $user = User::findOrFail($request->user_id);
        
        $mailData = [
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => $request->file('attachments', []),
        ];

        Mail::to($user->email)->send(new UserNotification($mailData));

        // Explicitly return a 200 status with JSON
        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully to ' . $user->email
        ], 200); // ← Explicit status code

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
            'message' => 'Validation failed'
        ], 422);

    } catch (\Exception $e) {
        Log::error('Mail send error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Show sent emails history
     */
    public function history()
    {
        // You would need to implement an EmailLog model for this
        // $emails = EmailLog::latest()->paginate(20);
        // return view('admin.mail.history', compact('emails'));
        
        return view('admin.mail.history');
    }
}