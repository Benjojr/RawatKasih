@extends('layouts.admin')

@section('title', 'Manajemen Pramurukti')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Pramurukti</h1>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-6 text-center text-gray-400">Belum ada pramurukti terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
