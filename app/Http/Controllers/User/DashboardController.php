<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Your User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function home()
    {
        $user = Auth::user();
        return view('user.layouts.home', compact('user'));
    }



    public function myaccount()
    {
        $user = Auth::user();

        return view('user.myaccount', compact('user'));
    }


    public function  order()
    {
        return view('user.order');
    }

    public function  assets()
    {
        return view('user.layouts.assets');
    }

    public function language()
    {
        return view('user.language');
    }
}
