<header class="flex items-center justify-between bg-surface px-6 py-4 border-b border-slate-700 relative">
    <div class="text-lg font-semibold">Dashboard</div>
    <div class="flex items-center space-x-4">
      <input type="text" placeholder="Search" class="px-10 py-2 bg-slate-700 rounded placeholder-gray-400 focus:outline-none" />
      <div class="flex items-center space-x-2 relative">
        {{-- <img src="https://flagcdn.com/w40/gb.png" class="h-5 w-6 rounded-sm" alt="English"> --}}
        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 48 48"><path stroke-linecap="r" stroke-linejoin="round" stroke-width="2" d="m32.8,29.3c-8.9-.8-16.2-7.8-17.5-16.6-.3-1.8-.3-3.7,0-5.4.2-1.4-1.4-2.3-2.5-1.6C6.3,9.7,2.1,16.9,2.5,25c.5,10.7,9,19.5,19.7,20.4,10.6.9,19.8-6,22.5-15.6.4-1.4-1-2.6-2.3-2-2.9,1.3-6.1,1.8-9.6,1.5Z" /></svg>
        <img src="https://randomuser.me/api/portraits/men/75.jpg" class="h-8 w-8 rounded-full border-2 border-white cursor-pointer" alt="User" onclick="toggleDropdown()" />
        <div id="dropdown" class="absolute right-0 top-10 bg-slate-800 rounded shadow-md p-4 w-48 hidden">
          <p class="font-semibold">Fazri Azis S</p>
          <p class="text-sm text-gray-400 mb-2">NPM: 202333500653</p>
          <hr class="border-slate-700 my-2">
          <button class="block w-full text-left text-sm py-1 hover:text-highlight">Pengaturan Akun</button>
          <button class="block w-full text-left text-sm py-1 hover:text-highlight">Logout</button>
        </div>
      </div>
    </div>
</header>