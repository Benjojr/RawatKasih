<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftPramurukti extends Model
{
    protected $table = 'shifts_pramurukti';
    protected $primaryKey = 'id_shift_harian';
    public $timestamps = false;

    protected $fillable = ['id_shift', 'id_pramurukti', 'tanggal'];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'id_shift', 'id_shift');
    }

    public function pramurukti()
    {
        return $this->belongsTo(Pramurukti::class, 'id_pramurukti', 'id_pramurukti');
    }
}