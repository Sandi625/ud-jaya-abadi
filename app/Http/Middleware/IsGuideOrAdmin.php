<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsGuideOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->level, ['admin', 'guide'])) {
            return $next($request);
        }

        // Kalau bukan admin atau guide, tolak
        abort(403, 'Unauthorized access.');
    }
}
