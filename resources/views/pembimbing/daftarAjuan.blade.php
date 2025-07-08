@extends('layouts/dashboard')

<style>
    table.dataTable thead th {
        background-color: #f3f4f6;
    }
</style>

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-1">Daftar Ajuan Bimbingan</h1>
    <p class="text-sm text-gray-500">Ajuan bimbingan mahasiswa yang masih menunggu keputusan Anda.</p>
</div>

<div class="bg-white p-6 rounded-xl shadow">
    <table id="ajuanTable" class="table-auto w-full text-sm text-left text-gray-700">
        <thead>
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Nama Mahasiswa</th>
                <th class="px-4 py-2">Topik</th>
                <th class="px-4 py-2">Jam</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ajuan as $item)
            <tr class="border-b">
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tgl_ajuan)->format('d/m/Y') }}</td>
                <td class="px-4 py-2">{{ $item->nama_mahasiswa }}</td>
                <td class="px-4 py-2">{{ $item->topik }}</td>
                <td class="px-4 py-2">
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                    </span>
                    &nbsp;–&nbsp;
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                    </span>
                </td>                
                <td class="px-4 py-2 space-x-2">
                    <button onclick="openModal('modal-setuju-{{ $item->kd_bimbingan }}')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">Setujui</button>
                    <button onclick="openModal('modal-tolak-{{ $item->kd_bimbingan }}')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">Tolak</button>
                </td>
            </tr>

            <!-- Modal Setuju -->
            <div id="modal-setuju-{{ $item->kd_bimbingan }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Persetujuan</h2>
                    <p>Setujui pengajuan bimbingan untuk <strong>{{ $item->nama_mahasiswa }}</strong>?</p>
                    <form action="{{ route('setujui.ajuan', $item->kd_bimbingan) }}" method="POST" class="mt-4 flex justify-end gap-2">
                        @csrf
                        <div class="flex justify-between">
                            <button type="button" onclick="closeModal('modal-setuju-{{ $item->kd_bimbingan }}')" class="px-3 py-1 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                            <button type="submit" class="px-3 py-1 rounded bg-green-600 hover:bg-green-700 text-white">Setujui</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div id="modal-tolak-{{ $item->kd_bimbingan }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Penolakan</h2>
                    <p class="text-sm mb-4">Tolak pengajuan bimbingan dari <strong>{{ $item->nama_mahasiswa }}</strong>?</p>
                    
                    <form action="{{ route('tolak.ajuan', $item->kd_bimbingan) }}" method="POST" onsubmit="return handleTolakSubmit('{{ $item->kd_bimbingan }}')">
                        @csrf
                        <input type="hidden" id="input-komentar-{{ $item->kd_bimbingan }}" name="komentar_penolakan">

                        <div class="space-y-2 text-sm text-gray-700">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="alasan_radio_{{ $item->kd_bimbingan }}" value="Maaf saya tidak bisa, jadwal bimbingan sedang padat" onclick="toggleTextarea('{{ $item->kd_bimbingan }}', false)">
                                <span>Maaf saya tidak bisa, jadwal bimbingan sedang padat</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="alasan_radio_{{ $item->kd_bimbingan }}" value="Maaf, ada rapat mendadak" onclick="toggleTextarea('{{ $item->kd_bimbingan }}', false)">
                                <span>Maaf, ada rapat mendadak</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="alasan_radio_{{ $item->kd_bimbingan }}" value="Lainnya" onclick="toggleTextarea('{{ $item->kd_bimbingan }}', true)">
                                <span>Lainnya</span>
                            </label>
                        </div>
            
                        <!-- Textarea Lainnya -->
                        <textarea id="textarea-lainnya-{{ $item->kd_bimbingan }}" rows="3" class="w-full border rounded p-2 mt-3 text-sm hidden" placeholder="Alasan penolakan lainnya..."></textarea>
            
                        <div class="flex justify-between gap-2 mt-4">
                            <button type="button" onclick="closeModal('modal-tolak-{{ $item->kd_bimbingan }}')" class="px-3 py-1 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                            <button type="submit" class="px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
                     
            @endforeach
        </tbody>
    </table>
</div>

<!-- DataTables & Modal Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#ajuanTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Belum ada ajuan bimbingan",
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

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }
</script>
<script>
    function toggleTextarea(kd_bimbingan, show) {
        const textarea = document.getElementById('textarea-lainnya-' + kd_bimbingan);
        if (show) {
            textarea.classList.remove('hidden');
            textarea.setAttribute('data-active', 'true');
            textarea.setAttribute('required', 'true');
        } else {
            textarea.classList.add('hidden');
            textarea.removeAttribute('data-active');
            textarea.removeAttribute('required');
        }
    }
    
    function handleTolakSubmit(kd_bimbingan) {
        const selected = document.querySelector(`input[name="alasan_radio_${kd_bimbingan}"]:checked`);
        const textarea = document.getElementById('textarea-lainnya-' + kd_bimbingan);
        const hiddenInput = document.getElementById('input-komentar-' + kd_bimbingan);
    
        if (!selected) {
            alert("Silakan pilih alasan penolakan.");
            return false;
        }
    
        if (selected.value === 'Lainnya') {
            if (!textarea.value.trim()) {
                alert("Silakan isi alasan pada kolom lainnya.");
                return false;
            }
            hiddenInput.value = textarea.value.trim();
        } else {
            hiddenInput.value = selected.value;
        }
    
        return true;
    }
</script>
    
@endsection
