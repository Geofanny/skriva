<x-dashboard.dashboard title="Daftar Dosen">
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

    <h2 class="text-3xl font-bold text-white mb-6">📋 Data Dosen</h2>

    <a href="{{ route('dosen.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition mb-5">
        Tambah Dosen +
    </a>

    <div class="bg-slate-800 p-4 rounded-xl overflow-x-auto border border-slate-700 text-amber-50">
        <table id="dosenTable" class="min-w-full divide-y capitalize divide-slate-700 text-sm">
            <thead class="uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">NIP</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Nomor Telepon</th>
                    <th class="px-6 py-3 text-left">Prodi</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dosens as $dosen)
                    <tr class="group transition">
                        <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium">{{ $dosen->nip }}</td>
                        <td class="px-6 py-4">{{ $dosen->nama }}</td>
                        <td class="px-6 py-4">{{ $dosen->no_hp }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold prodi-label"
                                  data-prodi="{{ $dosen->prodi }}">
                                {{ $dosen->prodi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-3">
                            <a href="{{ route('dosen.edit', $dosen->token) }}"
                               class="text-blue-700 group-hover:text-blue-400 font-semibold">Edit</a>
                            <form id="form-hapus-{{ $dosen->nip }}" action="{{ route('dosen.destroy', $dosen->nip) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmHapus('{{ $dosen->nip }}')"
                                        class="text-red-700 group-hover:text-red-400 font-semibold">Hapus</button>
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

                applyProdiColors();

                table.on('draw.dt', function () {
                    applyProdiColors();
                });
            });
        </script>

        <script>
            function confirmHapus(nip) {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data dosen akan dihapus secara permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-hapus-' + nip).submit();
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
    @endpush
</x-dashboard.dashboard>
