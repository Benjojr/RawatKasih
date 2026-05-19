@php
    $layout = match (Auth::user()->peran) {
        'admin' => 'layouts.admin',
        'pramurukti' => 'layouts.pramurukti',
        'keluarga' => 'layouts.keluarga',
    };
@endphp

@extends($layout)

@section('title', 'Pengaturan Profil')

@section('content')

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Pengaturan Profil</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola informasi akun kamu</p>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl p-6 shadow-sm max-w-lg">

        {{-- Avatar --}}
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
            <div
                class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-2xl font-bold">
                {{ strtoupper(substr($pengguna->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $pengguna->nama_lengkap }}</p>
                <p class="text-sm text-gray-400">{{ ucfirst($pengguna->peran) }}</p>
                <p class="text-sm text-gray-400">{{ $pengguna->email }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profil.update') }}">
            @csrf @method('PUT')

            <div class="flex flex-col gap-4">
                <div>
                    <label class="text-xs text-gray-500">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}"
                        required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500">No. Telpon</label>
                    <input type="text" name="no_telpon" value="{{ old('no_telpon', $pengguna->no_telpon) }}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-sm font-medium text-gray-700 mb-3">Ubah Password</p>
                    <div class="flex flex-col gap-3">
                        <div>
                            <label class="text-xs text-gray-500">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400"
                                placeholder="Kosongkan jika tidak ingin ubah">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

@endsection
