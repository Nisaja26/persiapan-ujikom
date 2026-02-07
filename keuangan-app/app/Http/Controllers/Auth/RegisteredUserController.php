<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // hanya admin boleh buka halaman register
        if (!auth()->check() || auth()->user()->role->name !== 'admin') {
            abort(403, 'Hanya admin yang boleh membuat akun.');
        }

        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle registration.
     */
    public function store(Request $request)
    {
        // hanya admin boleh register user
        if (!auth()->check() || auth()->user()->role->name !== 'admin') {
            abort(403, 'Hanya admin yang boleh membuat akun.');
        }

        // validasi
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:admin,ceo,user',
        ]);

        // cari role
        $role = Role::where('name', $request->role)->first();

        if (!$role) {
            return back()
                ->withErrors(['role' => 'Role tidak ditemukan'])
                ->withInput();
        }

        // simpan user
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'User berhasil dibuat');
    }
}
