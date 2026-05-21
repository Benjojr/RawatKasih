<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $chat = Chat::create([
            'id_pengirim' => Auth::id(),
            'id_penerima' => $pengguna->id_pengguna,
            'pesan' => $request->pesan,
            'dibaca' => false,
        ]);

        // Hapus typing status setelah pesan terkirim
        DB::table('typing_status')
            ->where('id_pengguna', Auth::id())
            ->delete();

        return response()->json([
            'id_chat' => $chat->id_chat,
        ]);
    }

    // Fix typing() — sudah ada logikanya, hanya perlu DB di-import
    public function typing(Request $request, Pengguna $pengguna)
    {
        DB::table('typing_status')->upsert([
            'id_pengguna' => Auth::id(),
            'id_lawan' => $pengguna->id_pengguna,
            'updated_at' => now(),
        ], ['id_pengguna']);

        return response()->json(['ok' => true]);
    }

    // Fix cekTyping() — sudah benar, hanya perlu DB di-import
    public function cekTyping(Pengguna $pengguna)
    {
        $sedangMenulis = DB::table('typing_status')
            ->where('id_pengguna', $pengguna->id_pengguna)
            ->where('id_lawan', Auth::id())
            ->where('updated_at', '>=', now()->subSeconds(1))
            ->exists();

        return response()->json(['typing' => $sedangMenulis]);
    }

    // Tambah method baru pesanBaru()
    public function pesanBaru(Request $request, Pengguna $pengguna)
    {
        $saya = Auth::user();
        $lastId = $request->query('last_id', 0);

        $pesan = Chat::where(function ($q) use ($saya, $pengguna) {
            $q->where('id_pengirim', $saya->id_pengguna)
                ->where('id_penerima', $pengguna->id_pengguna);
        })
            ->orWhere(function ($q) use ($saya, $pengguna) {
                $q->where('id_pengirim', $pengguna->id_pengguna)
                    ->where('id_penerima', $saya->id_pengguna);
            })
            ->where('id_chat', '>', $lastId)
            ->orderBy('created_at')
            ->get()
            ->map(fn ($p) => [
                'id_chat' => $p->id_chat,
                'id_pengirim' => $p->id_pengirim,
                'pesan' => $p->pesan,
                'waktu' => $p->created_at->format('H:i'),
                'dibaca' => $p->dibaca,
            ]);

        // Tandai pesan dari lawan sebagai dibaca
        Chat::where('id_pengirim', $pengguna->id_pengguna)
            ->where('id_penerima', $saya->id_pengguna)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return response()->json(['pesan' => $pesan]);
    }
}
