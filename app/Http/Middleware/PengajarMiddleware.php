<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PengajarMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role !== 'pengajar') {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
