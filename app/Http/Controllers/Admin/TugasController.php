<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $tugas = Tugas::all();
        return view('admin.tugas.index', compact('tugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:100',
            'tipe_tugas'  => 'required|in:aktifitas,monitoring,obat',
            'butuh_vital' => 'boolean',
        ]);

        Tugas::create([
            'judul_tugas' => $request->judul_tugas,
            'tipe_tugas'  => $request->tipe_tugas,
            'butuh_vital' => $request->boolean('butuh_vital'),
        ]);

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function update(Request $request, Tugas $tugas)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:100',
            'tipe_tugas'  => 'required|in:aktifitas,monitoring,obat',
            'butuh_vital' => 'boolean',
        ]);

        $tugas->update([
            'judul_tugas' => $request->judul_tugas,
            'tipe_tugas'  => $request->tipe_tugas,
            'butuh_vital' => $request->boolean('butuh_vital'),
        ]);

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return redirect()->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}