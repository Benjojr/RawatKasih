<?php

use App\Models\Rutinitas;
use App\Models\Penghuni;
use App\Models\TugasHarian;

Schedule::call(function () {
    $rutinitas = Rutinitas::with('tugas')->where('aktif', true)->get();
    $penghuni  = Penghuni::all();

    foreach ($rutinitas as $r) {
        foreach ($penghuni as $p) {
            $sudahAda = TugasHarian::where('id_penghuni', $p->id_penghuni)
                ->where('id_tugas', $r->id_tugas)
                ->whereDate('waktu_pelaksanaan', today())
                ->exists();

            if (!$sudahAda) {
                TugasHarian::create([
                    'id_penghuni'       => $p->id_penghuni,
                    'id_tugas'          => $r->id_tugas,
                    'waktu_pelaksanaan' => today()->format('Y-m-d') . ' ' . $r->jam,
                    'status_tugas'      => 'mendatang',
                    'mood'              => 'biasa',
                    'catatan'           => null,
                ]);
            }
        }
    }
})->dailyAt('06:00')->name('generate-rutinitas-harian');