@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold">
                {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <p class="text-xs text-gray-400">Halo,</p>
                <p class="font-semibold text-gray-800">{{ Auth::user()->nama_lengkap }}</p>
            </div>
        </div>
        <div>
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </div>
    </div>

    {{-- Ringkasan Banner --}}
    <div class="bg-green-500 text-white rounded-2xl px-6 py-4 flex justify-between items-center mb-6">
        <span class="text-sm font-medium">📊 Ringkasan Hari Ini</span>
        <span class="font-bold">0/5 selesai</span>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">{{ $totalPenghuni }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Penghuni</p>
            <p class="text-xs text-gray-400">3 kamar kosong</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">{{ $perluPerhatian }}</p>
            <p class="text-sm text-gray-500 mt-1">Perlu Perhatian</p>
            <p class="text-xs text-gray-400">Kondisi kurang baik</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">{{ $totalPramurukti }}</p>
            <p class="text-sm text-gray-500 mt-1">Pramurukti Aktif</p>
            <p class="text-xs text-gray-400">dari 10 terdaftar</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-800">0</p>
            <p class="text-sm text-gray-500 mt-1">Laporan Masuk</p>
            <p class="text-xs text-gray-400">Dari keluarga</p>
        </div>
    </div>

    {{-- Tugas Harian Admin --}}
    <div class="mb-8">
        <h2 class="font-semibold text-gray-700 mb-3">📋 Tugas Harian <span
                class="text-xs text-orange-400 font-normal ml-1">4 pending</span></h2>
        <div class="flex flex-col gap-3">
            @foreach ([['label' => 'Verifikasi laporan harian pramurukti', 'waktu' => '08:00', 'prioritas' => 'Tinggi'], ['label' => 'Cek kehadiran staff shift pagi', 'waktu' => '08:30', 'prioritas' => 'Tinggi'], ['label' => 'Review permintaan kunjungan keluarga', 'waktu' => '10:00', 'prioritas' => 'Sedang'], ['label' => 'Meeting koordinasi mingguan', 'waktu' => '14:00', 'prioritas' => 'Sedang']] as $tugas)
                <div class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $tugas['label'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $tugas['waktu'] }}</p>
                        </div>
                    </div>
                    <span
                        class="text-xs px-2 py-1 rounded-full
                {{ $tugas['prioritas'] === 'Tinggi' ? 'bg-red-100 text-red-500' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ $tugas['prioritas'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="grid grid-cols-2 gap-4">
        <button class="bg-green-500 hover:bg-green-600 text-white rounded-2xl p-5 text-left transition">
            <div class="text-2xl mb-2">📅</div>
            <p class="font-semibold text-sm">Atur Jadwal Shift</p>
            <p class="text-xs text-green-100 mt-1">Kelola shift pramurukti</p>
        </button>
        <button class="bg-purple-500 hover:bg-purple-600 text-white rounded-2xl p-5 text-left transition">
            <div class="text-2xl mb-2">📢</div>
            <p class="font-semibold text-sm">Kirim Pengumuman</p>
            <p class="text-xs text-purple-100 mt-1">Broadcast ke semua</p>
        </button>
    </div>

@endsection
