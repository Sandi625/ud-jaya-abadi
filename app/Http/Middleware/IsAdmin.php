<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login dan punya level 'admin'
        if (Auth::check() && Auth::user()->level === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, abort 403
        abort(403, 'Unauthorized');
    }
}
