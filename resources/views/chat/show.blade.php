@php
    $layout = match (Auth::user()->peran) {
        'admin' => 'layouts.admin',
        'pramurukti' => 'layouts.pramurukti',
        'keluarga' => 'layouts.keluarga',
    };
@endphp

@extends($layout)

@section('title', 'Chat - ' . $pengguna->nama_lengkap)

@section('content')

    <div class="flex gap-6 h-[calc(100vh-8rem)]">

        {{-- Sidebar Kontak --}}
        <div class="w-64 flex flex-col gap-2 overflow-y-auto flex-shrink-0">
            <a href="{{ route('chat.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Semua Chat
            </a>
            @foreach ($kontak as $k)
                <a href="{{ route('chat.show', $k->id_pengguna) }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl transition
            {{ $k->id_pengguna == $pengguna->id_pengguna ? 'bg-green-50 text-green-600' : 'bg-white hover:bg-gray-50' }}">
                    <div
                        class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-sm font-semibold flex-shrink-0">
                        {{ strtoupper(substr($k->nama_lengkap, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $k->nama_lengkap }}</p>
                        <p class="text-xs text-gray-400">{{ ucfirst($k->peran) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Area Chat --}}
        <div class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold">
                    {{ strtoupper(substr($pengguna->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $pengguna->nama_lengkap }}</p>
                    <p class="text-xs text-gray-400">{{ ucfirst($pengguna->peran) }}</p>
                </div>
            </div>

            {{-- Pesan --}}
            <div class="flex-1 overflow-y-auto px-5 py-4 flex flex-col gap-3" id="areaPesan">
                @forelse($pesan as $p)
                    @php $dariku = $p->id_pengirim == Auth::id(); @endphp
                    <div class="flex {{ $dariku ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md">
                            <div
                                class="px-4 py-2 rounded-2xl text-sm
                        {{ $dariku ? 'bg-green-500 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">
                                {{ $p->pesan }}
                            </div>
                            <p class="text-xs text-gray-400 mt-1 {{ $dariku ? 'text-right' : 'text-left' }}">
                                {{ \Carbon\Carbon::parse($p->created_at)->format('H:i') }}
                                @if ($dariku)
                                    • {{ $p->dibaca ? '✓✓' : '✓' }}
                                @endif
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex-1 flex items-center justify-center text-gray-400 text-sm">
                        Belum ada pesan. Mulai percakapan!
                    </div>
                @endforelse
            </div>

            {{-- Input --}}
            <div class="px-5 py-4 border-t border-gray-100">
                <form method="POST" action="{{ route('chat.store', $pengguna->id_pengguna) }}" class="flex gap-3">
                    @csrf
                    <input type="text" name="pesan" required placeholder="Ketik pesan..."
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto scroll ke bawah
        const area = document.getElementById('areaPesan');
        area.scrollTop = area.scrollHeight;
    </script>

@endsection
