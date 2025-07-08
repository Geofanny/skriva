<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Skriva</title>
  <link rel="shortcut icon" href="{{ asset('icon/logo2.png') }}" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center relative overflow-hidden">

  <!-- Gelombang latar -->
  <div class="absolute bottom-0 w-full z-0">
    <svg viewBox="0 0 1440 320" class="w-full">
      <path fill="#013244" fill-opacity="1"
        d="M0,256L80,245.3C160,235,320,213,480,192C640,171,800,149,960,144C1120,139,1280,149,1360,154.7L1440,160L1440,320L0,320Z">
      </path>
    </svg>
  </div>

  <!-- Kotak login -->
  <div class="w-full max-w-5xl mx-auto z-10 bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl overflow-hidden grid grid-cols-1 md:grid-cols-2 border border-gray-200">

    <!-- Kiri: Form -->
    <div class="p-10 flex flex-col justify-center bg-white bg-opacity-90">
      <div class="flex flex-col items-center mb-2">
        <img src="{{ asset('icon/logo2.png') }}" alt="Logo" class="w-20 mb-2" />
        <h1 class="text-3xl font-bold text-gray-800">Skriva</h1>
        <p class="text-gray-600 text-sm italic">BIMBINGAN MUDAH, SKRIPSI LANCAR</p>
      </div>

      <form method="POST" action="/login" class="space-y-5">
        @csrf
        <input type="text" name="nip" placeholder="Username"
          class="w-full p-3 rounded-lg bg-gray-100 placeholder-gray-500 text-gray-800 focus:outline-none focus:ring-2 focus:ring-cyan-800" required />

        <div class="relative">
          <input type="password" name="password" id="password" placeholder="Kata Sandi"
            class="w-full p-3 pr-12 rounded-lg bg-gray-100 placeholder-gray-500 text-gray-800 focus:outline-none focus:ring-2 focus:ring-cyan-800" required />
          <button type="button" onclick="togglePassword()" class="absolute top-3 right-3 text-gray-600">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path id="eyeOpen2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>

        <div class="flex justify-between text-gray-600 text-sm">
          <label class="flex items-center">
            <input type="checkbox" class="mr-2 accent-green-600" /> Remember me
          </label>
        </div>

        <button type="submit"
          class="w-full bg-cyan-900 hover:bg-cyan-700 text-white font-semibold py-3 rounded-lg transition duration-300">
          Login
        </button>
      </form>
    </div>

    <!-- Kanan: Gambar -->
    <div class="hidden md:flex items-center justify-center bg-gradient-to-tr from-white via-white/80 to-gray-100">
      <img src="{{ asset('icon/logo4.png') }}" alt="Login Image" class="w-full object-contain" />
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.967 9.967 0 012.295-3.95M6.223 6.223A10.05 10.05 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.01 4.736M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
        `;
      } else {
        passwordInput.type = "password";
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }
  </script>
</body>
</html>
