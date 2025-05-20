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

    public function showRegisterForm(Request $request)
    {
        $ref = $request->query('invited_by');
        return view('auth.register', compact('ref'));
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

    //     // Get referrer if valid referral code was given
    //     $referrer = null;
    //     if ($request->filled('invitation_code')) {
    //         $referrer = User::where('referral_code', $request->invitation_code)->first();
    //     }

    //     // Generate unique ID
    //     do {
    //         $uniqueId = rand(8000000000, 8999999999);
    //     } while (User::where('unique_id', $uniqueId)->exists());

    //     // Generate unique referral code
    //     do {
    //         $referralCode = strtoupper(Str::random(6));
    //     } while (User::where('referral_code', $referralCode)->exists());

    //     Log::info("Generated user unique_id", ['unique_id' => $uniqueId]);

    //     // Create user
    //     $user = User::create([
    //         'username' => $request->username,
    //         'email' => $request->email,
    //         'currency' => $request->currency,
    //         'password' => Hash::make($request->password),
    //         'unique_id' => $uniqueId,
    //         'referral_code' => $referralCode,
    //         'referrer_id' => optional($referrer)->id,
    //     ]);

    //     Auth::login($user);

    //     return redirect()->route('dashboard');
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

        // 1. Find referrer (Level 1)
        $referrer = null;
        if ($request->filled('invitation_code')) {
            $referrer = User::where('referral_code', $request->invitation_code)->first();
        }

        // 2. Create unique IDs
        do {
            $uniqueId = rand(8000000000, 8999999999);
        } while (User::where('unique_id', $uniqueId)->exists());

        do {
            $referralCode = strtoupper(Str::random(6));
        } while (User::where('referral_code', $referralCode)->exists());

        // 3. Create the new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'currency' => $request->currency,
            'password' => Hash::make($request->password),
            'unique_id' => $uniqueId,
            'referral_code' => $referralCode,
            'referrer_id' => optional($referrer)->id,
        ]);

        // 4. Update referral teams up to 3 levels
        $currentReferrer = $referrer;
        $level = 1;

        while ($currentReferrer && $level <= 3) {
            $team = \App\Models\Team::firstOrNew([
                'user_id' => $currentReferrer->id,
                'level' => $level,
            ]);

            // Initialize if new
            if (!$team->exists) {
                $team->members = 0;
                $team->deposit = 0;
                $team->commissions = 0;
            }

            $team->members += 1;
            $team->save();

            $currentReferrer = $currentReferrer->referrer;
            $level++;
        }

        // 5. Log the new user in
        Auth::login($user);

        // 6. Redirect to dashboard
        return redirect()->route('dashboard');
    }


    public function showLoginForm()
    {

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
