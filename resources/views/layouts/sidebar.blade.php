<!-- Sidebar -->
{{-- <aside id="sidebar"
  class="w-64 bg-cyan-800 text-sm p-4 flex flex-col transition-all duration-300 text-white"> --}}

  {{-- <aside id="sidebar"
  class="hidden lg:block w-64 bg-cyan-800 text-sm p-4 flex-col transition-all duration-300 text-white fixed z-40 h-full"> --}}

<aside id="sidebar" class="w-64 bg-cyan-800 text-sm p-4 flex-col transition-all duration-300 text-white fixed z-40 h-screen lg:translate-x-0 -translate-x-full lg:relative">


  <!-- Logo -->
  <div class="flex items-center space-x-2 pb-4 mb-6 border-b border-cyan-700">
    <img src="{{ asset('icon/logo2.png') }}" class="h-auto w-16" alt="Logo">
    <a href="#"><span class="text-2xl font-bold">Skriva</span></a>
  </div>

  <nav class="flex-1 space-y-6">
    @if(Auth::guard('mahasiswa')->check())

      @php
          $mahasiswa = Auth::guard('mahasiswa')->user();
          $punyaSkripsi = DB::table('skripsi')->where('npm', $mahasiswa->npm)->exists();
      @endphp

      <!-- DASHBOARD -->
      <ul class="space-y-1">
        <li>
          <a href="/dashboard" class="flex items-center py-1.5 px-2 rounded hover:bg-cyan-800 text-white hover:text-white
                  {{ !$punyaSkripsi ? 'pointer-events-none opacity-50' : '' }}" {!! !$punyaSkripsi ? 'title="Isi skripsi terlebih dahulu"' : '' !!}>
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
          </a>
        </li>
      </ul>

      <hr class="border-cyan-700 my-2">

      <!-- SKRIPSI -->
      <div>
        <p class="text-cyan-200 uppercase text-xs mb-2">Tugas Akhir</p>
        <ul class="space-y-1">

          <!-- Bimbingan -->
          <li x-data="{ open: false }">
            <button @click="open = !open"
                class="flex items-center p-2 w-full rounded hover:bg-cyan-800 text-white focus:outline-none {{ !$punyaSkripsi ? 'pointer-events-none opacity-50' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 8h2a2 2 0 0 1 2 2v10l-4-4H7a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Bimbingan</span>
                <svg class="w-4 h-4 ml-auto transform transition-transform duration-200"
                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        
            <ul x-show="open" class="ml-6 mt-2 space-y-1" x-cloak>
                <li>
                    <a href="/dashboard/bimbingan"
                        class="flex items-center p-2 rounded hover:bg-cyan-800 text-white
                            {{ !$punyaSkripsi ? 'pointer-events-none opacity-50' : '' }}"
                        {{ !$punyaSkripsi ? 'title=Isi skripsi terlebih dahulu' : '' }}>
                        
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 0 0 2-2V7H3v10a2 2 0 0 0 2 2z"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Ajuan & Jadwal
                    </a>
                </li>
                <li>
                    <a href="/dashboard/riwayat-ajuan"
                        class="flex items-center p-2 rounded hover:bg-cyan-800 text-white
                            {{ !$punyaSkripsi ? 'pointer-events-none opacity-50' : '' }}"
                        {{ !$punyaSkripsi ? 'title=Isi skripsi terlebih dahulu' : '' }}>
                        
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 7h18M3 12h18M3 17h18" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Riwayat Ajuan
                    </a>
                </li>
            </ul>
        </li>
        

          <!-- Skripsi -->
          <li>
            <a href="/dashboard/skripsi"
              class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V4.5A2.5 2.5 0 016.5 2h13a1.5 1.5 0 011.5 1.5V20a1.5 1.5 0 01-1.5 1.5H6.5A2.5 2.5 0 014 19.5z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h8M8 10h8M8 14h6" />
              </svg>            
              Skripsi
            </a>
          </li>

          <!-- Pembimbing -->
          <li>
            <a href="/dashboard/pembimbing"
              class="flex items-center p-2 rounded hover:bg-cyan-800 text-white
                      {{ !$punyaSkripsi ? 'pointer-events-none opacity-50' : '' }}"
              {{ !$punyaSkripsi ? 'title=Isi skripsi terlebih dahulu' : '' }}>
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m3-3a4 4 0 110-8 4 4 0 010 8zm8 0a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
              Pembimbing
            </a>
          </li>

        </ul>
      </div>


      {{-- <!-- DASHBOARD -->
      <ul class="space-y-1">
        <li>
          <a href="/dashboard" class="flex items-center py-1.5 px-2 rounded hover:bg-cyan-800 text-white hover:text-white">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
          </a>
        </li>
      </ul>

      <hr class="border-cyan-700 my-2">

      <!-- SKRIPSI -->
      <div>
        <p class="text-cyan-200 uppercase text-xs mb-2">Tugas Akhir</p>
        <ul class="space-y-1">

          <!-- Bimbingan -->
          <li>
            <a href="/dashboard/bimbingan" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 8h2a2 2 0 0 1 2 2v10l-4-4H7a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Bimbingan
            </a>
          </li>

          <!-- Skripsi -->
          <li>
            <a href="/dashboard/skripsi" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5V4.5A2.5 2.5 0 016.5 2h13a1.5 1.5 0 011.5 1.5V20a1.5 1.5 0 01-1.5 1.5H6.5A2.5 2.5 0 014 19.5z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h8M8 10h8M8 14h6" />
              </svg>            
              Skripsi
            </a>
          </li>

          <!-- Pembimbing -->
          <li>
            <a href="/dashboard/pembimbing" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m3-3a4 4 0 110-8 4 4 0 010 8zm8 0a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
              Pembimbing
            </a>
          </li>

        </ul>
      </div> --}}
    @endif

    @if(Auth::guard('koordinator')->check())
      <!-- DASHBOARD -->
      <ul class="space-y-1">
        <li>
          <a href="/coord-panel/dashboard" class="flex items-center py-1.5 px-2 rounded hover:bg-cyan-800 text-white hover:text-white">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
          </a>
        </li>
      </ul>

      <hr class="border-cyan-700 my-2">

      <!-- MAGEMENT -->
      <div>
        <p class="text-cyan-200 uppercase text-xs mb-2">Manajemen</p>
        <ul class="space-y-1">

          <!-- Pembimbing -->
          <li>
            <a href="/coord-panel/daftarPembimbing" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m3-3a4 4 0 110-8 4 4 0 010 8zm8 0a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
              Pembimbing
            </a>
          </li>

        </ul>
      </div>

      <hr class="border-cyan-700 my-2">

      <!-- MAGEMENT -->
      <div>
        <p class="text-cyan-200 uppercase text-xs mb-2">Monitoring</p>
        <ul class="space-y-1">

          <!-- Pembimbing -->
          <li>
            <a href="/coord-panel/monitoringBimbingan" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <!-- Ikon Kalender -->
              <svg class="w-5 h-5 mr-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M3 11h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
              </svg>
              Jadwal Bimbingan
            </a>
          </li>

        </ul>
      </div>
    @endif
    
    @if(Auth::guard('web')->check())
      <!-- DASHBOARD -->
      <ul class="space-y-1">
        <li>
          <a href="/sys-admin/dashboard" class="flex items-center py-1.5 px-2 rounded hover:bg-cyan-800 text-white hover:text-white">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
          </a>
        </li>
      </ul>
      <hr class="border-cyan-700 my-2">
      <!-- MANAJEMEN -->
      <div>
        <p class="text-cyan-200 uppercase text-xs mb-2">Manajemen</p>
        <ul class="space-y-1">
          <li>
            <a href="/sys-admin/daftarFakultas" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l9-6 9 6M4 10h16v2H4v-2zM6 12v6m4-6v6m4-6v6m4-6v6M4 18h16" />
              </svg>
              Fakultas
            </a>
          </li>                    
          <li>
            <a href="/sys-admin/daftarDosen" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 0C9 4 6 5 4 6v12c2-1 5-2 8-2s6 1 8 2V6c-2-1-5-2-8-2z" />
              </svg>
              Dosen
            </a>
          </li>
          <li>
            <a href="/sys-admin/daftarMahasiswa" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
              </svg>
              Mahasiswa
            </a>
          </li>
          <li>
            <a href="/sys-admin/daftarKoordinasi" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m3-3a4 4 0 110-8 4 4 0 010 8zm8 0a4 4 0 100-8 4 4 0 000 8z" />
              </svg>
              Koordinasi
            </a>
          </li>
        </ul>
      </div> 
      <hr class="border-cyan-700 my-2">
      <div>
          <p class="text-cyan-200 uppercase text-xs mb-2">Monitoring</p>
          <ul class="space-y-1">
              <li>
                  <a href="/sys-admin/statistik" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
                      <!-- Ikon Chart Bar -->
                      <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M9 17V9m4 8V5m4 12v-6" />
                      </svg>
                      Statistik Ajuan
                  </a>
              </li>
          </ul>
      </div>    
    @endif

    @if(Auth::guard('pembimbing')->check())
      <!-- DASHBOARD -->
      <ul class="space-y-1">
        <li>
          <a href="/mentor-access/dashboard" class="flex items-center py-1.5 px-2 rounded hover:bg-cyan-800 text-white hover:text-white">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            <span class="text-sm font-medium">Dashboard</span>
          </a>
        </li>
      </ul>
      <hr class="border-cyan-700 my-2">
      <!-- Bimbingan -->
      <div>
        <p class="text-cyan-200 uppercase text-xs mb-2">Bimbingan</p>
        <ul class="space-y-1">
          <li>
            <a href="/mentor-access/daftarAjuan" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <!-- Icon: Chat Plus -->
              <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 10h8m-4-4v8m6 4H7l-4 4V6a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2z" />
              </svg>
              Daftar Ajuan
            </a>
          </li>
          <li>
            <a href="/mentor-access/riwayatAjuan" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <!-- Icon: Chat Plus -->
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7h18M3 12h18M3 17h18" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
              Riwayat Ajuan
            </a>
          </li>
                         
          <li>
            <a href="/mentor-access/jadwalBimbingan" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
              <!-- Icon Calendar -->
              <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3M4 11h16M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
              </svg>
              Jadwal Bimbingan
            </a>
          </li>
        </ul>
      </div>
      <hr class="border-cyan-700 my-2">
      {{-- Monitoring --}}
      <div>
          <p class="text-cyan-200 uppercase text-xs mb-2">Monitoring</p>
          <ul class="space-y-1">
              <li>
                <a href="/mentor-access/daftarMahasiswa" class="flex items-center p-2 rounded hover:bg-cyan-800 text-white">
                  <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
                  </svg>
                  Mahasiswa
                </a>
              </li>
          </ul>
      </div> 
    @endif
  </nav>
</aside>