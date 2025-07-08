<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use App\Models\KoordinasiTA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('login/mahasiswa');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'npm', 'nip', 'password');
        $password = $credentials['password'];
    
        // Login untuk Users
        if (!empty($credentials['email'])) {
            if (Auth::guard('web')->attempt(['email' => $credentials['email'], 'password' => $password])) {
                return redirect('/sys-admin/dashboard');
            }
        }
    
        // // Login untuk Mahasiswa (dengan password)
        // if (!empty($credentials['npm']) && !empty($credentials['password'])) {
        //     $mahasiswa = Mahasiswa::where('npm', $credentials['npm'])->first();
        //     if ($mahasiswa && Hash::check($credentials['password'], $mahasiswa->password)) {
        //         Auth::guard('mahasiswa')->login($mahasiswa);
        //         return redirect('/dashboard');
        //     }
        // }

        // Login untuk Mahasiswa (dengan password)
        if (!empty($credentials['npm']) && !empty($credentials['password'])) {
            $mahasiswa = DB::table('mahasiswa')->where('npm', $credentials['npm'])->first();

            if ($mahasiswa && Hash::check($credentials['password'], $mahasiswa->password)) {
                // Cek apakah mahasiswa memiliki pembimbing 1 dan 2
                // Cek apakah mahasiswa memiliki pembimbing 1 dan 2
                $jumlahPembimbing = DB::table('pembimbing_mahasiswa')
                ->join('pembimbing', 'pembimbing_mahasiswa.kd_pembimbing', '=', 'pembimbing.kd_pembimbing')
                ->where('pembimbing_mahasiswa.npm', $mahasiswa->npm)
                ->whereIn('pembimbing.posisi', ['Pembimbing 1', 'Pembimbing 2'])
                ->distinct()
                ->count('pembimbing.posisi');

                if ($jumlahPembimbing < 2) {
                    return redirect('/login')
                        ->with('error', 'Pembimbing belum tersedia. Silakan hubungi Koordinasi TA.');
                }

                // Login mahasiswa
                Auth::guard('mahasiswa')->loginUsingId($mahasiswa->npm);

                // Cek apakah sudah memiliki data skripsi
                $adaSkripsi = DB::table('skripsi')
                    ->where('npm', $mahasiswa->npm)
                    ->exists();

                if ($adaSkripsi) {
                    return redirect('/dashboard');
                } else {
                    return redirect('/dashboard/skripsi');
                }
            }
        }

    
        // Login untuk Dosen
        if (!empty($credentials['nip'])) {
            // Cek login dosen dengan password
            if (Auth::guard('dosen')->attempt(['nip' => $credentials['nip'], 'password' => $password])) {
                $dosen = Auth::guard('dosen')->user();
                
                // Redirect berdasarkan role dosen
                $koordinator = KoordinasiTA::where('nip', $dosen->nip)->first();
                if ($koordinator) {
                    // Login ke guard koordinator juga
                    Auth::guard('koordinator')->login($koordinator);
                    return redirect('/coord-panel/dashboard');
                }
    
                $pembimbing = Pembimbing::where('nip', $dosen->nip)->first();
                if ($pembimbing) {
                    // Login ke guard pembimbing juga
                    Auth::guard('pembimbing')->login($pembimbing);
                    return redirect('/mentor-access/dashboard');
                }
    
                // Jika dosen tidak punya role
                Auth::guard('dosen')->logout();
                return back()->withErrors(['login' => 'Anda tidak memiliki akses ke sistem ini']);
            }
        }
    
        return back()->withErrors(['login' => 'Kredensial tidak valid']);
    }

    public function formLoginAdmin()
    {
        return view('login/admin');
    }

    // public function loginAdmin(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::guard('web')->attempt($credentials)) {
    //         return redirect()->intended('/dashboard-admin');
    //     }

    //     return back()->withErrors(['email' => 'Email atau password salah.']);
    // }

    public function formLoginPembimbing()
    {
        return view('login.pembimbing');
    }

    // public function loginPembimbing(Request $request)
    // {
    //     $credentials = $request->only('nip', 'password');

    //     if (Auth::guard('dosen')->attempt($credentials)) {
    //         return redirect()->intended('/dashboard-pembimbing');
    //     }

    //     return back()->withErrors(['nip' => 'NIP atau password salah.']);
    // }

    public function formLoginKoordinator()
    {
        return view('login.koordinator');
    }

    // public function loginKoordinator(Request $request)
    // {
    //     $credentials = $request->only('nip', 'password');

    //     if (Auth::guard('koordinator')->attempt($credentials)) {
    //         return redirect()->intended('/dashboard-koordinator');
    //     }

    //     return back()->withErrors(['nip' => 'NIP atau password salah.']);
    // }


    public function logout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect('/sys-admin')->with('success', 'Admin berhasil logout.');
        }

        if (Auth::guard('pembimbing')->check()) {
            Auth::guard('pembimbing')->logout();
            return redirect('/mentor-access')->with('success', 'Pembimbing berhasil logout.');
        }

        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
            return redirect('/login')->with('success', 'Mahasiswa berhasil logout.');
        }

        if (Auth::guard('koordinator')->check()) {
            Auth::guard('koordinator')->logout();
            return redirect('/coord-panel')->with('success', 'Koordinator berhasil logout.');
        }

        return redirect('/login')->with('info', 'Anda sudah logout.');
    }

    public function logoutMahasiswa()
    {
        Auth::guard('mahasiswa')->logout();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    public function logoutAdmin()
    {
        Auth::guard('web')->logout();
        return redirect('/sys-admin')->with('success', 'Anda telah logout.');
    }

    public function logoutPembimbing()
    {
        Auth::guard('dosen')->logout();
        return redirect('/mentor-access')->with('success', 'Anda telah logout.');
    }

    public function logoutKoordinator()
    {
        Auth::guard('koordinator')->logout();
        return redirect('/coord-panel')->with('success', 'Anda telah logout.');
    }
}
