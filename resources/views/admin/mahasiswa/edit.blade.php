@extends('layouts/dashboard')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Mahasiswa</h1>

    <form action="/mahasiswa/update/{{ $mahasiswa->npm }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NPM -->
            <div>
                <label for="npm" class="block text-sm font-medium text-gray-700 mb-1">NPM</label>
                <input type="text" id="npm" name="npm"
                       value="{{ $mahasiswa->npm }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100 cursor-not-allowed"
                       readonly>
            </div>

            <!-- Nama Mahasiswa -->
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                <input type="text" id="nama" name="nama"
                       value="{{ $mahasiswa->nama }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Prodi -->
            <div>
                <label for="kd_prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <select id="kd_prodi" name="kd_prodi"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="" disabled>-- Pilih Prodi --</option>
                    @foreach ($prodi as $item)
                        <option value="{{ $item->kd_prodi }}" {{ $item->kd_prodi == $mahasiswa->kd_prodi ? 'selected' : '' }}>
                            {{ $item->nama_prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (Opsional)</label>
                <input type="text" id="password" name="password"
                       placeholder="Kosongkan jika tidak ingin diganti"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ url('/dashboard/daftarMahasiswa') }}"
               class="bg-gray-300 hover:bg-gray-200 text-gray-800 font-semibold px-5 py-2 rounded-lg shadow">
                Batal
            </a>
            <button type="submit"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold px-5 py-2 rounded-lg shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
