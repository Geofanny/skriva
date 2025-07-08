@extends('layouts/dashboard')

@section('content')
<div>
    <!-- Header & Button Cetak -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Riwayat Ajuan</h1>
        <a href="#"  id="btnCetak" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-2 text-sm">
            <i data-feather="file-text" class="w-4 h-4 mr-1 inline"></i>
            Cetak PDF
        </a>
    </div>

    <!-- Filter -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="w-full md:w-1/2">
            <label class="block text-sm mb-1" for="filterMahasiswa">Nama Mahasiswa</label>
            <select id="filterMahasiswa" class="w-full border rounded px-3 py-2">
                <option value="">Semua</option>
                @foreach ($mahasiswa as $mhs)
                    <option value="{{ $mhs->nama }}">{{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>        
        <div class="w-full md:w-1/2">
            <label class="block text-sm mb-1" for="filterStatus">Status Ajuan</label>
            <select id="filterStatus" class="w-full border rounded px-3 py-2">
                <option value="">Semua</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-cyan-700 text-white">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Topik</th>
                    <th class="px-4 py-2 border">Mahasiswa</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Komentar</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($bimbingan as $item)
                <tr>
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $item->topik }}</td>
                    <td class="px-4 py-2 border">{{ $item->nama_mahasiswa }}</td>
                    <td class="px-4 py-2 border">{{ $item->tgl_ajuan }}</td>
                    <td class="px-4 py-2 border">
                        @if ($item->status == 'Disetujui')
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700 font-semibold">Disetujui</span>
                        @elseif ($item->status == 'Ditolak')
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700 font-semibold">Ditolak</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 font-semibold">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">{{ $item->komentar_penolakan }}</td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
</div>

<script>
    const filterMahasiswa = document.getElementById('filterMahasiswa');
    const filterStatus = document.getElementById('filterStatus');
    const tableBody = document.getElementById('tableBody');

    filterMahasiswa.addEventListener('change', filterTable);
    filterStatus.addEventListener('change', filterTable);

    function filterTable() {
        const mahasiswa = filterMahasiswa.value.toLowerCase();
        const status = filterStatus.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const nama = row.children[2].textContent.toLowerCase();
            const stat = row.children[4].textContent.toLowerCase();

            const matchMahasiswa = mahasiswa === '' || nama.includes(mahasiswa);
            const matchStatus = status === '' || stat.includes(status);

            row.style.display = (matchMahasiswa && matchStatus) ? '' : 'none';
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterMahasiswa = document.getElementById('filterMahasiswa');
        const filterStatus = document.getElementById('filterStatus');
        const tableBody = document.getElementById('tableBody');
    
        filterMahasiswa.addEventListener('change', filterTable);
        filterStatus.addEventListener('change', filterTable);
    
        function filterTable() {
            const nama = filterMahasiswa.value;
            const status = filterStatus.value;
    
            fetch(`/mentor-access/filterRiwayatAjuan?nama=${encodeURIComponent(nama)}&status=${encodeURIComponent(status)}`)
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
    
                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-2">Data tidak ditemukan</td></tr>`;
                        return;
                    }
    
                    data.forEach((item, index) => {
                        const badge = item.status === 'Disetujui' ? 
                            `<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700 font-semibold">Disetujui</span>` : 
                            `<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700 font-semibold">Ditolak</span>`;
    
                        tableBody.innerHTML += `
                            <tr>
                                <td class="px-4 py-2 border">${index + 1}</td>
                                <td class="px-4 py-2 border">${item.topik}</td>
                                <td class="px-4 py-2 border">${item.nama_mahasiswa}</td>
                                <td class="px-4 py-2 border">${item.tgl_ajuan}</td>
                                <td class="px-4 py-2 border">${badge}</td>
                                <td class="px-4 py-2 border">${item.komentar_penolakan}</td>
                            </tr>
                        `;
                    });
                })
                .catch(err => console.error('Error:', err));
        }
    });
</script>

<script>
    document.getElementById('btnCetak').addEventListener('click', function(e) {
        e.preventDefault();
    
        const nama = document.getElementById('filterMahasiswa').value;
        const status = document.getElementById('filterStatus').value;
    
        const url = `/mentor-access/cetakRiwayatAjuan?nama=${encodeURIComponent(nama)}&status=${encodeURIComponent(status)}`;
        window.open(url, '_blank');
    });
</script>    
    
@endsection
