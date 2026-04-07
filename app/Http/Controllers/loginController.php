<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{

    public function index()
    {
        return view('login');
    }


   public function authenticate(Request $request)
    {
        $request->validate([
            'login_identity' => 'required',
            'password' => 'required',
        ]);

    
        $loginType = str_contains($request->login_identity, '@') ? 'email' : 'nis';

        $credentials = [
            $loginType => $request->login_identity,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }
            return redirect()->intended('/aspirasi');
        }

        return back()->with('loginError', 'Login gagal! Periksa kembali NIS/Email dan Password.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}