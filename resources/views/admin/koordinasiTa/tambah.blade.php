@extends('layouts/dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Koordinasi</h1>
    <form action="/koordinasiBaru" method="POST" class="space-y-6">
        @csrf

        <!-- Prodi & Dosen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Prodi -->
            <div>
                <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select id="prodi" name="kd_prodi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="" disabled selected>-- Pilih Program Studi --</option>
                    @foreach ($daftarProdi as $item)
                        <option value="{{ $item->kd_prodi }}">{{ $item->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dosen -->
            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">Nama Dosen</label>
                <select id="nip" name="nip"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required disabled>
                    <option value="" disabled selected>-- Pilih Dosen --</option>
                </select>
            </div>

        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-between items-center ">
            <a href="/dashboard/daftarKoordinasi"
            class="inline-block bg-gray-300 hover:bg-gray-200 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow cursor-pointer">
             Batal
            </a>         
            <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    Submit
            </button>
        </div>

    </form>
</div>

<script>
    // Data dari controller
    const allDosen = @json($daftarDosen);

    // Elements
    const prodiSelect = document.getElementById('prodi');
    const dosenSelect = document.getElementById('nip');

    // Fungsi untuk mengisi select dosen
    function populateDosenSelect(dosenList) {
        dosenSelect.innerHTML = '<option value="" disabled selected>-- Pilih Dosen --</option>';
        
        dosenList.forEach(dosen => {
            const option = document.createElement('option');
            option.value = dosen.nip;
            option.textContent = dosen.nama;
            dosenSelect.appendChild(option);
        });
        
        dosenSelect.disabled = dosenList.length === 0;
    }

    // Event listener untuk prodi
    prodiSelect.addEventListener('change', function () {
        const selectedKdProdi = this.value;

        // Filter dosen berdasarkan kode prodi yang dipilih
        const filteredDosen = allDosen.filter(dosen => dosen.kd_prodi === selectedKdProdi);

        // Populate select dosen
        populateDosenSelect(filteredDosen);
    });
</script>

@endsection