<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{

    public function index()
    {
        return view('user.withdrawal-method');
    }

    public function withdraw()
    {
        return view('user.withdraw');
    }


}
