@extends('layouts/dashboard')

@section('content')
@php
    $currentYear = date('Y');
    $currentMonth = date('m');
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            {{-- Icon Clipboard Document --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 2h6a1 1 0 011 1v1h1a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zM9 12h6m-6 4h6" />
            </svg>
            Monitoring Jadwal Bimbingan
        </h1>
        
        <a href="/monitoring-bimbingan/export-pdf?bulan={{ request('bulan', date('m')) }}&tahun={{ request('tahun', date('Y')) }}" id="exportBtn"
        target="_blank"
        class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition text-sm">
     
        {{-- Icon Download --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
        </svg>
     
        Export PDF
     </a>
     
    </div>

   {{-- Filter Form --}}
    <div>
        <form method="GET" action="" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-center">
            {{-- Dropdown Bulan --}}
            <select name="bulan" class="w-full bg-white border border-gray-300 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2.5">
                <option value="" disabled selected>-- Bulan --</option>
                @foreach ([
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ] as $key => $bulan)
                    <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>{{ $bulan }}</option>
                @endforeach
            </select>

            {{-- Dropdown Tahun --}}
            <select name="tahun" class="w-full bg-white border border-gray-300 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2.5">
                <option value="" disabled selected>-- Tahun --</option>
                @for ($i = 2022; $i <= $currentYear; $i++)
                    <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </form>
    </div>

    {{-- Tabel Mahasiswa Bimbingan --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm print:text-xs print:table-fixed">
            <thead class="bg-cyan-700 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold">Prodi</th>
                    <th class="px-4 py-3 text-left font-semibold">Mahasiswa</th>
                    <th class="px-4 py-3 text-left font-semibold">Pembimbing</th>
                    <th class="px-4 py-3 text-left font-semibold">Topik Bimbingan</th>
                    <th class="px-4 py-3 text-left font-semibold">Jam</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 print:divide-gray-300">
                @forelse ($sesiBimbingan as $sesi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($sesi->tgl_ajuan)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ $sesi->nama_prodi ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $sesi->nama }}<br><span class="text-xs text-gray-500">{{ $sesi->npm }}</span></td>
                        <td class="px-4 py-3">{{ $sesi->nama_pembimbing ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $sesi->topik }}</td>
                        <td class="px-4 py-3 space-x-1">
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded">
                                {{ \Carbon\Carbon::parse($sesi->waktu_mulai)->format('H:i') }}
                            </span>
                            <span class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded">
                                {{ \Carbon\Carbon::parse($sesi->waktu_selesai)->format('H:i') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $sesiBimbingan->links() }}
    </div>    

</div>

{{-- Script AJAX untuk filter bulan & tahun --}}
<script>
    function fetchFilteredData() {
        const bulan = document.querySelector('[name="bulan"]').value;
        const tahun = document.querySelector('[name="tahun"]').value;

        fetch(`/monitoring-bimbingan/data?bulan=${bulan}&tahun=${tahun}`)
            .then(res => res.json())
            .then(data => {
                document.querySelector('.bg-white.rounded-xl.shadow.overflow-x-auto').innerHTML = data.html;
            });
    }

    function updateExportLink() {
        const bulan = document.querySelector('[name="bulan"]').value;
        const tahun = document.querySelector('[name="tahun"]').value;
        const exportBtn = document.getElementById('exportBtn');

        exportBtn.href = `/monitoring-bimbingan/export-pdf?bulan=${bulan}&tahun=${tahun}`;
    }

    document.querySelectorAll('select[name="bulan"], select[name="tahun"]').forEach(el => {
        el.addEventListener('change', () => {
            fetchFilteredData();
            updateExportLink();
        });
    });
</script>
@endsection
