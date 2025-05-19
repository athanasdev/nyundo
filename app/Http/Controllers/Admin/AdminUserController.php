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



     public function systemLogs()
     {
         return view('admin.dashbord.pages.logs');
     }

     public  function depost()
     {
         return view('admin.dashbord.pages.depost');
     }

     public function withdraw()
     {
        return view('admin.dashbord.pages.withdraw');
     }

     public function team()
     {
         return view('admin.dashbord.pages.team');
     }

      public function traderDetails()
      {
          return view('admin.dashbord.pages.traderdetails');
      }



}
