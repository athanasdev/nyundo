<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\ReferralSettings;
use App\Models\ReferralSetting;
  use App\Models\Deposit;


class AdminUserController extends Controller
{

    public function passwordResetList()
    {
        return view('admin.dashbord.pages.password');
    }



    public function traderList()
    {

        $traders = User::select('id', 'username', 'balance', 'status', 'Withdraw_amount', 'email', 'created_at')
            ->paginate(10);

        $totalUsers = User::count();

        $blockedUsers = User::where('status', 'blocked')->count();

        $activeTraders = User::where('status', 'active')->count();

        $withdrawRequests = Withdrawal::where('status', 'pending')->distinct('user_id')->count('user_id');


        return view('admin.dashbord.pages.trader', compact(
            'traders',
            'totalUsers',
            'blockedUsers',
            'activeTraders',
            'withdrawRequests'
        ));
    }


    public function systemLogs()
    {
        return view('admin.dashbord.pages.logs');
    }



    public function depost()
    {
        $deposits = Deposit::with('user')->orderBy('created_at', 'desc')->paginate(10);

        $pendingCount = Deposit::where('status', 'pending')->count();
        $completedCount = Deposit::where('status', 'completed')->count();

        $pendingTotal = Deposit::where('status', 'pending')->sum('amount');
        $completedTotal = Deposit::where('status', 'completed')->sum('amount');

        return view('admin.dashbord.pages.depost', [
            'withdraws' => $deposits, // keep the variable name as in the Blade view or change it in both places
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'pendingTotal' => $pendingTotal,
            'completedTotal' => $completedTotal,
        ]);

    }

    

    public function withdraw()
    {
        // Optimized aggregate queries
        $pendingCount = Withdrawal::where('status', 'pending')->count();
        $completedCount = Withdrawal::where('status', 'completed')->count();

        $pendingTotal = Withdrawal::where('status', 'pending')->sum('amount');
        $completedTotal = Withdrawal::where('status', 'completed')->sum('amount');

        // Eager load users to prevent N+1
        $withdraws = Withdrawal::with('user')->latest()->paginate(10);

        return view('admin.dashbord.pages.withdraw', compact(
            'pendingCount',
            'completedCount',
            'pendingTotal',
            'completedTotal',
            'withdraws'
        ));
    }

    public function team()
    {
        return view('admin.dashbord.pages.team');
    }

    public function traderDetails()
    {
        return view('admin.dashbord.pages.traderdetails');
    }



    public function settings()
    {

        $referralSettings = ReferralSetting::select('id', 'level', 'commission_percentage')->paginate(20);


        return view('admin.dashbord.pages.settings', compact('referralSettings'));
    }
}
