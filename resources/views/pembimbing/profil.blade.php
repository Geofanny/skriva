@extends('layouts.dashboard')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<div class="bg-white p-6 rounded-xl shadow-lg mx-auto">
    <h2 class="text-xl font-bold text-gray-800 mb-6">Profil Pembimbing</h2>

    <form id="form-biodata" action="/pembimbing/profil/update" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start bg-slate-50 p-6 rounded-lg border border-gray-200">
            <!-- FOTO -->
            <div class="flex-shrink-0 text-center">
                <div class="relative w-48 h-48 mx-auto mb-3">
                    <img id="preview-foto"
                         src="{{ $dosen->foto ? asset('storage/fotoProfil/' . $dosen->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
                         alt="Foto Profil"
                         class="rounded-xl w-full h-full object-cover border-4 border-cyan-800 shadow">
                    <label for="foto"
                           class="absolute bottom-2 right-2 bg-cyan-800 hover:bg-cyan-700 text-white rounded-full p-2 cursor-pointer shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z"/>
                        </svg>
                    </label>
                    <input id="foto" name="foto" type="file" accept="image/*" class="hidden">
                    <input type="hidden" name="cropped_foto" id="cropped-foto">
                </div>
                <p class="text-sm text-gray-500">Klik ikon pensil untuk ubah foto</p>
            </div>

            <!-- IDENTITAS -->
            <div class="flex-1 space-y-4 w-full">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-600">Nama <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ $dosen->nama }}"
                           class="mt-1 w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-cyan-400" required>
                </div>

                <div>
                    <label for="npm" class="block text-sm font-medium text-gray-600">NPM</label>
                    <input type="text" id="npm" name="npm" value="{{ $dosen->nip }}"
                           class="mt-1 w-full px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg shadow-sm" readonly>
                </div>

                <div>
                    <label for="prodi" class="block text-sm font-medium text-gray-600">Program Studi</label>
                    <input type="text" id="prodi" name="prodi" value="{{ $dosen->nama_prodi ?? '-' }}"
                           class="mt-1 w-full px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg shadow-sm" readonly>
                </div>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="border-t border-gray-300 pt-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="password_baru" class="block text-sm font-medium text-gray-600">Password Baru</label>
                    <input type="password" id="password_baru" name="password_baru" class="mt-1 w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-cyan-400"
                    placeholder="Masukkan password baru">
                </div>

                <div>
                    <label for="konfirmasi_password" class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password"
                           class="mt-1 w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-cyan-400" placeholder="Konfirmasi password baru"
                           oninput="cekKecocokanPassword()">
                    <p id="notif-password" class="text-sm mt-1 text-red-600 hidden">Konfirmasi password tidak cocok</p>
                </div>
            </div>
        </div>


        <!-- BUTTON -->
        <div class="text-right mt-6">
            <button type="button"
                    class="px-6 py-2 bg-cyan-800 hover:bg-cyan-700 text-white font-semibold rounded-lg transition-all disabled:cursor-not-allowed"
                    id="btn-simpan">
                Simpan Identitas
            </button>
        </div>
    </form>
    
</div>

<!-- MODAL CROPPER -->
<div id="cropper-modal" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-4 rounded-lg shadow-xl max-w-sm w-full text-gray-800">
        <div class="mb-4 border border-gray-300 rounded overflow-hidden bg-slate-100">
            <img id="cropper-image" class="w-full max-h-64 object-contain" />
        </div>
        <div class="flex justify-between space-x-2">
            <button type="button" onclick="cancelCrop()" class="px-4 py-1 bg-gray-300 text-gray-800 rounded">Batal</button>
            <button type="button" onclick="applyCrop()" class="px-4 py-1 bg-cyan-800 text-white rounded">Simpan</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    let cropper;

    document.getElementById('foto').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = document.getElementById('cropper-image');
                img.src = event.target.result;
                document.getElementById('cropper-modal').classList.remove('hidden');

                img.onload = function () {
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(img, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                    });
                };
            };
            reader.readAsDataURL(file);
        }
    });

    function applyCrop() {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
        document.getElementById('preview-foto').src = dataUrl;
        document.getElementById('cropped-foto').value = dataUrl;
        document.getElementById('cropper-modal').classList.add('hidden');
        cropper.destroy();
        cropper = null;
    }

    function cancelCrop() {
        document.getElementById('cropper-modal').classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    document.getElementById('btn-simpan').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan disimpan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#06b6d4',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-biodata').submit();
            }
        });
    });
</script>

@if(session('password_changed'))
<script>
    Swal.fire({
        title: 'Password Berhasil Diubah',
        text: 'Anda akan logout otomatis untuk login ulang.',
        icon: 'success',
        timer: 5000,
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        willClose: () => {
            // Redirect ke logout
            window.location.href = "/logout";
        }
    });
</script>
@endif



<script>
    function cekKecocokanPassword() {
        const pass = document.getElementById('password_baru');
        const konfirmasi = document.getElementById('konfirmasi_password');
        const notif = document.getElementById('notif-password');
        const btn = document.getElementById('btn-simpan');

        if (konfirmasi.value.length > 0 || pass.value.length > 0) {
            if (pass.value !== konfirmasi.value) {
                konfirmasi.classList.add('border-red-500');
                konfirmasi.classList.remove('border-gray-300');
                notif.classList.remove('hidden');
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                konfirmasi.classList.remove('border-red-500');
                konfirmasi.classList.add('border-gray-300');
                notif.classList.add('hidden');
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } else {
            // reset ke normal jika dua-duanya kosong
            konfirmasi.classList.remove('border-red-500');
            konfirmasi.classList.add('border-gray-300');
            notif.classList.add('hidden');
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
</script>

@endsection
