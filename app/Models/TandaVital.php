<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TandaVital extends Model
{
    protected $table = 'tanda_vital';
    protected $primaryKey = 'id_vital';
    public $timestamps = false;

    protected $fillable = [
        'id_penghuni', 'tekanan_darah',
        'detak_jantung', 'gula_darah',
        'suhu', 'tanggal', 'waktu',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni', 'id_penghuni');
    }
}