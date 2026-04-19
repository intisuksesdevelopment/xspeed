<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionMember
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah pengguna belum diautentikasi
        if (! Auth::guard('member')->check()) {
            return redirect('/'); // Arahkan ke halaman login
        }

        return $next($request);
    }
}
