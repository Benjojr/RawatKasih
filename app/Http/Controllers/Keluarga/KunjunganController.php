<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Kunjungan;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KunjunganController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();
        $keluarga = Keluarga::where('id_pengguna', $pengguna->id_pengguna)->first();

        $kunjungan = $keluarga
            ? Kunjungan::with('penghuni')
                ->where('id_keluarga', $keluarga->id_keluarga)
                ->orderByDesc('tanggal_kunjungan')
                ->get()
            : collect();

        $penghuni = Penghuni::all();

        return view('keluarga.kunjungan.index', compact('kunjungan', 'penghuni', 'keluarga'));
    }

    public function store(Request $request)
    {
        $pengguna = Auth::user();
        $keluarga = Keluarga::where('id_pengguna', $pengguna->id_pengguna)->first();

        if (! $keluarga) {
            return back()->with('error', 'Akun keluarga belum terdaftar. Hubungi admin.');
        }

        $request->validate([
            'id_penghuni' => 'required|exists:penghuni,id_penghuni',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required|integer|min:0|max:23',
            'catatan' => 'nullable|string|max:300',
        ]);

        Kunjungan::create([
            'id_keluarga' => $keluarga->id_keluarga,
            'id_penghuni' => $request->id_penghuni,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'status_kunjungan' => 'mendatang',
            'catatan' => $request->catatan,
        ]);

        // Kirim notifikasi ke admin
        $admins = Pengguna::where('peran', 'admin')->get();
        foreach ($admins as $admin) {
            NotifikasiHelper::kirim(
                $admin->id_pengguna,
                'Pengajuan Kunjungan Baru',
                Auth::user()->nama_lengkap.' mengajukan kunjungan pada '.$request->tanggal_kunjungan,
                'info'
            );
        }

        return redirect()->route('keluarga.kunjungan.index')
            ->with('success', 'Jadwal kunjungan berhasil diajukan.');
    }

    public function destroy(Kunjungan $kunjungan)
    {
        $kunjungan->delete();

        return redirect()->route('keluarga.kunjungan.index')
            ->with('success', 'Kunjungan berhasil dibatalkan.');
    }
}
