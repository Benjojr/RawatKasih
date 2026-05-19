@extends('layouts.admin')

@section('title', 'Manajemen Tugas')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Tugas</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Tambah Tugas
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Judul Tugas</th>
                    <th class="px-5 py-3 font-medium">Tipe</th>
                    <th class="px-5 py-3 font-medium">Butuh Vital</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tugas as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 font-medium text-gray-800">{{ $t->judul_tugas }}</td>
                        <td class="px-5 py-4">
                            <span
                                class="text-xs px-2 py-1 rounded-full
                        {{ $t->tipe_tugas === 'monitoring'
                            ? 'bg-blue-100 text-blue-600'
                            : ($t->tipe_tugas === 'obat'
                                ? 'bg-purple-100 text-purple-600'
                                : 'bg-yellow-100 text-yellow-600') }}">
                                {{ ucfirst($t->tipe_tugas) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-500">
                            {{ $t->butuh_vital ? '✅ Ya' : '—' }}
                        </td>
                        <td class="px-5 py-4 flex gap-3">
                            <button onclick="openEdit({{ $t }})"
                                class="text-xs text-blue-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('admin.tugas.destroy', $t->id_tugas) }}"
                                onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">Belum ada tugas terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Tugas</h2>
            <form method="POST" action="{{ route('admin.tugas.store') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Judul Tugas</label>
                        <input type="text" name="judul_tugas" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Tipe Tugas</label>
                        <select name="tipe_tugas" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="aktifitas">Aktifitas</option>
                            <option value="monitoring">Monitoring</option>
                            <option value="obat">Obat</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <input type="checkbox" name="butuh_vital" id="butuh_vital" value="1" class="rounded">
                        <label for="butuh_vital" class="text-sm text-gray-600">Butuh input tanda vital</label>
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

    {{-- Modal Edit --}}
    <div id="modalEdit" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Edit Tugas</h2>
            <form method="POST" id="formEdit">
                @csrf @method('PUT')
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Judul Tugas</label>
                        <input type="text" name="judul_tugas" id="edit_judul" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Tipe Tugas</label>
                        <select name="tipe_tugas" id="edit_tipe"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="aktifitas">Aktifitas</option>
                            <option value="monitoring">Monitoring</option>
                            <option value="obat">Obat</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <input type="checkbox" name="butuh_vital" id="edit_vital" value="1" class="rounded">
                        <label for="edit_vital" class="text-sm text-gray-600">Butuh input tanda vital</label>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(tugas) {
            document.getElementById('edit_judul').value = tugas.judul_tugas;
            document.getElementById('edit_tipe').value = tugas.tipe_tugas;
            document.getElementById('edit_vital').checked = tugas.butuh_vital == 1;
            document.getElementById('formEdit').action = `/admin/tugas/${tugas.id_tugas}`;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>

@endsection
