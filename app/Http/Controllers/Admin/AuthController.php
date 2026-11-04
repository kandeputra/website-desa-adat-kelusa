<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function form() { return view('admin.login'); }

    public function login(Request $r)
    {
        $data = $r->validate(['email' => 'required|email', 'password' => 'required|string']);
        if (! Auth::attempt($data + ['is_active' => true], $r->boolean('ingat'))) {
            return back()->withErrors(['email' => 'Email atau kata sandi salah, atau akun tidak aktif.'])->onlyInput('email');
        }
        $r->session()->regenerate();
        $r->user()->forceFill(['last_login_at' => now()])->save();
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('admin.login')->with('ok', 'Anda telah keluar.');
    }
}
