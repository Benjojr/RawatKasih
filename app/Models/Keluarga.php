<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
