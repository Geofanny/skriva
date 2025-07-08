@extends('layouts/dashboard')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    table.dataTable thead th {
        background-color: #f3f4f6;
    }
</style>

<div>
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar Program Studi</h1>
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="/dashboard" class="text-blue-600 hover:underline">Dashboard</a>
                    </li>
                    <li>/</li>
                    <li class="text-gray-500">Program Studi</li>
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
                title="Tambah Program Studi">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
            </button>

        </div>
        
       
    </div>

    <!-- Tabel -->
    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
        <table id="prodiTable" class="w-full text-sm text-left text-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Prodi</th>
                    <th class="px-4 py-2">Fakultas</th>
                    <th class="px-4 py-2">Nama Prodi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prodis as $prodi )
                <tr class="capitalize">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">F{{ $prodi->kd_prodi }}</td>
                    <td class="px-4 py-2">{{ $prodi->fakultas }}</td>
                    <td class="px-4 py-2">{{ $prodi->nama_prodi }}</td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            <button 
                                class="edit-prodi-btn inline-flex items-center bg-cyan-700 hover:bg-cyan-600 text-white text-xs px-3 py-1.5 rounded"
                                data-prodi='@json($prodi)'>
                                <i data-feather="edit-2" class="w-4 h-4 mr-1"></i> Edit
                            </button>
                            
                            <form action="/dashboard/prodi/{{ $prodi->kd_prodi }}" method="POST" class="inline-block delete-form">
                                @csrf
                                <button 
                                    type="button" 
                                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1.5 rounded delete-btn" 
                                    data-nama="{{ $prodi->nama_prodi }}">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                                           
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal Tambah -->
    <div id="modalForm" class="fixed inset-0 z-50 hidden bg-black/40 transition-opacity duration-300 flex justify-center items-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fade-in">
            <!-- Close -->
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
                Tambah Program Studi
            </h2>
            <hr class="border-t-2 border-cyan-600 w-full mb-4">  

            <form action="/prodiBaru" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                        <select id="fakultas" name="fakultas"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                                required>
                            <option value="" disabled selected>-- Pilih Fakultas --</option>
                            <option>Ilmu Pendidikan dan Pengetahuan Sosial</option>
                            <option>Matematika dan Ilmu Pengetahuan Alam</option>
                            <option>Teknik dan Ilmu Komputer</option>
                            <option>Bahasa dan Seni</option>
                        </select>
                    </div>
                    <div>
                        <label for="nama_prodi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                        <input type="text" id="nama_prodi" name="nama_prodi"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                            placeholder="Contoh: Teknik Informatika" required>
                    </div>
                </div>

                <div class="flex justify-between pt-4">
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

    <!-- Modal Edit Prodi -->
<div id="modalEditProdi" class="fixed inset-0 z-50 hidden bg-black/40 transition-opacity duration-300 flex justify-center items-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fade-in">
        <!-- Tombol Close -->
        <button onclick="closeEditProdiModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4h2m-1 0v16m8-8H4" />
            </svg>
            Edit Program Studi
        </h2>
        <hr class="border-t-2 border-blue-600 w-full mb-4">

        <form id="formEditProdi" method="POST" class="space-y-4">
            @csrf
            @method('POST') {{-- akan diganti ke PATCH secara dinamis --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Fakultas -->
                <div>
                    <label for="editFakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <select id="editFakultas" name="fakultas" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600">
                        <option value="" disabled selected>-- Pilih Fakultas --</option>
                        <option>Ilmu Pendidikan dan Pengetahuan Sosial</option>
                        <option>Matematika dan Ilmu Pengetahuan Alam</option>
                        <option>Teknik dan Ilmu Komputer</option>
                        <option>Bahasa dan Seni</option>
                    </select>
                </div>

                <!-- Nama Prodi -->
                <div>
                    <label for="editNamaProdi" class="block text-sm font-medium text-gray-700">Nama Prodi</label>
                    <input type="text" id="editNamaProdi" name="nama_prodi" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                        placeholder="Contoh: Teknik Informatika">
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" onclick="closeEditProdiModal()"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow-sm">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>




<!-- JS Section -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#prodiTable').DataTable({
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

        // Modal open/close
        const openBtn = document.getElementById("openModalBtn");
        const closeBtn = document.getElementById("closeModalBtn");
        const closeBtn2 = document.getElementById("closeModalBtn2");
        const modal = document.getElementById("modalForm");

        openBtn.addEventListener("click", () => modal.classList.remove("hidden"));
        closeBtn.addEventListener("click", () => modal.classList.add("hidden"));
        closeBtn2.addEventListener("click", () => modal.classList.add("hidden"));
    });

    // SweetAlert delete
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const nama = $(this).data('nama');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Data prodi "${nama}" akan dihapus permanen.`,
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

    document.querySelectorAll('.edit-prodi-btn').forEach(button => {
            button.addEventListener('click', function () {
                const prodi = JSON.parse(this.getAttribute('data-prodi'));
                openEditProdiModal(prodi);
            });
    });

    function openEditProdiModal(prodi) {
        document.getElementById('modalEditProdi').classList.remove('hidden');

        document.getElementById('editNamaProdi').value = prodi.nama_prodi;
        document.getElementById('editFakultas').value = prodi.fakultas;

        // Set action URL untuk update
        const form = document.getElementById('formEditProdi');
        form.action = `/prodi/${prodi.kd_prodi}`;
    }

    function closeEditProdiModal() {
        document.getElementById('modalEditProdi').classList.add('hidden');
    }
</script>

@endsection
