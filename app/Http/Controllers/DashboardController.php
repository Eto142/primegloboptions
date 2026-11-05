<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Transaction; // Make sure you have this model
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
     // Optional: require authentication
  

    //display user dashboard
   public function index() {
    // Get the currently authenticated user
    $user = auth()->user();

    // Fetch only the latest 5 transactions for this user
    $RecentTransactions = Transaction::where('user_id', $user->id)->latest()->take(5)->get();

    $RecentActivity = Transaction::where('user_id', $user->id)->latest()->take(4)->get();

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
    
    



    //yoyo

   
         $data['transaction'] = Transaction::where('user_id', Auth::user()->id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                        
                                         $data['details'] = Card::where('user_id',Auth::user()->id)->get();
        $data['detail'] = Card::where('user_id', Auth::user()->id)->first();

    

    return view('user.home', array_merge(compact('RecentTransactions', 'RecentActivity'), $data));

}

     public function Alltransactions()
    {
        $data['credit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1')->where('transaction_type', 'Credit')->sum('transaction_amount');
        $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1')->where('transaction_type', 'Debit')->sum('transaction_amount');
        $data['user_deposits'] = Deposit::where('user_id', Auth::user()->id)->where('status', '1')->sum('amount');
        $data['user_loans'] = Loan::where('user_id', Auth::user()->id)->where('status', '1')->sum('amount');
        $data['user_transfer'] = Transfer::where('user_id', Auth::user()->id)->sum('amount');
        $data['user_credit'] = Credit::where('user_id', Auth::user()->id)->where('status', '1')->sum('amount');
        $data['user_debit'] = Debit::where('user_id', Auth::user()->id)->where('status', '1')->sum('amount');
        $data['balance'] = $data['credit_transfers'] - $data['debit_transfers'];
        $data['transaction'] = Transaction::where('user_id', Auth::user()->id)
                                       ->orderBy('created_at', 'desc')
                                       ->get();
        $data['allTransactions'] = $data['transaction'];
        return view('user.transactions', $data);
    }

    public function transactions()
    {
        return $this->Alltransactions();
    }


     public function Completed()
{
    return view('user.withdrawal_completed');
}


     public function Bills()
    {
        return view('user.bills'); // Load the dashboard view
    }

    public function Alert()
    {
        return view('user.alert'); // Load the dashboard alert
    }

    public function Help()
    {
        return view('user.help'); // Load the dashboard help
    }

    public function Setting()
    {
        return view('user.setting'); // Load the dashboard view
    }

   public function updateSettings(Request $request){
    $request->validate([
   'name' => 'string|max:255',
   'kin' => 'string|max:255',
   'email' => 'string|unique:users,email' .auth()->id,
   'country' => 'string|max:255',
   'address' => 'string|max:255',
   'phone' => 'phone',
    ]);

   $user = auth()->user;
   $user->name = $request->input('name');
   $user->kin = $request->input('kin');
   $user->email = $request->input('email');
   $user->country = $request->input('country');
   $user->address = $request->input('address');
   $user->phone = $request->input('phone');
   $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}




  public function profile()
    {

         $data['credit_transfers']= Transaction::where('user_id',Auth::user()->id)->where('transaction_status','1')->where('transaction_type', 'Credit') ->sum('transaction_amount');
    $data['debit_transfers'] = Transaction::where('user_id', Auth::user()->id)->where('transaction_status', '1') ->where('transaction_type', 'Debit')  ->sum('transaction_amount');// Include only debit transactions->sum('transaction_amount');
    $data['user_deposits']= Deposit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    $data['user_loans']= Loan::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    // $data['user_card']= Card::where('user_id',Auth::user()->id)->sum('amount');
     $data['user_transfer']= Transfer::where('user_id',Auth::user()->id)->sum('amount');
    $data['user_credit']= Credit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    $data['user_debit']= Debit::where('user_id',Auth::user()->id)->where('status','1')->sum('amount');
    $data['balance'] = $data['credit_transfers'] - $data['debit_transfers'];
         $data['transaction'] = Transaction::where('user_id', Auth::user()->id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        return view('user.profile', $data); // Load the dashboard view
       
 
    }
    
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:100',
            'address'      => 'nullable|string|max:255',
            'dob'          => 'nullable|date',
            'gender'       => 'nullable|in:Male,Female,Other',
        ]);

        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->country      = $request->country;
        $user->address      = $request->address;
        $user->dob          = $request->dob;
        $user->gender       = $request->gender;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    



   

// public function personalDp(Request $request)
// {
//     // ✅ Strict validation
//     $request->validate([
//         'image' => 'required|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
//     ]);

//     $user = Auth::user();

//     // ✅ Delete old image safely if it exists
//     if ($user->display_picture && Storage::exists('public/display/' . basename($user->display_picture))) {
//         Storage::delete('public/display/' . basename($user->display_picture));
//     }

//     if ($request->hasFile('image')) {
//         $file = $request->file('image');

//         // ✅ Double-check that it's a real image
//         $imageInfo = @getimagesize($file->getPathname());
//         if ($imageInfo === false) {
//             return back()->withErrors(['image' => 'The uploaded file is not a valid image.']);
//         }

//         // ✅ Generate safe filename
//         $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

//         // ✅ Store safely in storage/app/public/display
//         $path = $file->storeAs('public/display', $filename);

//         // ✅ Save relative public path
//         $user->display_picture = 'storage/display/' . $filename;
//     }

//     $user->save();

//     return back()->with('status', 'Profile picture updated successfully!');
// }


public function personalDp(Request $request)
{
    // ✅ Strict validation
    $request->validate([
        'image' => 'required|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
    ]);

    $user = Auth::user();

    // ✅ Delete old image safely if it exists
    if ($user->display_picture) {
        // Since we are storing the path without the 'storage/' prefix in the registration, but in this function we are storing with 'storage/display/', we need to adjust.
        // Actually, we are using the 'public' disk, so we can delete using the relative path without 'storage/'
        // But note: in the registration, we are storing as 'profile_pictures/filename.jpg'
        // So we are storing in two different directories? Let's use the same directory.

        // Let's change this function to use the same disk and directory as registration.

        // We are going to use the 'public' disk and the directory 'profile_pictures'
        // So we delete the old image from the 'profile_pictures' directory.
        $oldImage = $user->display_picture;
        if (Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }
    }

    if ($request->hasFile('image')) {
        $file = $request->file('image');

        // ✅ Double-check that it's a real image
        $imageInfo = @getimagesize($file->getPathname());
        if ($imageInfo === false) {
            return back()->withErrors(['image' => 'The uploaded file is not a valid image.']);
        }

        // ✅ Generate safe filename
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        // ✅ Store safely in storage/app/public/profile_pictures
        $path = $file->storeAs('profile_pictures', $filename, 'public');

        // ✅ Save relative path (without 'storage/')
        $user->display_picture = $path; // This will be 'profile_pictures/filename.jpg'
    }

    $user->save();

    return back()->with('status', 'Profile picture updated successfully!');
}


 public function card()
    {
         
        $data['details'] = Card::where('user_id',Auth::user()->id)->get();
        $data['detail'] = Card::where('user_id', Auth::user()->id)->first();

        
        return view('user.card',$data);
 
    }




}
