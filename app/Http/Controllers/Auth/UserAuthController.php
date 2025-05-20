<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;




class UserAuthController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string|unique:users,username',
    //         'email' => 'required|email|unique:users,email',
    //         'currency' => 'required|string',
    //         'invitation_code' => 'nullable|string',
    //         'password' => 'required|string|confirmed|min:8',
    //         'agree' => 'required|accepted',
    //     ]);

    //     $user = User::create([
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'currency' => $request->currency,
    //         'invitation_code' => $request->invitation_code,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     $number = rand(0, 9999);
    //     Log::info("the info id", $number);
    //     Auth::login($user);

    //     return redirect()->route('login');
    // }


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

        // Find referrer by referral code if provided
        $referrer = null;
        if ($request->filled('invitation_code')) {
            $referrer = User::where('referral_code', $request->invitation_code)->first();
        }

        // Generate unique_id - 10 digit number starting with 8
        do {
            $uniqueId = rand(8000000000, 8999999999);
        } while (User::where('unique_id', $uniqueId)->exists());

        // Generate referral code - 6-character uppercase code
        do {
            $referralCode = strtoupper(Str::random(6));
        } while (User::where('referral_code', $referralCode)->exists());
        Log::info("the user unique id", ['unique_id', $uniqueId]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'currency' => $request->currency,
            'password' => Hash::make($request->password),
            'unique_id' => $uniqueId,
            'referral_code' => $referralCode,
            'referrer_id' => optional(User::where('referral_code', $request->invitation_code)->first())->id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
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
