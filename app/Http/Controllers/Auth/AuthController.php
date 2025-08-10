<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        if (auth()->check()) {
            $user = auth()->user();
                return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $cred = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($cred, $remember)) {
            $user = Auth::user();

            // Cek status user
            if (!$user->isAktif()) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'])
                    ->withInput($request->only('email'));
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('status', 'Anda berhasil masuk.');}

        return redirect()->back()->withErrors(['email' => 'Email atau password tidak valid.'])->withInput($request->only('email'));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
    
}
