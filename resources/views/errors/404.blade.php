<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>404 - Halaman Tidak Ditemukan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-700 to-cyan-900 flex items-center justify-center px-6 text-gray-100">

  <div class="text-center max-w-md">
    <h1 class="text-9xl font-extrabold text-red-600 mb-6 drop-shadow-lg">404</h1>
    <h2 class="text-3xl font-semibold mb-4 text-white drop-shadow-md">
      Halaman Tidak Ditemukan
    </h2>
    <p class="text-gray-300 mb-8">
      Maaf, halaman yang Anda cari tidak tersedia atau mungkin sudah dipindahkan.
    </p>
    <a 
      href="javascript:void(0)" 
      onclick="if(document.referrer) { window.location = document.referrer; window.location.reload(); } else { window.history.back(); }" 
      class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg shadow transition"
    >
      Kembali ke Halaman Sebelumnya
    </a>
  </div>

</body>
</html>
