<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penghuni;
use App\Models\TandaVital;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesehatanController extends Controller
{
    public function index(Request $request)
    {
        $pengguna = Auth::user();
        $keluarga = Keluarga::where('id_pengguna', $pengguna->id_pengguna)->first();

        $periode = $request->get('periode', '7');
        $penghuni = Penghuni::all();
        $idPenghuni = $request->get('id_penghuni', $penghuni->first()?->id_penghuni);

        $tandaVital = TandaVital::where('id_penghuni', $idPenghuni)
            ->where('tanggal', '>=', now()->subDays($periode)->toDateString())
            ->orderBy('tanggal')
            ->get();

        $labelGrafik = $tandaVital->pluck('tanggal')->map(fn ($d) => Carbon::parse($d)->format('d M'));
        $gulaData = $tandaVital->pluck('gula_darah');
        $detakData = $tandaVital->pluck('detak_jantung');
        $suhuData = $tandaVital->pluck('suhu');

        $vitalTerakhir = TandaVital::where('id_penghuni', $idPenghuni)
            ->orderByDesc('tanggal')->orderByDesc('waktu')
            ->first();

        return view('keluarga.kesehatan.index', compact(
            'tandaVital', 'labelGrafik', 'gulaData',
            'detakData', 'suhuData', 'periode',
            'penghuni', 'idPenghuni', 'vitalTerakhir',
        ));
    }
}
