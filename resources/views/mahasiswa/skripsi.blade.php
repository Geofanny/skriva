@extends('layouts/dashboard')

@section('content')

<style>
    .doc-page {
        margin: auto;
        padding: 2.5rem;
        background-color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border-radius: 0.5rem;
    }
</style>

<section class="doc-page text-gray-800 text-base leading-relaxed space-y-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-center sm:text-left">Skripsi Mahasiswa</h1>
        <button id="openModalBtn"
            class="bg-cyan-700 hover:bg-cyan-600 text-white p-4 rounded-full shadow-lg transition duration-200" 
            title="Edit Skripsi">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M11 4h2m1.586 0.586a2 2 0 112.828 2.828L9 16H6v-3l8.586-8.586z" />
            </svg>
        </button>
    </div>
    <hr class="border-t border-gray-300 mb-4">

    <div>
        <h2 class="font-semibold">Judul Skripsi</h2>
        <p>{{ $skripsi->judul ?? '...' }}</p>
    </div>

    <div>
        <h2 class="font-semibold">Kategori</h2>
        <p class="capitalize">{{ $skripsi->kategori ?? '...' }}</p>
    </div>

    <div>
        <h2 class="font-semibold">Tanggal Upload</h2>
        <p>{{ $skripsi->tgl_upload ?? '...' }}</p>
    </div>

    <div>
        <h2 class="font-semibold mb-2">Pembimbing</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm">
                <h3 class="font-medium text-cyan-800 mb-1">Pembimbing 1</h3>
                <p class="text-gray-700">{{ $pembimbing1->nama ?? '...' }}</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm">
                <h3 class="font-medium text-cyan-800 mb-1">Pembimbing 2</h3>
                <p class="text-gray-700">{{ $pembimbing2->nama ?? '...' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Modal --}}
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-800">Skripsi</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
        </div>
        <form action="/skripsi" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Skripsi</label>
                <textarea name="judul" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-cyan-500 focus:border-cyan-500" placeholder="Masukkan judul skripsi" rows="3" required>{{ $skripsi->judul ?? "" }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-cyan-500 focus:border-cyan-500" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="e-commerce" {{ $skripsi && $skripsi->kategori == 'e-commerce' ? 'selected' : '' }}>E-Commerce</option>
                    <option value="analisis dan perancangan" {{ $skripsi && $skripsi->kategori == 'analisis dan perancangan' ? 'selected' : '' }}>Analisis dan Perancangan</option>
                    <option value="rancang bangun sistem" {{ $skripsi && $skripsi->kategori == 'rancang bangun sistem' ? 'selected' : '' }}>Rancang Bangun Sistem</option>
                </select>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                    Batal
                </button>
                <button type="submit" class="bg-cyan-700 text-white px-4 py-2 rounded hover:bg-cyan-800">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const modal = document.getElementById('modal');
    const openBtn = document.getElementById('openModalBtn');

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
</script>

@endsection
