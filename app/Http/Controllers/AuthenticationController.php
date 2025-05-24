<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            return redirect()->intended('/profil');
            // return view('dosen.editProfil');
        }

        // login sebagai mahasiswa
        if (Auth::guard('mahasiswa')->attempt(['npm' => $credentials['username'], 'password' => $credentials['password']])) {
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
