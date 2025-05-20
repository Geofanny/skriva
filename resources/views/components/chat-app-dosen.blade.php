<div>
<!-- Chat Popup Button -->
<button id="chat-toggle" class="fixed bottom-6 right-6 bg-gradient-to-tr from-red-600 to-blue-700 text-white p-4 rounded-full shadow-lg z-50">
    Chat Mahasiswa
  </button>
  
  <!-- Chat Popup Window -->
  <div id="chat-popup" class="fixed bottom-24 right-6 w-80 bg-white border text-black rounded-2xl shadow-2xl hidden flex flex-col z-50">
    <div class="bg-blue-500 text-white p-4 rounded-t-2xl flex justify-between items-center">
      <span class="font-bold">Chat dengan Mahasiswa</span>
      <button onclick="toggleChat()" class="text-white text-xl">&times;</button>
    </div>
    <div class="p-4 border-b">
      <label for="dosen-select" class="block text-gray-700 text-sm font-bold mb-2">Pilih Mahasiswa</label>
      <select id="dosen-select" class="w-full border rounded-lg px-3 py-2">
        <option value="Asyrofi Anggar">Asyrofi Anggar</option>
        <option value="Fhaisal Argy">Fhaisal Argy</option>
        <option value="Argy Rafi">Argy Rafi</option>
      </select>
    </div>
    <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50">
      <div class="bg-gray-200 p-2 rounded-lg self-start text-sm max-w-xs">Pak saya mau tanya dong?</div>
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
  </div>