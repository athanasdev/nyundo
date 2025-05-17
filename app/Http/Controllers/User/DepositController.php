<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\ViewServiceProvider;

class DepositController extends Controller
{
     public function index()
     {
         return view('user.deposit');
     }

     public function buyCrypto()
     {
        return view('user.buycrypto');
     }

     public function transfer()
     {
        return view('user.transfer');
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

