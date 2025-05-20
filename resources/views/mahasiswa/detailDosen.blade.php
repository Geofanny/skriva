<x-layout title="Detail Dosen">
    <main class="flex-1 bg-slate-900 p-6 overflow-y-auto text-white">
        <h1 class="text-2xl font-bold mb-6">Detail Dosen Pembimbing</h1>
      
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Dosen 1 -->
          <div class="bg-slate-800 rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4 mb-4">
              <img src="https://via.placeholder.com/80" alt="Foto Dosen" class="rounded-full w-20 h-20 object-cover" />
              <div>
                <h2 class="text-xl font-semibold">Dr. Ir. Ahmad Syafii, M.Kom</h2>
                <p class="text-sm text-gray-300">NIP: 19800901 202001 1 001</p>
                <p class="text-sm text-gray-300">Email: ahmad.syafii@univ.ac.id</p>
              </div>
            </div>
            <p class="text-gray-300 mb-2">Dosen Pembimbing 1 dengan latar belakang Teknologi Informasi dan fokus riset pada Sistem Informasi, IoT dan Big Data. Memiliki pengalaman lebih dari 10 tahun dalam membimbing skripsi dan publikasi ilmiah.</p>
            <ul class="text-gray-300 text-sm list-disc pl-6">
              <li>Keahlian: Laravel, Data Mining, Machine Learning</li>
              <li>Jam Bimbingan: Senin & Rabu, 10.00 - 13.00 WIB</li>
              <li>Lokasi: Gedung B Lantai 3, Ruang 305</li>
            </ul>
          </div>
      
          <!-- Dosen 2 -->
          <div class="bg-slate-800 rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4 mb-4">
              <img src="https://via.placeholder.com/80" alt="Foto Dosen" class="rounded-full w-20 h-20 object-cover" />
              <div>
                <h2 class="text-xl font-semibold">Dr. Rika Handayani, M.T</h2>
                <p class="text-sm text-gray-300">NIP: 19761205 200012 2 002</p>
                <p class="text-sm text-gray-300">Email: rika.handayani@univ.ac.id</p>
              </div>
            </div>
            <p class="text-gray-300 mb-2">Dosen Pembimbing 2 dengan spesialisasi dalam pengembangan perangkat lunak dan rekayasa sistem. Berpengalaman dalam proyek-proyek penelitian nasional dan pengembangan aplikasi edukasi.</p>
            <ul class="text-gray-300 text-sm list-disc pl-6">
              <li>Keahlian: React, UI/UX, Software Engineering</li>
              <li>Jam Bimbingan: Selasa & Kamis, 13.00 - 16.00 WIB</li>
              <li>Lokasi: Gedung A Lantai 2, Ruang 210</li>
            </ul>
          </div>
        </div>
      </main>
      <x-chat-app></x-chat-app>
</x-layout>      