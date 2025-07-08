@extends('layouts/dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-1">Statistik Ajuan Bimbingan</h1>
    <p class="text-sm text-gray-500">Visualisasi tren dan distribusi bimbingan skripsi untuk mendukung evaluasi akademik.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Statistik Bimbingan Skripsi -->
    <div class="p-8 bg-white rounded-xl shadow">
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Statistik Ajuan Bimbingan</h2>
        <p class="text-sm text-gray-500 mb-4">Grafik berikut menunjukkan jumlah sesi bimbingan skripsi yang disetujui dan ditolak selama beberapa bulan terakhir.</p>
        <canvas id="statistikChart" class="w-full h-[500px]"></canvas>
        <p class="text-xs text-gray-400 mt-3 italic">* Data ini digunakan untuk mengevaluasi efektivitas proses pengajuan bimbingan skripsi secara berkala.</p>
    </div>

    <!-- Distribusi Bimbingan per Dosen -->
    <div class="p-8 bg-white rounded-xl shadow">
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Distribusi Ajuan Bimbingan per Dosen</h2>
        <p class="text-sm text-gray-500 mb-4">Diagram ini memperlihatkan jumlah ajuan bimbingan mahasiswa yang dibimbing oleh masing-masing dosen.</p>
        <canvas id="dosenChart" class="w-full h-[500px]"></canvas>
        <p class="text-xs text-gray-400 mt-3 italic">* Informasi ini bermanfaat untuk pemerataan beban dosen dalam proses pembimbingan.</p>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('statistikChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Disetujui',
                    data: {!! json_encode($dataDisetujui) !!},
                    borderColor: 'rgba(34,197,94,1)',
                    backgroundColor: 'rgba(34,197,94,0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Ditolak',
                    data: {!! json_encode($dataDitolak) !!},
                    borderColor: 'rgba(239,68,68,1)',
                    backgroundColor: 'rgba(239,68,68,0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: { /* ...same as sebelumnya... */ }
    });
    
    // Distribusi Bimbingan per Dosen
    const ctxDosen = document.getElementById('dosenChart').getContext('2d');
    new Chart(ctxDosen, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dosenLabels) !!},
            datasets: [{
                label: 'Jumlah Ajuan',
                data: {!! json_encode($dosenData) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: { /* ...same as sebelumnya... */ }
    });
</script>
    
@endsection
