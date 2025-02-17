<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Cek level pengguna dan arahkan ke halaman sesuai levelnya
            if ($user->level === 'admin') {
                return redirect('/admin');
            } elseif ($user->level === 'petugas') {
                return redirect('/petugas');
            } else {
                return redirect('/user');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Tampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru dengan level default 'peminjam'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'peminjam', // Level default hanya untuk user biasa
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
