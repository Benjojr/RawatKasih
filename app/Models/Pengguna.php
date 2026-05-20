<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'peran',
        'no_telpon',
    ];

    protected $hidden = [
        'password',
    ];

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_pengguna', 'id_pengguna');
    }
}
