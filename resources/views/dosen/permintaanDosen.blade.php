<x-layoutDosen title="Permintaan Bimbingan">
    <main class="flex-1 bg-slate-900 p-6 overflow-y-auto text-white">
        <h1 class="text-2xl font-bold mb-6">Permintaan Bimbingan</h1>
      
        <div class="space-y-4">
          <div class="bg-slate-800 p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-lg font-semibold">Fazri Azis</h2>
                <p class="text-sm text-gray-400">Topik: Desain UI UX</p>
                <p class="text-sm text-gray-200">Tanggal : 19 April 2025</p>
                <p class="text-sm text-gray-400">Pesan: Saya ingin bimbingan untuk UI login page.</p>
              </div>
              <div class="space-x-2">
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Terima</button>
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Tolak</button>
              </div>
            </div>
          </div>
      
          <div class="bg-slate-800 p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center">
              <div>
                <h2 class="text-lg font-semibold">Indah Permata</h2>
                <p class="text-sm text-gray-400">Topik: Sistem Informasi Perpustakaan</p>
                <p class="text-sm text-gray-200">Tanggal : 19 April 2025</p>
                <p class="text-sm text-gray-400">Pesan: Mohon bimbingan untuk pengembangan modul admin.</p>
              </div>
              <div class="space-x-2">
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Terima</button>
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Tolak</button>
              </div>
            </div>
          </div>
        </div>
      </main>

      <x-chat-app-dosen></x-chat-app-dosen>

</x-layoutDosen>