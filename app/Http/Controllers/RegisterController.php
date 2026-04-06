<?php

namespace App\Http\Controllers;

// Model user (database)
use App\Models\User;

// Untuk ambil input user
use Illuminate\Http\Request;

// Untuk enkripsi password
use Illuminate\Support\Facades\Hash;

// Untuk validasi manual
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan form register
     */
    public function showRegistrationForm()
    {
        // Tampilkan halaman register
        return view('auth.register');
    }

    /**
     * Proses pendaftaran user
     */
    public function register(Request $request)
    {
        // Validasi input manual
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'class' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'terms' => 'required|accepted', // harus centang syarat
        ], [
            // Pesan error custom
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'class.required' => 'Kelas wajib diisi',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // mengembalikan input sebelumnya
        }

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,

            // Password dienkripsi
            'password' => Hash::make($request->password),

            'role' => 'siswa', // default role siswa
            'class' => $request->class,
            'phone' => $request->phone,
        ]);

        // Auto login setelah register
        auth()->login($user);

        // Redirect ke dashboard siswa
        return redirect()->route('siswa.dashboard')
            ->with('success', 'Pendaftaran berhasil! Selamat datang di SIPENGADUAN.');
    }

    /**
     * Cek email (AJAX)
     */
    public function checkEmail(Request $request)
    {
        // Validasi email
        $request->validate([
            'email' => 'required|email'
        ]);

        // Cek apakah email sudah ada
        $exists = User::where('email', $request->email)->exists();

        // Kirim response JSON
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Email sudah terdaftar' : 'Email tersedia'
        ]);
    }
}