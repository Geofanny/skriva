<x-dashboard.dashboard>
  <form class="rounded-2xl shadow-inner" method="POST" action="/ajukan">
      @csrf

      <div class="bg-slate-800 p-5 rounded-xl shadow-md mb-10 border border-slate-700">
          <h1 class="text-2xl font-bold text-white capitalize flex items-center mb-2">
              <span class="bg-amber-500 bg-opacity-20 p-2 rounded-full mr-3">
                  <i data-feather="edit-3" class="w-6 h-6 text-amber-400"></i>
              </span>
              Form Pengajuan Judul
          </h1>
          <p class="text-slate-300 text-sm italic">Isi maksimal 3 judul yang ingin diajukan.</p>
      </div>

      <div class="flex gap-6 mb-6">
        <!-- Input Jumlah Judul -->
        <div class="w-1/2">
            <label for="jumlah_judul" class="block text-sm font-medium text-white mb-2">Jumlah Judul</label>
            <input
                type="number"
                id="jumlah_judul"
                name="jumlah_judul"
                min="1"
                max="3"
                placeholder="Masukkan jumlah (1-3)"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3"
                required
                oninput="validity.valid||(value='')"
            >
        </div>
    
        <!-- Select Kategori -->
        <div class="w-1/2">
            <label for="kategori" class="block text-sm font-medium text-white mb-2">Kategori Skripsi</label>
            <select name="kategori" id="kategori" required
                class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="e-commerce">E-Commerce</option>
                <option value="analisis dan perancangan">Analisis dan Perancangan</option>
                <option value="rancang bangun sistem">Rancang Bangun Sistem</option>
            </select>
        </div>
    </div>
    

      <div id="judulInputs" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"></div>

      <div class="flex justify-between">
          <button type="submit"
                  class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 font-semibold">
              Ajukan
          </button>
      </div>
  </form>

  @push('script')
  <script>
      const judulInput = document.getElementById('jumlah_judul');
      const judulContainer = document.getElementById('judulInputs');

      judulInput.addEventListener('input', function () {
          let jumlah = parseInt(this.value);

          if (jumlah > 3) {
              alert("Maksimal hanya 3 judul.");
              this.value = 3;
              jumlah = 3;
          }

          judulContainer.innerHTML = '';

          if (!jumlah || jumlah < 1) return;

          for (let i = 0; i < jumlah; i++) {
              const wrapper = document.createElement('div');
              wrapper.innerHTML = `
                  <label class="block text-sm font-medium text-white mb-1">Judul ${i + 1}</label>
                  <input type="text" name="judul[]" required
                      placeholder="Masukkan Judul ${i + 1}"
                      class="w-full bg-gray-800 text-white border border-gray-600 rounded-xl px-4 py-3">
              `;
              judulContainer.appendChild(wrapper);
          }
      });
  </script>

  <script src="https://unpkg.com/feather-icons"></script>
  <script>feather.replace();</script>
  @endpush


  {{-- @push('link')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
      .dataTables_length select {
          color: black; 
          background-color: white;
      }

      .dataTables_length select option {
          background-color: white;
          color: black;
      }
  </style>
@endpush

<h2 class="text-3xl font-bold text-white mb-6">📋 Judul Skripsi</h2>

<a href="#"
 class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition mb-5">
  Tambah Pembimbing +
</a>

<div class="bg-slate-800 p-4 rounded-xl capitalize overflow-x-auto border border-slate-700">
  <table id="dosenTable" class="min-w-full divide-y divide-slate-700 text-sm text-black">
      <thead class="bg-slate-700 text-gray-100 uppercase text-xs font-semibold">
          <tr>
              <th class="px-6 py-3 text-left">No</th>
              <th class="px-6 py-3 text-left">Kode Bimbingan</th>
              <th class="px-6 py-3 text-left">Dosen Pembimbing</th>
              <th class="px-6 py-3 text-left">Kategori</th>
              <th class="px-6 py-3 text-left">Mahasiswa</th>
              <th class="px-6 py-3 text-left">Aksi</th>
          </tr>
      </thead>
      <tbody class="divide-y divide-slate-700">
          <tr class="hover:bg-slate-700 group transition">
              <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">1</td>
              <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">BIM001</td>
              <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">Dr. Andi Wijaya</td>
              <td class="px-6 py-4 font-medium text-gray-800 group-hover:text-white">Pembimbing 1</td>
              <td class="px-6 py-4 font-medium text-center text-gray-800 group-hover:text-white">
                  3 | 
                  <button 
                      onclick="document.getElementById('modal-BIM001').classList.remove('hidden')"
                      class="text-blue-700 group-hover:text-blue-200 font-semibold">
                      Lihat Detail
                  </button>
              </td>
              <td class="px-6 py-4 space-x-2">
                  <a href="#" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded text-white text-xs">
                      <i data-feather="user-plus" class="w-4 h-4 mr-1"></i> Mahasiswa
                  </a>
                  <form action="#" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                      <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-white text-xs">
                          <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
                      </button>
                  </form>
              </td>
          </tr>
      </tbody>
  </table>

  <!-- Modal -->
  <div id="modal-BIM001" class="fixed hidden inset-0 bg-gradient-to-br from-black/80 to-gray-900/90 z-50 flex items-center justify-center px-4">
      <div class="bg-white dark:bg-gray-800 w-full max-w-xl rounded-2xl shadow-2xl p-8 relative text-gray-900 dark:text-gray-100">
          <h3 class="text-2xl font-extrabold mb-6 flex items-center gap-3">
              <span class="text-blue-600">📋</span> Daftar Mahasiswa | Sistem Informasi
          </h3>
          <div class="flex justify-between items-center mb-4">
              <p class="text-md text-gray-700 dark:text-gray-300">
                  Dosen Pembimbing: <strong class="text-blue-600">Dr. Andi Wijaya</strong>
              </p>
              <button 
                  onclick="printModal('BIM001')" 
                  class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg shadow-md transition"
                  aria-label="Cetak Daftar Mahasiswa">
                  🖨 Cetak
              </button>
          </div>
          
          <button 
              onclick="document.getElementById('modal-BIM001').classList.add('hidden')" 
              class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white font-bold text-2xl leading-none"
              aria-label="Tutup Modal">
              &times;
          </button>
          <div class="overflow-x-auto rounded-lg border border-gray-300 dark:border-gray-600 shadow-inner">
              <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                  <thead class="bg-blue-100 dark:bg-blue-900 font-semibold text-blue-700 dark:text-blue-300">
                      <tr>
                          <th class="px-5 py-3 border-b border-blue-300 dark:border-blue-700">No</th>
                          <th class="px-5 py-3 border-b border-blue-300 dark:border-blue-700">Nama Mahasiswa</th>
                          <th class="px-5 py-3 border-b border-blue-300 dark:border-blue-700">NPM</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr class="hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">1</td>
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">Agus Santoso</td>
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">211011400123</td>
                      </tr>
                      <tr class="hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">2</td>
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">Budi Hartono</td>
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">211011400456</td>
                      </tr>
                      <tr class="hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">3</td>
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">Citra Dewi</td>
                          <td class="px-5 py-3 border-b border-gray-200 dark:border-gray-700">211011400789</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

</div>

@push('script')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

  <script>
      $(document).ready(function () {
          $('#dosenTable').DataTable({
              responsive: true,
              language: {
                  search: "Cari:",
                  lengthMenu: "Tampilkan _MENU_ data per halaman",
                  zeroRecords: "Data tidak ditemukan",
                  info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                  infoEmpty: "Tidak ada data tersedia",
                  infoFiltered: "(difilter dari _MAX_ data)",
                  paginate: {
                      first: "Awal",
                      last: "Akhir",
                      next: "→",
                      previous: "←"
                  }
              }
          });
      });

      function printModal(id) {
          const modal = document.getElementById(`modal-${id}`);
          const printContent = modal.innerHTML;
          const originalContent = document.body.innerHTML;

          document.body.innerHTML = printContent;
          window.print();
          document.body.innerHTML = originalContent;
          window.location.reload();
      }
  </script>
  <script>feather.replace()</script>
@endpush --}}
</x-dashboard.dashboard>
