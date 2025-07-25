<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan Model User diimpor jika akan ada interaksi langsung

class LoginController extends Controller
{
    /**
     * Tampilkan formulir login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input dari formulir
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);


        // Debugging Langkah 1: Periksa kredensial yang diterima dari form.
        // Pastikan isinya adalah ['username' => 'admin', 'password' => 'password']
        // dd($credentials); // Comment kembali baris ini

        // Dapatkan instance UserProvider
        $provider = Auth::getProvider();

        // Debugging Langkah 2: Coba ambil user berdasarkan kredensial (tanpa password).
        // Ini akan mencoba mencari user berdasarkan 'username'.
        $user = $provider->retrieveByCredentials(['username' => $credentials['username']]); // Biarkan baris ini
        // dd($user); // Comment kembali baris ini

        // Debugging Langkah 3: Jika user ditemukan, coba validasi password secara manual.
        // if ($user) { // Comment kembali blok ini
        //     $passwordIsValid = $provider->validateCredentials($user, $credentials);
        //     dd($user, $passwordIsValid); // Comment kembali baris ini
        // } // Comment kembali blok ini

        $attemptResult = Auth::attempt($credentials);

        if ($attemptResult) {
            $request->session()->regenerate();

            // Mendapatkan pengguna yang sedang login
            $user = Auth::user();

            // Mengarahkan pengguna berdasarkan perannya
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'intern') {
                return redirect()->intended('/intern/dashboard');
            } elseif ($user->role === 'mentor') {
                return redirect()->intended('/mentor/dashboard');
            }
            // Jika peran tidak dikenali, redirect ke halaman default
            return redirect()->intended(route('home'));
        }

        // Jika otentikasi gagal, kembali ke formulir login dengan pesan error
        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('username');
    }

    /**
     * Tangani permintaan logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna saat ini

        $request->session()->invalidate(); // Invalidasi sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/login'); // Redirect ke halaman login setelah logout
    }
}