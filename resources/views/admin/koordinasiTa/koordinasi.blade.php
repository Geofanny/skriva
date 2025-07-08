@extends('layouts/dashboard')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    /* Tambahan supaya tabel tetap terlihat rapi dengan Tailwind */
    table.dataTable thead th {
        background-color: #f3f4f6;
    }
</style>

<div>
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar Koordinasi TA</h1>
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="/dashboard" class="text-blue-600 hover:underline">Dashboard</a>
                    </li>
                    <li>/</li>
                    <li class="text-gray-500">Koordinasi TA</li>
                </ol>
            </nav>
        </div>

        <!-- Header dan Tombol -->
        <div>
            {{-- <a href="/dashboard/koordinasi/baru"
               class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded shadow">
                + Tambah Koordinasi
            </a> --}}
            <button id="openModalBtn"
                class="bg-cyan-700 hover:bg-cyan-600 text-white p-4 rounded-full shadow-lg transition duration-200"
                title="Tambah Koordinasi TA">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
            </button>
        
            <!-- Modal -->
            <div id="modalForm"class="fixed inset-0 z-50 hidden bg-black/40 transition-opacity duration-300 flex justify-center items-center">
                <!-- Modal Content -->
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fade-in">
                    <!-- Close Button -->
                    <button id="closeModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <h2 class="text-2xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Koordinasi TA
                    </h2>
                    <hr class="border-t-2 border-cyan-600 w-full mb-4">                    
                    
                    <form action="/koordinasiBaru" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Prodi -->
                            <div>
                                <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <select id="prodi" name="kd_prodi"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                                        required>
                                    <option value="" disabled selected>-- Pilih Program Studi --</option>
                                    @foreach ($daftarProdi as $item)
                                        <option value="{{ $item->kd_prodi }}">{{ $item->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dosen -->
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                                <select id="nip" name="nip"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                                        required disabled>
                                    <option value="" disabled selected>-- Pilih Dosen --</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-between gap-2 pt-4">
                            <button type="button" id="closeModalBtn2"
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow-sm">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-cyan-700 hover:bg-cyan-600 text-white rounded-lg shadow-sm">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        
       
    </div>
    

    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
        <table id="koordinatorTable" class="w-full text-sm text-left text-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Koordinasi</th>
                    <th class="px-4 py-2">Program Studi</th>
                    <th class="px-4 py-2">Nama Dosen</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($koordinasiTa as $koordinator )
                <tr class="capitalize">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $koordinator->kd_koordinasi }}</td>
                    <td class="px-4 py-2">{{ $koordinator->nama_prodi }}</td>
                    <td class="px-4 py-2">{{ $koordinator->nama }}</td>
                    <td class="px-4 py-2">
                        {{-- <a href="/dashboard/koordinasi/{{ $koordinator->kd_koordinasi }}" class="text-blue-600 hover:text-blue-800 mr-2">Edit</a> --}}
                        <form action="/dashboard/koordinasi/{{ $koordinator->kd_koordinasi }}" method="POST" class="inline-block delete-form">
                            @csrf
                            <button type="button" class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs delete-btn" data-nama="{{ $koordinator->nama }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                            </button>
                        </form>                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#koordinatorTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
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
    });
</script>

<script>
    // SweetAlert untuk delete konfirmasi
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const nama = $(this).data('nama');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Data Koordinasi "${nama}" akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

<script>
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const closeModalBtn2 = document.getElementById('closeModalBtn2');
    const modalForm = document.getElementById('modalForm');

    openModalBtn.addEventListener('click', () => modalForm.classList.remove('hidden'));
    closeModalBtn.addEventListener('click', () => modalForm.classList.add('hidden'));
    closeModalBtn2.addEventListener('click', () => modalForm.classList.add('hidden'));

    const allDosen = @json($daftarDosen);
    const prodiSelect = document.getElementById('prodi');
    const dosenSelect = document.getElementById('nip');

    function populateDosenSelect(dosenList) {
        dosenSelect.innerHTML = '<option value="" disabled selected>-- Pilih Dosen --</option>';
        dosenList.forEach(d => {
            const option = document.createElement('option');
            option.value = d.nip;
            option.textContent = d.nama;
            dosenSelect.appendChild(option);
        });
        dosenSelect.disabled = dosenList.length === 0;
    }

    prodiSelect.addEventListener('change', function () {
        const filtered = allDosen.filter(d => d.kd_prodi === this.value);
        populateDosenSelect(filtered);
    });
</script>


@endsection
