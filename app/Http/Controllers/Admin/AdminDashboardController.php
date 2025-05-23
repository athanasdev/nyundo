<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\MainAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AdminDashboardController extends Controller
{



    public function index()
    {


        $totalUser = User::count();
        $totalDeposit = Deposit::sum('amount');
        $totalWithdraw = Withdrawal::where('status', 'complete')->sum('amount');
        $totalWithdrawRequest = Withdrawal::where('status', 'pending')->sum('amount');
        
        $admin = Auth::guard('admin')->user();
        return view('admin.dashbord.pages.home', compact('admin', 'totalUser', 'totalDeposit','totalWithdraw','totalWithdrawRequest'));


    }



}
