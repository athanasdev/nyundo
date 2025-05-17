<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class UserAuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'currency' => 'required|string',
            'invitation_code' => 'nullable|string',
            'password' => 'required|string|confirmed|min:8',
            'agree' => 'required|accepted',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'currency' => $request->currency,
            'invitation_code' => $request->invitation_code,
            'password' => Hash::make($request->password),
        ]);

        $number = rand(0, 9999);
        Log::info("the info id", $number);
        Auth::login($user);

        return redirect()->route('login');
    }


    public function showLoginForm()
    {
        $number = '8' . str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
        Log::info("Generated number", ['number' => $number]);

        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        Log::info('Login attempt', ['credentials' => $credentials]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('Login successful');
            return redirect()->intended(route('dashboard'))->with('success', 'Logged in successfully.');
        }
        Log::warning('Login failed');
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
