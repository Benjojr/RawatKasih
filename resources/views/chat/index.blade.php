@php
    $layout = match (Auth::user()->peran) {
        'admin' => 'layouts.admin',
        'pramurukti' => 'layouts.pramurukti',
        'keluarga' => 'layouts.keluarga',
    };
@endphp

@extends($layout)

@section('title', 'Chat')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Chat</h1>
        <button onclick="document.getElementById('modalChat').classList.remove('hidden')"
            class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded-lg transition">
            + Pesan Baru
        </button>
    </div>

    <div class="flex flex-col gap-2">
        @forelse($kontak as $k)
            <a href="{{ route('chat.show', $k->id_pengguna) }}"
                class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                <div
                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold">
                    {{ strtoupper(substr($k->nama_lengkap, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">{{ $k->nama_lengkap }}</p>
                    <p class="text-xs text-gray-400">{{ ucfirst($k->peran) }}</p>
                </div>
                @php
                    $belumDibaca = \App\Models\Chat::where('id_pengirim', $k->id_pengguna)
                        ->where('id_penerima', Auth::id())
                        ->where('dibaca', false)
                        ->count();
                @endphp
                @if ($belumDibaca > 0)
                    <span class="w-5 h-5 bg-green-500 text-white text-xs rounded-full flex items-center justify-center">
                        {{ $belumDibaca }}
                    </span>
                @endif
            </a>
        @empty
            <div class="bg-white rounded-2xl px-5 py-10 shadow-sm text-center text-gray-400">
                Belum ada percakapan. Mulai chat baru.
            </div>
        @endforelse
    </div>

    {{-- Modal Chat Baru --}}
    <div id="modalChat" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
            <h2 class="font-semibold text-gray-800 mb-4">Mulai Percakapan</h2>
            <div class="flex flex-col gap-2">
                @foreach ($semuaPengguna as $p)
                    <a href="{{ route('chat.show', $p->id_pengguna) }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 transition">
                        <div
                            class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-sm font-semibold">
                            {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $p->nama_lengkap }}</p>
                            <p class="text-xs text-gray-400">{{ ucfirst($p->peran) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">
                <button onclick="document.getElementById('modalChat').classList.add('hidden')"
                    class="w-full text-sm text-gray-500 px-4 py-2 rounded-lg hover:bg-gray-100">Tutup</button>
            </div>
        </div>
    </div>

@endsection
