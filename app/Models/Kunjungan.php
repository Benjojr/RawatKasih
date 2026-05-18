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
}
