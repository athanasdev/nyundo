<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\ViewServiceProvider;

class DepositController extends Controller
{
     public function index()
     {
        $user = Auth::user();
         return view('user.layouts.deposit', compact('user'));
     }

    
     public function fundsTransfer(Request $request)
     {
        //   save the data to the database
         return view('user.transfer');

     }

     public function viewDeposit()
     {
        return view('user.view-deposit');
     }


}

