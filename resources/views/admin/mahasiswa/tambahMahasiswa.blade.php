<x-dashboard.dashboard>
    <form class="rounded-2xl shadow-inner" method="POST" action="{{ route('mahasiswa.store') }}">
        @csrf
        <h2 class="text-lg font-semibold text-white mb-6">🧾 Form Input Mahasiswa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-white mb-1">NPM</label>
                <input type="text" name="npm" placeholder="NPM"
                    pattern="^[0-9]{1,15}$" maxlength="16"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('npm') border-red-500 @enderror"
                    value="{{ old('npm') }}" />
                
                @error('nip')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>                  
            <div>
                <label class="block text-sm font-medium text-white mb-1">Nama</label>
                <input type="text" name="nama" placeholder="Nama lengkap"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required />
            </div>
            <div>
                <label class="block text-sm font-medium text-white mb-1">Program Studi</label>
                <select name="prodi" id="prodi" required
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
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
                <label class="block text-sm font-medium text-white mb-1">No HP</label>
                <input type="text" name="no_hp" placeholder="Nomor Handphone"
                    pattern="^[0-9]{1,14}$" maxlength="14" required
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
            </div>    
            <div>
                <label class="block text-sm font-medium text-white mb-1">Password</label>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
            </div>
        </div>

        <div class="mt-10 flex justify-between">
            <a href="/mahasiswa"
                class="bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-600 transition font-semibold">
                ← Kembali
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-8 py-3 rounded-xl shadow hover:bg-blue-700 transition duration-200 font-semibold">
                Simpan
            </button>
        </div>
    </form>
</x-dashboard.dashboard>
