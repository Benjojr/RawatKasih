<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $primaryKey = 'id_kunjungan';

    public $timestamps = false;

    protected $fillable = [
        'id_keluarga', 'id_penghuni',
        'jam_kunjungan', 'tanggal_kunjungan',
        'status_kunjungan', 'catatan',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id_penghuni');
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga', 'id_keluarga');
    }
}
