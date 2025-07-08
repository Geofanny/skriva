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
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar Dosen</h1>
    
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="/dashboard" class="text-blue-600 hover:underline">Dashboard</a>
                    </li>
                    <li>/</li>
                    <li class="text-gray-500">Dosen</li>
                </ol>
            </nav>
        </div>
    
        <!-- Tombol Tambah Dosen -->
        <div>
            <button onclick="openModalDosen()"
                class="bg-cyan-700 hover:bg-cyan-600 text-white p-4 rounded-full shadow-lg transition duration-200"
                title="Tambah Dosen">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>
    

    <!-- Modal Tambah Dosen -->
    <div id="modalDosen" class="fixed inset-0 z-50 hidden bg-black/40 transition-opacity duration-300 flex justify-center items-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fade-in">
            <!-- Tombol Close -->
            <button onclick="closeModalDosen()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 class="text-2xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Dosen
            </h2>
            <hr class="border-t-2 border-cyan-600 w-full mb-4">

            <form action="/dosenBaru" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" id="nip" name="nip"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                            placeholder="Masukkan NIP" required>
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                        <input type="text" id="nama" name="nama"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                            placeholder="Masukkan nama dosen" required>
                    </div>
                </div>

                <div>
                    <label for="kd_prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <select id="kd_prodi" name="kd_prodi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:ring-cyan-600 focus:border-cyan-600"
                        required>
                        <option value="" disabled selected>-- Pilih Program Studi --</option>
                        @foreach ($daftarProdi as $prodi)
                            <option value="{{ $prodi->kd_prodi }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" onclick="closeModalDosen()"
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


    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
        <table id="mahasiswaTable" class="w-full text-sm text-left text-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">NIP</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Program Studi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarDosen as $dosen )
                <tr class="capitalize">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $dosen->nip }}</td>
                    <td class="px-4 py-2">{{ $dosen->nama }}</td>
                    <td class="px-4 py-2">{{ $dosen->nama_prodi }}</td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            <button
                                onclick="openEditModal('{{ $dosen->nip }}', '{{ $dosen->nama }}', '{{ $dosen->kd_prodi }}')"
                                class="inline-flex items-center bg-cyan-700 hover:bg-cyan-600 px-3 py-1.5 rounded text-white text-xs">
                                <i data-feather="edit-2" class="w-4 h-4 mr-1"></i> Edit
                            </button>

                            <form action="/dashboard/dosen/{{ $dosen->nip }}" method="POST" class="inline-block delete-form">
                                @csrf
                                <button type="button"
                                        class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs delete-btn"
                                        data-nama="{{ $dosen->nama }}">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>                      
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Edit Dosen -->
        <div id="modalEditDosen" class="fixed inset-0 z-50 hidden bg-black/40 transition-opacity duration-300 flex justify-center items-center">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fade-in">
                <!-- Tombol Close -->
                <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h2 class="text-2xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Edit Dosen
                </h2>
                <hr class="border-t-2 border-cyan-600 w-full mb-4">

                <form id="formEditDosen" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIP</label>
                            <input type="text" id="edit_nip" name="nip" readonly
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                            <input type="text" id="edit_nama" name="nama" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-cyan-600 focus:border-cyan-600">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                        <select id="edit_kd_prodi" name="kd_prodi"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-cyan-600 focus:border-cyan-600"
                                required>
                            <option value="" disabled>-- Pilih Program Studi --</option>
                            @foreach ($daftarProdi as $prodi)
                                <option value="{{ $prodi->kd_prodi }}">{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Password (Opsional)</label>
                        <input type="text" id="edit_password" name="password"
                            placeholder="Kosongkan jika tidak ingin diganti"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-cyan-600 focus:border-cyan-600">
                    </div>

                    <div class="flex justify-between pt-5">
                        <button type="button" onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow-sm">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-cyan-700 hover:bg-cyan-600 text-white rounded-lg shadow-sm">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#mahasiswaTable').DataTable({
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
            text: `Data dosen "${nama}" akan dihapus permanen.`,
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
    function openModalDosen() {
        document.getElementById('modalDosen').classList.remove('hidden');
    }

    function closeModalDosen() {
        document.getElementById('modalDosen').classList.add('hidden');
    }
</script>

<script>
    function openEditModal(nip, nama, kd_prodi) {
        // Set nilai input
        document.getElementById('edit_nip').value = nip;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_kd_prodi').value = kd_prodi;
        document.getElementById('edit_password').value = '';

        // Set action form
        document.getElementById('formEditDosen').action = `/dosen/update/${nip}`;

        // Tampilkan modal
        document.getElementById('modalEditDosen').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modalEditDosen').classList.add('hidden');
    }
</script>


@endsection
