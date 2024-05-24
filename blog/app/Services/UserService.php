<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct()
    {
        //
    }

    public function register(array $data)
    {
        // Membuat pengguna baru
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Default role
        ]);

        return $user;
    }

    public function login(array $credentials)
    {
        // Melakukan proses autentikasi
        if (auth()->attempt($credentials)) {
            // Autentikasi berhasil
            return true;
        }

        // Autentikasi gagal
        return false;
    }

    public function logout()
    {
        // Melakukan proses logout
        auth()->logout();
    }
}
