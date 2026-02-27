<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('class', 'like', '%' . $request->search . '%');
        }

        $students = $query->latest()->paginate(10);
        return view('admin.users.index', compact('students'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'class' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'class' => $request->class,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if ($user->role != 'siswa') {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role != 'siswa') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'class' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email', 'class', 'phone']));

        return redirect()->route('admin.users.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role != 'siswa') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Siswa berhasil dihapus.');
    }

    public function resetPassword(User $user)
    {
        if ($user->role != 'siswa') {
            abort(403);
        }

        $user->update([
            'password' => Hash::make('password123'),
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil direset ke "password123".');
    }
}