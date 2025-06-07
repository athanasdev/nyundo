<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
// Assuming you have a GameSetting model // Import the Auth facade
use Carbon\Carbon;
use App\Models\GameSetting; // Your GameSetting model
use App\Models\Transaction;
use App\Models\UserInvestment; // Your UserInvestment model


class TeamController extends Controller
{




    //   REFERRAL TEM AMANGEMENTS

    public function index()
    {
        $pageTitle = 'Manage Referral';
        $referrals = Referral::get();
        return view('admin.referral.index', compact('pageTitle', 'referrals'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'level'     => 'required|array|min:1',
            'level.*'   => 'required|integer|min:1',
            'percent'   => 'required|array',
            'percent.*' => 'required|numeric|gte:0',
        ]);


        Referral::truncate();

        $data = [];
        for ($a = 0; $a < count($request->level); $a++) {
            $data[] = [
                'level'   => $request->level[$a],
                'percent' => $request->percent[$a],
            ];
        }
        Referral::insert($data);

        $notify[] = ['success', 'Referral generated successfully'];
        return back()->withNotify($notify);
    }

    public function status($key)
    {

        $notify[] = ['success', 'Referral commission status updated successfully'];
        return back()->withNotify($notify);
    }



    // In your Laravel Controller's team() method

    // public function team()
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login');
    //     }

    //     // Level 1 referrals (direct referrals)
    //     $level1_members = User::where('referrer_id', $user->id)->get();
    //     $level1_count = $level1_members->count();
    //     // Count active Level 1 members using the 'status' field
    //     $level1_active_count = User::where('referrer_id', $user->id)
    //         ->where('balance', '>', 15) // <<< CORRECTED LOGIC
    //         ->count();

    //     // Level 2 referrals
    //     $level2_members = collect();
    //     $level2_active_count = 0;
    //     if ($level1_members->isNotEmpty()) {
    //         foreach ($level1_members as $level1_member) {
    //             $current_level2_members = User::where('referrer_id', $level1_member->id)->get();
    //             $level2_members = $level2_members->merge($current_level2_members);
    //             // Count active ones among these L2 members
    //             $level2_active_count += User::where('referrer_id', $level1_member->id)
    //                 ->where('balance', '>', 15)  // <<< CORRECTED LOGIC
    //                 ->count();
    //         }
    //     }
    //     $level2_count = $level2_members->count(); // Total L2 members

    //     // Level 3 referrals
    //     $level3_members = collect();
    //     $level3_active_count = 0;
    //     if ($level2_members->isNotEmpty()) { // Iterate through all collected L2 members
    //         foreach ($level2_members as $level2_member) {
    //             $current_level3_members = User::where('referrer_id', $level2_member->id)->get();
    //             $level3_members = $level3_members->merge($current_level3_members);
    //             // Count active ones among these L3 members
    //             $level3_active_count += User::where('referrer_id', $level2_member->id)
    //                 ->where('balance', '>', 15)  // <<< CORRECTED LOGIC
    //                 ->count();
    //         }
    //     }
    //     $level3_count = $level3_members->count(); // Total L3 members

    //     $total_registered_users = $level1_count + $level2_count + $level3_count;

    //     // Total active users across all three levels
    //     $active_users = $level1_active_count + $level2_active_count + $level3_active_count;

    //     // --- Calculate Deposits and Commissions ---
    //     $level1_deposit = $level1_members->sum('balance');
    //     $level1_commissions = $level1_deposit * 0.08;

    //     $level2_deposit = $level2_members->sum('balance');
    //     $level2_commissions = $level2_deposit * 0.04;

    //     $level3_deposit = $level3_members->sum('balance');
    //     $level3_commissions = $level3_deposit * 0.02;

    //     $total_deposits = $level1_deposit + $level2_deposit + $level3_deposit;
    //     $total_commissions = $level1_commissions + $level2_commissions + $level3_commissions;

    //     return view('user.layouts.team', compact(
    //         'user',
    //         'total_registered_users',
    //         'active_users', // This now uses the status field
    //         'level1_count',
    //         'level2_count',
    //         'level3_count',
    //         // You can also pass individual active counts if your view needs them
    //         // 'level1_active_count',
    //         // 'level2_active_count',
    //         // 'level3_active_count',
    //         'level1_deposit',
    //         'level1_commissions',
    //         'level2_deposit',
    //         'level2_commissions',
    //         'level3_deposit',
    //         'level3_commissions',
    //         'total_deposits',
    //         'total_commissions',
    //         'level1_members',
    //         'level2_members',
    //         'level3_members'

    //     ));

    // }


    public function team()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // --- 1. Get Team Members & Their IDs ---
        $level1_members = User::where('referrer_id', $user->id)->get();
        $level1_ids = $level1_members->pluck('id');

        $level2_members = User::whereIn('referrer_id', $level1_ids)->get();
        $level2_ids = $level2_members->pluck('id');

        $level3_members = User::whereIn('referrer_id', $level2_ids)->get();
        $level3_ids = $level3_members->pluck('id');

        // --- 2. Calculate Commissions from Historical Transactions ---
        $level1_commissions = Transaction::where('user_id', $user->id)->where('description', 'like', 'Level 1%')->sum('amount');
        $level2_commissions = Transaction::where('user_id', $user->id)->where('description', 'like', 'Level 2%')->sum('amount');
        $level3_commissions = Transaction::where('user_id', $user->id)->where('description', 'like', 'Level 3%')->sum('amount');
        $total_commissions = $level1_commissions + $level2_commissions + $level3_commissions;

        // --- 3. Calculate Total Team Investment (RENAMED BACK to match your view) ---
        $level1_deposit = UserInvestment::whereIn('user_id', $level1_ids)->sum('amount');
        $level2_deposit = UserInvestment::whereIn('user_id', $level2_ids)->sum('amount');
        $level3_deposit = UserInvestment::whereIn('user_id', $level3_ids)->sum('amount');
        $total_deposits = $level1_deposit + $level2_deposit + $level3_deposit;

        // --- 4. Calculate Active User & Team Counts ---
        $level1_active_count = User::whereIn('id', $level1_ids)->where('balance', '>', 15)->count();
        $level2_active_count = User::whereIn('id', $level2_ids)->where('balance', '>', 15)->count();
        $level3_active_count = User::whereIn('id', $level3_ids)->where('balance', '>', 15)->count();
        $active_users = $level1_active_count + $level2_active_count + $level3_active_count;

        $level1_count = $level1_members->count();
        $level2_count = $level2_members->count();
        $level3_count = $level3_members->count();
        $total_registered_users = $level1_count + $level2_count + $level3_count;

        // --- 5. Return All Data to the View (RENAMED BACK to match your view) ---
        return view('user.layouts.team', compact(
            'user',
            'total_registered_users',
            'active_users',
            'level1_count',
            'level2_count',
            'level3_count',
            'level1_deposit',
            'level2_deposit',
            'level3_deposit', // <-- Corrected name
            'total_deposits',                                     // <-- Corrected name
            'level1_commissions',
            'level2_commissions',
            'level3_commissions',
            'total_commissions',
            'level1_members',
            'level2_members',
            'level3_members'
        ));

    }



    public function bonuses()
    {
        return view('user.bonuses');
    }
}
