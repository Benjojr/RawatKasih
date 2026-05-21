<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $kredensial = $request->only('email', 'password');

        if (Auth::attempt($kredensial)) {
            $request->session()->regenerate();

            return match (Auth::user()->peran) {
                'admin' => redirect()->route('dashboard.admin'),
                'pramurukti' => redirect()->route('dashboard.pramurukti'),
                'keluarga' => redirect()->route('dashboard.keluarga'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:8|confirmed',
            'peran' => 'required|in:admin,pramurukti,keluarga',
            'no_telpon' => 'nullable|string|max:20',
        ]);

        Pengguna::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
            'no_telpon' => $request->no_telpon,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}