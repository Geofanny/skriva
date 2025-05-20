<aside id="sidebar" class="w-64 bg-sidebar text-sm p-4 flex flex-col transition-all duration-300 text-white" x-data="{ openMenu: '' }">
  <!-- Logo -->
  <div class="flex items-center space-x-2 pb-4 mb-6 border-b border-gray-600">
    <img src="{{ asset('asset/logo2.png') }}" class="h-auto w-12" alt="Logo">
    <a href="/mahasiswa"><span class="text-2xl font-bold">Skriva</span></a>
  </div>

  <nav class="flex-1 space-y-6">

    <!-- Dashboard -->
    <ul class="space-y-1">
      <li>
        <a href="/dashboard" class="flex items-center py-1.5 px-2 rounded hover:bg-slate-700">
          <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
          </svg>
          <span class="text-sm font-medium">Dashboard</span>
        </a>
      </li>
    </ul>

    <hr class="border-gray-600 my-2">

    <!-- Skripsi -->
    <div>
      <p class="text-gray-400 uppercase text-xs mb-2">Skripsi</p>
      <ul class="space-y-1">

        <!-- Pengajuan -->
        <li>
          <button @click="openMenu = openMenu === 'pengajuan' ? '' : 'pengajuan'" class="w-full flex items-center p-2 rounded hover:bg-slate-700">
            <svg class="w-5 h-5 mr-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Pengajuan
            <svg class="ml-auto w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-90': openMenu === 'pengajuan' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
          <ul x-show="openMenu === 'pengajuan'" x-transition class="ml-8 mt-1 space-y-1 text-gray-300">
            <li>
                <a href="/pengajuanJudul" class="flex items-center p-1 rounded hover:bg-slate-700">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 12H9m6 4H9m9 4H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Pengajuan Judul
                </a>
            </li>
            <li>
                <a href="/pengajuanBimbingan" class="flex items-center p-1 rounded hover:bg-slate-700">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 3H5a2 2 0 0 0-2 2v14l4-4h9a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Pengajuan Bimbingan
                </a>
            </li>
            <!-- Menu Daftar Judul -->
            <li>
                <a href="/daftarJudul" class="flex items-center p-1 rounded hover:bg-slate-700">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M15 12H9m6 4H9m9 4H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Daftar Pengajuan Judul
                </a>
            </li>
        </ul>
        
        </li>

        <!-- Bimbingan -->
        <li>
          <button @click="openMenu = openMenu === 'bimbingan' ? '' : 'bimbingan'" class="w-full flex items-center p-2 rounded hover:bg-slate-700">
            <svg class="w-5 h-5 mr-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M17 8h2a2 2 0 0 1 2 2v10l-4-4H7a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Bimbingan
            <svg class="ml-auto w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-90': openMenu === 'bimbingan' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
          <ul x-show="openMenu === 'bimbingan'" x-transition class="ml-8 mt-1 space-y-1 text-gray-300">
            <li>
              <a href="/bimbinganOnline" class="flex items-center p-1 rounded hover:bg-slate-700">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M15 10l4.5-2.3A1 1 0 0121 8.6v6.8a1 1 0 01-1.5.9L15 14m-1 6H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v12z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Bimbingan Online
              </a>
            </li>
            <li>
              <a href="/riwayatBimbingan" class="flex items-center p-1 rounded hover:bg-slate-700">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M12 8v4l3 3M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Riwayat Bimbingan
              </a>
            </li>
          </ul>
        </li>
        <!-- Menu Dosen -->
  <li>
    <a href="/dosen" class="flex items-center p-2 rounded hover:bg-slate-700 text-gray-300">
      <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 0C9 4 6 5 4 6v12c2-1 5-2 8-2s6 1 8 2V6c-2-1-5-2-8-2z" />
      </svg>
      Dosen
    </a>
  </li>

  <!-- Menu Mahasiswa -->
  <li>
    <a href="/mahasiswa" class="flex items-center p-2 rounded hover:bg-slate-700 text-gray-300">
      <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
      </svg>
      Mahasiswa
    </a>
  </li>


  <!-- Menu Pembimbing -->
  <li>
    <a href="/pembimbing" class="flex items-center p-2 rounded hover:bg-slate-700 text-gray-300">
      <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m3-3a4 4 0 110-8 4 4 0 010 8zm8 0a4 4 0 100-8 4 4 0 000 8z" />
      </svg>
      Pembimbing
    </a>
  </li>
      </ul>
    </div>

    <hr class="border-gray-600 my-2">

    <!-- Pembimbing Akademik -->
    <div>
      <p class="text-gray-400 uppercase text-xs mb-2">Pembimbing Akademik</p>
      <ul class="space-y-1">
        <li>
          <button @click="openMenu = openMenu === 'pembimbing' ? '' : 'pembimbing'" class="w-full flex items-center p-2 rounded hover:bg-slate-700">
            <svg class="w-5 h-5 mr-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v12z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Pembimbing Akademik
            <svg class="ml-auto w-4 h-4 transform" :class="{ 'rotate-90': openMenu === 'pembimbing' }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M9 5l7 7-7 7"/>
            </svg>
          </button>
          <ul x-show="openMenu === 'pembimbing'" x-transition class="ml-8 mt-1 space-y-1 text-gray-300">
            <li>
              <a href="/detailDosen" class="flex items-center p-1 rounded hover:bg-slate-700">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M5.1 17.8A9 9 0 0112 15a9 9 0 015.3 1.8M15 12a3 3 0 100-6 3 3 0 000 6z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Detail Dosen
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    <hr class="border-gray-600 my-2">

    <!-- Laporan -->
    <div>
      <p class="text-gray-400 uppercase text-xs mb-2">Laporan</p>
      <ul class="space-y-1">
        <li>
          <a href="/laporanKemajuan" class="flex items-center p-2 rounded hover:bg-slate-700">
            <svg class="w-5 h-5 mr-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M5 13l4 4L19 7"/>
            </svg>
            Laporan Kemajuan
          </a>
        </li>
      </ul>
    </div>

  </nav>
</aside>
