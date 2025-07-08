@extends('layouts.dashboard')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Ajuan Bimbingan</h1>
            <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/dashboard" class="text-cyan-700 hover:underline">Dashboard</a></li>
                    <li>/</li>
                    <li class="text-gray-500">Riwayat Ajuan</li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('filter-form').submit()" class="bg-cyan-700 hover:bg-cyan-600 text-white px-4 py-2 rounded-lg shadow">
                <i data-feather="filter" class="w-4 h-4 mr-1 inline"></i> Filter
            </button>
            <a href="{{ route('mahasiswa.riwayat.cetak', request()->query()) }}" target="_blank"
                class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg shadow">
                <i data-feather="file-text" class="w-4 h-4 mr-1 inline"></i> Cetak PDF
            </a>            
        </div>
    </div>

    <form id="filter-form" method="GET">
        <!-- Filter -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembimbing</label>
                <select id="filter-pembimbing" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-cyan-500 capitalize" name="pembimbing">
                    <option value="">-- Semua Pembimbing --</option>
                    @foreach ($daftarPembimbing as $pembimbing)
                    <option value="{{ $pembimbing->nama }}" {{ request('pembimbing') == $pembimbing->nama ? 'selected' : '' }}>
                        {{ $pembimbing->nama }}
                    </option>
                    @endforeach
                </select>
            </div>        

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="filter-status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-cyan-500" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
        </div>
    </form>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="w-full text-sm text-left">
            <thead class="bg-cyan-700 text-white">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Topik</th>
                    <th class="px-4 py-3">Pembimbing</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Komentar</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($riwayat as $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $item->topik }}</td>
                        <td class="px-4 py-3">{{ $item->nama_pembimbing }}</td>
                        <td class="px-4 py-3">{{ $item->tgl_ajuan }}</td>
                        <td class="px-4 py-3 capitalize">
                            @if ($item->status == 'Disetujui')
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs">Disetujui</span>
                            @elseif ($item->status == 'Ditolak')
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs">Ditolak</span>
                            @elseif ($item->status == 'selesai')
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">Selesai</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-gray-200 text-gray-700 text-xs">{{ ucfirst($item->status) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $item->komentar_penolakan ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada ajuan bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
