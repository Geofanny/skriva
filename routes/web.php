<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DosenController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\admin\MahasiswaController;
use App\Http\Controllers\mahasiswa\PengajuanController;
use App\Http\Controllers\admin\DaftarBimbinganController;

Route::get('/', function () {
    return redirect('/dosen');
});

// Route::get('/login', function () {
//     return view('loginn');
// });

Route::get('/regis', function () {
    return view('regis');
});

route::get('/mahasiswa', function () {
    return view('mahasiswa.mahasiswa');
});

// route::get('/pengajuanJudul', function () {
//     return view('mahasiswa.pengajuanJudul');
// });

route::get('/pengajuanBimbingan', function () {
    return view('mahasiswa.pengajuanBimbingan');
});

route::get('/bimbinganOnline', function () {
    return view('mahasiswa.bimbinganOnline');
});

route::get('/riwayatBimbingan', function () {
    return view('mahasiswa.riwayatBimbingan');
});

route::get('/detailDosen', function () {
    return view('mahasiswa.detailDosen');
});

// route::get('/dosen', function () {
//     return view('dosen.dosen');
// });

route::get('/permintaanDosen', function () {
    return view('dosen.permintaanDosen');
});

route::get('/jadwalDosen', function () {
    return view('dosen.jadwalBimbinganDosen');
});

route::get('/daftarMahasiswa', function () {
    return view('dosen.daftarMahasiswa');
});

// route::get('/admin', function () {
//     return view('admin.admin');
// });

Route::get('/login', [AuthenticationController::class,'showLogin']);
Route::get('/dashboard/login', [AuthenticationController::class,'showLoginAdmin']);
Route::post('/login', [AuthenticationController::class,'login']);
Route::get('/logout', [AuthenticationController::class,'logout']);

Route::resource('/dosen', DosenController::class);
Route::resource('/mahasiswa', MahasiswaController::class);
Route::get('/pembimbing/{slug}/mahasiswa', [DaftarBimbinganController::class,'mahasiswa']);
// Route::get('/pembimbing/{kode}/mahasiswa', [DaftarBimbinganController::class, 'mahasiswaDetail']);
// Route::get('/pembimbing/{kd_bimbingan}/mahasiswa', [DaftarBimbinganController::class, 'getMahasiswa']);

Route::post('/pembimbing/{kd}/mahasiswa', [DaftarBimbinganController::class,'daftarBimbingan']);
Route::post('/pembimbing/{slug}/edit', [DaftarBimbinganController::class,'editDaftar']);
Route::resource('/pembimbing', DaftarBimbinganController::class);

// Route::get('/admin', [DosenController::class,'index']);
// Route::get('/admin/tambahDosen', [DosenController::class,'tambah']);

Route::get('/pengajuanJudul', [PengajuanController::class,'pengajuanJudul']);
Route::post('/ajukan', [PengajuanController::class,'ajukan']);


route::get('/admin-dosen', function () {
    return view('admin.dosen');
});