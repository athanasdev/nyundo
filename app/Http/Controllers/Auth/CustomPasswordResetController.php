<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class CustomPasswordResetController extends Controller
{
    // Show the form where user enters email and token/password inputs
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Send reset code to user email if email exists
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => "We can't find an account with this email."]);
        }

        // Generate token
        $token = Str::random(6); // 6-char code
        $code = mt_rand(100000, 999999);

        // Store token + username + unique_id
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'code' => $code,
                'username' => $user->username,
                'unique_id' => $user->unique_id,
                'created_at' => now()
            ]
        );

        // Send email with the token
        Mail::raw("Your password reset code is: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset Code');
        });

        session(['reset_email' => $request->email]);

        return redirect()->route('password.set.new')->with('status', 'We have emailed your password reset code!');
    }

    // Reset password if token matches
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['email' => "No reset request found for this email."]);
        }

        if ($request->code !== $record->code) {
            return back()->withErrors(['code' => 'Invalid reset code.']);
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            return back()->withErrors(['token' => 'Reset code expired. Please request a new one.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => "User not found."]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password successfully reset. You can now login.');

    }


    // ✅ This is the missing method!
    public function showSetNewPasswordForm(Request $request)
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Please start the reset process again.']);
        }

        return view('auth.set-new-password', ['email' => $email]);

    }



}

