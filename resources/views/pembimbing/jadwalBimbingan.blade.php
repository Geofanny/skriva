@extends('layouts/dashboard')

<style>
    table.dataTable thead th {
        background-color: #f3f4f6;
    }
</style>

@section('content')
<div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Jadwal Bimbingan</h1>
        <p class="text-sm text-gray-500">Berikut adalah jadwal bimbingan yang anda akan laksanakan</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full md:w-auto">
        <div class="w-full">
            <label for="bulan" class="block text-sm text-gray-700 mb-1">Bulan</label>
            <select id="bulan" class="border rounded px-3 py-2 text-sm w-full">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ (int)($bulan ?? date('n')) === $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->locale('id')->isoFormat('MMMM') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="w-full">
            <label for="tahun" class="block text-sm text-gray-700 mb-1">Tahun</label>
            <select id="tahun" class="border rounded px-3 py-2 text-sm w-full">
                @php
                    $tahunSekarang = date('Y');
                @endphp
                @for($i = $tahunSekarang; $i >= $tahunSekarang - 2; $i--)
                    <option value="{{ $i }}" {{ (int)($tahun ?? date('Y')) === $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="flex items-end">
            <button id="cetakButton" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-700 text-white text-sm rounded h-[42px]">
                <i data-feather="file-text" class="w-4 h-4 mr-1 inline"></i>
                Cetak
            </button>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow">
    <table id="jadwalTable" class="table-auto w-full text-sm text-left text-gray-700">
        <thead>
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Nama Mahasiswa</th>
                <th class="px-4 py-2">Topik</th>
                <th class="px-4 py-2">Jam</th>
                {{-- <th class="px-4 py-2">Aksi</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal as $item)
            <tr class="border-b">
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tgl_ajuan)->format('d/m/Y') }}</td>
                <td class="px-4 py-2">{{ $item->nama_mahasiswa }}</td>
                <td class="px-4 py-2">{{ $item->topik }}</td>
                <td class="px-4 py-2 space-x-1">
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">
                        {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                    </span>
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">
                        {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                    </span>
                </td>                
                {{-- <td class="px-4 py-2 space-x-1">
                    @if($item->nama_file)
                        <button onclick="openModal('modal-file-{{ $item->kd_bimbingan }}')"
                            class="inline-flex items-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs"
                            title="Lihat file bimbingan">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 8h10M7 12h6m-6 4h10M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                            Lihat File
                        </button>
                    @else
                        <button class="inline-flex items-center px-2 py-1 bg-gray-300 text-gray-500 rounded text-xs cursor-not-allowed"
                                title="Tidak ada file yang diunggah" disabled>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7 8h10M7 12h6m-6 4h10M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                            </svg>
                            Lihat File
                        </button>
                    @endif

                    @if($item->nama_file)
                        <div id="modal-file-{{ $item->kd_bimbingan }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 p-4">
                            <div class="bg-white p-4 rounded-lg shadow-xl w-full max-w-3xl h-[80vh] flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <h2 class="text-lg font-semibold text-gray-800">Preview File Bimbingan</h2>
                                    <button onclick="closeModal('modal-file-{{ $item->kd_bimbingan }}')" class="text-gray-500 hover:text-gray-700">
                                        ✕
                                    </button>
                                </div>
                                <div class="flex-1 overflow-hidden rounded border">
                                    <embed src="{{ asset('storage/bimbingan/'.$item->nama_file) }}"
                                        type="application/pdf"
                                        class="w-full h-full"
                                        style="border: none; border-radius: 0.5rem;" />
                                </div>
                            </div>
                        </div>
                    @endif
    
                    <button onclick="openModal('modal-selesai-{{ $item->kd_bimbingan }}')" 
                        class="inline-flex items-center px-2 py-1 bg-red-500 hover:bg-green-700 text-white rounded text-xs">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Hapus
                    </button>
                    <div id="modal-selesai-{{ $item->kd_bimbingan }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Selesai Bimbingan</h2>
                            <p>Bimbingan dengan <strong>{{ $item->nama_mahasiswa }}</strong> telah selesai?</p>
                            <form action="{{ route('bimbingan.selesai', $item->kd_bimbingan) }}" method="POST" class="mt-4 flex justify-between gap-2">
                                @csrf
                                <button type="button" onclick="closeModal('modal-selesai-{{ $item->kd_bimbingan }}')" 
                                        class="px-3 py-1 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                                <button type="submit" class="px-3 py-1 rounded bg-green-600 hover:bg-green-700 text-white">Selesai</button>
                            </form>
                        </div>
                    </div>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
        
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        const table = $('#jadwalTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Jadwal bimbingan belum terbuat",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ data)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "→",
                    previous: "←"
                }
            }
        });

        // Isi tahun otomatis
        const tahunSelect = document.getElementById('tahun');
        const tahunSekarang = new Date().getFullYear();
        for (let i = tahunSekarang; i >= tahunSekarang - 2; i--) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            tahunSelect.appendChild(option);
        }

        // Trigger filter saat bulan atau tahun berubah
        $('#bulan, #tahun').on('change', function () {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();

            $.ajax({
                url: '/mentor-access/filter-jadwal',
                type: 'GET',
                data: {
                    bulan: bulan,
                    tahun: tahun
                },
                success: function (res) {
                    table.clear().draw();

                    if (res.length === 0) {
                        return;
                    }

                    res.forEach(item => {
                        const jamMulai = formatJam(item.waktu_mulai);
                        const jamSelesai = formatJam(item.waktu_selesai);
                        const tanggal = formatTanggal(item.tgl_ajuan);

                        table.row.add([
                            tanggal,
                            item.nama_mahasiswa,
                            item.topik,
                            `<span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">${jamMulai}</span>
                            <span class="inline-block bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded">${jamSelesai}</span>`
                        ]).draw();
                    });
                }
            });
        });

        function formatTanggal(tgl) {
            const dateObj = new Date(tgl);
            const day = String(dateObj.getDate()).padStart(2, '0');
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const year = dateObj.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function formatJam(jam) {
            return jam ? jam.substring(0, 5) : '';
        }
    });
</script>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }
</script>

<script>
    document.getElementById('cetakButton').addEventListener('click', function () {
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        let url = `/mentor-access/cetak-jadwal?`;

        if (bulan) url += `bulan=${bulan}&`;
        if (tahun) url += `tahun=${tahun}`;

        window.open(url, '_blank');
    });
</script>



@endsection
