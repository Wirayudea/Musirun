<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        try {
            $authenticated = Auth::attempt($credentials, $request->filled('remember'));
        } catch (QueryException $exception) {
            report($exception);

            return back()
                ->withErrors(['email' => 'Layanan login sedang tidak dapat terhubung ke database. Silakan coba lagi beberapa saat.'])
                ->onlyInput('email');
        }

        if ($authenticated) {
            $request->session()->regenerate();

            // Ensure user is admin
            if ((Auth::user()->role ?? 'user') !== 'admin') {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Akun tidak memiliki akses admin.']);
            }

            return redirect()->intended(route('admin.daftar_peserta'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
