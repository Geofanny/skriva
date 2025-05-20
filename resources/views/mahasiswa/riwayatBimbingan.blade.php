<x-layout title="Riwayat Bimbingan">

<main class="flex-1 bg-slate-900 p-6 overflow-y-auto">
    <h1 class="text-2xl font-bold mb-6 text-white">Riwayat Bimbingan</h1>
    <div class="bg-slate-800 p-6 rounded-lg shadow-md">
      <table class="min-w-full table-auto">
        <thead>
          <tr class="bg-slate-700 text-white text-left">
            <th class="px-4 py-2">Tanggal</th>
            <th class="px-4 py-2">Topik</th>
            <th class="px-4 py-2">Dosen Pembimbing</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Catatan Dosen</th>
          </tr>
        </thead>
        <tbody class="text-gray-300">
          <tr class="border-b border-slate-700">
            <td class="px-4 py-2">02 Mei 2025</td>
            <td class="px-4 py-2">Bab 1: Pendahuluan</td>
            <td class="px-4 py-2">Dosen Pembimbing 1</td>
            <td class="px-4 py-2">
              <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">Disetujui</span>
            </td>
            <td class="px-4 py-2">Lanjutkan ke Bab 2</td>
          </tr>
          <tr class="border-b border-slate-700">
            <td class="px-4 py-2">27 April 2025</td>
            <td class="px-4 py-2">Proposal Judul</td>
            <td class="px-4 py-2">Dosen Pembimbing 2</td>
            <td class="px-4 py-2">
              <span class="bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded">Revisi</span>
            </td>
            <td class="px-4 py-2">Perbaiki latar belakang</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
  
  <x-chat-app></x-chat-app>
</x-layout>