<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\DosenController;
use App\Http\Controllers\admin\ProdiController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\KoordinasiTaController;
use App\Http\Controllers\mahasiswa\BimbinganController;
use App\Http\Controllers\pembimbing\BimbinganController AS BimbinganMahasiswaController;
use App\Http\Controllers\koordinasi\MonitoringController;
use App\Http\Controllers\koordinasi\PembimbingController;
use App\Http\Controllers\mahasiswa\PengajuanJudulController;
use App\Http\Controllers\admin\MahasiswaController AS DataMahasiswaController;
use App\Http\Controllers\pembimbing\MahasiswaController AS DaftarMahasiswaController;
use App\Http\Controllers\dosen\DashboardController AS DashboarDosendController;
use App\Http\Controllers\mahasiswa\DashboardController AS DashboardMahasiswaController;
use App\Http\Controllers\koordinasi\DashboardController AS DashboardKoordinasiController;
use App\Http\Controllers\pembimbing\DashboardController AS DashboardPembimbingController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/admin', function () {
    return view('admin.index');
});

Route::get('/login',[AuthController::class,'formLogin']); // Mhaasiswa
Route::get('/sys-admin',[AuthController::class,'formLoginAdmin']); // Admin
Route::get('/mentor-access',[AuthController::class,'formLoginPembimbing']); // Pembimbing
Route::get('/coord-panel',[AuthController::class,'formLoginKoordinator']); //  Koordinasi

Route::post('/login', [AuthController::class, 'login']);
Route::post('/sys-admin', [AuthController::class, 'loginAdmin']);
Route::post('/mentor-access', [AuthController::class, 'loginPembimbing']);
Route::post('/coord-panel', [AuthController::class, 'loginKoordinator']);

Route::get('/logout', [AuthController::class, 'logout']);
// Route::middleware(['auth'])->get('/logout', [AuthController::class, 'logout']);

// // Mahasiswa
// Route::get('/logout', [AuthController::class, 'logoutMahasiswa']);
    
// // Admin
// Route::get('/logout-admin', [AuthController::class, 'logoutAdmin']);

// // Dosen Pembimbing
// Route::get('/logout-mentor', [AuthController::class, 'logoutPembimbing']);

// // Koordinator
// Route::get('/logout-coord', [AuthController::class, 'logoutKoordinator']);

// ini akses admin
Route::middleware('auth.role:web')->group(function () {

    // Prodi
    Route::get('/sys-admin/dashboard',[DashboardController::class,'index']);
    Route::get('/sys-admin/statistik',[DashboardController::class,'statistikBimbingan']);

    Route::get('/sys-admin/daftarFakultas',[ProdiController::class,'index']);
    Route::get('/dashboard/prodi/baru',[ProdiController::class,'tambahProdi']);
    Route::post('/prodiBaru',[ProdiController::class,'prodiBaru']);
    Route::get('/dashboard/prodi/{kd_prodi}',[ProdiController::class,'editProdi']);
    Route::post('/dashboard/prodi/{kd_prodi}', [ProdiController::class, 'destroy']);
    Route::post('/prodi/{kd_prodi}',[ProdiController::class,'update']);

    // Mahasiswa
    Route::get('/sys-admin/daftarMahasiswa',[DataMahasiswaController::class,'index']);
    Route::get('/dashboard/mahasiswa/baru',[DataMahasiswaController::class,'tambahMahasiswa']);
    Route::post('/mahasiswaBaru',[DataMahasiswaController::class,'mahasiswaBaru']);
    Route::get('/dashboard/mahasiswa/{npm}',[DataMahasiswaController::class,'editMahasiswa']);
    Route::post('/dashboard/mahasiswa/{npm}', [DataMahasiswaController::class, 'destroy']);
    Route::post('/mahasiswa/update/{npm}',[DataMahasiswaController::class,'update']);

    // Dosen
    Route::get('/sys-admin/daftarDosen',[DosenController::class,'index']);
    Route::get('/dashboard/dosen/baru',[DosenController::class,'tambahDosen']);
    Route::post('/dosenBaru',[DosenController::class,'dosenBaru']);
    Route::get('/dashboard/dosen/{nip}',[DosenController::class,'editDosen']);
    Route::post('/dosen/update/{nip}',[DosenController::class,'update']);
    Route::post('/dashboard/dosen/{nip}', [DosenController::class, 'destroy']);

    // Koordinator TA
    Route::get('/sys-admin/daftarKoordinasi',[KoordinasiTaController::class,'index']);
    Route::get('/dashboard/koordinasi/baru',[KoordinasiTaController::class,'tambahKoordinasi']);
    Route::post('/koordinasiBaru',[KoordinasiTaController::class,'koordinasiBaru']);
    Route::get('/dashboard/koordinasi/{kd_koordinasi}',[KoordinasiTaController::class,'editKoordinasi']);
    Route::post('/koordinasi/update/{kd_koordinasi}',[KoordinasiTaController::class,'update']);
    Route::post('/dashboard/koordinasi/{kd_koordinasi}', [KoordinasiTaController::class, 'destroy']);
});


// // Prodi
// Route::get('/dashboard/prodi',[ProdiController::class,'index']);
// Route::get('/dashboard/prodi/baru',[ProdiController::class,'tambahProdi']);
// Route::post('/prodiBaru',[ProdiController::class,'prodiBaru']);
// Route::get('/dashboard/prodi/{kd_prodi}',[ProdiController::class,'editProdi']);
// Route::post('/dashboard/prodi/{kd_prodi}', [ProdiController::class, 'destroy']);
// Route::post('/prodi/{kd_prodi}',[ProdiController::class,'update']);

// // Mahasiswa
// Route::get('/dashboard/daftarMahasiswa',[DataMahasiswaController::class,'index']);
// Route::get('/dashboard/mahasiswa/baru',[DataMahasiswaController::class,'tambahMahasiswa']);
// Route::post('/mahasiswaBaru',[DataMahasiswaController::class,'mahasiswaBaru']);
// Route::get('/dashboard/mahasiswa/{npm}',[DataMahasiswaController::class,'editMahasiswa']);
// Route::post('/dashboard/mahasiswa/{npm}', [DataMahasiswaController::class, 'destroy']);
// Route::post('/mahasiswa/update/{npm}',[DataMahasiswaController::class,'update']);

// // Dosen
// Route::get('/dashboard/daftarDosen',[DosenController::class,'index']);
// Route::get('/dashboard/dosen/baru',[DosenController::class,'tambahDosen']);
// Route::post('/dosenBaru',[DosenController::class,'dosenBaru']);
// Route::get('/dashboard/dosen/{nip}',[DosenController::class,'editDosen']);
// Route::post('/dosen/update/{nip}',[DosenController::class,'update']);
// Route::post('/dashboard/dosen/{nip}', [DosenController::class, 'destroy']);

// // Koordinator TA
// Route::get('/dashboard/daftarKoordinasi',[KoordinasiTaController::class,'index']);
// Route::get('/dashboard/koordinasi/baru',[KoordinasiTaController::class,'tambahKoordinasi']);
// Route::post('/koordinasiBaru',[KoordinasiTaController::class,'koordinasiBaru']);
// Route::get('/dashboard/koordinasi/{kd_koordinasi}',[KoordinasiTaController::class,'editKoordinasi']);
// Route::post('/koordinasi/update/{kd_koordinasi}',[KoordinasiTaController::class,'update']);
// Route::post('/dashboard/koordinasi/{kd_koordinasi}', [KoordinasiTaController::class, 'destroy']);

// ini akses pembimbing
Route::middleware('auth.role:pembimbing')->group(function () {

    Route::get('/mentor-access/dashboard',[DashboardPembimbingController::class,'index']);
    Route::get('/pembimbing/kalender-bimbingan', [DashboardPembimbingController::class, 'getKalender']);
    Route::get('/mentor-access/profil',[DashboardPembimbingController::class,'profil']);
    Route::post('/pembimbing/profil/update', [DashboardPembimbingController::class, 'updateProfilPembimbing']);


    Route::get('/mentor-access/daftarAjuan',[BimbinganMahasiswaController::class,'daftarAjuan']);

    Route::get('/mentor-access/riwayatAjuan',[BimbinganMahasiswaController::class,'riwayatAjuan']);

    Route::get('/mentor-access/filterRiwayatAjuan', [BimbinganMahasiswaController::class, 'filterRiwayatAjuan']);

    Route::get('/mentor-access/cetakRiwayatAjuan', [BimbinganMahasiswaController::class, 'cetakRiwayatAjuan']);

    // Untuk Pembimbing (pastikan menggunakan middleware pembimbing kalau perlu)
    Route::post('/pembimbing/ajuan/{kd_bimbingan}/setujui', [BimbinganMahasiswaController::class, 'setujui'])->name('setujui.ajuan');
    Route::post('/pembimbing/ajuan/{kd_bimbingan}/tolak', [BimbinganMahasiswaController::class, 'tolak'])->name('tolak.ajuan');
    Route::post('/pembimbing/bimbingan/selesai/{kd_bimbingan}', [BimbinganMahasiswaController::class, 'selesai'])
    ->name('bimbingan.selesai');

    Route::get('/mentor-access/jadwalBimbingan',[BimbinganMahasiswaController::class,'jadwalBimbingan']);
    Route::get('/mentor-access/filter-jadwal', [BimbinganMahasiswaController::class, 'filterJadwal']);
    Route::get('/mentor-access/cetak-jadwal', [BimbinganMahasiswaController::class, 'cetakJadwal'])->name('jadwal.cetak');

    Route::get('/mentor-access/daftarMahasiswa',[DaftarMahasiswaController::class,'daftarMahasiswa']);
    Route::get('/mentor-access/filterMahasiswa', [DaftarMahasiswaController::class, 'filterMahasiswa'])->name('filter.mahasiswa');

});

Route::middleware('auth.role:koordinator')->group(function () {
    // Tambahkan route khusus koordinator di sini jika ada
    // Misalnya dashboard-koordinator
    Route::get('/coord-panel/dashboard',[DashboardKoordinasiController::class,'index']);
    Route::get('/coord-panel/profil',[DashboardKoordinasiController::class,'profil']);
    Route::post('/koordinator/profil/update', [DashboardKoordinasiController::class, 'updateProfilKoordinasi']);

    Route::get('/coord-panel/daftarPembimbing',[PembimbingController::class,'index']);
    Route::get('/coord-panel/pembimbing/baru',[PembimbingController::class,'tambahPembimbing']);
    Route::post('/pembimbingBaru',[PembimbingController::class,'pembimbingBaru']);
    Route::get('/coord-panel/pembimbing/{kd_pembimbing}',[PembimbingController::class,'editPembimbing']);
    Route::post('/pembimbing/update/{pembimbing}',[PembimbingController::class,'update']);
    Route::post('/dashboard/pembimbing/{kd_pembimbing}', [PembimbingController::class, 'destroy']);
    Route::post('/dashboard/pembimbing/mahasiswa/hapus', [PembimbingController::class, 'hapusMahasiswa']);

    Route::get('/coord-panel/monitoringBimbingan',[MonitoringController::class,'index']);
    Route::get('/monitoring-bimbingan/pembimbing/{kd_prodi}', [MonitoringController::class, 'getPembimbingByProdi']);
    Route::get('/monitoring-bimbingan/data', [MonitoringController::class, 'getData']);
    Route::get('/monitoring-bimbingan/export-pdf', [MonitoringController::class, 'exportPDF']);


    Route::get('/get-dosen-by-prodi/{kd_prodi}', [PembimbingController::class, 'getDosenByProdi']);
    Route::get('/dashboard/pembimbing/{kd_pembimbing}/mahasiswa', [PembimbingController::class, 'getMahasiswa']);
    // Route::get('/api/mahasiswa-by-prodi/{kd_prodi}', [PembimbingController::class, 'getMahasiswaByProdi']);
    Route::get('/api/mahasiswa-by-prodi/{kd_prodi}/{nip}', [PembimbingController::class, 'getMahasiswaByProdi']);
    Route::post('/dashboard/pembimbing/mahasiswa/tambah', [PembimbingController::class, 'tambahMahasiswa']);
});

Route::middleware('auth.role:mahasiswa')->group(function () {
    // Tambahkan route khusus mahasiswa di sini
    Route::get('/dashboard',[DashboardMahasiswaController::class,'index']);
    Route::get('/dashboard/profil',[DashboardMahasiswaController::class,'profil']);

    Route::get('/dashboard/skripsi',[BimbinganController::class,'skripsi']);
    Route::post('/skripsi',[BimbinganController::class,'ajuanSkripsi']);

    Route::get('/dashboard/bimbingan',[BimbinganController::class,'bimbingan']);
    Route::post('/bimbingan',[BimbinganController::class,'ajuanBimbingan']);
    Route::post('/bimbingan/{kd_sesi}',[BimbinganController::class,'destroyBimbingan']);

    Route::get('/dashboard/pembimbing',[BimbinganController::class,'pembimbing']);

    Route::get('/dashboard/riwayat-ajuan',[BimbinganController::class,'riwayatAjuan']);

    Route::get('/mahasiswa/riwayat-ajuan/pdf', [BimbinganController::class, 'cetakPDF'])->name('mahasiswa.riwayat.cetak');

    Route::post('/mahasiswa/profil/update', [DashboardMahasiswaController::class, 'updateProfil']);

});


Route::get('/pengajuan_judul',[PengajuanJudulController::class,'formulirJudul']);