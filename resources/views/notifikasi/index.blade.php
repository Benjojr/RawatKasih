@php
    $layout = match (Auth::user()->peran) {
        'admin' => 'layouts.admin',
        'pramurukti' => 'layouts.pramurukti',
        'keluarga' => 'layouts.keluarga',
    };
@endphp

@extends($layout)

@section('title', 'Notifikasi')

@section('content')

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Notifikasi</h1>
        <p class="text-sm text-gray-400 mt-1">Semua pemberitahuan untukmu</p>
    </div>

    <div class="flex flex-col gap-3">
        @forelse($notifikasi as $n)
            <div
                class="bg-white rounded-2xl px-5 py-4 shadow-sm flex items-start gap-4
        {{ !$n->dibaca ? 'border-l-4 border-green-500' : '' }}">
                <div class="mt-0.5">
                    @if ($n->tipe === 'success')
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @elseif($n->tipe === 'warning')
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>
                    @else
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800">{{ $n->judul }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $n->pesan }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}
                    </p>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl px-5 py-10 shadow-sm text-center text-gray-400">
                Belum ada notifikasi.
            </div>
        @endforelse
    </div>

@endsection
