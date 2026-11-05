<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ManageCardController extends Controller
{
    //

     public function UsersCards()
{
    $user_cards = \App\Models\Card::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('admin.manage_cards', compact('user_cards'));
}


// Approve Card
    public function approveCard($id)
    {
        $card = Card::findOrFail($id);
        $card->status = 1;
        $card->save();

        Transaction::where('transaction_id', $card->transaction_id)
            ->update(['transaction_status' => 1]);

        $email = $card->email;
        $data = "Your Card has been approved successfully";
        // Mail::to($email)->send(new ApproveCardEmail($data));

        
        return redirect()->back()->with('status', 'Card has been approved successfully');
    }

    // Decline Card
    public function declineCard($id)
    {
        $card = Card::findOrFail($id);
        $card->status = 2;
        $card->save();

        Transaction::where('transaction_id', $card->transaction_id)
            ->update(['transaction_status' => 2]);

        $email = $card->email;
        $data = "Your Card has been declined successfully";
        // Mail::to($email)->send(new DeclineCardEmail($data));

        return redirect()->back()->with('status', 'Card has been declined successfully');
    }

    // Delete Card
    public function deleteCard($id)
    {
        $card = Card::findOrFail($id);
        Transaction::where('transaction_id', $card->transaction_id)
            ->delete(); // delete corresponding transaction if needed

        $card->delete();

        

        return redirect()->back()->with('status', 'Card has been deleted successfully');
    }
  
}
