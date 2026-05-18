@extends('layouts.admin')

@section('title', 'Manajemen Penghuni')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Penghuni</h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Tambah Penghuni
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Penghuni --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Gender</th>
                    <th class="px-5 py-3 font-medium">Tgl Lahir</th>
                    <th class="px-5 py-3 font-medium">Gol. Darah</th>
                    <th class="px-5 py-3 font-medium">Kamar</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($penghuni as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 font-medium text-gray-800">{{ $p->nama_lengkap }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->gender ?? '-' }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->tanggal_lahir ?? '-' }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->golongan_darah ?? '-' }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->kamar->nomor_kamar ?? '-' }}</td>
                        <td class="px-5 py-4 flex gap-2">
                            <button onclick="openEdit({{ $p }})"
                                class="text-xs text-blue-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('admin.penghuni.destroy', $p->id_penghuni) }}"
                                onsubmit="return confirm('Hapus penghuni ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-6 text-center text-gray-400">Belum ada penghuni terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Tambah Penghuni</h2>
            <form method="POST" action="{{ route('admin.penghuni.store') }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-500">Gender</label>
                            <select name="gender" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Gol. Darah</label>
                            <select name="golongan_darah"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Pilih</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Kamar</label>
                        <select name="id_kamar"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih Kamar</option>
                            @foreach ($kamar as $k)
                                <option value="{{ $k->id_kamar }}">{{ $k->nomor_kamar }} ({{ $k->status_kamar }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Alamat</label>
                        <textarea name="alamat" rows="2"
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

    {{-- Modal Edit --}}
    <div id="modalEdit" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Edit Penghuni</h2>
            <form method="POST" id="formEdit">
                @csrf @method('PUT')
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="edit_nama" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-500">Gender</label>
                            <select name="gender" id="edit_gender" required
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Gol. Darah</label>
                            <select name="golongan_darah" id="edit_golongan"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Pilih</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit_tanggal"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Kamar</label>
                        <select name="id_kamar" id="edit_kamar"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih Kamar</option>
                            @foreach ($kamar as $k)
                                <option value="{{ $k->id_kamar }}">{{ $k->nomor_kamar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" rows="2"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
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
        function openEdit(penghuni) {
            document.getElementById('edit_nama').value = penghuni.nama_lengkap;
            document.getElementById('edit_gender').value = penghuni.gender;
            document.getElementById('edit_golongan').value = penghuni.golongan_darah;
            document.getElementById('edit_tanggal').value = penghuni.tanggal_lahir;
            document.getElementById('edit_kamar').value = penghuni.id_kamar;
            document.getElementById('edit_alamat').value = penghuni.alamat;
            document.getElementById('formEdit').action = `/admin/penghuni/${penghuni.id_penghuni}`;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>

@endsection
