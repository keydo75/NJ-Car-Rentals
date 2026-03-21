<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('staff')->check() && Auth::guard('staff')->user()->isStaff()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access. Staff privileges required.');
    }
}
