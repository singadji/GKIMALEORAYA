<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    //public function handle(Request $request, Closure $next): Response
    //{
    //    return $next($request);
    //}

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->aktif === 'Y') {
            return $next($request);
        }

        // Log the user out if they are inactive
        Auth::logout();
        
        // Optionally, invalidate the session to clear all session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return 403 response or redirect as per your choice
        return abort(403, 'Your account is inactive. Please contact support.');
    }
}
