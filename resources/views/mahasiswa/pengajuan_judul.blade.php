@extends('layouts/dashboard')

@section('content')

<div class="bg-white w-full rounded-xl shadow-lg p-8 transition hover:shadow-2xl">
    <h2 class="text-3xl  text-slate-800 mb-6 flex items-center gap-2">
        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Form Pengajuan Judul Skripsi
    </h2>

    <form method="POST" action="">
        @csrf

        {{-- Input jumlah judul --}}
        <div class="mb-6">
            <label for="jumlah_judul" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Judul (maks. 3)</label>
            <input type="number" id="jumlah_judul" name="jumlah_judul" min="1" max="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                placeholder="Masukkan jumlah judul" required>
            <p id="warning" class="text-red-600 text-sm mt-1 hidden">Maksimal hanya boleh mengajukan 3 judul.</p>
        </div>

        {{-- Input kategori --}}
        <div class="mb-6">
            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-1">Kategori Skripsi</label>
            <select id="kategori" name="kategori"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Penelitian">Penelitian</option>
                <option value="Pengembangan">Pengembangan</option>
                <option value="Studi Kasus">Studi Kasus</option>
            </select>
        </div>

        {{-- Tempat input judul skripsi --}}
        <div id="judul-container" class="space-y-5"></div>

        <button type="submit"
            class="mt-6 w-full bg-indigo-600 text-white font-semibold py-2.5 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out">
            Ajukan Judul
        </button>
    </form>
</div>

{{-- Script dinamis --}}
<script>
    const jumlahInput = document.getElementById('jumlah_judul');
    const judulContainer = document.getElementById('judul-container');
    const warning = document.getElementById('warning');

    jumlahInput.addEventListener('input', function () {
        const jumlah = parseInt(this.value);
        judulContainer.innerHTML = '';

        if (jumlah > 3) {
            warning.classList.remove('hidden');
            this.value = 3;
            return;
        } else {
            warning.classList.add('hidden');
        }

        for (let i = 1; i <= jumlah; i++) {
            const group = document.createElement('div');
            group.innerHTML = `
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Skripsi ${i}</label>
                <input type="text" name="judul[]" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="Masukkan judul ke-${i}">
            `;
            judulContainer.appendChild(group);
        }
    });
</script>
@endsection
