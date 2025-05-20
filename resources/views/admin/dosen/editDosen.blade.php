<x-dashboard.dashboard>
    <form class="rounded-2xl shadow-inner" method="POST" action="{{ route('dosen.update', $dosen->token) }}">
        @csrf
        @method('PUT')

        <h2 class="text-lg font-semibold text-white mb-6">🧾 Form Edit Dosen</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-white mb-1">NIP</label>
                <input type="text" name="nip" placeholder="NIP"
                    pattern="^[0-9]{1,16}$" maxlength="16"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('nip') border-red-500 @enderror"
                    value="{{ old('nip', $dosen->nip) }}" />

            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-1">Nama</label>
                <input type="text" name="nama" placeholder="Nama lengkap"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    value="{{ old('nama', $dosen->nama) }}" required />
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-1">Program Studi</label>
                <select name="prodi" id="prodi" required
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="" disabled>Pilih Program Studi</option>
                    <optgroup label="FIPPS">
                        <option value="bimbingan dan konseling" {{ old('prodi', $dosen->prodi) == 'bimbingan dan konseling' ? 'selected' : '' }}>Bimbingan dan Konseling</option>
                        <option value="pendidikan ekonomi" {{ old('prodi', $dosen->prodi) == 'pendidikan ekonomi' ? 'selected' : '' }}>Pendidikan Ekonomi</option>
                        <option value="pendidikan sejarah" {{ old('prodi', $dosen->prodi) == 'pendidikan sejarah' ? 'selected' : '' }}>Pendidikan Sejarah</option>
                        <option value="bisnis digital" {{ old('prodi', $dosen->prodi) == 'bisnis digital' ? 'selected' : '' }}>Bisnis Digital</option>
                        <option value="manajemen ritel" {{ old('prodi', $dosen->prodi) == 'manajemen ritel' ? 'selected' : '' }}>Manajemen Ritel</option>
                    </optgroup>
                    <optgroup label="FMIPA">
                        <option value="pendidikan matematika" {{ old('prodi', $dosen->prodi) == 'pendidikan matematika' ? 'selected' : '' }}>Pendidikan Matematika</option>
                        <option value="pendidikan biologi" {{ old('prodi', $dosen->prodi) == 'pendidikan biologi' ? 'selected' : '' }}>Pendidikan Biologi</option>
                        <option value="pendidikan fisika" {{ old('prodi', $dosen->prodi) == 'pendidikan fisika' ? 'selected' : '' }}>Pendidikan Fisika</option>
                        <option value="sains data" {{ old('prodi', $dosen->prodi) == 'sains data' ? 'selected' : '' }}>Sains Data</option>
                    </optgroup>
                    <optgroup label="FTIK">
                        <option value="arsitektur" {{ old('prodi', $dosen->prodi) == 'arsitektur' ? 'selected' : '' }}>Arsitektur</option>
                        <option value="teknik industri" {{ old('prodi', $dosen->prodi) == 'teknik industri' ? 'selected' : '' }}>Teknik Industri</option>
                        <option value="teknik informatika" {{ old('prodi', $dosen->prodi) == 'teknik informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                        <option value="sistem informasi" {{ old('prodi', $dosen->prodi) == 'sistem informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    </optgroup>
                    <optgroup label="FBS">
                        <option value="pendidikan bahasa dan sastra indonesia" {{ old('prodi', $dosen->prodi) == 'pendidikan bahasa dan sastra indonesia' ? 'selected' : '' }}>Pendidikan Bahasa dan Sastra Indonesia</option>
                        <option value="pendidikan bahasa inggris" {{ old('prodi', $dosen->prodi) == 'pendidikan bahasa inggris' ? 'selected' : '' }}>Pendidikan Bahasa Inggris</option>
                        <option value="desain komunikasi visual" {{ old('prodi', $dosen->prodi) == 'desain komunikasi visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                    </optgroup>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-1">No HP</label>
                <input type="text" name="no_hp" placeholder="Nomor Handphone"
                    pattern="^[0-9]{1,14}$" maxlength="14" required
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    value="{{ old('no_hp', $dosen->no_hp) }}" />
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-1">Password <span class="text-sm text-gray-400">(isi jika ingin mengganti)</span></label>
                <input type="password" name="password" placeholder="Password"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
            </div>
        </div>

        <div class="mt-10 flex justify-between">
            <a href="{{ route('dosen.index') }}"
                class="bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-600 transition font-semibold">
                ← Kembali
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-xl shadow hover:bg-blue-700 transition duration-200 font-semibold">
                Simpan Perubahan
            </button>
        </div>
    </form>
</x-dashboard.dashboard>
