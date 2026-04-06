<?php

namespace App\Http\Middleware;

// Closure untuk melanjutkan request
use Closure;

// Request dari user
use Illuminate\Http\Request;

// Response HTTP
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user belum login atau bukan admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {

            // Redirect ke login + pesan error
            return redirect('/login')->with('error', 'Akses ditolak. Hanya admin yang diizinkan.');
        }

        // Jika lolos, lanjut ke request berikutnya
        return $next($request);
    }
}