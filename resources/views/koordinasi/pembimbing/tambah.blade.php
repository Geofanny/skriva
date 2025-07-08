@extends('layouts/dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pembimbing</h1>
    <form action="/pembimbingBaru" method="POST" class="space-y-6">
        @csrf

        <!-- Prodi & Dosen -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

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

            <!-- Posisi -->
            <div>
                <label for="pembimbing" class="block text-sm font-medium text-gray-700 mb-1">Pembimbing</label>
                <select id="pembimbing" name="posisi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required disabled>
                    <option value="" disabled selected>-- Pilih Posisi --</option>
                </select>
            </div>
            
        </div>

        <!-- Tombol -->
        <div class="flex justify-between items-center ">
            <a href="/dashboard/daftarPembimbing"
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
    const prodiSelect = document.getElementById('prodi');
    const dosenSelect = document.getElementById('nip');
    const posisiSelect = document.getElementById('pembimbing');

    let currentDosenData = [];

    prodiSelect.addEventListener('change', function () {
        const kdProdi = this.value;

        fetch(`/get-dosen-by-prodi/${kdProdi}`)
            .then(response => response.json())
            .then(data => {
                currentDosenData = data;
                dosenSelect.innerHTML = '<option value="" disabled selected>-- Pilih Dosen --</option>';
                posisiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Posisi --</option>';
                posisiSelect.disabled = true;

                data.forEach(dosen => {
                    const option = document.createElement('option');
                    option.value = dosen.nip;
                    option.textContent = dosen.nama;
                    dosenSelect.appendChild(option);
                });

                dosenSelect.disabled = data.length === 0;
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Gagal mengambil data dosen.');
            });
    });

    dosenSelect.addEventListener('change', function () {
        const selectedNip = this.value;
        const selectedDosen = currentDosenData.find(d => d.nip === selectedNip);

        posisiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Posisi --</option>';

        if (!selectedDosen) {
            posisiSelect.disabled = true;
            return;
        }

        const posisiTerambil = selectedDosen.posisi_terambil || [];

        const semuaPosisi = ['Pembimbing 1', 'Pembimbing 2'];
        const posisiTersedia = semuaPosisi.filter(pos => !posisiTerambil.includes(pos));

        posisiTersedia.forEach(pos => {
            const option = document.createElement('option');
            option.value = pos;
            option.textContent = pos;
            posisiSelect.appendChild(option);
        });

        posisiSelect.disabled = posisiTersedia.length === 0;
    });

</script>


@endsection
