<script>
  window.addEventListener('load', () => {
    const loadingScreen = document.getElementById('loading-screen');
    const body = document.getElementById('body');

    const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebar-backdrop'); // ✅ tambahkan ini


    // Tambahkan delay agar loading tidak terlalu cepat
    setTimeout(() => {
      loadingScreen.style.opacity = 0;
      setTimeout(() => {
        loadingScreen.style.display = 'none';
        body.classList.remove('overflow-hidden');

        @if(session('success'))
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
          });
        @endif
      }, 700); // waktu untuk transisi fade out
    }, 1800); // minimum tampilan loading 1.8 detik
  });
</script>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>

<script>
// function toggleSidebar() {
//   const sidebar = document.getElementById('sidebar');
//   const toggleIcon = document.getElementById('toggle-icon');
//   const backdrop = document.getElementById('sidebar-backdrop');

//   // Toggle translate-x untuk efek geser
//   const isClosed = sidebar.classList.contains('-translate-x-full');

//   if (isClosed) {
//     sidebar.classList.remove('-translate-x-full');
//     sidebar.classList.add('translate-x-0');
//     backdrop?.classList.remove('hidden');
//     toggleIcon.textContent = '✕';
//   } else {
//     sidebar.classList.remove('translate-x-0');
//     sidebar.classList.add('-translate-x-full');
//     backdrop?.classList.add('hidden');
//     toggleIcon.textContent = '☰';
//   }
// }

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const toggleIcon = document.getElementById('toggle-icon');
  const backdrop = document.getElementById('sidebar-backdrop');

  // Toggle translate-x untuk efek geser
  const isClosed = sidebar.classList.contains('-translate-x-full');

  if (isClosed) {
    sidebar.classList.remove('-translate-x-full');
    sidebar.classList.add('translate-x-0');
    backdrop?.classList.remove('hidden');
    toggleIcon.textContent = '✕';
  } else {
    sidebar.classList.remove('translate-x-0');
    sidebar.classList.add('-translate-x-full');
    backdrop?.classList.add('hidden');
    toggleIcon.textContent = '☰';
  }
}





  function toggleDropdown() {
    const dropdown = document.getElementById('dropdown');
    dropdown.classList.toggle('hidden');
  }

</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
