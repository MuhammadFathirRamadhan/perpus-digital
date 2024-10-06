<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // Mengambil semua data pengguna dari database
        $users = User::all();

        // Jika file view Anda berada di resources/views/admin/users/index.blade.php
        return view('admin.users.index', compact('users'));
        
        // Jika file view Anda berada di resources/views/admin/pages/users/index.blade.php
        // return view('admin.pages.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'nis_nip' => 'required|string|min:5',
            'address' => 'required|string',
            'role' => 'required|string',
        ]);

        // Simpan pengguna baru
        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    // UserController.php

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'role' => 'required|string',
    ]);

    $user = User::findOrFail($id);
    $user->update($request->all());

    return redirect()->back()->with('success', 'Pengguna berhasil diperbarui.');
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
}
}