@extends('layouts.keluarga')

@section('title', 'Grafik Kesehatan')

@section('content')

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Grafik Kesehatan</h1>
        <p class="text-sm text-gray-400 mt-1">Pantau tren kesehatan penghuni</p>
    </div>

    {{-- Filter --}}
    <div class="flex gap-3 mb-6 flex-wrap">
        <form method="GET" action="{{ route('keluarga.kesehatan.index') }}" class="flex gap-3 flex-wrap">
            <select name="id_penghuni" onchange="this.form.submit()"
                class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @foreach ($penghuni as $p)
                    <option value="{{ $p->id_penghuni }}" {{ $idPenghuni == $p->id_penghuni ? 'selected' : '' }}>
                        {{ $p->nama_lengkap }}
                    </option>
                @endforeach
            </select>

            @foreach (['7' => '7 Hari', '14' => '14 Hari', '30' => '1 Bulan', '90' => '3 Bulan'] as $val => $label)
                <button type="submit" name="periode" value="{{ $val }}"
                    class="px-4 py-2 rounded-lg text-sm border transition
            {{ $periode == $val ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
            @endforeach
        </form>
    </div>

    {{-- Vital Terakhir --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        @foreach ([['label' => 'Tekanan Darah', 'nilai' => $vitalTerakhir?->tekanan_darah ?? '-', 'satuan' => 'mmHg'], ['label' => 'Gula Darah', 'nilai' => $vitalTerakhir?->gula_darah ?? '-', 'satuan' => 'mg/dL'], ['label' => 'Detak Jantung', 'nilai' => $vitalTerakhir?->detak_jantung ?? '-', 'satuan' => 'bpm'], ['label' => 'Suhu', 'nilai' => $vitalTerakhir?->suhu ?? '-', 'satuan' => '°C']] as $v)
            <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
                <p class="text-xs text-gray-400 mb-1">{{ $v['label'] }}</p>
                <p class="text-xl font-bold text-gray-800">{{ $v['nilai'] }}</p>
                <p class="text-xs text-gray-400">{{ $v['satuan'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Grafik --}}
    <div class="grid grid-cols-1 gap-4">

        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-semibold text-gray-700 mb-4">Gula Darah (mg/dL)</h2>
            <canvas id="gulaChart" height="80"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-semibold text-gray-700 mb-4">Detak Jantung (bpm)</h2>
            <canvas id="detakChart" height="80"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-semibold text-gray-700 mb-4">Suhu Tubuh (°C)</h2>
            <canvas id="suhuChart" height="80"></canvas>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labelGrafik);
        const gulaData = @json($gulaData);
        const detakData = @json($detakData);
        const suhuData = @json($suhuData);

        function buatGrafik(id, label, data, warna) {
            new Chart(document.getElementById(id), {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label,
                        data,
                        borderColor: warna,
                        backgroundColor: warna + '20',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: warna,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        buatGrafik('gulaChart', 'Gula Darah', gulaData, '#10b981');
        buatGrafik('detakChart', 'Detak Jantung', detakData, '#3b82f6');
        buatGrafik('suhuChart', 'Suhu Tubuh', suhuData, '#f59e0b');
    </script>

@endsection
