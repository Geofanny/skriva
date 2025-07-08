@extends('layouts/dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Dosen</h1>
    <form action="/dosenBaru" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

             <!-- NIP -->
             <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" id="nip" name="nip"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan NIP" required>
            </div>

            <!-- Nama Dosen -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Dosen</label>
                <input type="text" id="nama" name="nama"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan nama dosen" required>
            </div>

        </div>

        <!-- Fakultas dan Nama Prodi: dua kolom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Program Studi -->
            <div>
                <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select id="prodi" name="kd_prodi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="" disabled selected>-- Pilih Program Studi --</option>
                       @foreach ($daftarProdi as $prodi )
                           <option value="{{ $prodi->kd_prodi }}"> {{ $prodi->nama_prodi }}</option>
                       @endforeach
                </select>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="text" id="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan password" required>
            </div>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-between items-center ">
            <a href="/dashboard/daftarDosen"
            class="inline-block bg-gray-300 hover:bg-gray-200 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow cursor-pointer">
             Batal
            </a>         
            <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-5 py-2 rounded-lg shadow">
                    Submit
            </button>
        </div>

    </form>
</div>
@endsection
