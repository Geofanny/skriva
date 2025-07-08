<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skriva</title>
    <link rel="shortcut icon" href="{{ asset('icon/logo2.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@heroicons/vue@2.0.16/dist/heroicons.min.js"></script>
  </head>
  <body class="min-h-screen bg-gradient-to-br from-teal-700 to-cyan-900 flex items-center justify-center relative overflow-hidden">
    <!-- Gelombang latar -->
    <div class="absolute bottom-0 w-full">
      <svg viewBox="0 0 1440 320" class="w-full">
        <path
          fill="#013244"
          fill-opacity="1"
          d="M0,256L80,245.3C160,235,320,213,480,192C640,171,800,149,960,144C1120,139,1280,149,1360,154.7L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z" 
        ></path>
      </svg>
    </div>

    <div class="bg-white/10 backdrop-blur-md p-10 rounded-xl shadow-lg w-full max-w-md relative z-10">
      <div class="flex flex-col items-center">
        <img src="{{ asset('icon/logo2.png') }}" alt="Logo" class="w-28" />
        <h1 class="text-white text-2xl font-bold">Skriva</h1>
        <p class="text-gray-300 mb-6 text-center text-sm italic">BIMBINGAN MUDAH, SKRIPSI LANCAR</p>
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm mb-4">
            {{ session('error') }}
        </div>
        @endif
        <form class="w-full" method="POST" action="/login">
          @csrf
          <input type="text" name="npm" placeholder="Username" class="w-full p-3 mb-4 rounded bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500" />

          <div class="relative mb-4">
            <input 
              type="password" 
              name="password" 
              id="password" 
              placeholder="Kata Sandi" 
              class="w-full p-3 pr-12 rounded bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500" 
              required 
            />
            <button type="button" onclick="togglePassword()" class="absolute top-3 right-3 text-gray-600">
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path id="eyeOpen2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>

          <div class="flex items-center justify-between mb-4">
            <label class="flex items-center text-white">
              <input type="checkbox" class="mr-2" /> Remember me
            </label>
            {{-- <a href="#" class="text-green-400 text-sm hover:underline">Forgot password?</a> --}}
          </div>
          <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded transition duration-300">Login</button>
        </form>
      </div>
    </div>

    <script>
      function togglePassword() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.295-3.95M6.223 6.223A10.05 10.05 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.01 4.736M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
          `;
        } else {
          passwordInput.type = "password";
          eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          `;
        }
      }
    </script>
  </body>
</html>
