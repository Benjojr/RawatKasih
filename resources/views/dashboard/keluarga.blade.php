@extends('layouts.keluarga')

@section('title', 'Dashboard Keluarga')

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
        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
    </div>

    {{-- Kartu Status Lansia --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
        @if ($keluarga)
            <p class="text-xs text-gray-400 mb-3">Status Lansia</p>
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xl font-bold">
                    ?
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800">Data penghuni belum terhubung</p>
                    <p class="text-sm text-gray-400">Hubungi admin untuk menghubungkan data</p>
                </div>
                <span class="text-xs bg-gray-100 text-gray-500 px-3 py-1 rounded-full">Tidak diketahui</span>
            </div>
        @else
            <p class="text-sm text-gray-400">Akun keluarga belum terdaftar. Hubungi admin panti.</p>
        @endif
    </div>

    {{-- Vital Terkini --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
            <p class="text-xs text-gray-400 mb-1">Tekanan Darah</p>
            <p class="text-lg font-bold text-gray-800">-/-</p>
            <p class="text-xs text-gray-400">mmHg</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
            <p class="text-xs text-gray-400 mb-1">Gula Darah</p>
            <p class="text-lg font-bold text-gray-800">-</p>
            <p class="text-xs text-gray-400">mg/dL</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
            <p class="text-xs text-gray-400 mb-1">Detak Jantung</p>
            <p class="text-lg font-bold text-gray-800">-</p>
            <p class="text-xs text-gray-400">bpm</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
            <p class="text-xs text-gray-400 mb-1">Suhu</p>
            <p class="text-lg font-bold text-gray-800">-</p>
            <p class="text-xs text-gray-400">°C</p>
        </div>
    </div>

    {{-- Timeline Aktivitas --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm mb-6">
        <h2 class="font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h2>
        <div class="flex flex-col gap-4">
            <p class="text-sm text-gray-400">Belum ada aktivitas tercatat hari ini.</p>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="grid grid-cols-2 gap-4">
        <button
            class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 rounded-2xl p-4 text-left transition shadow-sm">
            <p class="font-semibold text-sm">📅 Jadwal Kunjungan</p>
            <p class="text-xs text-gray-400 mt-1">Lihat & ajukan kunjungan</p>
        </button>
        <button
            class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 rounded-2xl p-4 text-left transition shadow-sm">
            <p class="font-semibold text-sm">📋 Riwayat Lengkap</p>
            <p class="text-xs text-gray-400 mt-1">Lihat semua catatan kesehatan</p>
        </button>
    </div>

@endsection
