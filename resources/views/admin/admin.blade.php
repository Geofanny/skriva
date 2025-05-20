<x-layoutAdmin title="Dashboard - Admin">

    <section class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-bold text-white">Manajemen Akun</h2>
          <button onclick="openModal('modalTambah')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Akun</button>
        </div>
      
        <div class="mb-4 flex items-center gap-2">
          <input type="text" id="searchInput" placeholder="Cari nama/email..." class="px-3 py-2 w-1/3 rounded bg-slate-700 text-white">
          <select id="roleFilter" class="px-3 py-2 rounded bg-slate-700 text-white">
            <option value="">Semua Role</option>
            <option value="dosen">Dosen</option>
            <option value="mahasiswa">Mahasiswa</option>
          </select>
        </div>
      
        <div class="overflow-auto bg-slate-800 rounded">
          <table class="w-full text-left text-white" id="akunTable">
            <thead class="bg-slate-700">
              <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b border-slate-600">
                <td class="px-4 py-2">Dr. Sinta Widya</td>
                <td class="px-4 py-2">sinta@skriva.ac.id</td>
                <td class="px-4 py-2">Dosen</td>
                <td class="px-4 py-2"><span class="bg-green-600 text-white px-2 py-1 rounded text-sm">Aktif</span></td>
                <td class="px-4 py-2 space-x-2">
                  <button onclick="confirmReset('Dr. Sinta Widya')" class="text-yellow-400 hover:underline">Reset</button>
                  <button onclick="openModal('modalEdit')" class="text-blue-400 hover:underline">Edit</button>
                  <button onclick="confirmDelete('Dr. Sinta Widya')" class="text-red-500 hover:underline">Hapus</button>
                </td>
              </tr>
              <!-- Tambahkan data lainnya -->
            </tbody>
          </table>
        </div>
      
        <!-- Modal Tambah Akun -->
        <div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white dark:bg-slate-800 p-6 rounded-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-white">Tambah Akun</h3>
            <input type="text" placeholder="Nama" class="w-full mb-2 px-3 py-2 rounded bg-slate-700 text-white">
            <input type="email" placeholder="Email" class="w-full mb-2 px-3 py-2 rounded bg-slate-700 text-white">
            <select class="w-full mb-4 px-3 py-2 rounded bg-slate-700 text-white">
              <option value="">Pilih Role</option>
              <option value="dosen">Dosen</option>
              <option value="mahasiswa">Mahasiswa</option>
            </select>
            <div class="flex justify-end gap-2">
              <button onclick="closeModal('modalTambah')" class="bg-gray-600 text-white px-4 py-2 rounded">Batal</button>
              <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
          </div>
        </div>
      
        <!-- Modal Edit Akun -->
        <div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white dark:bg-slate-800 p-6 rounded-lg w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-white">Edit Akun</h3>
            <input type="text" value="Dr. Sinta Widya" class="w-full mb-2 px-3 py-2 rounded bg-slate-700 text-white">
            <input type="email" value="sinta@skriva.ac.id" class="w-full mb-2 px-3 py-2 rounded bg-slate-700 text-white">
            <select class="w-full mb-4 px-3 py-2 rounded bg-slate-700 text-white">
              <option value="dosen" selected>Dosen</option>
              <option value="mahasiswa">Mahasiswa</option>
            </select>
            <div class="flex justify-end gap-2">
              <button onclick="closeModal('modalEdit')" class="bg-gray-600 text-white px-4 py-2 rounded">Batal</button>
              <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
          </div>
        </div>
      </section>
      
      <script>
        function openModal(id) {
          document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
          document.getElementById(id).classList.add('hidden');
        }
        function confirmReset(nama) {
          if (confirm(`Reset password akun ${nama}?`)) {
            alert('Password telah direset.');
          }
        }
        function confirmDelete(nama) {
          if (confirm(`Hapus akun ${nama}?`)) {
            alert('Akun telah dihapus.');
          }
        }
      </script>
      
   
</x-layoutAdmin>