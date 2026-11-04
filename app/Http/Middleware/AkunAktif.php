<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Keluarkan akun yang dinonaktifkan Super Admin. */
class AkunAktif
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && ! $request->user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            return redirect()->route('admin.login')->withErrors(['email' => 'Akun Anda dinonaktifkan. Hubungi Super Admin.']);
        }
        return $next($request);
    }
}
