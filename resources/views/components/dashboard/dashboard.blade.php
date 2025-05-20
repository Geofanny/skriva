<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Default Title' }}</title>
    <x-dashboard.link></x-dashboard.link>
    
    {{ $link ?? '' }}
    @stack('link')
    <style>
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }
    
      .animate-fade-in {
        animation: fadeIn 1s ease-out forwards;
      }
    </style>
    
  </head>
  <body class="flex bg-slate-900 text-white">

    <div id="loading-screen"  class="fixed inset-0 z-50 bg-slate-900 flex flex-col items-center justify-center text-center transition-opacity duration-700">
      <div class="animate-fade-in flex flex-col items-center">
        <img src="{{ asset('asset/logo2.png') }}" alt="Logo"
             class="w-auto h-40 drop-shadow-lg m-0 p-0 leading-none"
             style="display: block;">
        
        <h1 class="text-5xl font-extrabold text-white tracking-wide m-0 p-0 leading-none">Skriva</h1>
    
        <!-- Spinner -->
        <div class="mt-8 w-14 h-14 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
      </div>
    </div>
    


    <!-- Sidebar -->
    <x-dashboard.sidebar></x-dashboard.sidebar>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
      <!-- Topbar -->
      <x-dashboard.topbar></x-dashboard.topbar>

      <!-- Page content -->
      <main class="flex-1 bg-slate-900 p-6 overflow-y-auto">
        {{$slot}}
      </main>
    </div>

    <!-- Sidebar Toggle Button -->
    <button onclick="toggleSidebar()" id="toggle-button" class="absolute bottom-4 left-4 bg-slate-700 text-white px-3 py-2 rounded hover:bg-slate-600 transition-all">
      <span id="toggle-icon">✕</span>
    </button>

    <x-dashboard.script></x-dashboard.script>
    
    {{ $script ?? '' }}
    @stack('script')
  </body>
</html>
