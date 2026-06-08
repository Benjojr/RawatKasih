<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Keluarga;

class Keluarga extends Model
{
    protected $table = 'keluarga';

    protected $primaryKey = 'id_keluarga';

    public $timestamps = false;

    protected $fillable = ['id_pengguna'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function penghuni()
    {
        return $this->belongsToMany(
            Penghuni::class,
            'keluarga_penghuni',
            'id_keluarga',
            'id_penghuni'
        )->withPivot('hubungan');
    }

    public function keluarga()
    {
        return $this->belongsToMany(
            Keluarga::class,
            'keluarga_penghuni',
            'id_penghuni',
            'id_keluarga'
        )->withPivot('hubungan');
    }
}
