@props(['title' => 'Dashboard Skriva'])
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? '' }}</title>
    
    @include('layouts/link')
  </head>
  <body class="h-screen flex flex-col lg:flex-row bg-slate-100 text-white overflow-hidden" id="body">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 z-50 bg-cyan-900 flex flex-col items-center justify-center text-center transition-opacity duration-700">
      <div class="animate-fade-in flex flex-col items-center">
        <img src="{{ asset('icon/logo2.png') }}" alt="Logo"
             class="w-auto h-40 drop-shadow-lg" />
        <h1 class="text-5xl font-extrabold text-white tracking-wide">Skriva</h1>
        <div class="mt-8 w-48 h-1 bg-gray-700 rounded overflow-hidden">
          <div class="h-full bg-white animate-loading-bar"></div>
        </div>
      </div>
    </div>

    <!-- Sidebar Backdrop (hanya untuk mobile) -->
  <div id="sidebar-backdrop" 
  class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"
  onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    @include('layouts/sidebar')

    <!-- Main wrapper -->
    
    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
      <!-- Topbar -->
      @include('layouts/topbar')

      <!-- Page content -->
      <main class="flex-1 w-full overflow-y-auto p-4 sm:p-6 md:p-6 bg-slate-50 text-slate-800">
        @yield('content')
      </main>
    </div>

    {{-- <!-- Sidebar Toggle Button -->
    <button onclick="toggleSidebar()" id="toggle-button" class="absolute bottom-4 left-4 bg-slate-700 text-white px-3 py-2 rounded hover:bg-slate-600 transition-all">
      <span id="toggle-icon">✕</span>
    </button> --}}
    <button onclick="toggleSidebar()" id="toggle-button"
      class="fixed bottom-4 left-4 lg:hidden bg-slate-700 text-white px-3 py-2 rounded hover:bg-slate-600 transition-all z-50 ">
      <span id="toggle-icon">☰</span>
    </button>


    @include('layouts/script')
  </body>
</html>
