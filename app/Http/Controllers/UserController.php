<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Helper privat untuk cek apakah user ini akun root
    private function isRootUser(User $user): bool
    {
        return $user->email === 'admin@gmail.com';
    }

    // Tampilkan semua user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Tampilkan form tambah user
    public function create()
    {
        $levels = ['admin', 'guide', 'pelanggan'];
        return view('users.create', compact('levels'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'level' => ['required', Rule::in(['admin', 'guide', 'pelanggan'])],
        ]);

        // Hash password
        $validated['password'] = bcrypt($validated['password']);

        // Simpan user
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    // Tampilkan form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($this->isRootUser($user)) {
            return redirect()->route('users.index')->with('error', 'Akun root tidak bisa diedit.');
        }

        $levels = ['admin', 'guide', 'pelanggan'];
        return view('users.edit', compact('user', 'levels'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($this->isRootUser($user)) {
            return redirect()->route('users.index')->with('error', 'Akun root tidak bisa diubah.');
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:6|confirmed',
            'level'    => ['required', Rule::in(['admin', 'guide', 'pelanggan'])],
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($this->isRootUser($user)) {
            return redirect()->route('users.index')->with('error', 'Akun root tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
