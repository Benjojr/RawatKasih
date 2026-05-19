<?php

namespace App\Http\Controllers\Pramurukti;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;

class PasienController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['kamar'])->get();
        return view('pramurukti.pasien.index', compact('penghuni'));
    }

    public function show(Penghuni $penghuni)
    {
        $penghuni->load(['kamar']);
        return view('pramurukti.pasien.show', compact('penghuni'));
    }
}