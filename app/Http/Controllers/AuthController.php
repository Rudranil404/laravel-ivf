<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return $this->roleBasedRedirect(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return $this->roleBasedRedirect(Auth::user());
        }
        // The second parameter $request->boolean('remember') tells Laravel to keep the user logged in.
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->roleBasedRedirect(Auth::user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function roleBasedRedirect($user)
    {
        if ($user->hasRole('Super Admin')) {
            return redirect()->intended(route('superadmin.dashboard'));
        } elseif ($user->hasRole('Clinic Admin')) {
            return redirect()->intended(route('clinic.dashboard'));
        } else {
            return redirect()->intended(route('user.dashboard'));
        }
    }
}