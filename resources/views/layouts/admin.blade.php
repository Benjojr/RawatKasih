<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RawatKasih - Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-60 bg-white shadow-sm flex flex-col justify-between py-6 px-4 fixed h-full">
        <div>
            <div class="flex items-center gap-3 mb-10">
                <img src="{{ asset('icon.png') }}" alt="RawatKasih" class="w-10 h-10 rounded-xl object-cover">
                <div>
                    <p class="font-semibold text-sm text-gray-800">Panti Sejahtera</p>
                    <p class="text-xs text-gray-400">Portal Admin</p>
                </div>
            </div>

            <nav class="flex flex-col gap-1">
                <a href="{{ route('dashboard.admin') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('dashboard.admin') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('admin.penghuni.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.penghuni.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Penghuni
                </a>
                <a href="{{ route('admin.kamar.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.kamar.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-5a1 1 0 011-1h4a1 1 0 011 1v5h4a1 1 0 001-1V10" />
                    </svg>
                    Kamar
                </a>
                <a href="{{ route('admin.pramurukti.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.pramurukti.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Pramurukti
                </a>
                <a href="{{ route('admin.shift.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.shift.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Shift
                </a>
                <a href="{{ route('admin.tugas.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.tugas.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Tugas
                </a>
                <a href="{{ route('admin.rutinitas.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.rutinitas.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Rutinitas
                </a>
                <a href="{{ route('admin.kunjungan.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.kunjungan.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kunjungan
                </a>
                <a href="{{ route('chat.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('chat.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Chat
                </a>
                <a href="{{ route('admin.pengguna.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('admin.pengguna.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Pengguna
                </a>
                <a href="{{ route('profil.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                    {{ request()->routeIs('profil.*') ? 'bg-green-50 text-green-600' : 'text-gray-500 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </a>
            </nav>
        </div>

        <p class="text-xs text-gray-400 text-center">© 2026 Panti Sejahtera</p>
        <div class="mt-auto pt-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-red-500 hover:bg-red-50 w-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </aside>

    <main class="ml-60 flex-1 p-8">
        @yield('content')
    </main>

</body>

</html>
