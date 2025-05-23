<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Skriva - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <img src="{{ asset('asset/logo2.png') }}" alt="Logo" class="w-28" />
        <h1 class="text-white text-2xl font-bold">Skriva</h1>
        <p class="text-gray-300 mb-6 text-center text-sm italic">BIMBINGAN MUDAH, SKRIPSI LANCAR</p>
        <form class="w-full" method="POST" action="/login">
          @csrf
          <input type="text" name="username" placeholder="Username" class="w-full p-3 mb-4 rounded bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500" />
          <input type="password" name="password" placeholder="Password" class="w-full p-3 mb-4 rounded bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500" />
          <div class="flex items-center justify-between mb-4">
            <label class="flex items-center text-white">
              <input type="checkbox" class="mr-2" /> Remember me
            </label>
            <a href="#" class="text-green-400 text-sm hover:underline">Forgot password?</a>
          </div>
          <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded transition duration-300">Login</button>
        </form>
      </div>
    </div>
  </body>
</html>
