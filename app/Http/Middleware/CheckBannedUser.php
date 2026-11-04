<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBannedUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isBanned()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'គណនីរបស់អ្នកត្រូវបានផ្អាក ឬ Block ដោយ Admin (Your account has been suspended/blocked). សូមទាក់ទងមកកាន់ផ្នែក Support។',
            ]);
        }

        return $next($request);
    }
}

