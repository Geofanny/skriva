<x-layoutDosen title="Daftar Mahasiswa">

    <main class="flex-1 bg-slate-900 p-6 overflow-y-auto text-white">
        <h1 class="text-2xl font-bold mb-6">Daftar Mahasiswa Bimbingan</h1>
      
        <!-- Search Bar -->
        <div class="mb-6">
          <input type="text" id="searchInput" onkeyup="filterMahasiswa()" placeholder="Cari mahasiswa..." class="w-full md:w-1/2 px-4 py-2 rounded-lg bg-slate-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
      
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4" id="mahasiswaList">
          <!-- Daftar Mahasiswa -->
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa1')">
            <p class="font-semibold">Fazri Azis</p>
            <p class="text-sm text-gray-400">NPM: 123456789</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa2')">
            <p class="font-semibold">Rina Lestari</p>
            <p class="text-sm text-gray-400">NPM: 987654321</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa3')">
            <p class="font-semibold">Andi Saputra</p>
            <p class="text-sm text-gray-400">NPM: 112233445</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa4')">
            <p class="font-semibold">Siti Aminah</p>
            <p class="text-sm text-gray-400">NPM: 556677889</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa5')">
            <p class="font-semibold">Budi Pratama</p>
            <p class="text-sm text-gray-400">NPM: 101112131</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa6')">
            <p class="font-semibold">Dewi Kartika</p>
            <p class="text-sm text-gray-400">NPM: 141516171</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa7')">
            <p class="font-semibold">Rizky Ananda</p>
            <p class="text-sm text-gray-400">NPM: 181920212</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa8')">
            <p class="font-semibold">Lina Marlina</p>
            <p class="text-sm text-gray-400">NPM: 222324252</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa9')">
            <p class="font-semibold">Wahyu Hidayat</p>
            <p class="text-sm text-gray-400">NPM: 262728293</p>
          </div>
          <div class="bg-slate-800 p-4 rounded-lg shadow-md hover:bg-slate-700 transition cursor-pointer" onclick="toggleDetail('mahasiswa10')">
            <p class="font-semibold">Melati Putri</p>
            <p class="text-sm text-gray-400">NPM: 303132333</p>
          </div>
        </div>
      
        <!-- Detail Mahasiswa (hanya contoh satu, bisa ditambahkan dinamis) -->
        <div id="mahasiswa1" class="mt-6 p-6 bg-slate-800 rounded-lg shadow-md hidden">
          <h2 class="text-xl font-semibold mb-4">Detail Mahasiswa</h2>
          <p class="text-gray-300">Nama: <span class="font-medium">Fazri Azis</span></p>
          <p class="text-gray-300">NPM: <span class="font-medium">123456789</span></p>
          <p class="text-gray-300">Email: <span class="font-medium">fazri@example.com</span></p>
          <p class="text-gray-300">Judul Skripsi: <span class="font-medium">Rancang Bangun Sistem Informasi Penjadwalan Skripsi</span></p>
          <p class="text-gray-300">Status: <span class="font-medium">Aktif Bimbingan</span></p>
          <p class="text-gray-300">Jumlah Pertemuan: <span class="font-medium">5</span></p>
          <button onclick="closeDetail()" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white">Kembali ke daftar</button>
        </div>
      </main>
      
      <script>
        function toggleDetail(id) {
          document.getElementById('mahasiswaList').classList.add('hidden');
          const allDetails = document.querySelectorAll('[id^="mahasiswa"]');
          allDetails.forEach(d => d.classList.add('hidden'));
          const detail = document.getElementById(id);
          if (detail) detail.classList.remove('hidden');
        }
      
        function closeDetail() {
          const allDetails = document.querySelectorAll('[id^="mahasiswa"]');
          allDetails.forEach(d => d.classList.add('hidden'));
          document.getElementById('mahasiswaList').classList.remove('hidden');
        }
      
        function filterMahasiswa() {
          const input = document.getElementById('searchInput');
          const filter = input.value.toLowerCase();
          const list = document.getElementById('mahasiswaList');
          const cards = list.querySelectorAll('div.cursor-pointer');
      
          cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(filter) ? "block" : "none";
          });
        }
      </script>
            </main>
      
    <x-chat-app-dosen></x-chat-app-dosen>
</x-layoutDosen>