@extends('layouts.admin')

@section('title', 'Review Kunjungan')

@section('content')

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800">Review Kunjungan</h1>
        <p class="text-sm text-gray-400 mt-1">Kelola semua pengajuan kunjungan dari keluarga</p>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-600 text-sm px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif

    {{-- Filter Tab --}}
    @php $filter = request('status', 'semua'); @endphp
    <div class="flex gap-2 mb-6">
        @foreach (['semua' => 'Semua', 'mendatang' => 'Mendatang', 'tuntas' => 'Tuntas'] as $val => $label)
            <a href="{{ route('admin.kunjungan.index', ['status' => $val]) }}"
                class="px-4 py-2 rounded-lg text-sm border transition
        {{ $filter === $val ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Keluarga</th>
                    <th class="px-5 py-3 font-medium">Penghuni</th>
                    <th class="px-5 py-3 font-medium">Tanggal</th>
                    <th class="px-5 py-3 font-medium">Jam</th>
                    <th class="px-5 py-3 font-medium">Catatan</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kunjungan->when($filter !== 'semua', fn($c) => $c->where('status_kunjungan', $filter)) as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 font-medium text-gray-800">
                            {{ $k->keluarga->pengguna->nama_lengkap ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-gray-600">{{ $k->penghuni->nama_lengkap ?? '-' }}</td>
                        <td class="px-5 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-5 py-4 text-gray-600">
                            {{ str_pad($k->jam_kunjungan, 2, '0', STR_PAD_LEFT) }}:00
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $k->catatan ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <span
                                class="text-xs px-2 py-1 rounded-full
                        {{ $k->status_kunjungan === 'tuntas' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                                {{ ucfirst($k->status_kunjungan) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.kunjungan.updateStatus', $k->id_kunjungan) }}">
                                @csrf @method('PATCH')
                                <select name="status_kunjungan" onchange="this.form.submit()"
                                    class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-green-400">
                                    <option value="mendatang" {{ $k->status_kunjungan === 'mendatang' ? 'selected' : '' }}>
                                        Mendatang</option>
                                    <option value="tuntas" {{ $k->status_kunjungan === 'tuntas' ? 'selected' : '' }}>
                                        Tuntas</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-400">Belum ada pengajuan kunjungan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
