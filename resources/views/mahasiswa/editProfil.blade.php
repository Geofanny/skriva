<x-dashboard.dashboard title="Profil Mahasiswa">
    @push('link')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    @endpush

    @if(empty($mahasiswa->foto) && empty($mahasiswa->no_hp))
        <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded shadow">
            <p class="font-semibold">Perhatian!</p>
            <p>Mohon lengkapi semua data identitas dengan benar. <span class="text-red-500">*</span> menandakan field wajib diisi.</p>
        </div>
    @endif

    <h2 class="text-xl font-semibold text-white mb-6">Profil Mahasiswa</h2>

    <form id="form-biodata" class="space-y-6" action="/editProfilMahasiswa" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            <!-- FOTO -->
            <div class="col-span-1 flex flex-col items-center">
                <div class="relative w-52 h-52 mb-4">
                    <img id="preview-foto"
                         src="{{ $mahasiswa->foto ? asset('storage/fotoProfil/' . $mahasiswa->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
                         alt="Foto Profil"
                         class="rounded-full w-full h-full object-cover border-4 border-slate-700 shadow">
                    <label for="foto"
                           class="absolute bottom-2 right-2 bg-slate-600 hover:bg-slate-500 text-white rounded-full p-2 cursor-pointer shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3.536 3.536-6 6H9v-3.536z"/>
                        </svg>
                    </label>
                    <input id="foto" name="foto" type="file" accept="image/*" class="hidden">
                    <input type="hidden" name="cropped_foto" id="cropped-foto">
                </div>
                <p class="text-sm text-gray-400 mb-3">Klik ikon pensil untuk mengganti foto</p>
            </div>
            
            <!-- IDENTITAS -->
            <div class="col-span-2 space-y-6">
                <h3 class="text-lg font-semibold text-white mb-4">Identitas Mahasiswa</h3>
            
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="mb-5">
                        <label for="nama" class="block text-sm text-gray-300 mb-1">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ $mahasiswa->nama }}"
                               class="w-full px-3 capitalize py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400" required>
                    </div>
            
                    <div>
                        <label for="npm" class="block text-sm text-gray-300 mb-1">NPM</label>
                        <input type="text" id="npm" name="npm" value="{{ $mahasiswa->npm }}"
                               class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg" readonly>
                    </div>
            
                    <div>
                        <label for="prodi" class="block text-sm text-gray-300 mb-1">Program Studi</label>
                        <input type="text" id="prodi" name="prodi" value="{{ $mahasiswa->prodi }}"
                               class="w-full px-3 capitalize py-2 bg-slate-700 text-white rounded-lg" readonly>
                    </div>
            
                    <div>
                        <label for="no_hp" class="block text-sm text-gray-300 mb-1">
                            No. HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ $mahasiswa->no_hp }}"
                               class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                               pattern="\d{1,18}" maxlength="15"
                               title="Hanya angka maksimal 18 digit" placeholder="Masukkan nomor handphone"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>
            </div>
            
        </div>

        <!-- SUBMIT -->
        <div class="text-right pt-4">
            <button type="button"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition-all"
                    id="btn-simpan">
                Simpan Identitas
            </button>
        </div>
    </form>

    <!-- MODAL CROPPER -->
    <div id="cropper-modal" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center hidden">
        <div class="bg-slate-800 p-4 rounded-lg shadow-xl max-w-sm w-full text-white">
            <div class="mb-4 border border-slate-600 rounded overflow-hidden bg-slate-900">
                <img id="cropper-image" class="w-full max-h-64 object-contain" />
            </div>
            <div class="flex justify-between space-x-2">
                <button type="button" onclick="cancelCrop()" class="px-4 py-1 bg-gray-500 rounded">Batal</button>
                <button type="button" onclick="applyCrop()" class="px-4 py-1 bg-blue-600 rounded">Simpan</button>
            </div>
        </div>
    </div>

    @push('script')
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
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-biodata').submit();
                    }
                });
            });
        </script>

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        @endif
    @endpush
</x-dashboard.dashboard>
