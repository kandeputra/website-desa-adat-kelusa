<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/** Batasi rute untuk peran tertentu. Super Admin selalu lolos. */
class Peran
{
    public function handle(Request $request, Closure $next, string ...$peran)
    {
        $u = $request->user();
        abort_unless($u && ($u->isSuperAdmin() || in_array($u->role, $peran, true)), 403, 'Halaman ini hanya untuk Super Admin.');
        return $next($request);
    }
}
