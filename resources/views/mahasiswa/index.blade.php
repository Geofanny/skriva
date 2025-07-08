@extends('layouts/dashboard')

<style>
   .calendar-cell {
        padding: 0.75rem 0;
        background-color: #f1f5f9;
        border-radius: 6px;
    }
    .calendar-cell.red {
        background-color: #dc2626;
        color: white;
        font-weight: bold;
    }
</style>

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    {{-- Card: Pembimbing 1 --}}
    <div class="bg-emerald-100 rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-emerald-800">Pembimbing 1</h2>
        </div>
        <div class="mt-4">
            @if ($pembimbing1)
                <p class="text-xl font-bold text-emerald-900 capitalize">{{ $pembimbing1->nama }}</p>
                <p class="text-sm text-emerald-800 mt-1">NIP: {{ $pembimbing1->nip }}</p>
            @else
                <p class="text-xl font-bold text-emerald-900 capitalize">...</p>
                <p class="text-sm text-emerald-800 mt-1">NIP: 0</p>
                {{-- <p class="text-sm text-emerald-800 italic capitalize">Belum memiliki pembimbing 1</p> --}}
            @endif
        </div>
    </div>

    {{-- Card: Pembimbing 2 --}}
    <div class="bg-blue-100 rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-blue-800">Pembimbing 2</h2>
        </div>
        @if ($pembimbing2)
        <p class="text-xl font-bold text-blue-900">{{ $pembimbing2->nama }}</p>
        <p class="text-sm text-blue-800 mt-1">NIP: {{ $pembimbing2->nip }}</p>
        @else
        <p class="text-xl font-bold text-blue-900">...</p>
        <p class="text-sm text-blue-800 mt-1">NIP: 0</p>
        {{-- <p class="text-sm text-blue-800 italic">Belum memiliki pembimbing 2</p> --}}
        @endif
    </div>

    {{-- Card: Total Bimbingan --}}
    <div class="bg-cyan-100 rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-cyan-800">Total Bimbingan</h2>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-bold text-cyan-900">{{ $totalDisetujui }}</p>
            <p class="text-sm text-cyan-700 mt-1">Sesi Bimbingan</p>
        </div>
    </div>

</div>

{{-- Section: Jadwal Bimbingan Hari Ini & Kalender Dosen --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Jadwal Bimbingan Hari Ini --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Bimbingan Hari Ini</h2>
    
        <div class="max-h-64 overflow-y-auto pr-2">
            @if ($jadwalBimbingan->isEmpty())
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded relative text-sm" role="alert">
                    <strong class="font-medium"></strong> Tidak ada jadwal bimbingan yang hari ini.
                </div>
            @else
                <ul class="space-y-3 text-sm">
                    @foreach($jadwalBimbingan as $jadwal)
                        <li class="border-l-4 border-cyan-600 pl-3">
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                            </p>
                            <p class="text-gray-600">
                                Topik: {{ $jadwal->topik }} - dengan {{ $jadwal->nama_dosen }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    
    


    {{-- Kalender Dosen --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Kalender Jadwal Dosen</h2>
            <div>
                <button onclick="prevMonth()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">«</button>
                <button onclick="nextMonth()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">»</button>
            </div>
        </div>
    
        <div id="calendar-header" class="text-center text-lg font-semibold text-gray-700 mb-2"></div>
        <div class="grid grid-cols-7 gap-1 text-sm text-center font-medium text-gray-600 mb-2">
            <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
        </div>
        <div id="calendar-days" class="grid grid-cols-7 gap-1 text-center text-sm"></div>
        <div class="mt-4 flex gap-4 text-sm">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-red-600 rounded-full"></div> <span>Pembimbing 1</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-blue-600 rounded-full"></div> <span>Pembimbing 2</span>
            </div>
        </div>        
    </div>

</div>

<script>
    const tanggalPadat = @json($kalenderPadat);
    const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    let currentDate = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay(); // 0 = Minggu
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const calendarDays = document.getElementById('calendar-days');
        const header = document.getElementById('calendar-header');

        // Header bulan
        header.innerText = `${monthNames[month]} ${year}`;
        calendarDays.innerHTML = '';

        // Kosongkan awal minggu
        for (let i = 0; i < firstDay; i++) {
            const empty = document.createElement('div');
            calendarDays.appendChild(empty);
        }

        // Isi hari
        for (let d = 1; d <= daysInMonth; d++) {
            const dateKey = `${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const day = document.createElement('div');
            day.className = 'calendar-cell';
            day.innerHTML = `<div>${d}</div>`;

            // Cek apakah hari ini padat
            const padatItem = tanggalPadat.find(item => item.tanggal === dateKey);
            if (padatItem) {
                if (padatItem.posisi === 'Pembimbing 1') {
                    day.style.backgroundColor = '#dc2626'; // merah
                    day.style.color = 'white';
                    day.style.fontWeight = 'bold';
                    day.innerHTML += `<div class="text-white text-xs bold">(Padat)</div>`;
                } else if (padatItem.posisi === 'Pembimbing 2') {
                    day.style.backgroundColor = '#2563eb'; // biru
                    day.style.color = 'white';
                    day.style.fontWeight = 'bold';
                    day.innerHTML += `<div class="text-white text-xs">(Padat)</div>`;
                }
            }

            calendarDays.appendChild(day);
        }

    }

    function prevMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    }

    function nextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCalendar(currentDate);
    });
</script>

@endsection
