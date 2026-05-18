<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Penghuni;
use App\Models\TugasHarian;

class DashboardController extends Controller
{
    public function pramurukti()
    {
        $pengguna = Auth::user();

        $totalPenghuni = Penghuni::count();
        $tugasHariIni  = TugasHarian::whereDate('created_at', today())->count();
        $tugasSelesai  = TugasHarian::whereDate('created_at', today())
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
        return view('dashboard.admin');
    }

    public function keluarga()
    {
        return view('dashboard.keluarga');
    }
}