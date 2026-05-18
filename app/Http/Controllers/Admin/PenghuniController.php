<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with('kamar')->get();
        $kamar    = Kamar::all();

        return view('admin.penghuni.index', compact('penghuni', 'kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'gender'        => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'golongan_darah'=> 'nullable|in:A,B,AB,O',
            'alamat'        => 'nullable|string|max:100',
            'id_kamar'      => 'nullable|exists:kamar,id_kamar',
        ]);

        Penghuni::create($request->only([
            'nama_lengkap', 'gender', 'tanggal_lahir',
            'golongan_darah', 'alamat', 'id_kamar',
        ]));

        return redirect()->route('admin.penghuni.index')
            ->with('success', 'Penghuni berhasil ditambahkan.');
    }

    public function update(Request $request, Penghuni $penghuni)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'gender'        => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'golongan_darah'=> 'nullable|in:A,B,AB,O',
            'alamat'        => 'nullable|string|max:100',
            'id_kamar'      => 'nullable|exists:kamar,id_kamar',
        ]);

        $penghuni->update($request->only([
            'nama_lengkap', 'gender', 'tanggal_lahir',
            'golongan_darah', 'alamat', 'id_kamar',
        ]));

        return redirect()->route('admin.penghuni.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function destroy(Penghuni $penghuni)
    {
        $penghuni->delete();

        return redirect()->route('admin.penghuni.index')
            ->with('success', 'Penghuni berhasil dihapus.');
    }
}