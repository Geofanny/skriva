<x-dashboard.dashboard title="Daftar Pembimbing">
    @push('link')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
        <script src="https://unpkg.com/feather-icons"></script>
        <style>
            .dataTables_length select {
                color: black;
                background-color: white;
            }

            .dataTables_length select option {
                background-color: white;
                color: black;
            }

            #dosenTable {
                background-color: white !important;
                color: black !important;
            }

            #dosenTable thead {
                background-color: #f1f5f9;
                color: #111827;
            }

            #dosenTable tbody tr {
                background-color: white;
            }

            #dosenTable tbody tr:hover {
                background-color: #e2e8f0;
            }

            #dosenTable td,
            #dosenTable th {
                color: black !important;
            }

            .prodi-label {
                display: inline-block;
            }
        </style>
    @endpush

    <h2 class="text-3xl font-bold text-white mb-6">📋 Daftar Pembimbing</h2>

    <a href="{{ route('pembimbing.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition mb-5">
        Tambah Pembimbing +
    </a>

    <div class="bg-slate-800 p-4 rounded-xl capitalize overflow-x-auto border border-slate-700">
        <table id="dosenTable" class="min-w-full divide-y divide-slate-300 text-sm text-gray-900 bg-white">
            <thead class="bg-gray-100 text-gray-800 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Kode Bimbingan</th>
                    <th class="px-6 py-3 text-left">Dosen Pembimbing</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Mahasiswa</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($pembimbing as $data)
                    <tr class="hover:bg-gray-100 group transition">
                        <td class="px-6 py-4 font-medium text-gray-700 group-hover:text-black">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-700 group-hover:text-black">{{ $data->kd_bimbingan }}</td>
                        <td class="px-6 py-4 font-medium text-gray-700 group-hover:text-black">{{ $data->nama_dosen }}</td>
                        <td class="px-6 py-4 font-medium text-gray-700 group-hover:text-black">Pembimbing {{ $data->pembimbing }}</td>
                        <td class="px-6 py-4 font-medium text-center text-gray-700 group-hover:text-black">
                            {{ $data->jumlah_mahasiswa }} | 
                            <button 
                                onclick="document.getElementById('modal-{{ $data->kd_bimbingan }}').classList.remove('hidden')"
                                class="text-blue-700 group-hover:text-blue-500 font-semibold">
                                Lihat Detail
                            </button>
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            {{-- Tambah Mahasiswa --}}
                            @if ($data->jumlah_mahasiswa >= 6)
                                <div title="Kuota mahasiswa sudah penuh"
                                    class="inline-flex items-center bg-gray-400 cursor-not-allowed px-3 py-1.5 rounded text-white text-xs">
                                    <i data-feather="user-plus" class="w-4 h-4 mr-1"></i> Mahasiswa
                                </div>
                            @else
                                <a href="/pembimbing/{{ $data->slug }}/mahasiswa"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded text-white text-xs">
                                    <i data-feather="user-plus" class="w-4 h-4 mr-1"></i> Mahasiswa
                                </a>
                            @endif

                            {{-- Hapus --}}
                            <form id="form-hapus-{{ $data->kd_bimbingan }}" action="{{ route('pembimbing.destroy', $data->kd_bimbingan) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmHapus('{{ $data->kd_bimbingan }}')" class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                </button>
                            </form> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @foreach ($pembimbing as $data)
    <div id="modal-{{ $data->kd_bimbingan }}" class="fixed hidden inset-0 bg-black bg-opacity-80 z-50 flex items-center justify-center px-4">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl p-8 relative text-gray-900">
            <h3 class="text-2xl font-extrabold mb-6 flex items-center gap-3">
                <span class="text-blue-600">📋</span> Daftar Mahasiswa | {{ $data->prodi }}
            </h3>
            <div class="flex justify-between items-center mb-4">
                <p class="text-md text-gray-700">
                    Dosen Pembimbing: <strong class="text-blue-600">{{ $data->nama_dosen }}</strong>
                </p>
                <button 
                    onclick="printModal('{{ $data->kd_bimbingan }}')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition"
                    aria-label="Cetak Daftar Mahasiswa">
                    🖨 Cetak
                </button>
            </div>
            
            <button 
                onclick="document.getElementById('modal-{{ $data->kd_bimbingan }}').classList.add('hidden')" 
                class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 font-bold text-2xl leading-none"
                aria-label="Tutup Modal">
                &times;
            </button>

            <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-inner">
                <table class="w-full text-sm text-left text-gray-900 bg-white">
                    <thead class="bg-blue-100 font-semibold text-blue-700">
                        <tr>
                            <th class="px-5 py-3 border-b border-blue-300">No</th>
                            <th class="px-5 py-3 border-b border-blue-300">Nama Mahasiswa</th>
                            <th class="px-5 py-3 border-b border-blue-300">NPM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswa[$data->kd_bimbingan] ?? [] as $index => $mhs)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-5 py-3 border-b border-gray-200">{{ $index + 1 }}</td>
                                <td class="px-5 py-3 border-b border-gray-200">{{ $mhs->nama }}</td>
                                <td class="px-5 py-3 border-b border-gray-200">{{ $mhs->npm }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-3 text-center text-gray-500">
                                    Tidak ada mahasiswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach


    </div>

    @push('script')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#dosenTable').DataTable({
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
            function confirmHapus(kdBimbingan) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data mahasiswa akan dihapus secara permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-hapus-' + kdBimbingan).submit();
                    }
                });
            }
        </script>
        
        @if(session('success'))
         <script>
             Swal.fire({
                 icon: 'success',
                 title: 'Berhasil',
                 text: '{{ session('success') }}',
                 confirmButtonText: 'OK',
                 confirmButtonColor: '#3085d6'
             });
         </script>
         @endif
                
        <script>feather.replace()</script>
    @endpush
</x-dashboard.dashboard>
