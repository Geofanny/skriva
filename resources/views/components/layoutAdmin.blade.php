<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Default Title' }}</title>
    <link rel="shortcut icon" href="{{ asset('asset/faviconn.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: '#5b21b6',
              sidebar: '#0f172a',
              surface: '#1e293b',
              highlight: '#3b82f6'
            }
          }
        }
      }
    </script>
  </head>
  <body class="h-screen flex bg-slate-900 text-white">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-sidebar text-sm p-4 flex flex-col transition-all duration-300">
      <div class="flex items-center space-x-2 mb-6">
        <img src="{{ asset('asset/faviconn.png') }}" class="h-8" alt="Logo">
        <a href="/mahasiswa"><span class="text-2xl font-bold">Skriva - Admin</span></a>
      </div>
      <nav class="flex-1 overflow-y-auto">
        <hr>
        <p class="text-gray-400 uppercase text-xs mb-2">Admin Skriva</p>
        <ul class="space-y-1">
          <li>
            <a href="#" class="flex items-center p-2 rounded hover:bg-slate-700">
              <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h18v18H3z" /></svg>
              Akun
              <span class="ml-auto text-orange-400 text-xs">●</span>
            </a>
            <ul class="ml-6 mt-1 space-y-1 text-gray-300">
              <li><a href="/pengajuanJudul" class="block p-1 pl-4 rounded hover:bg-slate-700">Manajemen Akun</a></li>
              <li><a href="/pengajuanBimbingan" class="block p-1 pl-4 rounded hover:bg-slate-700">Kelola Data Dosen</a></li>
              <li><a href="/pengajuanBimbingan" class="block p-1 pl-4 rounded hover:bg-slate-700">Kelola Data Mahasiswa</a></li>
              <li><a href="/pengajuanBimbingan" class="block p-1 pl-4 rounded hover:bg-slate-700">Kelola Data Dosen</a></li>
              <li><a href="/pengajuanBimbingan" class="block p-1 pl-4 rounded hover:bg-slate-700">Monitoring Aktivitas</a></li>
              <li><a href="/pengajuanBimbingan" class="block p-1 pl-4 rounded hover:bg-slate-700">Atur Jadwal Sidang</a></li>
              <li><a href="/pengajuanBimbingan" class="block p-1 pl-4 rounded hover:bg-slate-700">Kelola Quote/Login UI</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
      <!-- Topbar -->
      <header class="flex items-center justify-between bg-surface px-6 py-4 border-b border-slate-700 relative">
        <div class="text-lg font-semibold">Dashboard</div>
        <div class="flex items-center space-x-4">
          <input type="text" placeholder="Search" class="px-10 py-2 bg-slate-700 rounded placeholder-gray-400 focus:outline-none" />
          <div class="flex items-center space-x-2 relative">
            {{-- <img src="https://flagcdn.com/w40/gb.png" class="h-5 w-6 rounded-sm" alt="English"> --}}
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 48 48"><path stroke-linecap="r" stroke-linejoin="round" stroke-width="2" d="m32.8,29.3c-8.9-.8-16.2-7.8-17.5-16.6-.3-1.8-.3-3.7,0-5.4.2-1.4-1.4-2.3-2.5-1.6C6.3,9.7,2.1,16.9,2.5,25c.5,10.7,9,19.5,19.7,20.4,10.6.9,19.8-6,22.5-15.6.4-1.4-1-2.6-2.3-2-2.9,1.3-6.1,1.8-9.6,1.5Z" /></svg>
            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="h-8 w-8 rounded-full border-2 border-white cursor-pointer" alt="User" onclick="toggleDropdown()" />
            <div id="dropdown" class="absolute right-0 top-10 bg-slate-800 rounded shadow-md p-4 w-48 hidden">
              <p class="font-semibold">Geofanoy</p>
              <p class="text-sm text-gray-400 mb-2">Admin</p>
              <hr class="border-slate-700 my-2">
              <button class="block w-full text-left text-sm py-1 hover:text-highlight">Pengaturan Akun</button>
              <button class="block w-full text-left text-sm py-1 hover:text-highlight">Logout</button>
            </div>
          </div>
        </div>
      </header>

      <!-- Page content -->
      <main class="flex-1 bg-slate-900 p-6 overflow-y-auto">
        {{$slot}}
      </main>
    </div>

    <!-- Sidebar Toggle Button -->
    <button onclick="toggleSidebar()" id="toggle-button" class="absolute bottom-4 left-4 bg-slate-700 text-white px-3 py-2 rounded hover:bg-slate-600 transition-all">
      <span id="toggle-icon">✕</span>
    </button>

    <script>
      function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleIcon = document.getElementById('toggle-icon');

        if (sidebar.classList.contains('hidden')) {
          sidebar.classList.remove('hidden');
          sidebar.classList.add('w-64');
          toggleIcon.textContent = '✕';
        } else {
          sidebar.classList.add('hidden');
          sidebar.classList.remove('w-64');
          toggleIcon.textContent = '☰';
        }
      }

      function toggleDropdown() {
        const dropdown = document.getElementById('dropdown');
        dropdown.classList.toggle('hidden');
      }
    </script>
  </body>
</html>
