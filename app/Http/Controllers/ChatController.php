<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();

        // Ambil semua pengguna yang pernah chat dengan user ini
        $idChat = Chat::where('id_pengirim', $pengguna->id_pengguna)
            ->orWhere('id_penerima', $pengguna->id_pengguna)
            ->get();

        $idLawan = [];
        foreach ($idChat as $c) {
            $id = $c->id_pengirim == $pengguna->id_pengguna
                ? $c->id_penerima
                : $c->id_pengirim;
            $idLawan[] = (int) $id;
        }
        $idLawan = array_unique($idLawan);

        $kontak = Pengguna::whereIn('id_pengguna', $idLawan)->get();

        // Semua pengguna lain untuk mulai chat baru
        $semuaPengguna = Pengguna::where('id_pengguna', '!=', $pengguna->id_pengguna)->get();

        return view('chat.index', compact('kontak', 'semuaPengguna'));
    }

    public function show(Pengguna $pengguna)
    {
        $saya = Auth::user();

        // Tandai pesan masuk sebagai dibaca
        Chat::where('id_pengirim', $pengguna->id_pengguna)
            ->where('id_penerima', $saya->id_pengguna)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        $pesan = Chat::where(function ($q) use ($saya, $pengguna) {
            $q->where('id_pengirim', $saya->id_pengguna)
                ->where('id_penerima', $pengguna->id_pengguna);
        })
            ->orWhere(function ($q) use ($saya, $pengguna) {
                $q->where('id_pengirim', $pengguna->id_pengguna)
                    ->where('id_penerima', $saya->id_pengguna);
            })
            ->orderBy('created_at')
            ->get();

        $semuaPengguna = Pengguna::where('id_pengguna', '!=', $saya->id_pengguna)->get();

        // Kontak yang pernah chat
        $idChat = Chat::where('id_pengirim', $saya->id_pengguna)
            ->orWhere('id_penerima', $saya->id_pengguna)
            ->get();

        $idLawan = [];
        foreach ($idChat as $c) {
            $id = $c->id_pengirim == $saya->id_pengguna
                ? $c->id_penerima
                : $c->id_pengirim;
            $idLawan[] = (int) $id;
        }
        $idLawan[] = (int) $pengguna->id_pengguna;
        $idLawan = array_unique($idLawan);

        $kontak = Pengguna::whereIn('id_pengguna', $idLawan)->get();

        return view('chat.show', compact('pesan', 'pengguna', 'kontak', 'semuaPengguna'));
    }

    public function store(Request $request, Pengguna $pengguna)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        Chat::create([
            'id_pengirim' => Auth::id(),
            'id_penerima' => $pengguna->id_pengguna,
            'pesan' => $request->pesan,
            'dibaca' => false,
        ]);

        return redirect()->route('chat.show', $pengguna->id_pengguna);
    }
}
