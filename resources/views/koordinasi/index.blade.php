@extends('layouts/dashboard')

@section('content')
<div class="space-y-6">
    
    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 bg-gradient-to-r from-cyan-900 to-cyan-700 text-white rounded-xl shadow p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-2">Total Mahasiswa Bimbingan</h3>
                <p class="text-4xl font-bold">{{ $totalMahasiswaBimbingan }}</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10-8l-4-4m0 0l-4 4m4-4v12"/>
            </svg>
        </div>

        <div class="bg-white rounded-xl shadow p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Pembimbing</h3>
                <p class="text-4xl font-bold text-cyan-800">{{ $totalPembimbing }}</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-cyan-700 opacity-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Pengajuan Bimbingan {{ date('Y') }}</h3>
            <div class="relative w-full h-[300px]">
                <canvas id="pengajuanChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pembimbing Berdasarkan Prodi</h3>
            <div class="relative w-full h-[300px]">
                <canvas id="prodiChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const pengajuanCtx = document.getElementById('pengajuanChart').getContext('2d');
    const pengajuanChart = new Chart(pengajuanCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelsBulan) !!},
            datasets: [{
                label: 'Jumlah Pengajuan Bimbingan',
                data: {!! json_encode($dataBulan) !!},
                backgroundColor: 'rgba(14, 165, 233, 0.85)',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Pie Chart (Pembimbing per Prodi)
    const prodiCtx = document.getElementById('prodiChart').getContext('2d');
    const prodiChart = new Chart(prodiCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labelProdi) !!},
            datasets: [{
                label: 'Jumlah Pembimbing',
                data: {!! json_encode($dataProdi) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(251, 191, 36, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(168, 85, 247, 0.7)'
                ],
                hoverOffset: 12,
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '55%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    window.addEventListener('resize', () => {
        pengajuanChart.resize();
        prodiChart.resize();
    });
</script>

@endsection
