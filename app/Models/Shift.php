<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shifts';
    protected $primaryKey = 'id_shift';
    public $timestamps = false;

    protected $fillable = ['nama_shift', 'waktu_mulai', 'waktu_selesai'];

    public function jadwal()
    {
        return $this->hasMany(ShiftPramurukti::class, 'id_shift', 'id_shift');
    }
}