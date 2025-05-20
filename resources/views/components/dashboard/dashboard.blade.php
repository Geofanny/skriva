<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Default Title' }}</title>
    <x-dashboard.link></x-dashboard.link>
    
    {{ $link ?? '' }}
    @stack('link')
  </head>
  <body class="flex bg-slate-900 text-white">
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
