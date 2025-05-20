<x-dashboard.dashboard>
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
        </style>
    @endpush

    <h2 class="text-3xl font-bold text-white mb-6">📋 Daftar Pembimbing</h2>

    <a href="{{ route('pembimbing.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition mb-5">
        Tambah Pembimbing +
    </a>

    <div class="bg-slate-800 p-4 rounded-xl capitalize overflow-x-auto border border-slate-700">
        <table id="dosenTable" class="min-w-full divide-y divide-slate-700 text-sm text-black">
            <thead class="bg-slate-700 text-gray-100 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Kode Bimbingan</th>
                    <th class="px-6 py-3 text-left">Dosen Pembimbing</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Mahasiswa</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @foreach ($pembimbing as $data)
                    <tr class="hover:bg-slate-700 group transition">
                        <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">{{ $data->kd_bimbingan }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">{{ $data->nama_dosen }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">Pembimbing {{ $data->pembimbing }}</td>
                        <td class="px-6 py-4 font-medium text-center text-gray-800 group-hover:text-white">
                            {{ $data->jumlah_mahasiswa }} | 
                            <button 
                                onclick="document.getElementById('modal-{{ $data->kd_bimbingan }}').classList.remove('hidden')"
                                class="text-blue-700 group-hover:text-blue-200 font-semibold">
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
                            <form action="{{ route('pembimbing.destroy', $data->kd_bimbingan) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs">
                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @foreach ($pembimbing as $data)
    <div id="modal-{{ $data->kd_bimbingan }}" class="fixed hidden inset-0 bg-gradient-to-br from-black/80 to-gray-900/90 z-50 flex items-center justify-center px-4">
        <div class="bg-white dark:bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl p-8 relative text-gray-900 dark:text-gray-100">
            <h3 class="text-2xl font-extrabold mb-6 flex items-center gap-3">
                <span class="text-blue-600">📋</span> Daftar Mahasiswa | {{ $data->prodi }}
            </h3>
            <div class="flex justify-between items-center mb-4">
                <p class="text-md text-gray-700 dark:text-gray-300">
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
            class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-bold text-2xl leading-none"
            aria-label="Tutup Modal">
            &times;
        </button>
            <div class="overflow-x-auto rounded-lg border border-gray-300 dark:border-gray-600 shadow-inner">
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-blue-100 dark:bg-blue-900 font-semibold text-blue-700 dark:text-blue-300">
                        <tr>
                            <th class="px-5 py-3 border-b border-blue-300 dark:border-blue-700">No</th>
                            <th class="px-5 py-3 border-b border-blue-300 dark:border-blue-700">Nama Mahasiswa</th>
                            <th class="px-5 py-3 border-b border-blue-300 dark:border-blue-700">NPM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswa[$data->kd_bimbingan] ?? [] as $index => $mhs)
                            <tr class="hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                                <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">{{ $index + 1 }}</td>
                                <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">{{ $mhs->nama }}</td>
                                <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">{{ $mhs->npm }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada mahasiswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- <div class="flex justify-end gap-4 mt-8">
                <button 
                    onclick="document.getElementById('modal-{{ $data->kd_bimbingan }}').classList.add('hidden')" 
                    class="bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold py-2 px-5 rounded-lg transition">
                    Tutup
                </button>
                <button 
                    onclick="printModal('{{ $data->kd_bimbingan }}')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg transition">
                    🖨 Cetak
                </button>
            </div> --}}
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
