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
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pembimbing Mahasiswa</h1>
            {{-- <a href="/dashboard/pembimbing/baru"
               class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold py-2 px-4 rounded shadow">
                + Tambah Pembimbing
            </a> --}}
            <!-- Tombol Modal -->
            <button onclick="openModalBimbingan()" 
            class="bg-cyan-700 hover:bg-cyan-600 text-white p-4 rounded-full shadow-lg transition duration-200" 
            title="Tambah Pembimbing">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            </button>
        </div>

        <div id="modal-bimbingan" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl">
                <form action="/pembimbingBaru" method="POST" class="p-6 space-y-6">
                    @csrf
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Tambah Pembimbing</h2>
        
                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Prodi -->
                        <div>
                            <label for="modal_prodi" class="text-sm font-medium text-gray-700">Program Studi</label>
                            <select id="modal_prodi" name="kd_prodi" required
                                    class="w-full border rounded px-3 py-2 focus:ring-cyan-500">
                                <option value="" disabled selected>-- Pilih Prodi --</option>
                                @foreach ($daftarProdi as $item)
                                    <option value="{{ $item->kd_prodi }}">{{ $item->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
        
                        <!-- Dosen -->
                        <div>
                            <label for="modal_nip" class="text-sm font-medium text-gray-700">Dosen</label>
                            <select id="modal_nip" name="nip" disabled required
                                    class="w-full border rounded px-3 py-2 focus:ring-cyan-500">
                                <option value="">-- Pilih Dosen --</option>
                            </select>
                        </div>
        
                        <!-- Posisi -->
                        <div>
                            <label for="modal_posisi" class="text-sm font-medium text-gray-700">Posisi</label>
                            <select id="modal_posisi" name="posisi" disabled required
                                    class="w-full border rounded px-3 py-2 focus:ring-cyan-500">
                                <option value="">-- Pilih Posisi --</option>
                            </select>
                        </div>
                    </div>
        
                    <!-- Tombol -->
                    <div class="flex justify-between items-center border-t pt-4">
                        <button type="button" onclick="closeModalBimbingan()"
                                class="bg-gray-300 hover:bg-gray-200 text-gray-800 px-5 py-2 rounded">
                            Batal
                        </button>
                        <button type="submit"
                                class="bg-cyan-700 hover:bg-cyan-600 text-white px-5 py-2 rounded shadow">
                            Submit
                        </button>
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
                <li class="text-gray-500">Pembimbing</li>
            </ol>
        </nav>
    </div>
    

    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
        <table id="koordinatorTable" class="w-full text-sm text-left text-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Kode Pembimbing</th>
                    <th class="px-4 py-2">Nama Dosen</th>
                    <th class="px-4 py-2">Posisi</th>
                    <th class="px-4 py-2">Mahasiswa</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarPembimbing as $pembimbing )
                <tr class="capitalize">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $pembimbing->kd_pembimbing }}</td>
                    <td class="px-4 py-2">{{ $pembimbing->nama }}</td>
                    <td class="px-4 py-2">{{ $pembimbing->posisi }}</td>
                    <td class="px-4 py-2">{{ $jumlahMahasiswa[$pembimbing->kd_pembimbing] ?? 0 }} | <button type="button"
                        data-kode="{{ $pembimbing->kd_pembimbing }}"
                        data-nama="{{ $pembimbing->nama }}"
                        class="text-blue-600 hover:text-blue-800 mr-2 detail-btn">
                        Lihat Detail
                    </button></td>
                    <td class="px-4 py-2">
                        <div class="flex space-x-2">
                            
                            {{-- <button 
                                onclick="bukaModalTambahMahasiswa('{{ $pembimbing->kd_pembimbing }}', '{{ $pembimbing->kd_prodi }}')" 
                                class="inline-flex items-center bg-cyan-700 hover:bg-cyan-600 px-3 py-1.5 rounded text-white text-xs">
                                <i data-feather="user-plus" class="w-4 h-4 mr-1"></i> Mahasiswa
                            </button> --}}
                            @php
                                $jumlah = $jumlahMahasiswa[$pembimbing->kd_pembimbing] ?? 0;
                            @endphp

                            {{-- <button
                                onclick="bukaModalTambahMahasiswa('{{ $pembimbing->kd_pembimbing }}', '{{ $pembimbing->kd_prodi }}','{{ $pembimbing->nip }}')"
                                class="inline-flex items-center px-3 py-1.5 rounded text-xs
                                    {{ $jumlah >= 10 ? 'bg-gray-400 cursor-not-allowed' : 'bg-cyan-700 hover:bg-cyan-600 text-white' }}"
                                {{ $jumlah >= 10 ? 'disabled' : '' }}>
                                <i data-feather="user-plus" class="w-4 h-4 mr-1"></i> Mahasiswa
                            </button> --}}

                            <button
                                onclick="bukaModalTambahMahasiswa('{{ $pembimbing->kd_pembimbing }}', '{{ $pembimbing->kd_prodi }}','{{ $pembimbing->nip }}','{{ $pembimbing->posisi }}', '{{ $jumlahMahasiswa[$pembimbing->kd_pembimbing] ?? 0 }}')"
                                class="inline-flex items-center px-3 py-1.5 rounded text-xs
                                    {{ ($jumlahMahasiswa[$pembimbing->kd_pembimbing] ?? 0) >= 10 ? 'bg-gray-400 cursor-not-allowed' : 'bg-cyan-700 hover:bg-cyan-600 text-white' }}"
                                {{ ($jumlahMahasiswa[$pembimbing->kd_pembimbing] ?? 0) >= 10 ? 'disabled' : '' }}>
                                <i data-feather="user-plus" class="w-4 h-4 mr-1"></i> Mahasiswa
                            </button>



                            <div id="modal-tambah-mahasiswa" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl">
                                    <form method="POST" action="/dashboard/pembimbing/mahasiswa/tambah" id="formTambahMahasiswa" class="flex flex-col">
                                        @csrf
                                        <input type="hidden" name="kd_pembimbing" id="input-kd-pembimbing">
                            
                                        <!-- Header -->
                                        <div class="flex justify-between items-center p-4 border-b">
                                            <h2 class="text-xl font-semibold text-gray-800">Tambah Mahasiswa</h2>
                                            <button type="button" onclick="tutupModalTambahMahasiswa()" class="text-2xl text-gray-500 hover:text-red-600">&times;</button>
                                        </div>
                            
                                        <!-- Body -->
                                        <div class="p-6 space-y-6">
                                            <!-- Jumlah & Metode -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Input Jumlah -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700"  id="label-jumlah-mahasiswa">Jumlah Mahasiswa (maks 10)</label>
                                                    <input type="number" name="jumlah" id="jumlah-mahasiswa"
                                                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-cyan-500"
                                                        min="1" required>
                                                    <small id="loading-mahasiswa" class="text-xs text-gray-500 block mt-1">Memuat data mahasiswa...</small>
                                                </div>
                            
                                                <!-- Metode -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Metode Penambahan</label>
                                                    <div class="mt-2 space-y-2">
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input type="radio" name="metode" value="acak" class="form-radio text-cyan-600" required>
                                                            <span>Acak</span>
                                                        </label>
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input type="radio" name="metode" value="manual" class="form-radio text-cyan-600" required>
                                                            <span>Manual</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                            
                                            <!-- Jika Manual -->
                                            <div id="form-manual" class="hidden space-y-3">
                                                <label class="block text-sm font-medium text-gray-700">Pilih Mahasiswa (Manual):</label>
                                                <div id="manual-select-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <!-- Select akan muncul di sini -->
                                                </div>
                                            </div>
                            
                                            <!-- Jika Acak -->
                                            <div id="form-acak" class="hidden space-y-3">
                                                <label class="block text-sm font-medium text-gray-700">
                                                    Mahasiswa yang akan ditambahkan:
                                                </label>

                                                <div id="card-mahasiswa-acak"
                                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 overflow-y-auto max-h-64 p-2 border rounded">
                                                    <!-- Card acak akan muncul di sini -->
                                                </div>
                                            </div>

                                        </div>
                            
                                        <!-- Footer -->
                                        <div class="flex justify-between items-center border-t p-4 rounded-b-xl">
                                            <button type="button"
                                                onclick="tutupModalTambahMahasiswa()"
                                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded">
                                                Batal
                                            </button>

                                            <button type="submit"
                                                class="bg-cyan-700 hover:bg-cyan-600 text-white px-5 py-2 rounded-lg shadow">
                                                Simpan
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            
                            
                            <form action="/dashboard/pembimbing/{{ $pembimbing->kd_pembimbing }}" method="POST" class="inline-block delete-form">
                                @csrf
                                <button type="button"
                                        class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs delete-btn"
                                        data-nama="{{ $pembimbing->nama }}">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Detail Mahasiswa -->
        <div id="modal-detail" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all scale-95 animate-fade-in">
                
                <!-- Header Modal -->
                <div class="flex justify-between items-start p-6 border-b border-gray-200">
                    <div>
                        <h3 id="nama-dosen" class="text-2xl font-bold text-gray-800">Nama Dosen</h3>
                        <span id="nama-prodi" class="inline-block mt-1 px-3 py-1 text-xs font-semibold bg-cyan-100 text-cyan-800 rounded-full">
                            Sistem Informasi
                        </span>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
                </div>
        
                <!-- Isi Modal -->
                <div class="p-6 space-y-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-left">#</th>
                                    <th class="px-6 py-3 text-left">Nama Mahasiswa</th>
                                    <th class="px-6 py-3 text-left">NPM</th>
                                    <th class="px-6 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-mahasiswa" class="divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition">
                                    <td colspan="3" class="text-center py-4 text-gray-500">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        
                <!-- Footer -->
                <div class="flex justify-end p-4 border-t border-gray-200">
                    <button onclick="closeModal()" class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg shadow transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
        
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
    function closeModal() {
        $('#modal-detail').addClass('hidden');
    }

    $('.detail-btn').on('click', function () {
        const kode = $(this).data('kode');
        const nama = $(this).data('nama');

        // Set loading
        $('#nama-dosen').text(nama);
        $('#nama-prodi').text('Memuat...');
        $('#tabel-mahasiswa').html('<tr><td colspan="3" class="text-center py-4 text-gray-500">Memuat data...</td>');

        // Tampilkan modal
        $('#modal-detail').removeClass('hidden');

        // Ambil data mahasiswa & prodi via AJAX
        $.get(`/dashboard/pembimbing/${kode}/mahasiswa`, function (data) {
            $('#nama-prodi').text(data.prodi || 'Tidak diketahui');

            if (data.mahasiswa.length > 0) {
                let rows = '';
                data.mahasiswa.forEach((mhs, i) => {
                    rows += `<tr>
                                <td class="px-4 py-2">${i + 1}</td>
                                <td class="px-4 py-2 capitalize">${mhs.nama}</td>
                                <td class="px-4 py-2">${mhs.npm}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="/dashboard/pembimbing/mahasiswa/hapus" class="form-hapus-mahasiswa inline">
                                        @csrf
                                        <input type="hidden" name="kd_pembimbing" value="${kode}">
                                        <input type="hidden" name="npm" value="${mhs.npm}">
                                        <button type="submit"
                                            class="hapus-mahasiswa-btn bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-800 p-1.5 rounded-full transition"
                                            data-nama="${mhs.nama}"
                                            title="Hapus Mahasiswa">
                                            <!-- Icon minus -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                             </tr>`;
                });
                $('#tabel-mahasiswa').html(rows);
            } else {
                $('#tabel-mahasiswa').html(`<tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada mahasiswa bimbingan.</td>
                </tr>`);
            }
        });
    });

    // Event delegation untuk tombol hapus mahasiswa
    $(document).on('submit', '.form-hapus-mahasiswa', function (e) {
        e.preventDefault();
        const form = this;
        const nama = $(this).find('.hapus-mahasiswa-btn').data('nama');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Mahasiswa "${nama}" akan dihapus dari pembimbing.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Kirim form biasa, CSRF sudah aman
            }
        });
    });


</script>

<script>
    let semuaMahasiswa = [];
    let kdProdiAktif = '';
    let sisaMahasiswaBisaDitambah = 10;

    function bukaModalTambahMahasiswa(kdPembimbing, kdProdi, nip, posisiPembimbing,totalMahasiswa){
        $('#modal-tambah-mahasiswa').removeClass('hidden');
        $('#input-kd-pembimbing').val(kdPembimbing);
        kdProdiAktif = kdProdi;

        $('#form-manual').hide();
        $('#form-acak').hide();
        $('#card-mahasiswa-acak').empty().hide();
        $('input[name=metode]').prop('checked', false).prop('disabled', true);
        $('#manual-select-container').empty();
        $('#loading-mahasiswa').show();

        semuaMahasiswa = [];

        // Hitung sisa
        sisaMahasiswaBisaDitambah = 10 - parseInt(totalMahasiswa);
        if (sisaMahasiswaBisaDitambah < 0) sisaMahasiswaBisaDitambah = 0;

        $('#label-jumlah-mahasiswa').text(`Jumlah Mahasiswa (sisa ${sisaMahasiswaBisaDitambah} dari maksimal 10)`);
        $('#jumlah-mahasiswa').attr({
            'max': sisaMahasiswaBisaDitambah,
            'min': 1
        }).val('');

        $('#jumlah-mahasiswa').on('input', function () {
            let val = parseInt($(this).val());

            if (isNaN(val) || val < 1) {
                $(this).val(1);
            } else if (val > sisaMahasiswaBisaDitambah) {
                $(this).val(sisaMahasiswaBisaDitambah);
            }
        });


        $.ajax({
            url: `/api/mahasiswa-by-prodi/${kdProdi}/${nip}`,
            method: 'GET',
            success: function(data) {
                // console.log('Data Mahasiswa dari Backend:', data);
                // posisiPembimbing = parseInt(posisiPembimbing);
                // Filter berdasarkan posisi
                if (posisiPembimbing === 'Pembimbing 1') {
                    semuaMahasiswa = data.filter(mhs => !mhs.punya_pembimbing1);
                } else if (posisiPembimbing === 'Pembimbing 2') {
                    semuaMahasiswa = data.filter(mhs => !mhs.punya_pembimbing2);
                }

                // console.log('Setelah Filter:', semuaMahasiswa);
                $('#loading-mahasiswa').hide();
                $('input[name=metode]').prop('disabled', false);

                $('input[name=metode]').off('change').on('change', function () {
                    tampilkanOpsi();
                });
            },
            error: function() {
                alert('Gagal mengambil data mahasiswa.');
                $('#loading-mahasiswa').hide();
            }
        });
    }

    function tutupModalTambahMahasiswa() {
        $('#modal-tambah-mahasiswa').addClass('hidden');
        $('#formTambahMahasiswa')[0].reset();
        $('#form-manual').hide();
        $('#form-acak').hide();
        $('#manual-select-container').empty();
        $('#card-mahasiswa-acak').empty().hide();
    }

    function tampilkanOpsi() {
        const metode = $('input[name=metode]:checked').val();
        const jumlah = parseInt($('#jumlah-mahasiswa').val());

        // if (!jumlah || jumlah > 10 || jumlah < 1) {
        //     alert('Masukkan jumlah mahasiswa antara 1 - 10 terlebih dahulu.');
        //     $('input[name=metode]').prop('checked', false);
        //     return;
        // }

        // if (semuaMahasiswa.length < jumlah) {
        //     alert('Jumlah mahasiswa tidak mencukupi.');
        //     $('input[name=metode]').prop('checked', false);
        //     return;
        // }

        if (!jumlah || jumlah < 1) {
            alert('Masukkan jumlah mahasiswa terlebih dahulu.');
            $('input[name=metode]').prop('checked', false);
            return;
        }

        if (jumlah > sisaMahasiswaBisaDitambah) {
            alert(`Maksimal hanya bisa menambahkan ${sisaMahasiswaBisaDitambah} mahasiswa lagi.`);
            $('input[name=metode]').prop('checked', false);
            return;
        }

        if (semuaMahasiswa.length < jumlah) {
            alert('Jumlah mahasiswa tersedia tidak mencukupi.');
            $('input[name=metode]').prop('checked', false);
            return;
        }

        if (metode === 'acak') {
            $('#form-acak').show();
            $('#form-manual').hide();
            $('#card-mahasiswa-acak').empty().show();

            // Acak mahasiswa
            const shuffled = semuaMahasiswa.sort(() => 0.5 - Math.random());
            const selected = shuffled.slice(0, jumlah);

            selected.forEach((mhs, index) => {
                const card = `
                    <div class="p-3 border rounded shadow-sm bg-gray-50">
                        <input type="hidden" name="mahasiswa_acak[]" value="${mhs.npm}">
                        <div class="font-semibold text-gray-800">${mhs.nama}</div>
                        <div class="text-sm text-gray-500">${mhs.npm}</div>
                    </div>
                `;
                $('#card-mahasiswa-acak').append(card);
            });

        } else if (metode === 'manual') {
            $('#form-acak').hide();
            $('#card-mahasiswa-acak').hide().empty();
            $('#form-manual').show();

            let selectContainer = $('#manual-select-container');
            selectContainer.empty();

            for (let i = 0; i < jumlah; i++) {
                let selectHTML = `<select name="mahasiswa_manual[]" class="select-mahasiswa w-full border rounded px-2 py-1" required>
                    <option selected disable>-- Pilih Mahasiswa --</option>`;
                semuaMahasiswa.forEach(mhs => {
                    selectHTML += `<option value="${mhs.npm}">${mhs.nama} (${mhs.npm})</option>`;
                });
                selectHTML += `</select>`;
                selectContainer.append(selectHTML);
            }

            // Set event listener untuk semua dropdown agar opsi unik
            $('.select-mahasiswa').on('change', function () {
                let selectedValues = $('.select-mahasiswa').map(function () {
                    return $(this).val();
                }).get();

                $('.select-mahasiswa').each(function () {
                    const currentVal = $(this).val();
                    $(this).find('option').each(function () {
                        const val = $(this).val();
                        if (val === "") return;
                        if (val !== currentVal && selectedValues.includes(val)) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            });
        }
    }
</script>

<script>
    function openModalBimbingan() {
        document.getElementById('modal-bimbingan').classList.remove('hidden');
    }

    function closeModalBimbingan() {
        document.getElementById('modal-bimbingan').classList.add('hidden');
        document.querySelector('#modal_prodi').value = '';
        document.querySelector('#modal_nip').innerHTML = '<option value="">-- Pilih Dosen --</option>';
        document.querySelector('#modal_nip').disabled = true;
        document.querySelector('#modal_posisi').innerHTML = '<option value="">-- Pilih Posisi --</option>';
        document.querySelector('#modal_posisi').disabled = true;
    }

    const prodiSelect = document.getElementById('modal_prodi');
    const dosenSelect = document.getElementById('modal_nip');
    const posisiSelect = document.getElementById('modal_posisi');
    let currentDosenData = [];

    prodiSelect.addEventListener('change', function () {
        const kdProdi = this.value;

        fetch(`/get-dosen-by-prodi/${kdProdi}`)
            .then(res => res.json())
            .then(data => {
                currentDosenData = data;
                dosenSelect.innerHTML = '<option value="">-- Pilih Dosen --</option>';
                posisiSelect.innerHTML = '<option value="">-- Pilih Posisi --</option>';
                posisiSelect.disabled = true;

                data.forEach(dosen => {
                    dosenSelect.innerHTML += `<option value="${dosen.nip}">${dosen.nama}</option>`;
                });

                dosenSelect.disabled = data.length === 0;
            });
    });

    dosenSelect.addEventListener('change', function () {
        const selected = currentDosenData.find(d => d.nip === this.value);
        posisiSelect.innerHTML = '<option value="">-- Pilih Posisi --</option>';
        posisiSelect.disabled = true;

        if (!selected) return;

        const posisiTerambil = selected.posisi_terambil || [];
        const semua = ['Pembimbing 1', 'Pembimbing 2'];
        const tersedia = semua.filter(pos => !posisiTerambil.includes(pos));

        tersedia.forEach(pos => {
            posisiSelect.innerHTML += `<option value="${pos}">${pos}</option>`;
        });

        posisiSelect.disabled = tersedia.length === 0;
    });
</script>

@endsection
