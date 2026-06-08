<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rutinitas extends Model
{
    protected $table = 'rutinitas';
    protected $primaryKey = 'id_rutinitas';
    public $timestamps = false;

    protected $fillable = ['id_tugas', 'jam', 'aktif'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }
}