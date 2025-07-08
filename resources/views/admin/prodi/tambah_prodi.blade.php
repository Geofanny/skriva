@extends('layouts/dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Program Studi</h1>
    <form action="/prodiBaru" method="POST" class="space-y-6">
        @csrf

        <!-- Fakultas dan Nama Prodi: dua kolom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Fakultas -->
            <div>
                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                <select id="fakultas" name="fakultas"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="" disabled selected>-- Pilih Fakultas --</option>
                        <option>Ilmu Pendidikan dan Pengetahuan Sosial</option>
                        <option>Matematika dan Ilmu Pengetahuan Alam</option>
                        <option>Teknik dan Ilmu Komputer</option>
                        <option>Bahasa dan Seni</option>
                </select>
            </div>

            <!-- Nama Prodi -->
            <div>
                <label for="nama_prodi" class="block text-sm font-medium text-gray-700 mb-1">Nama Prodi</label>
                <input type="text" id="nama_prodi" name="nama_prodi"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Contoh: Teknik Informatika" required>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-between items-center ">
            <a href="/dashboard/prodi"
            class="inline-block bg-gray-300 hover:bg-gray-200 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow cursor-pointer">
             Batal
            </a>         
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    Submit
            </button>
        </div>

    </form>
</div>
@endsection
