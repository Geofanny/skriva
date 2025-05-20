<!-- Layout Full Kalender + Sidebar -->
<section id="calender"></section>
<h1 class="text-3xl font-semibold text-white">Kalender</h1>
<div class="flex flex-col lg:flex-row min-h-screen bg-slate-900 text-white">

<!-- Kalender Section -->

<div class="w-full lg:w-2/3 p-6">
<div id='calendar' class="shadow-2xl rounded-3xl overflow-hidden bg-slate-900 p-4"></div>
</div>

<!-- Sidebar Section -->
<aside class="w-full lg:w-1/3 p-6 bg-slate-900 shadow-inner rounded-l-2xl flex flex-col">
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
<div id="schedule-modal" class="fixed inset-0 bg-gray bg-opacity-50 hidden items-center justify-center z-50">
<div class="bg-slate-500 p-6 rounded-3xl w-11/12 md:w-96 shadow-2xl">
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
<h2 class="text-xl font-bold mb-4 text-black">Detail Jadwal</h2>
<div class="mb-4">
  <p class="text-black"><strong>Jenis:</strong> <span id="detail-type"></span></p>
  <p class="text-black"><strong>Tanggal:</strong> <span id="detail-date"></span></p>
  <p class="text-black"><strong>Deskripsi:</strong> <span id="detail-desc"></span></p>
</div>
<div class="flex justify-end">
  <button onclick="closeDetailModal()" class="bg-slate-900 px-4 py-2 rounded-lg border hover:bg-gray-700">Tutup</button>
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
