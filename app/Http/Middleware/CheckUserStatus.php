<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // Check if user is inactive
            if (!$user->isActive()) {
                Auth::logout(); // Log out the inactive user
                return redirect()->route('login')->with('status', 'Your account is inactive. Please contact support for assistance.');
            }

            // Check if usertype is 3
            if ($user->usertype == 3) {
                return redirect('/show-appointments');
            }
            if ($user->usertype == 1) {
                return redirect('/admin/home');
            }  
            if ($user->usertype == 0) {
                return redirect('/admin/home');
            }  
        }

        return $next($request);
    }
}
