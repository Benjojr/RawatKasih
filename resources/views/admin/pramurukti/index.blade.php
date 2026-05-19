@extends('layouts.admin')

@section('title', 'Manajemen Pramurukti')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Pramurukti</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Tambah Pramurukti
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Email</th>
                    <th class="px-5 py-3 font-medium">No. Telpon</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pramurukti as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold text-sm">
                                    {{ strtoupper(substr($p->pengguna->nama_lengkap, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $p->pengguna->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->pengguna->email }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->pengguna->no_telpon ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.pramurukti.destroy', $p->id_pramurukti) }}"
                                onsubmit="return confirm('Hapus pramurukti ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">Belum ada pramurukti terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Pramurukti</h2>
            <form method="POST" action="{{ route('admin.pramurukti.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="text-xs text-gray-500">Pilih Pengguna (peran pramurukti)</label>
                    <select name="id_pengguna" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <option value="">Pilih pengguna...</option>
                        @foreach ($pengguna as $pg)
                            <option value="{{ $pg->id_pengguna }}">{{ $pg->nama_lengkap }} — {{ $pg->email }}</option>
                        @endforeach
                    </select>
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
