@extends('layouts/dashboard')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    table.dataTable thead th {
        background-color: #f3f4f6;
    }

    @media (max-width: 850px) {
        #previewModal .responsive-iframe {
            height: 60vh;
        }
    }
</style>

<div>
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Jadwal Bimbingan</h1>
            <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/dashboard" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li>/</li>
                    <li class="text-gray-500">Jadwal Bimbingan</li>
                </ol>
            </nav>
        </div>

        <div>
            <button onclick="openModalBimbingan()" class="bg-cyan-700 hover:bg-cyan-600 text-white p-4 rounded-full shadow-lg transition duration-200" title="Tambah Bimbingan">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="modalBimbingan" class="fixed inset-0 z-50 hidden bg-black/40 flex justify-center items-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative">
            <button onclick="closeModalBimbingan()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 class="text-2xl font-bold text-gray-800 mb-3 flex items-center gap-2">Tambah Bimbingan</h2>
            <hr class="border-t-2 border-cyan-600 w-full mb-4">

            <form action="/bimbingan" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Topik</label>
                    <input type="text" name="topik" class="w-full border rounded px-3 py-2 mt-1" placeholder="Contoh: Bab 1 - Pendahuluan">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pembimbing</label>
                        <select name="pembimbing" class="w-full border rounded px-3 py-2 mt-1" required>
                            <option selected disabled>-- Pilih Pembimbing --</option>
                            @foreach ($pembimbingList as $pembimbing)
                                <option value="{{ $pembimbing->kd_pembimbing }}">
                                    {{ $pembimbing->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border rounded px-3 py-2 mt-1">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="w-full border rounded px-3 py-2 mt-1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="w-full border rounded px-3 py-2 mt-1">
                    </div>
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700">File Bimbingan</label>
                    <input type="file" name="file" class="w-full border rounded px-3 py-2 mt-1">
                </div> --}}

                <div class="flex justify-between gap-2 pt-4">
                    <button type="button" onclick="closeModalBimbingan()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-cyan-700 hover:bg-cyan-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalHapus" class="fixed inset-0 z-50 hidden bg-black/40 flex justify-center items-center">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm text-center">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Yakin ingin menghapus?</h3>
            <p class="text-sm text-gray-600 mb-4">Data bimbingan ini akan dihapus secara permanen.</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeModalHapus()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Preview File -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden bg-black/40 flex justify-center items-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl w-full p-4 relative flex flex-col">
            <button onclick="closePreviewModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-xl font-semibold mb-3 text-gray-800">Preview File Bimbingan</h2>
            
            <!-- Responsive iframe wrapper -->
            <div class="relative w-full" style="padding-top: 56.25%;"> <!-- 16:9 aspect ratio -->
                <iframe id="previewIframe" class="absolute top-0 left-0 w-full h-full border rounded" frameborder="0"
                onerror="handlePreviewError()"></iframe>
            </div>
        </div>
    </div>


    <!-- Tabel -->
    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
        <table id="bimbinganTable" class="w-full text-sm text-left text-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Topik</th>
                    <th class="px-4 py-2">Pembimbing</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Jam</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Komentar</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataBimbingan as $bimbingan)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $bimbingan->topik }}</td>
                        <td class="px-4 py-2">{{ $bimbingan->nama_pembimbing }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($bimbingan->tgl_ajuan)->format('Y/m/d') }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($bimbingan->waktu_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($bimbingan->waktu_selesai)->format('H:i') }}
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $bimbingan->status == 'Disetujui' ? 'bg-green-100 text-green-700' :
                                   ($bimbingan->status == 'Ditolak' ? 'bg-red-100 text-red-700' :
                                   'bg-yellow-100 text-yellow-700') }}">
                                {{ $bimbingan->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            {{ $bimbingan->komentar_penolakan }}</td>                        
                        <td class="px-4 py-2 flex gap-2">
                            {{-- @if ($bimbingan->file) --}}
                                {{-- Tombol File aktif --}}
                                {{-- <button onclick="openPreviewModal('{{ asset('storage/bimbingan/' . $bimbingan->file) }}')"
                                    class="flex items-center gap-1 bg-cyan-700 hover:bg-cyan-600 text-white text-xs px-3 py-1.5 rounded shadow transition"
                                    title="Lihat File">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    File
                                </button> --}}
                            {{-- @else --}}
                                {{-- Tombol File disabled --}}
                                {{-- <button disabled
                                    class="flex items-center gap-1 bg-gray-300 text-gray-600 text-xs px-3 py-1.5 rounded shadow transition cursor-not-allowed"
                                    title="Belum ada file">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    File
                                </button> --}}
                            {{-- @endif --}}
                        
                            {{-- Tombol Hapus selalu aktif --}}
                            <button onclick="openModalHapus('/bimbingan/{{ $bimbingan->kd_sesi }}')"
                                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1.5 rounded shadow transition">
                                <i data-feather="trash-2" class="w-4 h-4"></i>
                                Hapus
                            </button>
                        </td>                                              
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#bimbinganTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada bimbingan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Data kosong",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    next: "→",
                    previous: "←"
                }
            },
        });
    });

    function openModalBimbingan() {
        document.getElementById('modalBimbingan').classList.remove('hidden');
    }

    function closeModalBimbingan() {
        document.getElementById('modalBimbingan').classList.add('hidden');
    }

    function openModalHapus(actionUrl) {
        document.getElementById('formHapus').setAttribute('action', actionUrl);
        document.getElementById('modalHapus').classList.remove('hidden');
    }

    function closeModalHapus() {
        document.getElementById('modalHapus').classList.add('hidden');
    }

    function openPreviewModal(fileUrl) {
        document.getElementById('previewIframe').src = fileUrl;
        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreviewModal() {
        document.getElementById('previewIframe').src = '';
        document.getElementById('previewModal').classList.add('hidden');
    }
    function handlePreviewError() {
        closePreviewModal();
        // Download file jika gagal preview
        const link = document.createElement('a');
        link.href = currentPreviewUrl;
        link.download = '';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
