@extends('layouts/dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Koordinasi</h1>
    <form action="/koordinasi/update/{{ $koordinasi->kd_koordinasi }}" method="POST" class="space-y-6">
        @csrf

        <!-- Prodi & Dosen -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Prodi -->
            <div>
                <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select id="prodi" name="kd_prodi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="" disabled>-- Pilih Program Studi --</option>
                    @foreach ($daftarProdi as $item)
                        <option value="{{ $item->kd_prodi }}" {{ $item->kd_prodi == $koordinasi->kd_prodi ? 'selected' : '' }}>
                            {{ $item->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dosen -->
            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">Nama Dosen</label>
                <select id="nip" name="nip"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="" disabled>-- Pilih Dosen --</option>
                    @foreach ($daftarDosen as $dosen)
                        <option value="{{ $dosen->nip }}" {{ $dosen->nip == $koordinasi->nip ? 'selected' : '' }}>
                            {{ $dosen->nama }}
                        </option>
                    @endforeach
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
                    Update
            </button>
        </div>

    </form>
</div>

<script>
    // Data dari controller
    const allDosen = @json($daftarDosen);
    const selectedProdi = @json($koordinasi->kd_prodi);

    // Elements
    const prodiSelect = document.getElementById('prodi');
    const dosenSelect = document.getElementById('nip');

    // Fungsi untuk mengisi select dosen
    function populateDosenSelect(dosenList, selectedNip = null) {
        dosenSelect.innerHTML = '<option value="" disabled>-- Pilih Dosen --</option>';

        dosenList.forEach(dosen => {
            const option = document.createElement('option');
            option.value = dosen.nip;
            option.textContent = dosen.nama;
            if (dosen.nip === selectedNip) {
                option.selected = true;
            }
            dosenSelect.appendChild(option);
        });

        dosenSelect.disabled = dosenList.length === 0;
    }

    // Saat halaman load, pastikan dosen terisi sesuai prodi
    document.addEventListener('DOMContentLoaded', () => {
        const currentProdi = prodiSelect.value;

        const filteredDosen = allDosen.filter(dosen => dosen.kd_prodi === currentProdi);
        const currentNip = @json($koordinasi->nip);
        populateDosenSelect(filteredDosen, currentNip);
    });

    // Event listener untuk prodi
    prodiSelect.addEventListener('change', function () {
        const selectedKdProdi = this.value;

        const filteredDosen = allDosen.filter(dosen => dosen.kd_prodi === selectedKdProdi);
        populateDosenSelect(filteredDosen);
    });
</script>

@endsection