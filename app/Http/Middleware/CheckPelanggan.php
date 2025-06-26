<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPelanggan
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->level === 'pelanggan') {
            return $next($request);
        }

        // Jika bukan pelanggan, redirect atau abort
        return redirect('/login')->withErrors('Akses hanya untuk pelanggan.');
    }
}
