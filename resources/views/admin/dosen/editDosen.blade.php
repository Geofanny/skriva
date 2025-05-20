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
                    <option value="" disabled {{ old('prodi', $dosen->prodi) == '' ? 'selected' : '' }}>Pilih Program Studi</option>
            
                    <optgroup label="FIPPS">
                        <option value="Bimbingan dan Konseling" {{ old('prodi', $dosen->prodi) == 'Bimbingan dan Konseling' ? 'selected' : '' }}>Bimbingan dan Konseling</option>
                        <option value="Pendidikan Ekonomi" {{ old('prodi', $dosen->prodi) == 'Pendidikan Ekonomi' ? 'selected' : '' }}>Pendidikan Ekonomi</option>
                        <option value="Pendidikan Sejarah" {{ old('prodi', $dosen->prodi) == 'Pendidikan Sejarah' ? 'selected' : '' }}>Pendidikan Sejarah</option>
                        <option value="Bisnis Digital" {{ old('prodi', $dosen->prodi) == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
                        <option value="Manajemen Ritel" {{ old('prodi', $dosen->prodi) == 'Manajemen Ritel' ? 'selected' : '' }}>Manajemen Ritel</option>
                    </optgroup>
            
                    <optgroup label="FMIPA">
                        <option value="Pendidikan Matematika" {{ old('prodi', $dosen->prodi) == 'Pendidikan Matematika' ? 'selected' : '' }}>Pendidikan Matematika</option>
                        <option value="Pendidikan Biologi" {{ old('prodi', $dosen->prodi) == 'Pendidikan Biologi' ? 'selected' : '' }}>Pendidikan Biologi</option>
                        <option value="Pendidikan Fisika" {{ old('prodi', $dosen->prodi) == 'Pendidikan Fisika' ? 'selected' : '' }}>Pendidikan Fisika</option>
                        <option value="Sains Data" {{ old('prodi', $dosen->prodi) == 'Sains Data' ? 'selected' : '' }}>Sains Data</option>
                    </optgroup>
            
                    <optgroup label="FTIK">
                        <option value="Arsitektur" {{ old('prodi', $dosen->prodi) == 'Arsitektur' ? 'selected' : '' }}>Arsitektur</option>
                        <option value="Teknik Industri" {{ old('prodi', $dosen->prodi) == 'Teknik Industri' ? 'selected' : '' }}>Teknik Industri</option>
                        <option value="Teknik Informatika" {{ old('prodi', $dosen->prodi) == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                        <option value="Sistem Informasi" {{ old('prodi', $dosen->prodi) == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    </optgroup>
            
                    <optgroup label="FBS">
                        <option value="Pendidikan Bahasa dan Sastra Indonesia" {{ old('prodi', $dosen->prodi) == 'Pendidikan Bahasa dan Sastra Indonesia' ? 'selected' : '' }}>Pendidikan Bahasa dan Sastra Indonesia</option>
                        <option value="Pendidikan Bahasa Inggris" {{ old('prodi', $dosen->prodi) == 'Pendidikan Bahasa Inggris' ? 'selected' : '' }}>Pendidikan Bahasa Inggris</option>
                        <option value="Desain Komunikasi Visual" {{ old('prodi', $dosen->prodi) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
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
