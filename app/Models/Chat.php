<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    public $timestamps = false;

    protected $fillable = [
        'id_pengirim', 'id_penerima', 'pesan', 'dibaca',
    ];

    public function pengirim()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengirim', 'id_pengguna');
    }

    public function penerima()
    {
        return $this->belongsTo(Pengguna::class, 'id_penerima', 'id_pengguna');
    }
}