<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function showLogForm()
    {
        return view('home.yo');
    }


//  public function login(Request $request)
// {
//     try {
//         // Validate request data (either email or phone, plus password)
//         $validator = Validator::make($request->all(), [
//             'email' => 'required|string',
//             'password' => 'required',
//         ]);

//         if ($validator->fails()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Validation error',
//                 'errors' => $validator->errors()
//             ], 422);
//         }

//         $loginInput = $request->input('email'); // field can contain email or phone number
//         $password = $request->input('password');
//         $remember = $request->boolean('remember');

//         // Determine if the input is an email or a phone number
//         $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

//         // Attempt authentication with either email or phone
//         if (Auth::attempt([$fieldType => $loginInput, 'password' => $password], $remember)) {
//             $request->session()->regenerate();

//             return response()->json([
//                 'success' => true,
//                 'message' => 'Login successful!',
//                 'redirect' => route('user.home'),
//             ]);
//         }

//         // Authentication failed
//         return response()->json([
//             'success' => false,
//             'message' => 'Invalid credentials provided.',
//             'errors' => [
//                 'email' => [trans('auth.failed')],
//             ],
//         ], 422);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'An error occurred during login. Please try again.',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }



public function login(Request $request)
{
    try {
        // ✅ Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $loginInput = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // ✅ Determine if login is via email or phone
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // ✅ Attempt login
        if (Auth::attempt([$fieldType => $loginInput, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ Send professional login alert email
            try {
                $time = now()->format('d M Y, h:i A');
                $ip = $request->ip();

                Mail::send('emails.login-alert', [
                    'user' => $user,
                    'time' => $time,
                    'ip' => $ip,
                ], function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Login Alert - TopSavers Bank');
                });

            } catch (\Exception $mailError) {
                \Log::error('Login email failed: ' . $mailError->getMessage());
            }

            // ✅ Return success response
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => route('user.home'),
            ]);
        }

        // ❌ If authentication fails
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials provided.',
            'errors' => [
                'email' => [trans('auth.failed')],
            ],
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred during login. Please try again.',
            'error' => $e->getMessage(),
        ], 500);
    }
}




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
