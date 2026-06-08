<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Rutinitas;
use App\Models\Tugas;
use App\Models\TugasHarian;
use Illuminate\Http\Request;

class RutinitasController extends Controller
{
    public function index()
    {
        $rutinitas = Rutinitas::with('tugas')->orderBy('jam')->get();
        $tugas = Tugas::all();

        return view('admin.rutinitas.index', compact('rutinitas', 'tugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tugas' => 'required|exists:tugas,id_tugas',
            'jam' => 'required',
        ]);

        Rutinitas::create([
            'id_tugas' => $request->id_tugas,
            'jam' => $request->jam,
            'aktif' => true,
        ]);

        return back()->with('success', 'Rutinitas berhasil ditambahkan.');
    }

    public function toggle(Rutinitas $rutinitas)
    {
        $rutinitas->update(['aktif' => ! $rutinitas->aktif]);

        return back()->with('success', 'Status rutinitas diperbarui.');
    }

    public function destroy(Rutinitas $rutinitas)
    {
        $rutinitas->delete();

        return back()->with('success', 'Rutinitas berhasil dihapus.');
    }

    public function generate()
    {
        $rutinitas = Rutinitas::with('tugas')->where('aktif', true)->get();
        $penghuni = Penghuni::all();

        if ($rutinitas->isEmpty()) {
            return back()->with('error', 'Belum ada rutinitas aktif.');
        }

        if ($penghuni->isEmpty()) {
            return back()->with('error', 'Belum ada penghuni terdaftar.');
        }

        $jumlah = 0;

        foreach ($rutinitas as $r) {
            foreach ($penghuni as $p) {
                // Cek sudah ada belum hari ini
                $sudahAda = TugasHarian::where('id_penghuni', $p->id_penghuni)
                    ->where('id_tugas', $r->id_tugas)
                    ->whereDate('waktu_pelaksanaan', today())
                    ->exists();

                if (! $sudahAda) {
                    TugasHarian::create([
                        'id_penghuni' => $p->id_penghuni,
                        'id_tugas' => $r->id_tugas,
                        'waktu_pelaksanaan' => today()->format('Y-m-d').' '.$r->jam,
                        'status_tugas' => 'mendatang',
                        'mood' => 'biasa',
                        'catatan' => null,
                    ]);
                    $jumlah++;
                }
            }
        }

        return back()->with('success', "Berhasil generate {$jumlah} tugas harian untuk hari ini.");
    }
}
