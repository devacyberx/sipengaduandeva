<?php

namespace App\Http\Middleware;

// Untuk melanjutkan request
use Closure;

// Request dari user
use Illuminate\Http\Request;

// Response HTTP
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah belum login atau bukan siswa
        if (!auth()->check() || !auth()->user()->isSiswa()) {

            // Redirect ke login jika tidak memenuhi syarat
            return redirect('/login')->with('error', 'Akses ditolak. Hanya siswa yang diizinkan.');
        }

        // Jika lolos, lanjut ke controller
        return $next($request);
    }
}