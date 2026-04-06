<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Untuk autentikasi user login
use Illuminate\Support\Facades\Auth;

// Untuk enkripsi & cek password
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function adminProfile()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Tampilkan halaman profile admin
        return view('admin.settings.profile', compact('user'));
    }

    public function siswaProfile()
    {
        // Ambil user login
        $user = Auth::user();

        // Tampilkan halaman profile siswa
        return view('siswa.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Ambil user login
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',

            // Jika siswa wajib isi class
            'class' => $user->isSiswa() ? 'required|string|max:50' : 'nullable',
        ]);

        // Ambil data dari request
        $data = $request->only(['name', 'email', 'phone']);
        
        // Tambahkan class jika siswa
        if ($user->isSiswa()) {
            $data['class'] = $request->class;
        }

        // Update data user
        $user->update($data);

        // Tentukan redirect berdasarkan role
        $route = $user->isAdmin() ? 'admin.settings.profile' : 'siswa.profile.index';

        return redirect()->route($route)
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        // Validasi input password
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Ambil user login
        $user = Auth::user();

        // Cek password lama (keamanan)
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // Update password baru (dienkripsi)
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect sesuai role
        $route = $user->isAdmin() ? 'admin.settings.profile' : 'siswa.profile.index';

        return redirect()->route($route)
            ->with('success', 'Password berhasil diubah.');
    }
}