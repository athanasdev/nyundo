<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\ReferralSettings;
use App\Models\ReferralSetting;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{

    public function passwordResetList()
    {
        $resetRequests = DB::table('password_reset_tokens')
            ->select('email', 'username', 'unique_id', 'code', 'created_at')
            ->get();

        return view('admin.dashbord.pages.password', compact('resetRequests'));
    }


    public function traderList()
    {

        $traders = User::select('id', 'unique_id', 'username', 'balance', 'status', 'Withdraw_amount', 'email', 'created_at')
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

            'withdraws' => $deposits,
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


    public function traderDetails($id)
    {
        // Get user details
        $user = User::findOrFail($id);

        // Get transaction history
        $transactions = Transaction::where('user_id', $user->id)->latest()->get();

        // Get team referral data (assuming 3 levels)
        $teams = Team::where('user_id', $user->id)->get()->groupBy('level');
        $referralSummary = [
            'totalMembers' => $teams->flatten()->count(),
            'totalDeposit' => $teams->flatten()->sum('deposit'),
            'totalCommissions' => $teams->flatten()->sum('commissions'),
            'levels' => $teams
        ];

        return view('admin.dashbord.pages.traderdetails', compact('user', 'transactions', 'referralSummary'));
    }

    public function traderBlock(Request $request,  $id)
    {
        $user = User::findOrFail($id);

        $user->status = 'blocked';
        $user->save();

        return redirect()->back()->with('success', 'User has been blocked successfully.');
    }



    public function settings()
    {

        $referralSettings = ReferralSetting::select('id', 'level', 'commission_percentage')->paginate(20);


        return view('admin.dashbord.pages.settings', compact('referralSettings'));
    }
}
