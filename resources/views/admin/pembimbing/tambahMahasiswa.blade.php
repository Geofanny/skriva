<x-dashboard.dashboard title="Penambahan Mahasiswa Bimbingan">
    <form class="rounded-2xl shadow-inner" method="POST" action="/pembimbing/{{ $kode }}/mahasiswa">
        @csrf
        <div class="bg-slate-800 p-5 rounded-xl shadow-md mb-10 border border-slate-700">
            <h1 class="text-2xl font-bold text-white capitalize flex items-center mb-2">
                <span class="bg-amber-500 bg-opacity-20 p-2 rounded-full mr-3">
                    <i data-feather="user-check" class="w-6 h-6 text-amber-400"></i>
                </span>
                {{ $nama_pembimbing }} <span class="mx-2 text-slate-400">|</span> {{ $kategori }}
            </h1>
            <h3 class="text-slate-300 text-sm italic tracking-wide">{{ ucwords($prodi) }}</h3>
        </div>        
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <input type="number" name="jumlah" id="jumlah" required
    min="1" max="{{ $sisaKuota }}"
    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3"
    placeholder="Maksimal {{ $sisaKuota }} mahasiswa"
    oninput="validity.valid||(value='')">


            <div>
                <label class="block text-sm font-medium text-white mb-6">Metode Pemilihan</label>
                <div class="flex gap-6 text-white mt-2">
                    <label><input type="radio" name="metode" value="manual" checked> Manual</label>
                    <label><input type="radio" name="metode" value="acak"> Acak</label>
                </div>
            </div>
        </div>

        <div id="mahasiswaInputs" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6"></div>

        <div class="mt-7 flex justify-between">
            <a href="/pembimbing"
                class="bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-600 font-semibold">
                ← Kembali
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 font-semibold">
                Simpan
            </button>
        </div>
    </form>

    @push('script')
    <script>
        const allMahasiswa = @json($mahasiswa);
        const jumlahInput = document.getElementById('jumlah');
        const metodeRadios = document.getElementsByName('metode');
        const mahasiswaInputsContainer = document.getElementById('mahasiswaInputs');

        const filteredMahasiswa = allMahasiswa;

        jumlahInput.addEventListener('input', generateMahasiswaInputs);
        metodeRadios.forEach(r => r.addEventListener('change', generateMahasiswaInputs));

        function generateMahasiswaInputs() {
            const jumlah = parseInt(jumlahInput.value);
            const metode = document.querySelector('input[name="metode"]:checked')?.value;

            mahasiswaInputsContainer.innerHTML = '';
            if (!jumlah || jumlah < 1 || jumlah > 6 || filteredMahasiswa.length === 0) return;

            if (metode === 'manual') {
                for (let i = 0; i < jumlah; i++) {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = `
                        <label class="block text-sm font-medium text-white mb-1">Nama Mahasiswa (${i + 1})</label>
                        <select name="mahasiswa[]" required class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
                            <option value="" disabled selected>Pilih Mahasiswa</option>
                            ${filteredMahasiswa.map(m => `<option value="${m.npm}">${m.nama}</option>`).join('')}
                        </select>
                    `;
                    mahasiswaInputsContainer.appendChild(wrapper);
                }
            } else {
                const randomMahasiswa = filteredMahasiswa.sort(() => 0.5 - Math.random()).slice(0, jumlah);
                randomMahasiswa.forEach((m, index) => {
                    const card = document.createElement('div');
                    card.className = "bg-gray-700 rounded-xl p-4 text-white shadow-lg flex flex-col gap-1";

                    card.innerHTML = `
                        <div class="text-sm text-gray-400 mb-1">Mahasiswa ${index + 1}</div>
                        <div class="text-lg font-semibold">${m.nama}</div>
                        <div class="text-sm text-gray-300">NPM: ${m.npm}</div>
                        <input type="hidden" name="mahasiswa[]" value="${m.npm}">
                    `;
                    mahasiswaInputsContainer.appendChild(card);
                });
            }
        }
    </script>
    <script>
        const sisaKuota = {{ $sisaKuota }};
    
        function generateMahasiswaInputs() {
            let jumlah = parseInt(jumlahInput.value);
            const metode = document.querySelector('input[name="metode"]:checked')?.value;
    
            if (jumlah > sisaKuota) {
                alert(`Jumlah mahasiswa melebihi kuota! Maksimal hanya ${sisaKuota}.`);
                jumlahInput.value = sisaKuota;
                jumlah = sisaKuota;
            }
    
            mahasiswaInputsContainer.innerHTML = '';
            if (!jumlah || jumlah < 1 || filteredMahasiswa.length === 0) return;
    
            if (metode === 'manual') {
                for (let i = 0; i < jumlah; i++) {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = `
                        <label class="block text-sm font-medium text-white mb-1">Nama Mahasiswa (${i + 1})</label>
                        <select name="mahasiswa[]" required class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
                            <option value="" disabled selected>Pilih Mahasiswa</option>
                            ${filteredMahasiswa.map(m => `<option value="${m.npm}">${m.nama}</option>`).join('')}
                        </select>
                    `;
                    mahasiswaInputsContainer.appendChild(wrapper);
                }
            } else {
                const randomMahasiswa = filteredMahasiswa.sort(() => 0.5 - Math.random()).slice(0, jumlah);
                randomMahasiswa.forEach((m, index) => {
                    const card = document.createElement('div');
                    card.className = "bg-gray-700 rounded-xl p-4 text-white shadow-lg flex flex-col gap-1";
    
                    card.innerHTML = `
                        <div class="text-sm text-gray-400 mb-1">Mahasiswa ${index + 1}</div>
                        <div class="text-lg font-semibold">${m.nama}</div>
                        <div class="text-sm text-gray-300">NPM: ${m.npm}</div>
                        <input type="hidden" name="mahasiswa[]" value="${m.npm}">
                    `;
                    mahasiswaInputsContainer.appendChild(card);
                });
            }
        }
    </script>
    
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
    
    @endpush
</x-dashboard.dashboard>
