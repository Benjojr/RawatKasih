<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Pramurukti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotifikasiHelper;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::orderBy('peran')->get();

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function updatePeran(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'peran' => 'required|in:keluarga,pramurukti,admin',
        ]);

        if ($pengguna->id_pengguna === Auth::id()) {
            return back()->with('error', 'Tidak bisa mengubah peran akun sendiri.');
        }

        $peranLama = $pengguna->peran;
        $peranBaru = $request->peran;

        $pengguna->update(['peran' => $peranBaru]);

        // Otomatis tambah ke tabel pramurukti
        if ($peranBaru === 'pramurukti' && $peranLama !== 'pramurukti') {
            Pramurukti::firstOrCreate(['id_pengguna' => $pengguna->id_pengguna]);
        }

        // Otomatis hapus dari tabel pramurukti
        if ($peranLama === 'pramurukti' && $peranBaru !== 'pramurukti') {
            Pramurukti::where('id_pengguna', $pengguna->id_pengguna)->delete();
        }

        // Kirim notifikasi ke pengguna yang diubah perannya
        NotifikasiHelper::kirim(
            $pengguna->id_pengguna,
            'Peran Akun Diubah',
            'Peran akun kamu telah diubah menjadi '.ucfirst($peranBaru).' oleh admin.',
            'info'
        );

        return back()->with('success', 'Peran berhasil diubah menjadi '.ucfirst($peranBaru).'.');
    }

    public function destroy(Pengguna $pengguna)
    {
        if ($pengguna->id_pengguna === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $pengguna->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }

    public function blacklist(Request $request, Pengguna $pengguna)
    {
        if ($pengguna->id_pengguna === Auth::id()) {
            return back()->with('error', 'Tidak bisa memblacklist akun sendiri.');
        }

        $status = $request->has('unblacklist') ? false : true;
        $pengguna->update(['blacklist' => $status]);

        $pesan = $status ? 'Akun berhasil diblacklist.' : 'Akun berhasil diaktifkan kembali.';

        return back()->with('success', $pesan);
    }
}
