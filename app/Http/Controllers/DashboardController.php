<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Penghuni;
use App\Models\Pramurukti;
use App\Models\TugasHarian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function pramurukti()
    {
        $pengguna = Auth::user();

        $totalPenghuni = Penghuni::count();
        $tugasHariIni = TugasHarian::whereDate('waktu_pelaksanaan', today())->count();
        $tugasSelesai = TugasHarian::whereDate('waktu_pelaksanaan', today())
            ->where('status_tugas', 'tuntas')->count();
        $perluPerhatian = 0; // akan diisi nanti setelah ada data vital

        $daftarPenghuni = Penghuni::all();

        return view('dashboard.pramurukti', compact(
            'pengguna',
            'totalPenghuni',
            'tugasHariIni',
            'tugasSelesai',
            'perluPerhatian',
            'daftarPenghuni',
        ));
    }

    public function admin()
    {
        $totalPenghuni = Penghuni::count();
        $totalPramurukti = Pramurukti::count();
        $perluPerhatian = 0; // akan diisi nanti setelah ada data vital

        return view('dashboard.admin', compact(
            'totalPenghuni',
            'totalPramurukti',
            'perluPerhatian',
        ));
    }

    public function keluarga()
    {
        $pengguna = Auth::user();
        $keluarga = Keluarga::where('id_pengguna', $pengguna->id_pengguna)->first();

        $daftarPenghuni = $keluarga
            ? $keluarga->penghuni()->with(['kamar', 'tandaVital' => function ($q) {
                $q->orderByDesc('tanggal')->orderByDesc('waktu')->limit(1);
            }])->get()
            : collect();

        return view('dashboard.keluarga', compact('pengguna', 'keluarga', 'daftarPenghuni'));
    }
}
