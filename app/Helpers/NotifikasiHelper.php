<?php

namespace App\Helpers;

use App\Models\Notifikasi;

class NotifikasiHelper
{
    public static function kirim(int $idPengguna, string $judul, string $pesan, string $tipe = 'info'): void
    {
        Notifikasi::create([
            'id_pengguna' => $idPengguna,
            'judul'       => $judul,
            'pesan'       => $pesan,
            'tipe'        => $tipe,
            'dibaca'      => false,
        ]);
    }
}