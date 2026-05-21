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

            {{-- Typing Indicator --}}
            <div id="typingIndicator" class="hidden px-5 pb-2">
                <div class="flex items-center gap-2">
                    <div class="bg-gray-100 rounded-2xl rounded-bl-sm px-4 py-2 flex items-center gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $pengguna->nama_lengkap }} sedang mengetik...</span>
                </div>
            </div>

            {{-- Input --}}
            <div class="px-5 py-4 border-t border-gray-100">
                <form id="formChat" class="flex gap-3"> {{-- hapus method/action, tambah id --}}
                    @csrf
                    <input type="text" name="pesan" id="inputPesan" required placeholder="Ketik pesan..."
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
        const areaPesan = document.getElementById('areaPesan');
        const typingIndicator = document.getElementById('typingIndicator');
        const idLawan = {{ $pengguna->id_pengguna }};
        const sayaId = {{ Auth::id() }};
        let lastId = {{ $pesan->last()?->id_chat ?? 0 }};
        let typingTimeout = null;

        // Scroll ke bawah saat pertama load
        areaPesan.scrollTop = areaPesan.scrollHeight;

        // Submit via fetch — tidak reload halaman
        document.getElementById('formChat').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('inputPesan');
            const pesan = input.value.trim();
            if (!pesan) return;

            tampilkanPesan({
                id_pengirim: sayaId,
                pesan: escapeHtml(pesan),
                waktu: waktuSekarang(),
                dibaca: false,
            });
            input.value = '';

            fetch('{{ route('chat.store', $pengguna->id_pengguna) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        pesan
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.id_chat && data.id_chat > lastId) lastId = data.id_chat;
                });
        });

        // Sinyal typing ke server
        document.getElementById('inputPesan').addEventListener('input', function() {
            clearTimeout(typingTimeout);
            fetch(`/chat/${idLawan}/typing`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            });
            typingTimeout = setTimeout(() => {}, 2000);
        });

        if (window._intervalPesan) clearInterval(window._intervalPesan);
        if (window._intervalTyping) clearInterval(window._intervalTyping);

        window._intervalPesan = setInterval(ambilPesanBaru, 1000);
        window._intervalTyping = setInterval(cekTyping, 1000);



        function ambilPesanBaru() {
            fetch(`/chat/${idLawan}/pesan-baru?last_id=${lastId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.pesan && data.pesan.length > 0) {
                        data.pesan.forEach(p => {
                            // Hanya update lastId kalau lebih besar dari yang sekarang
                            if (p.id_chat > lastId) lastId = p.id_chat;
                            if (p.id_pengirim != sayaId) {
                                tampilkanPesan(p);
                            }
                        });
                    }
                });
        }

        function cekTyping() {
            fetch(`/chat/${idLawan}/cek-typing`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.typing) {
                        typingIndicator.classList.remove('hidden');
                        areaPesan.scrollTop = areaPesan.scrollHeight;
                    } else {
                        typingIndicator.classList.add('hidden');
                    }
                });
        }

        function tampilkanPesan(p) {
            const dariku = p.id_pengirim == sayaId;
            const div = document.createElement('div');
            div.className = 'flex ' + (dariku ? 'justify-end' : 'justify-start');

            const warnaBubble = dariku ?
                'bg-green-500 text-white rounded-br-sm' :
                'bg-gray-100 text-gray-800 rounded-bl-sm';

            const alignWaktu = dariku ? 'text-right' : 'text-left';
            const centang = dariku ? '• ✓' : '';

            div.innerHTML =
                '<div class="max-w-xs lg:max-w-md">' +
                '<div class="px-4 py-2 rounded-2xl text-sm ' + warnaBubble + '">' +
                p.pesan +
                '</div>' +
                '<p class="text-xs text-gray-400 mt-1 ' + alignWaktu + '">' +
                p.waktu + ' ' + centang +
                '</p>' +
                '</div>';

            areaPesan.appendChild(div);
            areaPesan.scrollTop = areaPesan.scrollHeight;
        }

        function waktuSekarang() {
            const now = new Date();
            return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        }

        function escapeHtml(text) {
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }
    </script>

@endsection
