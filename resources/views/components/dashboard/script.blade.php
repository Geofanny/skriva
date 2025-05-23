<script>
 window.addEventListener('load', () => {
  const loadingScreen = document.getElementById('loading-screen');
  const body = document.getElementById('body');

  // sembunyikan loading screen
  loadingScreen.style.opacity = 0;
  setTimeout(() => {
    loadingScreen.style.display = 'none';
    // aktifkan scroll kembali
    body.classList.remove('overflow-hidden');
  }, 700);
});

</script>

<script>
  function confirmLogout() {
    Swal.fire({
      title: 'Yakin ingin logout?',
      text: "Sesi Anda akan diakhiri.",
      imageUrl: '{{ asset("asset/logout.png") }}',
      imageWidth: 90,
      imageHeight: 90,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, logout',
      cancelButtonText: 'Batal',
      customClass: {
        image: 'mx-auto'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "/logout";
      }
    });
  }
</script>


<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const toggleIcon = document.getElementById('toggle-icon');

    if (sidebar.classList.contains('hidden')) {
      sidebar.classList.remove('hidden');
      sidebar.classList.add('w-64');
      toggleIcon.textContent = '✕';
    } else {
      sidebar.classList.add('hidden');
      sidebar.classList.remove('w-64');
      toggleIcon.textContent = '☰';
    }
  }

  function toggleDropdown() {
    const dropdown = document.getElementById('dropdown');
    dropdown.classList.toggle('hidden');
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
