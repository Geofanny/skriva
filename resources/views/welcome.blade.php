<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Penjadwalan Skripsi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</head>
<body class=" bg-gray-50 min-h-screen">
  <div class="flex">
    
       <!-- Sidebar Modern -->
<aside class="h-screen w-64 bg-white shadow-md flex flex-col justify-between fixed left-0 top-0 z-40">
  <div>
    <div class="flex items-center gap-2 px-6 py-4 border-b">
      <img src="{{ asset('asset/faviconn.png') }}" class="h-10" alt="Logo">
      <span class="text-xl font-bold text-blue-600">Skriva</span>
    </div>
    <nav class="mt-4">
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium transition">
        <i class="fas fa-home w-5 text-blue-600"></i> Dashboard
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium transition">
        <i class="fas fa-calendar-alt w-5 text-blue-600"></i> Kalender
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium transition">
        <i class="fas fa-user-check w-5 text-blue-600"></i> Jadwal Bimbingan
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium transition">
        <i class="fas fa-chalkboard-teacher w-5 text-blue-600"></i> Jadwal Sidang
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium transition">
        <i class="fas fa-users w-5 text-blue-600"></i> Dosen Pembimbing
      </a>
      <a href="#" class="flex items-center gap-3 px-6 py-3 hover:bg-blue-100 text-gray-700 font-medium transition">
        <i class="fas fa-history w-5 text-blue-600"></i> Riwayat Bimbingan
      </a>
    </nav>
  </div>
  <div class="px-6 py-4">
    <a href="#" class="flex items-center gap-2 text-red-500 hover:text-red-600 font-semibold">
      <i class="fas fa-sign-out-alt w-5"></i> Logout
    </a>
  </div>
</aside>
    
    <!-- Main Content -->
    <main class="flex-1 p-6 space-y-12 ml-64">
      <!-- Dashboard Section -->
      <section id="dashboard">
        <header class="mb-6">
          <h1 class="text-3xl font-semibold text-gray-800">Dashboard</h1>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-medium text-gray-600">Bimbingan Selesai</h2>
            <p class="text-2xl font-bold text-red-600">12</p>
          </div>
          <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-medium text-gray-600">Bimbingan Hari Ini</h2>
            <p class="text-2xl font-bold text-yellow-600">2</p>
          </div>
          <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-lg font-medium text-gray-600">Sidang Terdekat</h2>
            <p class="text-2xl font-bold text-pink-600">24 April 2025</p>
          </div>
        </div>
      </section>

    <!-- Layout Full Kalender + Sidebar -->
    <section id="calender"></section>
    <h1 class="text-3xl font-semibold text-gray-800">Kalender</h1>
<div class="flex flex-col lg:flex-row min-h-screen bg-white text-black">
  
  <!-- Kalender Section -->
  
  <div class="w-full lg:w-2/3 p-6">
    <div id='calendar' class="shadow-2xl rounded-3xl overflow-hidden bg-white p-4"></div>
  </div>

  <!-- Sidebar Section -->
  <aside class="w-full lg:w-1/3 p-6 bg-white shadow-inner rounded-l-2xl flex flex-col">
    <h2 class="text-2xl font-bold mb-4">Informasi Jadwal</h2>
    <div class="flex gap-2 mb-4">
      <button onclick="filterEvents('All')" class="flex-1 px-3 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 text-sm">Semua</button>
      <button onclick="filterEvents('Bimbingan')" class="flex-1 px-3 py-2 bg-blue-500 rounded-lg hover:bg-blue-600 text-white text-sm">Bimbingan</button>
      <button onclick="filterEvents('Sidang')" class="flex-1 px-3 py-2 bg-red-500 rounded-lg hover:bg-red-600 text-white text-sm">Sidang</button>
    </div>
    <div id="event-list" class="space-y-4 overflow-y-auto flex-1">
      <!-- Event list akan muncul disini -->
    </div>
    <button onclick="openModal()" class="mt-6 bg-gradient-to-r from-purple-500 to-indigo-600 text-white py-2 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition">Ajukan Jadwal Baru</button>
    <div class="mt-10">
      <h3 class="text-lg font-semibold mb-2">Keterangan:</h3>
      <div class="flex items-center mb-2">
        <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span> <span>Bimbingan</span>
      </div>
      <div class="flex items-center">
        <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span> <span>Sidang</span>
      </div>
    </div>
  </aside>
</div>

<!-- Modal Ajukan Jadwal -->
<div id="schedule-modal" class="fixed inset-0 bg-white bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white p-6 rounded-3xl w-11/12 md:w-96 shadow-2xl">
    <h2 class="text-xl font-bold mb-4">Ajukan Jadwal</h2>
    <form id="schedule-form">
      <div class="mb-4">
        <label class="block mb-1 text-sm font-semibold">Jenis Jadwal</label>
        <select id="schedule-type" class="w-full border rounded-lg px-3 py-2 bg-white text-black">
          <option value="Bimbingan">Bimbingan</option>
          <option value="Sidang">Sidang</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block mb-1 text-sm font-semibold">Tanggal</label>
        <input type="date" id="schedule-date" class="w-full border rounded-lg px-3 py-2 bg-white text-black">
      </div>
      <div class="mb-4">
        <label class="block mb-1 text-sm font-semibold">Deskripsi</label>
        <textarea id="schedule-desc" class="w-full border rounded-lg px-3 py-2 bg-white text-black"></textarea>
      </div>
      <div class="flex justify-end">
        <button type="button" onclick="closeModal()" class="mr-2 px-4 py-2 rounded-lg border hover:bg-gray-700">Batal</button>
        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Ajukan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Detail Jadwal -->
<div id="detail-modal" class="fixed inset-0 bg-white bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white p-6 rounded-3xl w-11/12 md:w-96 shadow-2xl">
    <h2 class="text-xl font-bold mb-4">Detail Jadwal</h2>
    <div class="mb-4">
      <p class="text-black"><strong>Jenis:</strong> <span id="detail-type"></span></p>
      <p class="text-black"><strong>Tanggal:</strong> <span id="detail-date"></span></p>
      <p class="text-black"><strong>Deskripsi:</strong> <span id="detail-desc"></span></p>
    </div>
    <div class="flex justify-end">
      <button onclick="closeDetailModal()" class="px-4 py-2 rounded-lg border hover:bg-gray-700">Tutup</button>
    </div>
  </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 left-6 bg-green-600 text-white py-2 px-4 rounded-lg shadow-lg hidden">
  Jadwal berhasil diajukan!
</div>

<!-- FullCalendar CDN -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<!-- Script Kalender dan Modal -->
<script>
  let events = [];
  let calendar;

  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      selectable: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: events,
      eventClick: function(info) {
        openDetailModal(info.event);
      }
    });
    calendar.render();

    document.getElementById('schedule-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const type = document.getElementById('schedule-type').value;
      const date = document.getElementById('schedule-date').value;
      const desc = document.getElementById('schedule-desc').value;

      if (!date || !desc) {
        alert('Tanggal dan deskripsi wajib diisi!');
        return;
      }

      const bgColor = type === 'Bimbingan' ? '#3b82f6' : '#ef4444';

      const newEvent = {
        title: type,
        start: date,
        allDay: true,
        backgroundColor: bgColor,
        extendedProps: { description: desc, type: type }
      };

      events.push(newEvent);
      calendar.addEvent(newEvent);
      renderEventList();

      showToast();
      document.getElementById('schedule-form').reset();
      closeModal();
    });
  });

  function renderEventList(filter = 'All') {
    const list = document.getElementById('event-list');
    list.innerHTML = '';

    events.filter(e => filter === 'All' || e.extendedProps.type === filter).forEach((event, index) => {
      const item = document.createElement('div');
      item.className = 'p-4 bg-white rounded-lg shadow-sm border-l-4 cursor-pointer ' + (event.title === 'Bimbingan' ? 'border-blue-400' : 'border-red-400');
      item.innerHTML = `<strong>${event.title}</strong><div class='text-xs text-gray-900 mb-1'>${event.start}</div><p class='text-sm text-gray-800'>${event.extendedProps.description}</p>`;
      item.onclick = () => openDetailModal(event);
      list.appendChild(item);
    });
  }

  function filterEvents(type) {
    renderEventList(type);
  }

  function openModal() {
    document.getElementById('schedule-modal').classList.remove('hidden');
    document.getElementById('schedule-modal').classList.add('flex');
  }

  function closeModal() {
    document.getElementById('schedule-modal').classList.add('hidden');
  }

  function showToast() {
    const toast = document.getElementById('toast');
    toast.classList.remove('hidden');
    setTimeout(() => {
      toast.classList.add('hidden');
    }, 3000);
  }

  function openDetailModal(event) {
    document.getElementById('detail-type').textContent = event.extendedProps.type;
    document.getElementById('detail-date').textContent = event.startStr;
    document.getElementById('detail-desc').textContent = event.extendedProps.description;
    document.getElementById('detail-modal').classList.remove('hidden');
    document.getElementById('detail-modal').classList.add('flex');
  }

  function closeDetailModal() {
    document.getElementById('detail-modal').classList.add('hidden');
  }
</script>

      <!-- Jadwal Bimbingan Section -->
      <section id="jadwal-bimbingan">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Bimbingan</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dosen</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">22 April 2025</td>
                <td class="px-6 py-4 whitespace-nowrap">10:00 - 11:00</td>
                <td class="px-6 py-4 whitespace-nowrap">Dr. Bambang</td>
                <td class="px-6 py-4 whitespace-nowrap text-yellow-600 font-semibold">Menunggu</td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">20 April 2025</td>
                <td class="px-6 py-4 whitespace-nowrap">14:00 - 15:00</td>
                <td class="px-6 py-4 whitespace-nowrap">Prof. Nina</td>
                <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajukan Bimbingan</button>
      </section>

      {{-- jadwal sidang --}}
      <section id="jadwal-sidang">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Sidang</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tempat</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">30 April 2025</td>
                <td class="px-6 py-4 whitespace-nowrap">09:00 - 10:30</td>
                <td class="px-6 py-4 whitespace-nowrap">Ruang Sidang A</td>
                <td class="px-6 py-4 whitespace-nowrap text-yellow-600 font-semibold">Dijadwalkan</td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">15 Mei 2025</td>
                <td class="px-6 py-4 whitespace-nowrap">13:00 - 14:30</td>
                <td class="px-6 py-4 whitespace-nowrap">Ruang Sidang B</td>
                <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajukan Sidang</button>
      </section>
      
      <!-- Dosen Pembimbing Section -->
      <section id="dosen-pembimbing" class="mt-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dosen Pembimbing</h2>
        <div class="grid md:grid-cols-2 gap-6">
          <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700">Pembimbing 1</h3>
            <p class="text-gray-600">Dr. Ahmad Yusuf, M.Kom</p>
            <p class="text-gray-500 text-sm">ahmad.yusuf@univ.ac.id</p>
          </div>
          <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700">Pembimbing 2</h3>
            <p class="text-gray-600">Prof. Dewi Kartika, M.T</p>
            <p class="text-gray-500 text-sm">dewi.kartika@univ.ac.id</p>
          </div>
        </div>
      </section>

      <!-- Jadwal Sidang Section -->
<section id="jadwal-sidang">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Sidang</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tempat</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">30 April 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">09:00 - 10:30</td>
          <td class="px-6 py-4 whitespace-nowrap">Ruang Sidang A</td>
          <td class="px-6 py-4 whitespace-nowrap text-yellow-600 font-semibold">Dijadwalkan</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">15 Mei 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">13:00 - 14:30</td>
          <td class="px-6 py-4 whitespace-nowrap">Ruang Sidang B</td>
          <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
        </tr>
      </tbody>
    </table>
  </div>
  <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajukan Sidang</button>
</section>

<!-- Dosen Pembimbing Section -->
<section id="dosen-pembimbing" class="mt-12">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dosen Pembimbing</h2>
  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="text-lg font-semibold text-gray-700">Pembimbing 1</h3>
      <p class="text-gray-600">Dr. Ahmad Yusuf, M.Kom</p>
      <p class="text-gray-500 text-sm">ahmad.yusuf@univ.ac.id</p>
      <p class="text-gray-500 text-sm">09281422323</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="text-lg font-semibold text-gray-700">Pembimbing 2</h3>
      <p class="text-gray-600">Prof. Dewi Kartika, M.T</p>
      <p class="text-gray-500 text-sm">dewi.kartika@univ.ac.id</p>
      <p class="text-gray-500 text-sm">08685903323</p>
    </div>
  </div>
</section>

<!-- Riwayat Bimbingan Section -->
<section id="riwayat-bimbingan" class="mt-12">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Riwayat Bimbingan</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">10 April 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">10:00 - 11:00</td>
          <td class="px-6 py-4 whitespace-nowrap">Revisi Bab 2</td>
          <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">05 April 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">13:00 - 14:00</td>
          <td class="px-6 py-4 whitespace-nowrap">Diskusi metodologi</td>
          <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- Jadwal Sidang Section -->
<section id="jadwal-sidang">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Jadwal Sidang</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tempat</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">30 April 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">09:00 - 10:30</td>
          <td class="px-6 py-4 whitespace-nowrap">Ruang Sidang A</td>
          <td class="px-6 py-4 whitespace-nowrap text-yellow-600 font-semibold">Dijadwalkan</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">15 Mei 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">13:00 - 14:30</td>
          <td class="px-6 py-4 whitespace-nowrap">Ruang Sidang B</td>
          <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
        </tr>
      </tbody>
    </table>
  </div>
  <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Ajukan Sidang</button>
</section>

<!-- Dosen Pembimbing Section -->
<section id="dosen-pembimbing" class="mt-12">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dosen Pembimbing</h2>
  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="text-lg font-semibold text-gray-700">Pembimbing 1</h3>
      <p class="text-gray-600">Dr. Ahmad Yusuf, M.Kom</p>
      <p class="text-gray-500 text-sm">ahmad.yusuf@univ.ac.id</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow">
      <h3 class="text-lg font-semibold text-gray-700">Pembimbing 2</h3>
      <p class="text-gray-600">Prof. Dewi Kartika, M.T</p>
      <p class="text-gray-500 text-sm">dewi.kartika@univ.ac.id</p>
    </div>
  </div>
</section>

<!-- Riwayat Bimbingan Section -->
<section id="riwayat-bimbingan" class="mt-12">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Riwayat Bimbingan</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">10 April 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">10:00 - 11:00</td>
          <td class="px-6 py-4 whitespace-nowrap">Revisi Bab 2</td>
          <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
        </tr>
        <tr>
          <td class="px-6 py-4 whitespace-nowrap">05 April 2025</td>
          <td class="px-6 py-4 whitespace-nowrap">13:00 - 14:00</td>
          <td class="px-6 py-4 whitespace-nowrap">Diskusi metodologi</td>
          <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">Selesai</td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

<!-- Upload Dokumen Section -->
<section id="upload-dokumen" class="mt-12">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upload Dokumen Skripsi</h2>
  <form class="bg-white p-6 rounded-xl shadow space-y-4">
    <p class="text-gray-700 text-sm mb-2">Checklist Persyaratan:</p>
    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 list-inside list-disc text-sm text-gray-700">
      <li><input type="checkbox" class="mr-2">Tugas Akhir (jilid)</li>
      <li><input type="checkbox" class="mr-2">Bukti Acc Dospem</li>
      <li><input type="checkbox" class="mr-2">Foto Copy Ijazah Terakhir</li>
      <li><input type="checkbox" class="mr-2">Foto Copy KTP</li>
      <li><input type="checkbox" class="mr-2">Foto Copy Pembayaran TA</li>
      <li><input type="checkbox" class="mr-2">KRS TA & Transkrip Nilai SIAK Online</li>
      <li><input type="checkbox" class="mr-2">Foto Copy Penyetaraan</li>
      <li><input type="checkbox" class="mr-2">Foto Copy Bukti Penyerahan KKP (T.Inf)</li>
      <li><input type="checkbox" class="mr-2">DVD RW</li>
      <li><input type="checkbox" class="mr-2">Pas Foto 3.7 x 4.8 cm = 4 lbr</li>
    </ul>
    <div class="mt-4">
      <label for="file" class="block text-sm font-medium text-gray-700">Upload File Pendukung</label>
      <input type="file" id="file" name="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Upload</button>
  </form>
</section>

<!-- Notifikasi Section -->
<section id="notifikasi" class="mt-12">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Notifikasi</h2>
  <ul class="space-y-4">
    <li class="bg-white p-4 rounded-xl shadow border-l-4 border-yellow-500">
      <p class="text-sm text-gray-700">Pengajuan sidang telah berhasil dikirim. Menunggu verifikasi dosen pembimbing.</p>
    </li>
    <li class="bg-white p-4 rounded-xl shadow border-l-4 border-green-500">
      <p class="text-sm text-gray-700">Sidang anda telah selesai. Silakan upload dokumen pendukung.</p>
    </li>
  </ul>
</section>

<!-- Chat Popup Button -->
<button id="chat-toggle" class="fixed bottom-6 right-6 bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-full shadow-lg z-50">
  Chat Dosen
</button>

<!-- Chat Popup Window -->
<div id="chat-popup" class="fixed bottom-24 right-6 w-80 bg-white border rounded-2xl shadow-2xl hidden flex flex-col z-50">
  <div class="bg-blue-500 text-white p-4 rounded-t-2xl flex justify-between items-center">
    <span class="font-bold">Chat dengan Dosen</span>
    <button onclick="toggleChat()" class="text-white text-xl">&times;</button>
  </div>
  <div class="p-4 border-b">
    <label for="dosen-select" class="block text-gray-700 text-sm font-bold mb-2">Pilih Dosen:</label>
    <select id="dosen-select" class="w-full border rounded-lg px-3 py-2">
      <option value="Dr. Ahmad Yusuf, M.Kom">Dr. Ahmad Yusuf, M.Kom</option>
      <option value="Prof. Dewi Kartika, M.T">Prof. Dewi Kartika, M.T</option>
    </select>
  </div>
  <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50">
    <div class="bg-gray-200 p-2 rounded-lg self-start text-sm max-w-xs">Halo, ada yang bisa dibantu?</div>
  </div>
  <div class="p-4 border-t flex items-center">
    <input type="text" id="chat-input" placeholder="Ketik pesan..." class="flex-1 border rounded-full px-4 py-2 text-sm">
    <button onclick="sendMessage()" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm">Kirim</button>
  </div>
</div>

<!-- Script Chat -->
<script>
  function toggleChat() {
    const chatPopup = document.getElementById('chat-popup');
    chatPopup.classList.toggle('hidden');
    chatPopup.classList.toggle('flex');
  }

  document.getElementById('chat-toggle').addEventListener('click', toggleChat);

  function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    const selectedDosen = document.getElementById('dosen-select').value;

    if (message !== '') {
      const chatBox = document.getElementById('chat-messages');
      const userMsg = document.createElement('div');
      userMsg.className = 'bg-blue-100 p-2 rounded-lg self-end text-sm max-w-xs ml-auto';
      userMsg.innerText = message;
      chatBox.appendChild(userMsg);

      setTimeout(() => {
        const dosenMsg = document.createElement('div');
        dosenMsg.className = 'bg-gray-200 p-2 rounded-lg self-start text-sm max-w-xs';
        dosenMsg.innerText = `(${selectedDosen}): Terima kasih, pesan Anda sudah diterima.`;
        chatBox.appendChild(dosenMsg);
        chatBox.scrollTop = chatBox.scrollHeight;
      }, 1000);

      input.value = '';
      chatBox.scrollTop = chatBox.scrollHeight;
    }
  }
</script>


    </main>
  </div>
</body>
</html>