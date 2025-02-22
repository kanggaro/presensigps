<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('user')->check()) {
            return redirect('/panel/dashboardAdmin'); // Redirect jika user sudah login
        }

        if (Auth::guard('karyawan')->check()) {
            return redirect('/dashboard'); // Redirect jika karyawan sudah login
        }

        return $next($request);
    }
}
