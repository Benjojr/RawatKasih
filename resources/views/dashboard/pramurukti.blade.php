@extends('layouts.pramurukti')

@section('title', 'Dashboard Pramurukti')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold">
                {{ strtoupper(substr($pengguna->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <p class="text-xs text-gray-400">Halo,</p>
                <p class="font-semibold text-gray-800">{{ $pengguna->nama_lengkap }}</p>
            </div>
        </div>
        <a href="{{ route('notifikasi.index') }}" class="relative">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @php
                $jumlahNotif = \App\Models\Notifikasi::where('id_pengguna', Auth::id())
                    ->where('dibaca', false)
                    ->count();
            @endphp
            @if ($jumlahNotif > 0)
                <span
                    class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                    {{ $jumlahNotif }}
                </span>
            @endif
        </a>
    </div>

    {{-- Shift Banner --}}
    <div class="bg-green-500 text-white rounded-2xl px-6 py-4 flex justify-between items-center mb-6">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">Shift pagi berakhir dalam</span>
        </div>
        <span class="font-bold text-lg">2j 30m</span>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">{{ $totalPenghuni }}</p>
            <p class="text-sm text-gray-500 mt-1">Lansia dirawat</p>
            <p class="text-xs text-gray-400">Shift pagi</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">{{ $tugasSelesai }}/{{ $tugasHariIni }}</p>
            <p class="text-sm text-gray-500 mt-1">Tugas selesai</p>
            <p class="text-xs text-gray-400">Hari ini</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">{{ $perluPerhatian }}</p>
            <p class="text-sm text-gray-500 mt-1">Perlu perhatian</p>
            <p class="text-xs text-gray-400">Kondisi kurang baik</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">0</p>
            <p class="text-sm text-gray-500 mt-1">Laporan masuk</p>
            <p class="text-xs text-gray-400">Dari keluarga</p>
        </div>
    </div>

    {{-- Pasien Hari Ini --}}
    <div class="mb-8">
        <h2 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Pasien hari ini
        </h2>
        <div class="flex gap-3 flex-wrap">
            @forelse($daftarPenghuni as $penghuni)
                <div class="bg-white rounded-xl px-4 py-3 shadow-sm flex items-center gap-2">
                    <div
                        class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-sm font-semibold">
                        {{ strtoupper(substr($penghuni->nama_lengkap, 0, 1)) }}
                    </div>
                    <span class="text-sm text-gray-700">{{ $penghuni->nama_lengkap }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400">Belum ada penghuni terdaftar.</p>
            @endforelse
        </div>
    </div>

    {{-- Tugas Harian --}}
    <div>
        <h2 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Tugas harian
        </h2>
        <div class="flex flex-col gap-3">
            @forelse($tugasHariIniList ?? [] as $tugas)
                <div class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center gap-3">
                    <span
                        class="w-3 h-3 rounded-full
                    {{ $tugas->status_tugas === 'tuntas'
                        ? 'bg-green-400'
                        : ($tugas->status_tugas === 'in progress'
                            ? 'bg-blue-400'
                            : 'bg-yellow-400') }}">
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ $tugas->catatan }}</p>
                        <p class="text-xs text-gray-400 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $tugas->waktu_pelaksanaan }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl px-5 py-4 shadow-sm">
                    <p class="text-sm text-gray-400">Belum ada tugas harian.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection
