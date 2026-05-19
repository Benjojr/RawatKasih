<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = 'penghuni';

    protected $primaryKey = 'id_penghuni';

    public $timestamps = false;

    protected $fillable = [
        'id_kamar', 'id_resep', 'id_riwayat_penyakit',
        'nama_lengkap', 'gender', 'tanggal_lahir',
        'golongan_darah', 'alamat',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    public function tugasHarian()
    {
        return $this->hasMany(TugasHarian::class, 'id_penghuni', 'id_penghuni');
    }
}
