<?php

namespace App\Http\Controllers;

use App\Models\User; // Your User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ImpersonateController extends Controller
{

    public function loginAsUser($id)
    {
        // No need for 'if (!Auth::guard('admin')->check())' here if the route is protected by 'auth:admin' middleware
        Session::put('impersonated_by', Auth::guard('admin')->id()); // Store current admin ID

        Auth::guard('admin')->logout(); // Log out the admin

        $user = User::findOrFail($id);
        Auth::guard('web')->login($user); // Log in the user

        return redirect()->route('dashboard'); // Redirect to user dashboard
    }

    public function leave()
    {
        if (!Session::has('impersonated_by')) {
            return redirect()->route('dashboard'); // Or handle error if no admin ID found
        }

        $adminId = Session::get('impersonated_by');

        Auth::guard('web')->logout(); // Log out the impersonated user

        Auth::guard('admin')->loginUsingId($adminId); // Log back in the original admin

        Session::forget('impersonated_by'); // Clear the session key

        return redirect()->route('admin.trader'); // Redirect back to admin dashboard

        
    }
}
