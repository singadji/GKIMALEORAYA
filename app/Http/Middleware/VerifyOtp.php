<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyOtp
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->google2fa_secret) {
            return $next($request);
        }

        if (!session('mfa_verified')) {
            return redirect()->route('mfa.verify');
        }

        return $next($request);
    }
}
