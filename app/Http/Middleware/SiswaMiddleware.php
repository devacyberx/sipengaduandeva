<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isSiswa()) {
            return redirect('/login')->with('error', 'Akses ditolak. Hanya siswa yang diizinkan.');
        }
        return $next($request);
    }
}