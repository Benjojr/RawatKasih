@extends('layouts.pramurukti')

@section('title', 'Daftar Pasien')

@section('content')

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Daftar Pasien</h1>
        <p class="text-sm text-gray-400 mt-1">Total {{ $penghuni->count() }} penghuni terdaftar</p>
    </div>

    {{-- Search --}}
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Cari nama pasien..."
            class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    {{-- Daftar --}}
    <div class="flex flex-col gap-3" id="daftarPasien">
        @forelse($penghuni as $p)
            <a href="{{ route('pramurukti.pasien.show', $p->id_penghuni) }}"
                class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-center justify-between hover:shadow-md transition pasien-item">
                <div class="flex items-center gap-4">
                    <div
                        class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-semibold">
                        {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 pasien-nama">{{ $p->nama_lengkap }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->age . ' tahun' : '-' }}
                            @if ($p->kamar)
                                • Kamar {{ $p->kamar->nomor_kamar }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">Stabil</span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-2xl px-5 py-6 shadow-sm text-center text-gray-400">
                Belum ada penghuni terdaftar.
            </div>
        @endforelse
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('.pasien-item').forEach(item => {
                const nama = item.querySelector('.pasien-nama').textContent.toLowerCase();
                item.style.display = nama.includes(keyword) ? '' : 'none';
            });
        });
    </script>

@endsection
