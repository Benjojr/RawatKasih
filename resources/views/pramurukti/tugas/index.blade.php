@extends('layouts.pramurukti')

@section('title', 'Tugas Harian')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Tugas Harian</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Tambah Tugas
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    {{-- Progress --}}
    @php
        $total = $tugasHarian->count();
        $selesai = $tugasHarian->where('status_tugas', 'tuntas')->count();
        $persen = $total > 0 ? round(($selesai / $total) * 100) : 0;
    @endphp
    <div class="bg-white rounded-2xl p-5 shadow-sm mb-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Progres hari ini</span>
            <span class="text-green-600 font-medium">{{ $selesai }}/{{ $total }} tugas</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-green-500 h-2 rounded-full transition-all" style="width: {{ $persen }}%"></div>
        </div>
    </div>

    {{-- Daftar Tugas (grouped by sesi) --}}
    @php
        function sesiWaktu($waktu)
        {
            $jam = (int) \Carbon\Carbon::parse($waktu)->format('H');
            if ($jam >= 5 && $jam < 11) {
                return 'Pagi';
            }
            if ($jam >= 11 && $jam < 15) {
                return 'Siang';
            }
            if ($jam >= 15 && $jam < 19) {
                return 'Sore';
            }
            return 'Malam';
        }

        $grouped = $tugasHarian->groupBy(fn($t) => sesiWaktu($t->waktu_pelaksanaan));
        $urutan = ['Pagi', 'Siang', 'Sore', 'Malam'];
        $sesiIcon = [
            'Pagi' => ['range' => '05:00–11:00'],
            'Siang' => ['range' => '11:00–15:00'],
            'Sore' => ['range' => '15:00–19:00'],
            'Malam' => ['range' => '19:00–05:00'],
        ];
    @endphp

    <div class="flex flex-col gap-1">
        @forelse($urutan as $sesi)
            @if ($grouped->has($sesi))
                {{-- Header Sesi --}}
                <div class="flex items-center gap-3 mt-5 mb-2">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                        {{ $sesi }} · {{ $sesiIcon[$sesi]['range'] }}
                    </span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                {{-- Tugas dalam sesi ini --}}
                @foreach ($grouped[$sesi] as $t)
                    @php
                        $dotColor = match ($t->status_tugas) {
                            'tuntas' => 'bg-green-500',
                            'in progress' => 'bg-blue-500',
                            default => 'bg-yellow-400',
                        };
                        $badgeCls = match ($t->status_tugas) {
                            'tuntas' => 'bg-green-100 text-green-700',
                            'in progress' => 'bg-blue-100 text-blue-700',
                            default => 'bg-yellow-100 text-yellow-700',
                        };
                        $badgeLabel = match ($t->status_tugas) {
                            'tuntas' => 'Tuntas',
                            'in progress' => 'In Progress',
                            default => 'Mendatang',
                        };
                    @endphp
                    <div class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $dotColor }}"></span>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $t->tugas->judul_tugas ?? '-' }} — {{ $t->penghuni->nama_lengkap ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($t->waktu_pelaksanaan)->format('H:i') }}
                                    · {{ ucfirst($t->tugas->tipe_tugas ?? '') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Badge status --}}
                            <span class="text-xs font-medium px-3 py-1 rounded-full {{ $badgeCls }}">
                                {{ $badgeLabel }}
                            </span>

                            {{-- Dropdown update status --}}
                            <form method="POST"
                                action="{{ route('pramurukti.tugas.updateStatus', $t->id_tugas_harian) }}">
                                @csrf @method('PATCH')
                                <select name="status_tugas" onchange="this.form.submit()"
                                    class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-green-400 bg-white">
                                    <option value="mendatang" {{ $t->status_tugas === 'mendatang' ? 'selected' : '' }}>
                                        Mendatang</option>
                                    <option value="in progress" {{ $t->status_tugas === 'in progress' ? 'selected' : '' }}>
                                        In Progress</option>
                                    <option value="tuntas" {{ $t->status_tugas === 'tuntas' ? 'selected' : '' }}>
                                        Tuntas</option>
                                </select>
                            </form>

                            {{-- Tombol hapus --}}
                            <form method="POST" action="{{ route('pramurukti.tugas.destroy', $t->id_tugas_harian) }}"
                                onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-sm font-medium bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-xl transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        @empty
            <div class="bg-white rounded-2xl px-5 py-6 shadow-sm text-center text-gray-400">
                Belum ada tugas hari ini.
            </div>
        @endforelse
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Tugas</h2>
            <form method="POST" action="{{ route('pramurukti.tugas.store') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Penghuni</label>
                        <select name="id_penghuni" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih penghuni...</option>
                            @foreach ($penghuni as $p)
                                <option value="{{ $p->id_penghuni }}">{{ $p->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Jenis Tugas</label>
                        <select name="id_tugas" id="selectTugas" required ...>
                            <option value="">Pilih tugas...</option>
                            @foreach ($tugas as $tg)
                                <option value="{{ $tg->id_tugas }}" data-vital="{{ $tg->butuh_vital ? '1' : '0' }}">
                                    {{ $tg->judul_tugas }} ({{ $tg->tipe_tugas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Waktu Pelaksanaan</label>
                        <input type="time" name="waktu_pelaksanaan" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Mood Penghuni</label>
                        <select name="mood" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="baik">Baik</option>
                            <option value="biasa">Biasa</option>
                            <option value="kurang baik">Kurang Baik</option>
                            <option value="buruk">Buruk</option>
                        </select>
                    </div>
                    <div id="sectionVital" class="hidden flex flex-col gap-3 p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs font-medium text-gray-500">Tanda Vital</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-gray-500">Tekanan Darah</label>
                                <input type="text" name="tekanan_darah" placeholder="cth: 120/80"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Detak Jantung (bpm)</label>
                                <input type="number" name="detak_jantung"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Gula Darah (mg/dL)</label>
                                <input type="number" step="0.01" name="gula_darah"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Suhu (°C)</label>
                                <input type="number" step="0.1" name="suhu"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Catatan</label>
                        <textarea name="catatan" rows="2"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('selectTugas').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const butuhVital = selected.dataset.vital === '1';
            document.getElementById('sectionVital').classList.toggle('hidden', !butuhVital);
        });
    </script>
@endsection
