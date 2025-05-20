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
