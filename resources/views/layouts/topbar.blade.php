<header class="flex items-center justify-between bg-white px-6 py-4 shadow-sm border-b border-gray-200 relative">
  @php
    $user = null;
    $label = '';
    $id = '';
    $name = '';

    if (Auth::guard('pembimbing')->check()) {
        $pembimbing = Auth::guard('pembimbing')->user();
        $user = $pembimbing->dosen; // relasi ke dosen
        $label = 'NIP';
        $id = $user->nip ?? '-';
        $name = $user->nama ?? 'Pembimbing';
    } elseif (Auth::guard('koordinator')->check()) {
        $koordinator = Auth::guard('koordinator')->user();
        $user = $koordinator->dosen; // relasi ke dosen
        $label = 'NIP';
        $id = $user->nip ?? '-';
        $name = $user->nama ?? 'Koordinator';
    } elseif (Auth::guard('mahasiswa')->check()) {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $label = 'NPM';
        $id = $mahasiswa->npm ?? '-';
        $name = $mahasiswa->nama ?? 'Mahasiswa';
    } else {
        $user = Auth::user(); // admin via guard web
        $name = $user->name ?? 'Admin';
        $label = '';
        $id = '';
    }
  @endphp
  <div>
    <h1 class="text-2xl font-semibold text-gray-800">Selamat Datang, {{ $name }}</h1>
    <p class="text-sm text-gray-500 mt-1" id="date"></p>
  </div>

  <div class="flex items-center space-x-5">
    <!-- Notification Bell -->
    <button class="relative text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Notifications">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 00-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
    </button>

    
    <!-- User Avatar -->
    <div class="relative">
      @php
          use App\Models\Dosen;

          $mahasiswa = Auth::guard('mahasiswa')->user();
          $admin = Auth::guard('web')->user();
          $koordinasi = Auth::guard('koordinator')->user();
          $pembimbing = Auth::guard('pembimbing')->user();

          $dosenKoordinator = null;
          $dosenPembimbing = null;

          if ($koordinasi) {
              $dosenKoordinator = Dosen::where('nip', $koordinasi->nip)->first();
          }
          if ($pembimbing) {
              $dosenPembimbing = Dosen::where('nip', $pembimbing->nip)->first();
          }
      @endphp

      @if($mahasiswa)
        <img src="{{ $mahasiswa->foto ? asset('storage/fotoProfil/' . $mahasiswa->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
          class="h-9 w-9 rounded-full cursor-pointer border-2 border-cyan-700 hover:border-blue-500 transition duration-300"
          alt="User"
          onclick="toggleDropdown()" />
      @endif

      @if($dosenKoordinator)
      <img src="{{ $dosenKoordinator->foto ? asset('storage/fotoProfil/' . $dosenKoordinator->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
           class="h-9 w-9 rounded-full cursor-pointer border-2 border-cyan-700 hover:border-blue-500 transition duration-300"
           alt="User"
           onclick="toggleDropdown()" />
      @endif

      @if($dosenPembimbing)
      <img src="{{ $dosenPembimbing->foto ? asset('storage/fotoProfil/' . $dosenPembimbing->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
           class="h-9 w-9 rounded-full cursor-pointer border-2 border-cyan-700 hover:border-blue-500 transition duration-300"
           alt="User"
           onclick="toggleDropdown()" />
      @endif

      @if($admin)
        <img src="https://randomuser.me/api/portraits/men/75.jpg" class="h-9 w-9 rounded-full cursor-pointer border-2 border-cyan-700 hover:border-blue-500 transition duration-300" alt="User" onclick="toggleDropdown()" />
      @endif
      <!-- Dropdown -->
      <div id="dropdown" class="absolute right-0 top-12 bg-white rounded shadow-lg p-4 w-48 hidden border border-gray-200 z-50">

        <p class="font-semibold text-gray-800 capitalize">{{ $name }}</p>
        @if($label)
            <p class="text-sm text-gray-500 mb-2">{{ $label }}: {{ $id }}</p>
        @endif

        <hr class="border-gray-200 my-2" />
        @if(Auth::guard('mahasiswa')->check())
            @php
              $mahasiswa = Auth::guard('mahasiswa')->user();
              $punyaSkripsi = DB::table('skripsi')->where('npm', $mahasiswa->npm)->exists();
            @endphp
          <a href="/dashboard/profil" class="block w-full text-left text-sm py-1 text-gray-700 hover:text-blue-600 {{ !$punyaSkripsi ? 'pointer-events-none opacity-50' : '' }}">
            Pengaturan Akun
          </a>
        @endif
        @if(Auth::guard('pembimbing')->check())
          <a href="/mentor-access/profil" class="block w-full text-left text-sm py-1 text-gray-700 hover:text-blue-600">
            Pengaturan Akun
          </a>
        @endif
        @if(Auth::guard('koordinator')->check())
          <a href="/coord-panel/profil" class="block w-full text-left text-sm py-1 text-gray-700 hover:text-blue-600">
            Pengaturan Akun
          </a>
        @endif      
        <button class="block w-full text-left text-sm py-1 text-gray-700 hover:text-red-600" onclick="confirmLogout()">Logout</button>
      </div>
    </div>
  </div>
</header>

<script>
  // Tampilkan tanggal hari ini di topbar
  const dateElem = document.getElementById('date');
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  dateElem.textContent = new Date().toLocaleDateString('id-ID', options);


  function confirmLogout() {
    Swal.fire({
      title: 'Yakin ingin logout?',
      text: "Sesi Anda akan diakhiri.",
      imageUrl: '{{ asset("icon/logout.png") }}',
      imageWidth: 90,
      imageHeight: 90,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, logout',
      cancelButtonText: 'Batal',
      customClass: {
        image: 'mx-auto'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        // Loading dulu
        Swal.fire({
          title: 'Sedang logout...',
          text: 'Mohon tunggu sebentar',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        // Setelah 1.5 detik, ganti ke sukses
        setTimeout(() => {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil logout',
            showConfirmButton: false,
            timer: 1500,
            allowOutsideClick: false,
            allowEscapeKey: false
          }).then(() => {
            // Setelah sukses selesai, redirect logout
            window.location.href = "/logout";
          });
        }, 1500);
      }
    });
  }
</script>
