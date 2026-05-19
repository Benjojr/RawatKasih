<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function edit()
    {
        $pengguna = Auth::user();
        return view('profil.edit', compact('pengguna'));
    }

    public function update(Request $request)
    {
        $pengguna = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'no_telpon'    => 'nullable|string|max:20',
            'password'     => 'nullable|min:8|confirmed',
        ]);

        $pengguna->nama_lengkap = $request->nama_lengkap;
        $pengguna->no_telpon    = $request->no_telpon;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}