@extends('layouts/dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1 -->
    <div class="bg-indigo-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition duration-300">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-900 text-white p-3 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 9h10M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white">Jadwal Bimbingan</h2>
            </div>
        </div>
        <div class="flex items-baseline space-x-2">
            <p class="text-4xl font-extrabold text-white">{{ $bimbinganHariIni ?? 0 }}</p>
            @if ($bimbinganHariIni >= 10)
                <span class="text-sm bg-white text-indigo-700 font-bold px-2 py-1 rounded-full">
                    Padat
                </span>
            @endif
        </div>
        <p class="text-sm text-indigo-200 mt-1">Mahasiswa dibimbing hari ini</p>
    </div>

    <!-- Card 2 -->
    <div class="bg-amber-700 p-6 rounded-2xl shadow-md hover:shadow-lg transition duration-300">
        <div class="flex items-center space-x-3 mb-4">
            <div class="bg-amber-900 text-white p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2 2m8-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-white">Pengajuan Bimbingan</h2>
        </div>
        <p class="text-4xl font-extrabold text-white">{{ $belumDisetujui ?? 0 }}</p>
        <p class="text-sm text-amber-100 mt-1">Menunggu Persetujuan</p>
    </div>

    <!-- Card 3 -->
    <div class="bg-teal-800 p-6 rounded-2xl shadow-md hover:shadow-lg transition duration-300">
        <div class="flex items-center space-x-3 mb-4">
            <div class="bg-teal-900 text-white p-3 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 3.13a4 4 0 010 7.75M8 3.13a4 4 0 000 7.75"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-white">Mahasiswa Dibimbing</h2>
        </div>
        <p class="text-4xl font-extrabold text-white">{{ $totalDibimbing ?? 0 }}</p>
        <p class="text-sm text-teal-100 mt-1">Total Aktif Dibimbing</p>
    </div>
</div>

<!-- Kalender dan Diagram -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- Kalender Bimbingan -->
    <div class="bg-white rounded-xl shadow p-6 min-h-[350px] flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-semibold text-gray-800">Kalender Bimbingan</h2>
                <div>
                    <button id="prevMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm font-medium">&larr;</button>
                    <button id="nextMonth" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm font-medium">&rarr;</button>
                </div>
            </div>
            <h3 id="monthTitle" class="text-md font-semibold text-center text-gray-800 mb-2">Januari</h3>
            <div id="calendarGrid" class="grid grid-cols-7 gap-1 text-center text-sm">
                <!-- Hari akan diisi via JS -->
            </div>
        </div>
        <div class="mt-4 flex items-center space-x-4 text-sm text-gray-600">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-red-600 rounded-sm"></div>
                <span>Padat</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-green-600 rounded-sm"></div>
                <span>Normal</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 bg-gray-200 rounded-sm border"></div>
                <span>Tidak Ada Bimbingan</span>
            </div>
        </div>
    </div>

    <!-- Grafik Pengajuan -->
    <div class="bg-white rounded-xl shadow p-6 min-h-[350px] flex flex-col justify-between">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Pengajuan Bimbingan</h2>
        <div class="flex-grow">
            <canvas id="bimbinganChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartLabels = @json($chartLabels ?? []);
    const chartSemua = @json($chartSemua ?? []);
    const chartDisetujui = @json($chartDisetujui ?? []);

    const ctx = document.getElementById('bimbinganChart').getContext('2d');
    const bimbinganChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Semua Pengajuan',
                    data: chartSemua,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                },
                {
                    label: 'Disetujui',
                    data: chartDisetujui,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>


<script>
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    function renderCalendar(monthIndex, year, calendarData) {
        const calendar = document.getElementById('calendarGrid');
        const monthTitle = document.getElementById('monthTitle');
        monthTitle.textContent = `${months[monthIndex]} ${year}`;

        calendar.innerHTML = '';
        const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();

        for (let day = 1; day <= daysInMonth; day++) {
            let colorClass = 'bg-gray-100 text-gray-800';
            const jumlah = calendarData[day] ?? 0;

            if (jumlah > 3) {
                colorClass = 'bg-red-600 text-white font-bold';
            } else if (jumlah > 0) {
                colorClass = 'bg-green-600 text-white';
            }

            const dayBox = `<div class="p-2 rounded ${colorClass}">${day}</div>`;
            calendar.insertAdjacentHTML('beforeend', dayBox);
        }
    }

    function loadCalendarData(month, year) {
        fetch(`/pembimbing/kalender-bimbingan?bulan=${month + 1}&tahun=${year}`)
            .then(response => response.json())
            .then(data => {
                renderCalendar(month, year, data);
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadCalendarData(currentMonth, currentYear);

        document.getElementById('prevMonth').addEventListener('click', () => {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            loadCalendarData(currentMonth, currentYear);
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            loadCalendarData(currentMonth, currentYear);
        });
    });

</script>

@endsection
