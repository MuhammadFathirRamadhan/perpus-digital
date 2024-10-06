<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register');
    }

    public function store(Request $request)
    {
        // Validasi input dengan pengecekan unik pada username dan email
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'username' => 'required|min:2|unique:users,username', // validasi unik username
            'address' => 'required|min:6',
            'phone' => 'required|min:12',
            'email' => 'required|email|unique:users,email', // validasi unik email
            'nis_nip' => 'required|min:5',
            'password' => 'required|min:5',
    
        ], [
            // Pesan error yang lebih jelas
            'username.unique' => 'Username sudah dipakai, silakan gunakan yang lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
        ]);

        // Enkripsi password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan data pengguna baru
        User::create($validatedData);

        // Redirect ke halaman login setelah registrasi sukses
        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
