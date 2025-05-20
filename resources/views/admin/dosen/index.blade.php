<x-dashboard.dashboard>
    @push('link')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
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

    <h2 class="text-3xl font-bold text-white mb-6">📋 Data Dosen</h2>

    <a href="{{ route('dosen.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition mb-5">
        Tambah Dosen +
    </a>

    <div class="bg-slate-800 p-4 rounded-xl overflow-x-auto border border-slate-700 text-amber-50">
        <table id="dosenTable" class="min-w-full divide-y capitalize divide-slate-700 text-sm text-black">
            <thead class="bg-slate-700 text-gray-100 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">NIP</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Nomor Telepon</th>
                    <th class="px-6 py-3 text-left">Prodi</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                @foreach ($dosens as $dosen)
                    <tr class="hover:bg-slate-700 group transition">
                        <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">{{ $loop->iteration }}</td> 
                        <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">{{ $dosen->nip }}</td>
                        <td class="px-6 py-4 text-gray-800 group-hover:text-white">{{ $dosen->nama }}</td>
                        <td class="px-6 py-4 text-gray-800 group-hover:text-white">{{ $dosen->no_hp }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold prodi-label" data-prodi="{{ $dosen->prodi }}">
                                {{ $dosen->prodi }}
                            </span>
                        </td>                        
                        <td class="px-6 py-4 space-x-3">
                            <a href="{{ route('dosen.edit', $dosen->token) }}" class="text-blue-700 group-hover:text-blue-200 font-semibold">Edit</a>
                            <form action="{{ route('dosen.destroy', $dosen->nip) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-700 group-hover:text-red-300 font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

    @push('script')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

        <script>
            const bgDarkColors = [
                "#1E293B", "#334155", "#4B5563", "#1F2937", "#3F3F46",
                "#3730A3", "#4C1D95", "#7C3AED", "#0F172A", "#4A044E",
                "#78350F", "#14532D", "#172554", "#3B0764", "#164E63", "#431407"
            ];
        
            function hashString(str) {
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                return Math.abs(hash);
            }
        
            function getColorByProdi(prodi) {
                const index = hashString(prodi.toLowerCase()) % bgDarkColors.length;
                return {
                    bg: bgDarkColors[index],
                    text: "#FFFFFF"
                };
            }
        
            function applyProdiColors() {
                $('.prodi-label').each(function () {
                    const prodi = $(this).data('prodi');
                    if (prodi) {
                        const color = getColorByProdi(prodi);
                        $(this).css({
                            backgroundColor: color.bg,
                            color: color.text,
                        });
                    }
                });
            }
        
            $(document).ready(function () {
                const table = $('#dosenTable').DataTable({
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
        
                // Apply color saat pertama kali
                applyProdiColors();
        
                // Apply color SETIAP DataTables redraw (pagination, search, sort, dll)
                table.on('draw.dt', function () {
                    applyProdiColors();
                });
            });
        </script>
        
    @endpush
</x-dashboard.dashboard>
