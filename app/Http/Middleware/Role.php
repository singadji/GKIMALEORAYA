<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (auth()->check()) {
            $userRole = \Auth::user()->role;

            // Check if the user's role matches any of the specified roles
            if (!in_array($userRole, $roles)) {
                return abort(404);
            }
        }
        
        return $next($request);
    }
}
//if (!Auth::check() || Auth::user()->role->role_id !== $role) {
//    abort(403, 'Unauthorized.');
//}