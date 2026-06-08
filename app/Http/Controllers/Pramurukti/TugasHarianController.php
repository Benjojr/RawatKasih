<?php

namespace App\Http\Controllers\Pramurukti;

use App\Helpers\NotifikasiHelper;
use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Penghuni;
use App\Models\TandaVital;
use App\Models\Tugas;
use App\Models\TugasHarian;
use Illuminate\Http\Request;

class TugasHarianController extends Controller
{
    public function index()
    {
        $tugasHarian = TugasHarian::with(['penghuni', 'tugas'])
            ->whereDate('waktu_pelaksanaan', today())
            ->orderBy('waktu_pelaksanaan')
            ->get();

        $penghuni = Penghuni::all();
        $tugas = Tugas::all();

        return view('pramurukti.tugas.index', compact('tugasHarian', 'penghuni', 'tugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penghuni' => 'required|exists:penghuni,id_penghuni',
            'id_tugas' => 'required|exists:tugas,id_tugas',
            'waktu_pelaksanaan' => 'required',
            'catatan' => 'nullable|string|max:300',
            'mood' => 'required|in:baik,biasa,kurang baik,buruk',
        ]);

        TugasHarian::create([
            'id_penghuni' => $request->id_penghuni,
            'id_tugas' => $request->id_tugas,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'catatan' => $request->catatan,
            'mood' => $request->mood,
            'status_tugas' => 'mendatang',
        ]);

        if ($request->filled('tekanan_darah') || $request->filled('gula_darah')) {
            TandaVital::create([
                'id_penghuni' => $request->id_penghuni,
                'tekanan_darah' => $request->tekanan_darah,
                'detak_jantung' => $request->detak_jantung,
                'gula_darah' => $request->gula_darah,
                'suhu' => $request->suhu,
                'tanggal' => today(),
                'waktu' => $request->waktu_pelaksanaan,
            ]);
        }

        // Kirim notifikasi ke semua admin
        $penghuni = Penghuni::find($request->id_penghuni);
        $admins = Pengguna::where('peran', 'admin')->get();
        foreach ($admins as $admin) {
            NotifikasiHelper::kirim(
                $admin->id_pengguna,
                'Tugas Baru Ditambahkan',
                'Pramurukti menambahkan tugas baru untuk '.($penghuni->nama_lengkap ?? ''),
                'info'
            );
        }

        return redirect()->route('pramurukti.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, TugasHarian $tugasHarian)
    {
        $request->validate([
            'status_tugas' => 'required|in:mendatang,in progress,tuntas',
        ]);

        $tugasHarian->update(['status_tugas' => $request->status_tugas]);

        return redirect()->route('pramurukti.tugas.index')
            ->with('success', 'Status tugas diperbarui.');
    }

    public function destroy(TugasHarian $tugasHarian)
    {
        $tugasHarian->delete();

        return redirect()->route('pramurukti.tugas.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
