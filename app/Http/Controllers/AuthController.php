<?php

namespace App\Http\Controllers;

// Untuk ambil input user
use Illuminate\Http\Request;

// Untuk sistem autentikasi (login/logout)
use Illuminate\Support\Facades\Auth;

// Untuk enkripsi password (meskipun di sini tidak dipakai langsung)
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Menampilkan halaman login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login (email & password)
        if (Auth::attempt($credentials)) {

            // Regenerate session untuk keamanan
            $request->session()->regenerate();
            
            // Cek role user
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Hapus session lama
        $request->session()->invalidate();

        // Generate token baru (keamanan)
        $request->session()->regenerateToken();

        // Redirect ke login
        return redirect('/login');
    }
}