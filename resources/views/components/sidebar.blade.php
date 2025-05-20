<!-- Sidebar Modern -->
<aside class="h-screen w-64 bg-gradient-to-br from-teal-700 to-cyan-900 shadow-md flex flex-col justify-between fixed left-0 top-0 z-40">
  <div>
    <div class="flex items-center gap-2 px-6 py-4 border-b">
      <img src="{{ asset('asset/faviconn.png') }}" class="h-10" alt="Logo">
      <span class="text-xl font-bold text-white">Skriva</span>
    </div>
    <nav class="mt-4">
      <a href="/mahasiswa" class="flex items-center gap-3 px-6 py-3 hover:bg-green-500 text-white font-medium transition">
        <i class="fas fa-home w-5 text-blue-600"></i> Dashboard
      </a>
      <div class="space-y-1">
        <button
          id="toggleSkripsi"
          class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transition"
        >
          <span class="flex items-center gap-3 px-6 py-3 text-white font-medium transition">
            <i data-lucide="graduation-cap" class="fas fa-home w-5 text-blue-600"></i>
            -> Pengajuan
          </span>
          <i id="iconSkripsi" data-lucide="chevron-down" class="w-4 h-4 text-white transition-transform"></i>
        </button>
      
        <div id="submenuSkripsi" class="ml-8 mt-1 space-y-1 hidden">
          <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transitionn">- Pengajuan Judul</a>
          <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transitionn">- Pengajuan Bimbingan</a>
        </div>
      </div>
      <a href="/jadwal-bimbingan" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transition">
        <i class="fas fa-user-check w-5 text-blue-600"></i> Jadwal Bimbingan
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transition">
        <i class="fas fa-chalkboard-teacher w-5 text-blue-600"></i> Jadwal Sidang
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transition">
        <i class="fas fa-users w-5 text-blue-600"></i> Dosen Pembimbing
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-white font-medium transition">
        <i class="fas fa-history w-5 text-blue-600"></i> Riwayat Bimbingan
      </a>
    </nav>
  </div>
  <div class="px-6 py-4">
    <a href="#" class="flex items-center gap-2 text-white hover:text-red-500 font-semibold">
      <i class="fas fa-sign-out-alt w-5"></i> Logout
    </a>
  </div>
</aside>

<script>
  document.getElementById("toggleSkripsi").addEventListener("click", () => {
    const submenu = document.getElementById("submenuSkripsi");
    const icon = document.getElementById("iconSkripsi");
    submenu.classList.toggle("hidden");
    icon.classList.toggle("rotate-180"); // animasi rotasi icon
  });
</script>
