<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - RawatKasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow w-full max-w-sm">
        <h1 class="text-2xl font-semibold text-green-600 text-center mb-6">Sign up</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Pilihan Peran --}}
            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-2">Daftar sebagai</label>

                <div class="flex gap-2">
                    @foreach(['pramurukti' => 'Pramurukti', 'keluarga' => 'Keluarga', 'admin' => 'Admin'] as $value => $label)

                    <label class="flex-1 cursor-pointer">
                        <input
                            type="radio"
                            name="peran"
                            value="{{ $value }}"
                            class="peer hidden"
                            {{ old('peran') === $value ? 'checked' : '' }}>

                        <div class="text-center border border-gray-300 rounded-lg py-2 text-sm
                    text-gray-600 transition
                    peer-checked:bg-green-500
                    peer-checked:text-white
                    peer-checked:border-green-500">
                            {{ $label }}
                        </div>
                    </label>

                    @endforeach
                </div>

                @error('peran')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('nama_lengkap')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-600 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 rounded-lg transition">
                Sign up
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-green-600 font-medium hover:underline">Log in</a>
        </p>
    </div>
</body>

</html>