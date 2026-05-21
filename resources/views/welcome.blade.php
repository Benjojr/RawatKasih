<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RawatKasih — Caregiver Assistant</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('icon.png') }}" alt="RawatKasih" class="w-10 h-10 rounded-xl object-cover">
            <span class="font-bold text-gray-800 text-lg">RawatKasih</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-green-600 font-medium transition">
                Masuk
            </a>
            <a href="{{ route('register') }}"
                class="text-sm bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition">
                Daftar
            </a>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-5xl mx-auto px-8 py-20 text-center">
        <img src="{{ asset('icon.png') }}" alt="RawatKasih" class="w-30 h-30 mx-auto mb-6 rounded-2xl object-cover">
        <span class="inline-block bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full mb-4">
            🏆 Juara 1 GEMASTIK 2025
        </span>
        <h1 class="text-4xl font-bold text-gray-800 mb-4 leading-tight">
            Solusi Digital untuk <br>
            <span class="text-green-500">Perawatan Lansia</span> yang Lebih Baik
        </h1>
        <p class="text-gray-500 text-lg mb-8 max-w-2xl mx-auto">
            RawatKasih menghubungkan pramurukti, keluarga, dan manajemen panti wreda
            dalam satu platform terintegrasi untuk monitoring lansia secara real-time.
        </p>
        <div class="flex gap-3 justify-center">
            <a href="{{ route('register') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-medium transition">
                Mulai Sekarang
            </a>
            <a href="{{ route('login') }}"
                class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-6 py-3 rounded-xl font-medium transition">
                Masuk ke Akun
            </a>
        </div>
    </section>

    {{-- 3 Peran --}}
    <section class="max-w-5xl mx-auto px-8 pb-16">
        <h2 class="text-center text-xl font-semibold text-gray-700 mb-8">Dirancang untuk Tiga Peran Utama</h2>
        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Pramurukti</h3>
                <p class="text-sm text-gray-500">Catat tugas harian, input tanda vital, dan pantau kondisi setiap lansia
                    dengan mudah.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Keluarga</h3>
                <p class="text-sm text-gray-500">Pantau kondisi orang tua secara real-time, lihat grafik kesehatan, dan
                    ajukan jadwal kunjungan.</p>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-sm text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Admin Panti</h3>
                <p class="text-sm text-gray-500">Kelola penghuni, jadwal shift pramurukti, dan semua operasional panti
                    dari satu dashboard.</p>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section class="bg-white py-16">
        <div class="max-w-5xl mx-auto px-8">
            <h2 class="text-center text-xl font-semibold text-gray-700 mb-8">Fitur Unggulan</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach ([['icon' => '📊', 'judul' => 'Grafik Kesehatan', 'deskripsi' => 'Pantau tren tanda vital lansia dengan grafik interaktif'], ['icon' => '💬', 'judul' => 'Chat Terintegrasi', 'deskripsi' => 'Komunikasi langsung antara keluarga, pramurukti, dan admin'], ['icon' => '🔔', 'judul' => 'Notifikasi Otomatis', 'deskripsi' => 'Pemberitahuan real-time saat ada tugas atau kunjungan baru'], ['icon' => '📅', 'judul' => 'Jadwal Kunjungan', 'deskripsi' => 'Ajukan dan kelola jadwal kunjungan dengan mudah'], ['icon' => '🏥', 'judul' => 'Monitoring Harian', 'deskripsi' => 'Input tanda vital, mood, dan catatan setiap shift'], ['icon' => '👥', 'judul' => 'Manajemen Shift', 'deskripsi' => 'Atur jadwal shift pramurukti secara efisien']] as $fitur)
                    <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-gray-50 transition">
                        <span class="text-2xl">{{ $fitur['icon'] }}</span>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $fitur['judul'] }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $fitur['deskripsi'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="max-w-5xl mx-auto px-8 py-16 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Siap memulai?</h2>
        <p class="text-gray-500 mb-6">Daftar sekarang dan kelola panti wredamu dengan lebih efisien.</p>
        <a href="{{ route('register') }}"
            class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-medium transition inline-block">
            Daftar Gratis
        </a>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-6 text-center text-sm text-gray-400">
        © 2026 RawatKasih — Tim InnoVate, Institut Teknologi Sepuluh Nopember
    </footer>

</body>

</html>
