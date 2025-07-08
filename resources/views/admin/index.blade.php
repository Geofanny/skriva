@extends('layouts/dashboard')

@section('content')

<div class="space-y-6">

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Mahasiswa -->
        <div class="bg-white shadow-md rounded-2xl p-6 flex items-center gap-6 min-h-[140px]">
            <div class="bg-green-100 text-green-700 p-4 rounded-full">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 20h5V4H2v16h5m10-8l-4-4m0 0l-4 4m4-4v12" />
                </svg>
            </div>
            <div>
                <p class="text-base text-gray-500">Total Mahasiswa</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalMahasiswa }}</h3>
            </div>
        </div>

        <!-- Dosen -->
        <div class="bg-white shadow-md rounded-2xl p-6 flex items-center gap-6 min-h-[140px]">
            <div class="bg-yellow-100 text-yellow-600 p-4 rounded-full">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7" />
                </svg>
            </div>
            <div>
                <p class="text-base text-gray-500">Total Dosen</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalDosen }}</h3>
            </div>
        </div>

        <!-- Koordinasi TA -->
        <div class="bg-white shadow-md rounded-2xl p-6 flex items-center gap-6 min-h-[140px]">
            <div class="bg-red-100 text-red-600 p-4 rounded-full">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m2 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-base text-gray-500">Koordinasi TA</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalKoordinasi }}</h3>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Line Chart -->
        <div class="bg-white shadow-md rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Bimbingan Mahasiswa</h2>
            <div class="relative w-full h-[250px]">
                <canvas id="bimbinganChart" class="max-h-[250px]"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart - Prodi per Fakultas -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Jumlah Program Studi per Fakultas</h3>
            <div class="relative w-full h-[300px]">
                <canvas id="prodiChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Counter animation
    const counters = document.querySelectorAll('.count');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-count');
            const current = +counter.innerText;
            const increment = Math.ceil(target / 100); // speed
            if (current < target) {
                counter.innerText = current + increment;
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });
</script>


<script>
    // Line Chart - Bimbingan Disetujui
    const ctxLine = document.getElementById('bimbinganChart').getContext('2d');
    const bimbinganChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($bulan) !!},
            datasets: [{
                label: 'Ajuan Disetujui',
                data: {!! json_encode($jumlahBimbingan) !!},
                fill: true,
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                tension: 0.35,
                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                pointHoverRadius: 6,
                pointRadius: 4,
                pointHoverBorderColor: 'white',
                pointHoverBorderWidth: 2,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        boxWidth: 14,
                        font: {
                            size: 13
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Doughnut Chart - Jumlah Prodi per Fakultas
    const prodiCtx = document.getElementById('prodiChart').getContext('2d');
    const prodiChart = new Chart(prodiCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labelFakultas) !!},
            datasets: [{
                label: 'Jumlah Program Studi',
                data: {!! json_encode($dataFakultas) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(251, 191, 36, 0.7)',
                    'rgba(34, 197, 94, 0.7)',
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(168, 85, 247, 0.7)'
                ],
                borderColor: '#fff',
                borderWidth: 1,
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '55%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1800,
                easing: 'easeOutBounce'
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 13
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw} Prodi`;
                        }
                    }
                }
            }
        }
    });
</script>


@endsection
