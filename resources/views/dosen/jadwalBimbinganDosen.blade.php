<x-layoutDosen title="Jadwal Bimbingan">

    <main class="flex-1 bg-slate-900 p-6 overflow-y-auto text-white">
        <h1 class="text-2xl font-bold mb-6">Jadwal Bimbingan & Detail</h1>
      
        <!-- Daftar Jadwal Bimbingan -->
        <div class="space-y-4 mb-10">
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('detail1')">
            <p class="text-white font-semibold">Fazri Azis - Senin, 6 Mei 2025 - 10:00 WIB</p>
            <p class="text-sm text-gray-400">Topik: Rancang Bangun Sistem Informasi Penjadwalan Skripsi</p>
          </div>
        </div>
      
        <!-- Detail Jadwal Tersembunyi -->
        <div id="detail1" class="bg-slate-800 p-6 rounded-lg shadow-md space-y-4 hidden">
          <div>
            <h2 class="text-xl font-semibold">Informasi Mahasiswa</h2>
            <p class="text-gray-300">Nama: <span class="font-medium">Fazri Azis</span></p>
            <p class="text-gray-300">NPM: <span class="font-medium">123456789</span></p>
            <p class="text-gray-300">Email: <span class="font-medium">fazri@example.com</span></p>
          </div>
      
          <div>
            <h2 class="text-xl font-semibold">Topik Bimbingan</h2>
            <p class="text-gray-300">Judul: <span class="font-medium">Rancang Bangun Sistem Informasi Penjadwalan Skripsi</span></p>
            <p class="text-gray-300">Deskripsi: <span class="font-medium">Sistem ini bertujuan memudahkan penjadwalan dan komunikasi antara mahasiswa dan dosen.</span></p>
          </div>
      
          <div>
            <h2 class="text-xl font-semibold">Jadwal</h2>
            <p class="text-gray-300">Tanggal: <span class="font-medium">Senin, 6 Mei 2025</span></p>
            <p class="text-gray-300">Waktu: <span class="font-medium">10:00 - 11:00</span></p>
            <p class="text-gray-300">Tempat: <span class="font-medium">Ruang Bimbingan 2 / Online via Zoom</span></p>
          </div>
      
          <div class="flex justify-end space-x-4">
            <button class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded">Mulai Bimbingan</button>
            <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">Batalkan</button>
          </div>
        </div>
      </main>
      
      <script>
        function toggleDetail(id) {
          const detail = document.getElementById(id);
          detail.classList.toggle('hidden');
        }
      </script>
      
      <x-chat-app-dosen></x-chat-app-dosen>
</x-layoutDosen>