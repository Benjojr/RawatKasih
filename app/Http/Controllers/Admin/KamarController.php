<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::withCount('penghuni')->get();
        return view('admin.kamar.index', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar'  => 'required|string|max:10|unique:kamar,nomor_kamar',
            'status_kamar' => 'required|in:tersedia,diisi',
        ]);

        Kamar::create($request->only(['nomor_kamar', 'status_kamar']));

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'nomor_kamar'  => 'required|string|max:10|unique:kamar,nomor_kamar,' . $kamar->id_kamar . ',id_kamar',
            'status_kamar' => 'required|in:tersedia,diisi',
        ]);

        $kamar->update($request->only(['nomor_kamar', 'status_kamar']));

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Kamar $kamar)
    {
        if ($kamar->penghuni()->count() > 0) {
            return redirect()->route('admin.kamar.index')
                ->with('error', 'Kamar tidak bisa dihapus karena masih ada penghuni.');
        }

        $kamar->delete();

        return redirect()->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}