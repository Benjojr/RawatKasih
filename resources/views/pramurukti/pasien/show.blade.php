@extends('layouts.pramurukti')

@section('title', 'Profil Pasien')

@section('content')

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('pramurukti.pasien.index') }}" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Profil Pasien</h1>
    </div>

    {{-- Kartu Utama --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm mb-4">
        <div class="flex items-center gap-4 mb-6">
            <div
                class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-2xl font-bold">
                {{ strtoupper(substr($penghuni->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <p class="text-lg font-semibold text-gray-800">{{ $penghuni->nama_lengkap }}</p>
                <p class="text-sm text-gray-400">
                    {{ $penghuni->tanggal_lahir ? \Carbon\Carbon::parse($penghuni->tanggal_lahir)->age . ' tahun' : '-' }}
                    @if ($penghuni->kamar)
                        • Kamar {{ $penghuni->kamar->nomor_kamar }}
                    @endif
                </p>
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
                <p class="text-xs text-gray-400">Kamar</p>
                <p class="font-medium text-gray-700 mt-1">{{ $penghuni->kamar->nomor_kamar ?? '-' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-400">Alamat</p>
                <p class="font-medium text-gray-700 mt-1">{{ $penghuni->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Tugas Hari Ini --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="font-semibold text-gray-700 mb-4">Tugas Hari Ini</h2>
        @php
            $tugasHariIni = $penghuni
                ->tugasHarian()
                ->with('tugas')
                ->whereDate('waktu_pelaksanaan', today())
                ->orderBy('waktu_pelaksanaan')
                ->get();
        @endphp
        @forelse($tugasHariIni as $t)
            <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                <span
                    class="w-2.5 h-2.5 rounded-full flex-shrink-0
            {{ $t->status_tugas === 'tuntas'
                ? 'bg-green-400'
                : ($t->status_tugas === 'in progress'
                    ? 'bg-blue-400'
                    : 'bg-yellow-400') }}">
                </span>
                <div>
                    <p class="text-sm text-gray-700">{{ $t->tugas->judul_tugas ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $t->waktu_pelaksanaan }}</p>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400">Belum ada tugas untuk pasien ini hari ini.</p>
        @endforelse
    </div>

@endsection
