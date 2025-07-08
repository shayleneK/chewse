<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return Inertia::render('Login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:users,name|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        Auth::login($user);

        return redirect('/Home');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8', 'max:255',],
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        };

        $user = Auth::user();

        return back();
    }

    public function logout(Request $request): Response
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location('/Login');
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }



        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
