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

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id_penghuni');
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }
}
