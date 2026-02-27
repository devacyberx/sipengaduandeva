<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function adminProfile()
    {
        $user = Auth::user();
        return view('admin.settings.profile', compact('user'));
    }

    public function siswaProfile()
    {
        $user = Auth::user();
        return view('siswa.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'class' => $user->isSiswa() ? 'required|string|max:50' : 'nullable',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        
        if ($user->isSiswa()) {
            $data['class'] = $request->class;
        }

        $user->update($data);

        $route = $user->isAdmin() ? 'admin.settings.profile' : 'siswa.profile.index';

        return redirect()->route($route)
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $route = $user->isAdmin() ? 'admin.settings.profile' : 'siswa.profile.index';

        return redirect()->route($route)
            ->with('success', 'Password berhasil diubah.');
    }
}