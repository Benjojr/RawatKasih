@extends('layouts.keluarga')

@section('title', 'Jadwal Kunjungan')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Jadwal Kunjungan</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Ajukan Kunjungan
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-600 text-sm px-4 py-3 rounded-lg">{{ session('error') }}</div>
    @endif

    @if (!$keluarga)
        <div class="bg-yellow-50 text-yellow-700 text-sm px-4 py-3 rounded-lg mb-4">
            Akun keluarga belum terdaftar. Hubungi admin panti untuk mendaftarkan akun kamu.
        </div>
    @endif

    <div class="flex flex-col gap-3">
        @forelse($kunjungan as $k)
            <div class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold">
                        {{ strtoupper(substr($k->penghuni->nama_lengkap, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $k->penghuni->nama_lengkap }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->translatedFormat('d F Y') }}
                            • Pukul {{ str_pad($k->jam_kunjungan, 2, '0', STR_PAD_LEFT) }}:00
                        </p>
                        @if ($k->catatan)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $k->catatan }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="text-xs px-2 py-1 rounded-full
                {{ $k->status_kunjungan === 'tuntas' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                        {{ ucfirst($k->status_kunjungan) }}
                    </span>
                    @if ($k->status_kunjungan === 'mendatang')
                        <form method="POST" action="{{ route('keluarga.kunjungan.destroy', $k->id_kunjungan) }}"
                            onsubmit="return confirm('Batalkan kunjungan ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:underline">Batalkan</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl px-5 py-8 shadow-sm text-center text-gray-400">
                Belum ada jadwal kunjungan.
            </div>
        @endforelse
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Ajukan Kunjungan</h2>
            <form method="POST" action="{{ route('keluarga.kunjungan.store') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Penghuni yang Dikunjungi</label>
                        <select name="id_penghuni" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih penghuni...</option>
                            @foreach ($penghuni as $p)
                                <option value="{{ $p->id_penghuni }}">{{ $p->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" required min="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Jam Kunjungan</label>
                        <select name="jam_kunjungan" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            @for ($i = 8; $i <= 17; $i++)
                                <option value="{{ $i }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Catatan (opsional)</label>
                        <textarea name="catatan" rows="2"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"
                            placeholder="Misal: membawa makanan, keperluan khusus..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Ajukan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
