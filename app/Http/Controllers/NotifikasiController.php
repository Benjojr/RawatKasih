<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('id_pengguna', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        // Tandai semua sebagai dibaca
        Notifikasi::where('id_pengguna', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function belumDibaca()
    {
        $jumlah = Notifikasi::where('id_pengguna', Auth::id())
            ->where('dibaca', false)
            ->count();

        return response()->json(['jumlah' => $jumlah]);
    }
}
