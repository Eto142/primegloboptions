<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->to('/login'); // Redirects to user/home URL
        }
        $user = Auth::user();

        if ($message = $user->accountRestrictionMessage()) {
            Auth::guard('web')->logout();
            $request->session()->regenerate();

            return redirect()->route('login')->with('error', $message);
        }

        return $next($request);
    }
}
