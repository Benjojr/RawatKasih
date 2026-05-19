<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\ShiftPramurukti;
use App\Models\Pramurukti;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts     = Shift::all();
        $pramurukti = Pramurukti::with('pengguna')->get();

        $jadwal = ShiftPramurukti::with(['shift', 'pramurukti.pengguna'])
            ->where('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->get()
            ->groupBy('tanggal');

        return view('admin.shift.index', compact('shifts', 'pramurukti', 'jadwal'));
    }

    public function storeShift(Request $request)
    {
        $request->validate([
            'nama_shift'    => 'required|string|max:50',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
        ]);

        Shift::create($request->only(['nama_shift', 'waktu_mulai', 'waktu_selesai']));

        return redirect()->route('admin.shift.index')
            ->with('success', 'Shift berhasil ditambahkan.');
    }

    public function storeJadwal(Request $request)
    {
        $request->validate([
            'id_shift'      => 'required|exists:shifts,id_shift',
            'id_pramurukti' => 'required|exists:pramurukti,id_pramurukti',
            'tanggal'       => 'required|date|after_or_equal:today',
        ]);

        ShiftPramurukti::create($request->only([
            'id_shift', 'id_pramurukti', 'tanggal',
        ]));

        return redirect()->route('admin.shift.index')
            ->with('success', 'Jadwal shift berhasil ditambahkan.');
    }

    public function destroyJadwal(ShiftPramurukti $shiftPramurukti)
    {
        $shiftPramurukti->delete();

        return redirect()->route('admin.shift.index')
            ->with('success', 'Jadwal shift berhasil dihapus.');
    }

    public function destroyShift(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('admin.shift.index')
            ->with('success', 'Shift berhasil dihapus.');
    }
}