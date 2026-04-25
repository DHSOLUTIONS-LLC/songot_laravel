<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FullPackageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->plan_tier !== 'full') {
            abort(403, 'Access denied. Full Package required.');
        }
        
        return $next($request);
    }
}