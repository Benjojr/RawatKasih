<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasHarian extends Model
{
    protected $table = 'tugas_harian';
    protected $primaryKey = 'id_tugas_harian';
    public $timestamps = false;

    protected $fillable = [
        'id_penghuni', 'id_tugas', 'catatan',
        'waktu_pelaksanaan', 'status_tugas', 'mood',
    ];
}