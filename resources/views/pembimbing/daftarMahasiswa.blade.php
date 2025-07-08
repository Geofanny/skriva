@extends('layouts/dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-1">Monitoring Mahasiswa</h1>
    <p class="text-sm text-gray-500">Filter berdasarkan nama mahasiswa dan kategori skripsi.</p>
</div>

<div class="bg-white p-6 rounded-xl shadow mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="filterMahasiswa" class="block text-sm font-medium text-gray-700">Nama Mahasiswa</label>
            <select id="filterMahasiswa" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                <option value="">Semua Mahasiswa</option>
                @foreach($mahasiswa as $mhs)
                    <option value="{{ $mhs->npm }}">{{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filterKategori" class="block text-sm font-medium text-gray-700">Kategori Skripsi</label>
            <select id="filterKategori" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                <option value="">Semua Kategori</option>
                <option value="e-commerce">E-Commerce</option>
                <option value="analisis dan perancangan">Analisis dan Perancangan</option>
                <option value="rancang bangun sistem">Rancang Bangun Sistem</option>
            </select>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow">
    <table id="monitoringTable" class="table-auto w-full text-sm text-left text-gray-700">
        <thead>
            <tr>
                <th class="px-4 py-2">Nama Mahasiswa</th>
                <th class="px-4 py-2">Kategori</th>
                <th class="px-4 py-2">Judul Skripsi</th>
                <th class="px-4 py-2">Disetujui</th>
                <th class="px-4 py-2">Ditolak</th>
            </tr>
        </thead>
        <tbody id="tbody-monitoring">
            @forelse($monitoring as $item)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $item->nama }}</td>
                    <td class="px-4 py-2 capitalize">{{ $item->kategori }}</td>
                    <td class="px-4 py-2">{{ $item->judul }}</td>
                    <td class="px-4 py-2 text-center">{{ $item->jumlah_bimbingan }}</td>
                    <td class="px-4 py-2 text-center">{{ $item->jumlah_ditolak }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4 text-gray-500">Data tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
        
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function loadFilteredData() {
        const npm = $('#filterMahasiswa').val();
        const kategori = $('#filterKategori').val();

        $.ajax({
            url: "{{ route('filter.mahasiswa') }}",
            type: "GET",
            data: {
                npm: npm,
                kategori: kategori
            },
            success: function (response) {
                let rows = '';
                if (response.data.length === 0) {
                    rows = '<tr><td colspan="4" class="text-center py-4 text-gray-500">Data tidak ditemukan.</td></tr>';
                } else {
                    response.data.forEach(item => {
                        const kategori = item.kategori 
                            ? `<span class="capitalize">${item.kategori}</span>` 
                            : `<span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded">Belum Mengisi</span>`;

                        const judul = item.judul 
                            ? item.judul 
                            : `<span class="bg-red-100 text-red-700 text-xs font-semibold px-2 py-1 rounded">Belum Mengisi</span>`;

                        rows += `
                            <tr class="border-b">
                                <td class="px-4 py-2">${item.nama}</td>
                                <td class="px-4 py-2">${kategori}</td>
                                <td class="px-4 py-2">${judul}</td>
                                <td class="px-4 py-2">${item.jumlah_bimbingan}</td>
                                <td class="px-4 py-2">${item.jumlah_ditolak}</td>
                            </tr>`;
                    });

                }
                $('#tbody-monitoring').html(rows);
            }
        });
    }

    $(document).ready(function () {
        loadFilteredData(); // Load awal

        $('#filterMahasiswa, #filterKategori').on('change', function () {
            loadFilteredData();
        });
    });
</script>
@endsection
