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

    {{-- Daftar Tugas --}}
    <div class="flex flex-col gap-3">
        @forelse($tugasHarian as $t)
            <div class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span
                        class="w-3 h-3 rounded-full flex-shrink-0
                {{ $t->status_tugas === 'tuntas'
                    ? 'bg-green-400'
                    : ($t->status_tugas === 'in progress'
                        ? 'bg-blue-400'
                        : 'bg-yellow-400') }}">
                    </span>
                    <div>
                        <p
                            class="text-sm font-medium text-gray-700
                    {{ $t->status_tugas === 'tuntas' ? 'line-through text-gray-400' : '' }}">
                            {{ $t->tugas->judul_tugas ?? '-' }} — {{ $t->penghuni->nama_lengkap ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ $t->waktu_pelaksanaan }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('pramurukti.tugas.updateStatus', $t->id_tugas_harian) }}">
                        @csrf @method('PATCH')
                        <select name="status_tugas" onchange="this.form.submit()"
                            class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-green-400">
                            <option value="mendatang" {{ $t->status_tugas === 'mendatang' ? 'selected' : '' }}>Mendatang
                            </option>
                            <option value="in progress" {{ $t->status_tugas === 'in progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="tuntas" {{ $t->status_tugas === 'tuntas' ? 'selected' : '' }}>Tuntas
                            </option>
                        </select>
                    </form>
                    <form method="POST" action="{{ route('pramurukti.tugas.destroy', $t->id_tugas_harian) }}"
                        onsubmit="return confirm('Hapus tugas ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
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
                        <select name="id_tugas" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih tugas...</option>
                            @foreach ($tugas as $tg)
                                <option value="{{ $tg->id_tugas }}">{{ $tg->judul_tugas }} ({{ $tg->tipe_tugas }})
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

@endsection
