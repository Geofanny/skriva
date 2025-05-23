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

        // Coba login sebagai dosen
        if (Auth::guard('dosen')->attempt(['nip' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->intended('/dosen');
        }

        // Coba login sebagai mahasiswa
        if (Auth::guard('mahasiswa')->attempt(['npm' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->intended('/mahasiswa');
        }

        // Coba login sebagai admin
        if (Auth::guard('admin')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->intended('/pembimbing');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('dosen')->logout();
        Auth::guard('mahasiswa')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
