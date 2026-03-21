<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->isCustomer()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized access. Please login as customer.');
    }
}
