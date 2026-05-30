@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Pengguna</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola semua akun pengguna sistem</p>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-600 text-sm px-4 py-3 rounded-lg">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Email</th>
                    <th class="px-5 py-3 font-medium">No. Telpon</th>
                    <th class="px-5 py-3 font-medium">Peran</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengguna as $pg)
                    <tr class="hover:bg-gray-50 {{ $pg->blacklist ? 'opacity-50' : '' }}">
                        <td class="px-5 py-4 font-medium text-gray-800">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xs font-semibold">
                                    {{ strtoupper(substr($pg->nama_lengkap, 0, 1)) }}
                                </div>
                                {{ $pg->nama_lengkap }}
                                @if ($pg->id_pengguna === Auth::id())
                                    <span class="text-xs text-gray-400">(kamu)</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $pg->email }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $pg->no_telpon ?? '-' }}</td>
                        <td class="px-5 py-4">
                            @if ($pg->id_pengguna !== Auth::id())
                                <form method="POST" action="{{ route('admin.pengguna.updatePeran', $pg->id_pengguna) }}">
                                    @csrf @method('PATCH')
                                    <div class="flex gap-2 items-center">
                                        <select name="peran"
                                            class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-green-400">
                                            <option value="keluarga" {{ $pg->peran === 'keluarga' ? 'selected' : '' }}>
                                                Keluarga</option>
                                            <option value="pramurukti" {{ $pg->peran === 'pramurukti' ? 'selected' : '' }}>
                                                Pramurukti</option>
                                            <option value="admin" {{ $pg->peran === 'admin' ? 'selected' : '' }}>
                                                Admin</option>
                                        </select>
                                        <button type="submit"
                                            onclick="return confirm('Ubah peran {{ $pg->nama_lengkap }}?')"
                                            class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-lg transition">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-600">
                                    {{ ucfirst($pg->peran) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if ($pg->blacklist)
                                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-600">Blacklist</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">Aktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            @if ($pg->id_pengguna !== Auth::id())
                                <div class="flex gap-2">
                                    @if (!$pg->blacklist)
                                        <form method="POST"
                                            action="{{ route('admin.pengguna.blacklist', $pg->id_pengguna) }}"
                                            onsubmit="return confirm('Blacklist akun {{ $pg->nama_lengkap }}?')">
                                            @csrf @method('PATCH')
                                            <button class="text-xs text-orange-500 hover:underline">Blacklist</button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ route('admin.pengguna.blacklist', $pg->id_pengguna) }}"
                                            onsubmit="return confirm('Aktifkan kembali akun {{ $pg->nama_lengkap }}?')">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="unblacklist" value="1">
                                            <button class="text-xs text-blue-500 hover:underline">Aktifkan</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.pengguna.destroy', $pg->id_pengguna) }}"
                                        onsubmit="return confirm('Hapus akun {{ $pg->nama_lengkap }}? Tindakan ini tidak bisa dibatalkan.')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">Belum ada pengguna terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
