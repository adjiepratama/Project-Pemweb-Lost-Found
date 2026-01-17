<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin() {
        return view('auth.login');
    }

    // Tampilkan Form Register
    public function showRegister() {
        return view('auth.register');
    }

    // Proses Register (Hanya untuk User/Mahasiswa)
    public function register(Request $request) {
        // 1. Validasi Input yang lebih lengkap
        $request->validate([
            'name'       => 'required|string|max:255',
            'no_unik' => 'required|string|unique:users', 
            'email'      => 'required|email|unique:users',    
            'username'   => 'required|string|unique:users',   
            'password' => 'required|min:6|confirmed',
        ], [
            // Pesan Error Custom (Opsional, biar bahasa Indonesia)
            'no_unik.unique' => 'Nomer unik (NIM/NIK) ini sudah terdaftar.',
            'email.unique'      => 'Email ini sudah digunakan.',
            'username.unique'   => 'Username ini sudah digunakan.',
        ]);

        // 2. Simpan ke Database
        User::create([
            'name'       => $request->name,
            'no_unik' => $request->no_unik, 
            'email'      => $request->email,      
            'username'   => $request->username,
            'password'   => Hash::make($request->password), 
            'role'       => 'user' 
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Proses Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }
            
            // Default ke user dashboard
            return redirect()->intended('user/dashboard');
        }

        return back()->withErrors([
            'username' => 'Login gagal, periksa username atau password Anda.',
        ])->onlyInput('username');
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}