<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AdminDashboardController extends Controller
{



    public function index()
    {

        $admin = Auth::guard('admin')->user();
         return view('admin.dashbord.pages.home', compact('admin'));

    }




}

