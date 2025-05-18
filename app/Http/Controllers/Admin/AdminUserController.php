<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{

     public function passwordResetList()
     {
         return view('admin.dashbord.pages.password');
     }

     public function traderList()
     {
         return view('admin.dashbord.pages.trader');
     }

     

}
