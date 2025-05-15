<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
      public function myaccount()
      {
         return view('user.myaccount');
      }


      public function  order()
      {
        return view('user.order');
      }

      public function  assets()
      {
        return view('user.assets');
      }




}
