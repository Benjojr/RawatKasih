@extends('layouts.admin')

@section('title', 'Manajemen Kamar')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Kamar</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Tambah Kamar
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-600 text-sm px-4 py-3 rounded-lg">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-3 gap-4">
        @forelse($kamar as $k)
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <p class="font-semibold text-gray-800">Kamar {{ $k->nomor_kamar }}</p>
                    <span
                        class="text-xs px-2 py-1 rounded-full
                {{ $k->status_kamar === 'tersedia' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                        {{ ucfirst($k->status_kamar) }}
                    </span>
                </div>
                <p class="text-sm text-gray-400 mb-4">{{ $k->penghuni_count }} penghuni</p>
                <div class="flex gap-2">
                    <button onclick="openEdit({{ $k }})"
                        class="text-xs text-blue-500 hover:underline">Edit</button>
                    <form method="POST" action="{{ route('admin.kamar.destroy', $k->id_kamar) }}"
                        onsubmit="return confirm('Hapus kamar ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-400 py-10">Belum ada kamar terdaftar.</div>
        @endforelse
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Kamar</h2>
            <form method="POST" action="{{ route('admin.kamar.store') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" required placeholder="cth: 1A"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Status</label>
                        <select name="status_kamar" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="tersedia">Tersedia</option>
                            <option value="diisi">Diisi</option>
                        </select>
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
            <h2 class="font-semibold text-gray-800 mb-4">Edit Kamar</h2>
            <form method="POST" id="formEdit">
                @csrf @method('PUT')
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Nomor Kamar</label>
                        <input type="text" name="nomor_kamar" id="edit_nomor" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Status</label>
                        <select name="status_kamar" id="edit_status" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="tersedia">Tersedia</option>
                            <option value="diisi">Diisi</option>
                        </select>
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
        function openEdit(kamar) {
            document.getElementById('edit_nomor').value = kamar.nomor_kamar;
            document.getElementById('edit_status').value = kamar.status_kamar;
            document.getElementById('formEdit').action = `/admin/kamar/${kamar.id_kamar}`;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>

@endsection
