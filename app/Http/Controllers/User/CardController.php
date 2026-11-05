<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
      public function index()
    {
        return view('user.card.index');
    }



    

public function card()
    {
         
        $data['details'] = Card::where('user_id',Auth::user()->id)->get();
        $data['detail'] = Card::where('user_id', Auth::user()->id)->first();

        
        return view('user.card',$data);
 
    }


     public function requestCard($user_id)
    {
        // $userData = User::where('id',$user_id)->first();
        // $user_id = $userData->id;

        $existingCard = Card::where('user_id', $user_id)->first();

        // Check if the user already has a card
        if ($existingCard) {
            return back()->with('error', 'You already have a card. You cannot request another one.');
        }


        $amount = 0;

        

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
               
        // $card_number = rand(7650399737987384, 1234498894128763);  
                $card_number = '';
for ($i = 0; $i < 16; $i++) {
    $card_number .= rand(0, 9);
}    
        
        $cvc = rand(765, 123);        
        $ref = rand(76503737, 12344994);
        $startDate = date('Y-m-d');
        $expiryDate = date('Y-m-d', strtotime( $startDate.'+ 24 months'));

        $ref = rand(76503737, 12344994);   
       $card = new Card;
       $card->transaction_id = $ref;
       $card->user_id = Auth::user()->id;
        $card->card_number = $card_number;
        $card->card_cvc = $cvc;
        $card->card_expiry = $expiryDate;
        $card->email = Auth::user()->email;
        $card->status = 1;
        $card->save();

        // $transaction = new Transaction;
        // $transaction->user_id = Auth::user()->id;
        // $transaction->transaction_id = $ref;
        // $transaction->transaction_ref = "CD".$ref;
        // $transaction->transaction_type = "Debit";
        // $transaction->transaction = "Card";
        // // $transaction->transaction_amount = "10";
        // $transaction->email = Auth::user()->email;
        // $transaction->credit =  "0";
        // $transaction->debit = "0";
        // $transaction->transaction_description = "ATM Card";
        // $transaction->transaction_status = 1;
        // $transaction->save();


        return view('user.getting_card');
    }



    
     public function CardWithdrawal(){
         
          $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
        $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
        $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
        $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
        $data['balance'] = $data['user_deposits'] + $data['credit_transfers']+ $data['user_loans']- $data['debit_transfers']- $data['user_card'];
          $data['details'] = Card::where('user_id',Auth::user()->id)->get();
        return view('user.card_withdrawal', $data);
    } 



    
 public function requestCardDelivery(Request $request)
    {
       $card = Auth::user();
       $card->fname= $request['fname'];
       $card->delivery_address= $request['address'];
       $card->delivery_phone= $request['phone'];
       $card->emailAddress= $request['emailAddress'];

       $card->update();

        return view('user.getting_card_delivered');
    }
    


    
}
