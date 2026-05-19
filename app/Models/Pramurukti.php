<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pramurukti extends Model
{
    protected $table = 'pramurukti';

    protected $primaryKey = 'id_pramurukti';

    public $timestamps = false;

    protected $fillable = [
        'id_pengguna', 'id_tugas_harian',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
