<x-dashboard.dashboard>
    <form class="rounded-2xl shadow-inner" method="POST" action="{{ route('pembimbing.store') }}">
        @csrf
        <h2 class="text-lg font-semibold text-white mb-6">🧾 Form Input Pembimbing</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-white mb-1">Program Studi</label>
                <select id="prodi" required
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
                    <option value="" disabled selected>Pilih Program Studi</option>
                    <optgroup label="FIPPS">
                        <option value="bimbingan dan konseling">Bimbingan dan Konseling</option>
                        <option value="pendidikan ekonomi">Pendidikan Ekonomi</option>
                        <option value="pendidikan sejarah">Pendidikan Sejarah</option>
                        <option value="bisnis digital">Bisnis Digital</option>
                        <option value="manajemen ritel">Manajemen Ritel</option>
                    </optgroup>
                    <optgroup label="FMIPA">
                        <option value="pendidikan matematika">Pendidikan Matematika</option>
                        <option value="pendidikan biologi">Pendidikan Biologi</option>
                        <option value="pendidikan fisika">Pendidikan Fisika</option>
                        <option value="sains data">Sains Data</option>
                    </optgroup>
                    <optgroup label="FTIK">
                        <option value="arsitektur">Arsitektur</option>
                        <option value="teknik industri">Teknik Industri</option>
                        <option value="teknik informatika">Teknik Informatika</option>
                        <option value="sistem informasi">Sistem Informasi</option>
                    </optgroup>
                    <optgroup label="FBS">
                        <option value="pendidikan bahasa dan sastra indonesia">Pendidikan Bahasa dan Sastra Indonesia</option>
                        <option value="pendidikan bahasa inggris">Pendidikan Bahasa Inggris</option>
                        <option value="desain komunikasi visual">Desain Komunikasi Visual</option>
                    </optgroup>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-1">Nama Dosen</label>
                <select name="nip" id="dosen" required disabled
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
                    <option value="" disabled selected>Pilih Dosen Pembimbing</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-1">Kategori</label>
                <select name="pembimbing" id="pembimbing" required disabled
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
                    <option value="" disabled selected>Pilih Jenis Pembimbing</option>
                </select>
            </div>            
        </div>

        <div class="mt-10 flex justify-between">
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
    const allDosen = @json($dosenPembimbing);

    const prodiSelect = document.getElementById('prodi');
    const dosenSelect = document.getElementById('dosen');
    const pembimbing = document.getElementById('pembimbing');

    function populateSelect(selectElement, items, defaultText) {
        selectElement.innerHTML = `<option value="" disabled selected>${defaultText}</option>`;
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.nip;
            option.textContent = item.nama;
            selectElement.appendChild(option);
        });
        selectElement.disabled = items.length === 0;
    }

    prodiSelect.addEventListener('change', function () {
        const selectedProdi = this.value.toLowerCase();

        const filteredDosen = allDosen.filter(d => d.prodi.toLowerCase() === selectedProdi);

        populateSelect(dosenSelect, filteredDosen, 'Pilih Dosen Pembimbing');

        pembimbing.disabled = filteredDosen.length === 0;
    });

    dosenSelect.addEventListener('change', function () {
        const selectedNip = this.value;

        const selectedDosen = allDosen.find(d => d.nip === selectedNip);

        pembimbing.innerHTML = '<option value="" disabled selected>Pilih Jenis Pembimbing</option>';

        if (selectedDosen && selectedDosen.kategori_tersedia.length > 0) {
            selectedDosen.kategori_tersedia.forEach(k => {
                const option = document.createElement('option');
                option.value = k;
                option.textContent = 'Pembimbing ' + k;
                pembimbing.appendChild(option);
            });

            pembimbing.disabled = false;
        } else {
            pembimbing.disabled = true;
        }
    });


</script>
@endpush

</x-dashboard.dashboard>
