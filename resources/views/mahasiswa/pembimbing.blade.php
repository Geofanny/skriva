@extends('layouts/dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Kartu Identitas Pembimbing</h1>
    <p class="text-sm text-gray-600">Informasi dosen pembimbing Anda secara lengkap.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Kartu Pembimbing 1 --}}
    <div class="bg-white border border-emerald-300 rounded-xl shadow-lg w-full p-6 flex flex-col items-center relative">
        {{-- Gantungan --}}
        <div class="w-10 h-2 bg-gray-300 rounded-full absolute -top-2"></div>
        <div class="w-1 h-6 bg-gray-400 absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1 rounded-sm"></div>

        {{-- Foto --}}
        <img src="{{ $pembimbing1->foto ? asset('storage/fotoProfil/' . $pembimbing1->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
             class="w-28 h-28 rounded-full border-4 border-emerald-500 shadow mb-4 object-cover" alt="Pembimbing 1">

        {{-- Info Utama --}}
        <h3 class="text-lg font-bold text-gray-800 text-center">{{ $pembimbing1->nama ?? '...' }}</h3>
        <p class="text-sm text-gray-600 text-center">NIP: {{ $pembimbing1->nip ?? '0' }}</p>
        <span class="mt-3 px-3 py-1 bg-emerald-100 text-emerald-800 text-sm rounded-full">Pembimbing 1</span>

        {{-- Detail Tambahan --}}
        <div class="mt-4 bg-gray-50 rounded-lg px-4 py-2 text-center">
            <p class="text-sm text-gray-700 capitalize"><strong>Program Studi:</strong><br>{{ $pembimbing1->nama_prodi ?? '...' }}</p>
        </div>
    </div>

    {{-- Kartu Pembimbing 2 --}}
    <div class="bg-white border border-indigo-300 rounded-xl shadow-lg w-full p-6 flex flex-col items-center relative">
        {{-- Gantungan --}}
        <div class="w-10 h-2 bg-gray-300 rounded-full absolute -top-2"></div>
        <div class="w-1 h-6 bg-gray-400 absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1 rounded-sm"></div>

        {{-- Foto --}}
        <img src="{{ $pembimbing2->foto ? asset('storage/fotoProfil/' . $pembimbing2->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
             class="w-28 h-28 rounded-full border-4 border-indigo-500 shadow mb-4 object-cover" alt="Pembimbing 2">

        {{-- Info Utama --}}
        <h3 class="text-lg font-bold text-gray-800 text-center">{{ $pembimbing2->nama ?? '...' }}</h3>
        <p class="text-sm text-gray-600 text-center">NIP {{ $pembimbing2->nip ?? '0' }}</p>
        <span class="mt-3 px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">Pembimbing 2</span>

        {{-- Detail Tambahan --}}
        <div class="mt-4 bg-gray-50 rounded-lg px-4 py-2 text-center">
            <p class="text-sm text-gray-700 capitalize"><strong>Program Studi:</strong><br>{{ $pembimbing2->nama_prodi ?? '...' }}</p>
        </div>
    </div>
</div>
@endsection
