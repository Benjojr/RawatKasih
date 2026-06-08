@extends('layouts.admin')

@section('title', 'Rutinitas Harian')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Rutinitas Harian</h1>
            <p class="text-sm text-gray-400 mt-1">Jadwal kegiatan rutin untuk semua penghuni setiap hari</p>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('admin.rutinitas.generate') }}">
                @csrf
                <button type="submit" onclick="return confirm('Generate tugas harian untuk semua penghuni hari ini?')"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg transition">
                    ⚡ Generate Hari Ini
                </button>
            </form>
            <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
                + Tambah Rutinitas
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-600 text-sm px-4 py-3 rounded-lg">{{ session('error') }}</div>
    @endif

    {{-- Info --}}
    <div class="bg-blue-50 text-blue-700 text-sm px-4 py-3 rounded-lg mb-6">
        Klik <strong>Generate Hari Ini</strong> setiap pagi untuk membuat tugas harian otomatis bagi semua penghuni
        berdasarkan rutinitas aktif.
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Kegiatan</th>
                    <th class="px-5 py-3 font-medium">Tipe</th>
                    <th class="px-5 py-3 font-medium">Jam</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rutinitas as $r)
                    <tr class="hover:bg-gray-50 {{ !$r->aktif ? 'opacity-50' : '' }}">
                        <td class="px-5 py-4 font-medium text-gray-800">{{ $r->tugas->judul_tugas }}</td>
                        <td class="px-5 py-4">
                            <span
                                class="text-xs px-2 py-1 rounded-full
                        {{ $r->tugas->tipe_tugas === 'monitoring'
                            ? 'bg-blue-100 text-blue-600'
                            : ($r->tugas->tipe_tugas === 'obat'
                                ? 'bg-purple-100 text-purple-600'
                                : 'bg-yellow-100 text-yellow-600') }}">
                                {{ ucfirst($r->tugas->tipe_tugas) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-600">{{ $r->jam }}</td>
                        <td class="px-5 py-4">
                            <span
                                class="text-xs px-2 py-1 rounded-full
                        {{ $r->aktif ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $r->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 flex gap-3">
                            <form method="POST" action="{{ route('admin.rutinitas.toggle', $r->id_rutinitas) }}">
                                @csrf @method('PATCH')
                                <button class="text-xs text-blue-500 hover:underline">
                                    {{ $r->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.rutinitas.destroy', $r->id_rutinitas) }}"
                                onsubmit="return confirm('Hapus rutinitas ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-400">
                            Belum ada rutinitas. Tambahkan kegiatan rutin seperti senam, sarapan, mandi, dll.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Rutinitas</h2>
            <form method="POST" action="{{ route('admin.rutinitas.store') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Jenis Tugas</label>
                        <select name="id_tugas" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih tugas...</option>
                            @foreach ($tugas as $t)
                                <option value="{{ $t->id_tugas }}">{{ $t->judul_tugas }} ({{ $t->tipe_tugas }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Jam Pelaksanaan</label>
                        <input type="time" name="jam" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
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
