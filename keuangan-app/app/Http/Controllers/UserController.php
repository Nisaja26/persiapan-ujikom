<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // eager loading supaya tidak N+1 query
        $users = User::with('role')->latest()->get();

       return view('users.index', compact('users'));

    }

    public function destroy(User $user)
    {
        // optional: cegah hapus diri sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
