<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::with(['penghuni', 'keluarga.pengguna'])
            ->orderByDesc('tanggal_kunjungan')
            ->get();

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'status_kunjungan' => 'required|in:mendatang,tuntas',
        ]);

        $kunjungan->update(['status_kunjungan' => $request->status_kunjungan]);

        return redirect()->route('admin.kunjungan.index')
            ->with('success', 'Status kunjungan berhasil diperbarui.');
    }
}