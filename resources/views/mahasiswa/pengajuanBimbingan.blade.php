<x-layout title="Pengajuan Bimbingan">
<main class="flex-1 bg-slate-900 p-6 overflow-y-auto">
    <h1 class="text-2xl font-bold mb-6 text-white">Pengajuan Bimbingan</h1>
    <form class="bg-slate-800 p-6 rounded-lg shadow-md space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-300 mb-1">Pilih Dosen Pembimbing</label>
        <div class="flex space-x-4">
          <label class="flex items-center space-x-2 text-white">
            <input type="radio" name="dospem" value="1" class="form-radio text-highlight focus:ring-highlight" />
            <span>Dosen Pembimbing 1</span>
          </label>
          <label class="flex items-center space-x-2 text-white">
            <input type="radio" name="dospem" value="2" class="form-radio text-highlight focus:ring-highlight" />
            <span>Dosen Pembimbing 2</span>
          </label>
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-300 mb-1">Topik Bimbingan</label>
        <input type="text" class="w-full px-4 py-2 rounded bg-slate-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-highlight" placeholder="Masukkan topik yang ingin dibimbing" />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-300 mb-1">Pesan Tambahan</label>
        <textarea rows="4" class="w-full px-4 py-2 rounded bg-slate-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-highlight" placeholder="Tuliskan pesan atau pertanyaan untuk dosen..."></textarea>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="bg-highlight text-white px-4 py-2 rounded hover:bg-blue-600 transition">Kirim Permintaan</button>
      </div>
    </form>
  </main>
  
<x-chat-app></x-chat-app>
</x-layout>