@extends('layouts.admin')

@section('title', 'Detail Penghuni')

@section('content')

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.penghuni.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Detail Penghuni</h1>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-600 text-sm px-4 py-3 rounded-lg">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-2 gap-6">

        {{-- Info Penghuni --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-2xl font-bold">
                    {{ strtoupper(substr($penghuni->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-lg">{{ $penghuni->nama_lengkap }}</p>
                    <p class="text-sm text-gray-400">Kamar {{ $penghuni->kamar->nomor_kamar ?? '-' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400">Gender</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $penghuni->gender ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Golongan Darah</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $penghuni->golongan_darah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Tanggal Lahir</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $penghuni->tanggal_lahir ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Umur</p>
                    <p class="font-medium text-gray-700 mt-1">
                        {{ $penghuni->tanggal_lahir ? \Carbon\Carbon::parse($penghuni->tanggal_lahir)->age . ' tahun' : '-' }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-400">Alamat</p>
                    <p class="font-medium text-gray-700 mt-1">{{ $penghuni->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Keluarga Terhubung --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-700">Keluarga Terhubung</h2>
                <button onclick="document.getElementById('modalAssign').classList.remove('hidden')"
                    class="text-xs bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg transition">
                    + Hubungkan
                </button>
            </div>

            @forelse($penghuni->keluarga as $k)
                <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-sm font-semibold">
                            {{ strtoupper(substr($k->pengguna->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $k->pengguna->nama_lengkap }}</p>
                            <p class="text-xs text-gray-400">
                                {{ $k->pivot->hubungan ?? 'Tidak disebutkan' }} • {{ $k->pengguna->no_telpon ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <form method="POST"
                        action="{{ route('admin.penghuni.removeKeluarga', [$penghuni->id_penghuni, $k->id_keluarga]) }}"
                        onsubmit="return confirm('Lepas hubungan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Lepas</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-400">Belum ada keluarga terhubung.</p>
            @endforelse
        </div>

    </div>

    {{-- Modal Assign Keluarga --}}
    <div id="modalAssign" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Hubungkan Keluarga</h2>
            <form method="POST" action="{{ route('admin.penghuni.assignKeluarga', $penghuni->id_penghuni) }}">
                @csrf
                <div class="flex flex-col gap-3">
                    <div>
                        <label class="text-xs text-gray-500">Akun Keluarga</label>
                        <select name="id_keluarga" required
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih akun keluarga...</option>
                            @foreach ($keluargaTersedia as $k)
                                <option value="{{ $k->id_keluarga }}">
                                    {{ $k->pengguna->nama_lengkap }} — {{ $k->pengguna->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Hubungan</label>
                        <select name="hubungan"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="">Pilih hubungan...</option>
                            <option value="Anak">Anak</option>
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Cucu">Cucu</option>
                            <option value="Keponakan">Keponakan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="document.getElementById('modalAssign').classList.add('hidden')"
                        class="text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Hubungkan</button>
                </div>
            </form>
        </div>
    </div>

@endsection
