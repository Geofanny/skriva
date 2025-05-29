<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }
    public function showLoginAdmin()
    {
        return view('loginAdmin');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // login sebagai dosen
        if (Auth::guard('dosen')->attempt(['nip' => $credentials['username'], 'password' => $credentials['password']])) {
            $nip = Auth::guard('dosen')->user()->nip;
        
            // Cek apakah field penting kosong atau belum ada riwayat pendidikan
            $dosen = DB::table('dosen')->where('nip', $nip)->first();
            $riwayat = DB::table('riwayat_pendidikan')->where('nip', $nip)->exists();
        
            if (empty($dosen->foto) && empty($dosen->no_hp) && !$riwayat) {
                return redirect('/profilDosen');
            }
        
            return redirect()->intended('/pembimbing');
        }
        

        // login sebagai mahasiswa
        if (Auth::guard('mahasiswa')->attempt(['npm' => $credentials['username'], 'password' => $credentials['password']])) {
            $npm = Auth::guard('mahasiswa')->user()->npm;
        
            // Ambil data mahasiswa
            $mahasiswa = DB::table('mahasiswa')->where('npm', $npm)->first();
        
            // Cek jika foto atau no_hp masih kosong
            if (empty($mahasiswa->foto) && empty($mahasiswa->no_hp)) {
                return redirect('/profilMahasiswa');
            }
        
            return redirect()->intended('/pengajuanJudul');
        }
        

        // login sebagai admin
        if (Auth::guard('admin')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->intended('/pembimbing');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        $redirectRoute = '/login';

        if (Auth::guard('admin')->check()) {
            $redirectRoute = '/dashboard/login';
        }

        // Logout semua guard
        Auth::guard('admin')->logout();
        Auth::guard('dosen')->logout();
        Auth::guard('mahasiswa')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($redirectRoute);
    }

}
