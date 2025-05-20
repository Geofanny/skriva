<x-layout title="Bimbingan Online">

    <main class="flex-1 bg-slate-900 p-6 overflow-y-auto">
        <h1 class="text-2xl font-bold mb-6 text-white">Bimbingan Online</h1>
        <form class="bg-slate-800 p-6 rounded-lg shadow-md space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Tanggal Bimbingan</label>
            <input type="date" class="w-full px-4 py-2 rounded bg-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-highlight" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Topik Bimbingan</label>
            <input type="text" class="w-full px-4 py-2 rounded bg-slate-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-highlight" placeholder="Tuliskan topik pembahasan" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-1">Catatan atau Laporan</label>
            <textarea rows="5" class="w-full px-4 py-2 rounded bg-slate-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-highlight" placeholder="Unggah laporan bimbingan atau catatan progress..."></textarea>
          </div>
          <div class="flex justify-end">
            <button type="submit" class="bg-highlight text-white px-4 py-2 rounded hover:bg-blue-600 transition">Kirim Bimbingan</button>
          </div>
        </form>
      </main>
   
</x-layout>