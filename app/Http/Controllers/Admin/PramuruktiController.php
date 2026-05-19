<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pramurukti;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class PramuruktiController extends Controller
{
    public function index()
    {
        $pramurukti = Pramurukti::with('pengguna')->get();
        $pengguna   = Pengguna::where('peran', 'pramurukti')->get();

        return view('admin.pramurukti.index', compact('pramurukti', 'pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:pengguna,id_pengguna|unique:pramurukti,id_pengguna',
        ]);

        Pramurukti::create(['id_pengguna' => $request->id_pengguna]);

        return redirect()->route('admin.pramurukti.index')
            ->with('success', 'Pramurukti berhasil ditambahkan.');
    }

    public function destroy(Pramurukti $pramurukti)
    {
        $pramurukti->delete();

        return redirect()->route('admin.pramurukti.index')
            ->with('success', 'Pramurukti berhasil dihapus.');
    }
}