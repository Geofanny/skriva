<x-dashboard.dashboard title="Profil Dosen">
    @push('link')
        {{-- CDN CRROPER JS --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    @endpush

    <h2 class="text-xl font-semibold text-white mb-6">Profil Dosen</h2>

    {{-- <p class="mb-6 text-sm text-gray-400">
        <span class="text-red-500 font-bold">*</span> = Field yang dapat diedit
    </p> --}}

    <form id="form-biodata" class="space-y-6" action="/editProfil" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Foto + Nama -->
            <div class="col-span-1 flex flex-col items-center">
                <!-- Preview lingkaran -->
                <div class="relative w-40 h-40 mb-4">
                    <img id="preview-foto"
                         src="{{ $dosen->foto ? asset('storage/fotoProfil/'.$dosen->foto) : 'https://www.gravatar.com/avatar/?d=mp&s=200' }}"
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
    
                <!-- Modal cropper -->
                <div id="cropper-modal" class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center hidden">
                    <div class="bg-slate-800 p-4 rounded-lg shadow-xl max-w-sm w-full text-white">
                        <div class="mb-4 border border-slate-600 rounded overflow-hidden bg-slate-900">
                            <img id="cropper-image" class="w-full max-h-64 object-contain bg-slate-900" />
                        </div>
                        <div class="flex justify-between space-x-2">
                            <button type="button" onclick="cancelCrop()" class="px-4 py-1 bg-gray-500 text-white rounded">Batal</button>
                            <button type="button" onclick="applyCrop()" class="px-4 py-1 bg-blue-600 text-white rounded">Simpan</button>
                        </div>
                    </div>
                </div>
    
                <div class="w-full">
                    <label for="nama" class="block text-sm text-gray-300 mb-1">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ ucwords(strtolower($dosen->nama)) }}"
                           class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400">
                </div>
            </div>
    
            <!-- Data Diri + Pendidikan -->
            <div class="col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-6">Identitas Dosen</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-300 text-sm mb-1" for="nip">NIP</label>
                            <input type="text" id="nip" name="nip" value="{{ $dosen->nip }}"
                                   class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1" for="prodi">Program Studi</label>
                            <input type="text" id="prodi" name="prodi" value="{{ ucwords(strtolower($dosen->prodi)) }}"
                                   class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg" readonly>
                        </div>
                        <div class="sm:col-span-2 mt-3">
                            <label class="block text-gray-300 text-sm mb-1" for="no_hp">
                                No. HP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="no_hp" name="no_hp" value="{{ $dosen->no_hp }}"
                                class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                                pattern="\d{1,18}" maxlength="13"
                                title="Hanya boleh angka tanpa simbol, maksimal 18 digit"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Riwayat Pendidikan -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-white">Riwayat Pendidikan</h3>
                <button type="button" onclick="tambahBaris()"
                        class="bg-green-600 hover:bg-green-500 text-white font-semibold px-3 py-1.5 rounded-md text-sm">
                    + Tambah Riwayat
                </button>
            </div>
    
            <div id="pendidikan-wrapper" class="space-y-4">
                @if($riwayatPendidikan->isEmpty())
                    {{-- Jika belum ada data pendidikan --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-slate-800 p-4 rounded-lg relative">
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Jenjang <span class="text-red-500">*</span></label>
                            <input type="text" name="pendidikan[0][jenjang]" placeholder="S1/D4" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Program Studi <span class="text-red-500">*</span></label>
                            <input type="text" name="pendidikan[0][program_studi]" placeholder="Jurusan" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Tahun Masuk <span class="text-red-500">*</span></label>
                            <input type="number" name="pendidikan[0][tahun_masuk]" placeholder="Tahun Masuk"
                            class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                            pattern="\d{1,4}" maxlength="4"
                            title="Masukkan tahun dengan maksimal 4 digit"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">

                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Tahun Keluar <span class="text-red-500">*</span></label>
                            <input type="number" name="pendidikan[0][tahun_keluar]" placeholder="Tahun Keluar" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                            pattern="\d{1,4}" maxlength="4"
                            title="Masukkan tahun dengan maksimal 4 digit"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                        </div>
                    </div>
                @else
                    @foreach($riwayatPendidikan as $i => $riwayat)
                    <input type="hidden" name="pendidikan[{{ $i }}][id]" value="{{ $riwayat->id_pendidikan }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-slate-800 p-4 rounded-lg relative">
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Jenjang <span class="text-red-500">*</span></label>
                            <input type="text" name="pendidikan[{{ $i }}][jenjang]" value="{{ $riwayat->jenjang }}" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Program Studi <span class="text-red-500">*</span></label>
                            <input type="text" name="pendidikan[{{ $i }}][program_studi]" value="{{ $riwayat->prodi }}" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg">
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Tahun Masuk <span class="text-red-500">*</span></label>
                            <input type="number" name="pendidikan[{{ $i }}][tahun_masuk]" value="{{ $riwayat->tahun_masuk }}" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                            pattern="\d{1,4}" maxlength="4"
                            title="Masukkan tahun dengan maksimal 4 digit"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                        </div>
                        <div>
                            <label class="block text-gray-300 text-sm mb-1">Tahun Keluar <span class="text-red-500">*</span></label>
                            <input type="number" name="pendidikan[{{ $i }}][tahun_keluar]" value="{{ $riwayat->tahun_keluar }}" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                            pattern="\d{1,4}" maxlength="4"
                            title="Masukkan tahun dengan maksimal 4 digit"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    
        <!-- Tombol Simpan -->
        <div class="text-right pt-4">
            <button type="button"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition-all" id="btn-simpan">
                Simpan Identitas
            </button>
        </div>
    </form>
    


    @push('script')
        {{-- SCRIPT CROOPER JS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

        <script>
            let pendidikanIndex = {{ $riwayatPendidikan->count() > 0 ? $riwayatPendidikan->count() : 1 }};

            function tambahBaris() {
                const wrapper = document.getElementById('pendidikan-wrapper');
                const html = `
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-slate-800 p-4 rounded-lg relative">
                    <div>
                        <label class="block text-gray-300 text-sm mb-1">Jenjang</label>
                        <input type="text" name="pendidikan[${pendidikanIndex}][jenjang]" placeholder="S1/D4" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm mb-1">Program Studi</label>
                        <input type="text" name="pendidikan[${pendidikanIndex}][program_studi]" placeholder="Jurusan"class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm mb-1">Tahun Masuk</label>
                        <input type="number" name="pendidikan[${pendidikanIndex}][tahun_masuk]" placeholder="Tahun Masuk" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                        pattern="\d{1,4}" maxlength="4"
                        title="Masukkan tahun dengan maksimal 4 digit"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm mb-1">Tahun Keluar</label>
                        <input type="number" name="pendidikan[${pendidikanIndex}][tahun_keluar]" placeholder="Tahun Keluar" class="w-full px-3 py-2 bg-slate-700 text-white rounded-lg focus:ring focus:ring-blue-400"
                        pattern="\d{1,4}" maxlength="4"
                        title="Masukkan tahun dengan maksimal 4 digit"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                    </div>
                    <button type="button" onclick="hapusBaris(this)"
                            class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm shadow-md">
                        &times;
                    </button>
                </div>`;
                wrapper.insertAdjacentHTML('beforeend', html);
                pendidikanIndex++;
            }

            function hapusBaris(button) {
                button.parentElement.remove();
            }

        </script>

        <script>
            let cropper;

            document.getElementById('foto').addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const cropperImage = document.getElementById('cropper-image');

                        // Set source dulu, lalu tunggu sampai gambar termuat
                        cropperImage.onload = function () {
                            if (cropper) cropper.destroy();
                            cropper = new Cropper(cropperImage, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 1,
                            });
                        };

                        cropperImage.src = event.target.result;
                        document.getElementById('cropper-modal').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            function applyCrop() {
                if (!cropper) return;

                // Dapatkan hasil crop sebagai JPG (bukan PNG)
                const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
                const dataUrl = canvas.toDataURL('image/jpeg', 0.9); // quality 90%

                // Tampilkan preview di browser
                document.getElementById('preview-foto').src = dataUrl;

                // Simpan ke hidden input
                document.getElementById('cropped-foto').value = dataUrl;

                // Sembunyikan modal dan bersihkan cropper
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
        </script>

        <script>
            document.getElementById('btn-simpan').addEventListener('click', function (e) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Identitas biodata dosen akan disimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form jika user klik "Ya, simpan!"
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
