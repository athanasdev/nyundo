<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{

    public function index()
    {
        return view('user.withdrawal-method');
    }

    public function withdraw()
    {
        $user = Auth::user();
        return view('user.layouts.withdraw', compact('user'));
    }


}
