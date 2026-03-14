<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Menampilkan daftar role
     */
    public function index()
    {
        $roles = Role::latest()->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Simpan role baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    /**
     * Hapus role
     */
    public function destroy(Role $role)
    {
        // ❗ Cegah hapus role yang sedang dipakai user
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak bisa dihapus karena masih digunakan user');
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
