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
    <div class="mb-5">
        <!-- Header dan Tombol -->
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Mahasiswa</h1>
            <!-- Tombol Tambah Mahasiswa -->
            <button onclick="openModalMahasiswa()" class="bg-cyan-700 hover:bg-cyan-600 text-white p-4 rounded-full shadow-lg transition duration-200" title="Tambah Mahasiswa">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>

        <!-- Modal Tambah Mahasiswa -->
        <div id="modalMahasiswa" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Tambah Mahasiswa</h2>
                    <button onclick="closeModalMahasiswa()" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                </div>

                <form action="/mahasiswaBaru" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NPM</label>
                            <input type="text" name="npm" required class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="nama" required class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <select name="kd_prodi" required class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-500">
                            <option disabled selected>-- Pilih Prodi --</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->kd_prodi }}">{{ $item->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between gap-3 pt-4">
                        <button type="button" onclick="closeModalMahasiswa()" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded bg-cyan-700 hover:bg-cyan-600 text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 mb-2" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="/dashboard" class="text-blue-600 hover:underline">Dashboard</a>
                </li>
                <li>/</li>
                <li class="text-gray-500">Mahasiswa</li>
            </ol>
        </nav>
    </div>
    

    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
        <table id="mahasiswaTable" class="w-full text-sm text-left text-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">NPM</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Program Studi</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswas as $mahasiswa )
                <tr class="capitalize">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $mahasiswa->npm }}</td>
                    <td class="px-4 py-2">{{ $mahasiswa->nama }}</td>
                    <td class="px-4 py-2">{{ $mahasiswa->nama_prodi }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex space-x-2">
                            <button
                                onclick="openModalEditMahasiswa(this)"
                                data-npm="{{ $mahasiswa->npm }}"
                                data-nama="{{ $mahasiswa->nama }}"
                                data-kd_prodi="{{ $mahasiswa->kd_prodi }}"
                                class="inline-flex items-center bg-cyan-700 hover:bg-cyan-600 px-3 py-1.5 rounded text-white text-xs">
                                <i data-feather="edit-2" class="w-4 h-4 mr-1"></i>Edit
                            </button>
                            <form action="/dashboard/mahasiswa/{{ $mahasiswa->npm }}" method="POST" class="inline-block delete-form">
                                @csrf
                                <button type="button"
                                            class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs delete-btn"
                                            data-nama="{{ $mahasiswa->nama }}">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>                            
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Edit Mahasiswa -->
        <div id="modalEditMahasiswa" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Edit Mahasiswa</h2>
                    <button onclick="closeModalEditMahasiswa()" class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                </div>

                <form action="/mahasiswa/update/{{ $mahasiswa->npm }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NPM -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NPM</label>
                            <input type="text" name="npm" value="{{ $mahasiswa->npm }}" readonly
                                class="w-full border rounded px-3 py-2 text-sm bg-gray-100 cursor-not-allowed">
                        </div>

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                            <input type="text" name="nama" value="{{ $mahasiswa->nama }}" required
                                class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Prodi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                            <select name="kd_prodi" required
                                class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-500">
                                <option value="" disabled>-- Pilih Prodi --</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->kd_prodi }}" {{ $item->kd_prodi == $mahasiswa->kd_prodi ? 'selected' : '' }}>
                                        {{ $item->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password (Opsional)</label>
                            <input type="text" name="password" placeholder="Kosongkan jika tidak ingin diubah"
                                class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-between gap-3 pt-4">
                        <button type="button" onclick="closeModalEditMahasiswa()"
                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-200">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 rounded bg-cyan-700 hover:bg-cyan-600 text-white">Update</button>
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
            text: `Data mahasiswa "${nama}" akan dihapus permanen.`,
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
    function openModalMahasiswa() {
        document.getElementById('modalMahasiswa').classList.remove('hidden');
    }

    function closeModalMahasiswa() {
        document.getElementById('modalMahasiswa').classList.add('hidden');
    }
</script>

<script>
    function openModalEditMahasiswa(button) {
        // Ambil data dari atribut
        const npm = button.getAttribute('data-npm');
        const nama = button.getAttribute('data-nama');
        const kd_prodi = button.getAttribute('data-kd_prodi');

        // Set form action (gunakan route yang sesuai)
        const form = document.querySelector('#modalEditMahasiswa form');
        form.action = `/mahasiswa/update/${npm}`;

        // Isi input form
        form.querySelector('input[name="npm"]').value = npm;
        form.querySelector('input[name="nama"]').value = nama;
        form.querySelector('select[name="kd_prodi"]').value = kd_prodi;
        form.querySelector('input[name="password"]').value = ''; // kosongkan

        // Tampilkan modal
        document.getElementById('modalEditMahasiswa').classList.remove('hidden');
    }

    function closeModalEditMahasiswa() {
        document.getElementById('modalEditMahasiswa').classList.add('hidden');
    }
</script>


@endsection
