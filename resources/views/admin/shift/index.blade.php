@extends('layouts.admin')

@section('title', 'Manajemen Shift')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Shift</h1>
        <div class="flex gap-2">
            <button onclick="document.getElementById('modalJenis').classList.remove('hidden')"
                class="border border-green-500 text-green-500 hover:bg-green-50 text-sm px-4 py-2 rounded-lg transition">
                + Jenis Shift
            </button>
            <button onclick="document.getElementById('modalJadwal').classList.remove('hidden')"
                class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
                + Atur Jadwal
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    {{-- Jenis Shift --}}
    <div class="mb-8">
        <h2 class="font-semibold text-gray-700 mb-3">Jenis Shift</h2>
        <div class="grid grid-cols-3 gap-4">
            @forelse($shifts as $s)
                <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $s->nama_shift }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $s->waktu_mulai }} — {{ $s->waktu_selesai }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.shift.destroyShift', $s->id_shift) }}"
                        onsubmit="return confirm('Hapus shift ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-2xl p-4 shadow-sm text-center text-gray-400 text-sm">
                    Belum ada jenis shift.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Jadwal Shift --}}
    <div>
        <h2 class="font-semibold text-gray-700 mb-3">Jadwal Mendatang</h2>
        @forelse($jadwal as $tanggal => $items)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500 mb-2">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </p>
                <div class="flex flex-col gap-2">
                    @foreach ($items as $item)
                        <div class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-sm font-semibold">
                                    {{ strtoupper(substr($item->pramurukti->pengguna->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $item->pramurukti->pengguna->nama_lengkap }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $item->shift->nama_shift }} •
                                        {{ $item->shift->waktu_mulai }} — {{ $item->shift->waktu_selesai }}
                                    </p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.shift.destroyJadwal', $item->id_shift_harian) }}"
                                onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl px-5 py-8 shadow-sm text-center text-gray-400">
                Belum ada jadwal shift mendatang.
            </div>
        @endforelse
    </div>

    {{-- Modal Jenis Shift --}}
    <div id="modalJenis" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Jenis Shift</h2>
            <form method="POST" action="{{ route('admin.shift.storeShift') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Nama Shift</label>
                        <input type="text" name="nama_shift" required placeholder="cth: Shift Pagi"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-500">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="document.getElementById('modalJenis').classList.add('hidden')"
                        class="text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Jadwal --}}
    <div id="modalJadwal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Atur Jadwal Shift</h2>
            <form method="POST" action="{{ route('admin.shift.storeJadwal') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Pramurukti</label>
                        <select name="id_pramurukti" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih pramurukti...</option>
                            @foreach ($pramurukti as $p)
                                <option value="{{ $p->id_pramurukti }}">{{ $p->pengguna->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Shift</label>
                        <select name="id_shift" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih shift...</option>
                            @foreach ($shifts as $s)
                                <option value="{{ $s->id_shift }}">{{ $s->nama_shift }} ({{ $s->waktu_mulai }} -
                                    {{ $s->waktu_selesai }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Tanggal</label>
                        <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="document.getElementById('modalJadwal').classList.add('hidden')"
                        class="text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
