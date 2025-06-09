<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCtrl extends Controller
{
    public function login_view() {


        return view('pages.login');
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->with([
            'invalid' => 'The provided credentials do not match our records.',
        ]);
    }
}
