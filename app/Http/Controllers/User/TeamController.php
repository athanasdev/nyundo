<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use App\Models\GameSetting; // Assuming you have a GameSetting model // Import the Auth facade
use Carbon\Carbon;

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





    // public function team()
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login');
    //     }

    //     // Level 1 referrals (direct referrals)
    //     $level1_members = User::where('referrer_id', $user->id)->get();
    //     $level1_count = $level1_members->count();

    //     // Level 2 referrals
    //     $level2_members = collect(); // Initialize as an empty collection
    //     if ($level1_members->isNotEmpty()) { // Check if there are level 1 members to iterate
    //         foreach ($level1_members as $level1_member) {
    //             $level2_members = $level2_members->merge(User::where('referrer_id', $level1_member->id)->get());
    //         }
    //     }
    //     $level2_count = $level2_members->count();

    //     // Level 3 referrals
    //     $level3_members = collect(); // Initialize as an empty collection
    //     if ($level2_members->isNotEmpty()) { // Check if there are level 2 members to iterate
    //         foreach ($level2_members as $level2_member) {
    //             $level3_members = $level3_members->merge(User::where('referrer_id', $level2_member->id)->get());
    //         }
    //     }
    //     $level3_count = $level3_members->count();

    //     $total_registered_users = $level1_count + $level2_count + $level3_count;
    //     $active_users = 0; // You'll need to implement logic to determine active users

    //     // Placeholder for deposit and commission calculations
    //     $level1_deposit = 0.00;
    //     $level1_commissions = 0.00;
    //     $level2_deposit = 0.00;
    //     $level2_commissions = 0.00;
    //     $level3_deposit = 0.00;
    //     $level3_commissions = 0.00;
    //     $total_deposits = 0.00;
    //     $total_commissions = 0.00;

    //     // Implement logic to calculate actual deposits and commissions for each level
    //     // Example for level 1 deposits (assuming 'balance' field on user represents their total deposit for simplicity):
    //     // $level1_deposit = $level1_members->sum('balance');
    //     // You'd need a proper transactions or deposits table for accurate sums.

    //     return view('user.layouts.team', compact(
    //         'user',
    //         'total_registered_users',
    //         'active_users',
    //         'level1_count',
    //         'level2_count',
    //         'level3_count',
    //         'level1_deposit',
    //         'level1_commissions',
    //         'level2_deposit',
    //         'level2_commissions',
    //         'level3_deposit',
    //         'level3_commissions',
    //         'total_deposits',
    //         'total_commissions',
    //         'level1_members',     // <-- ADD THIS
    //         'level2_members',     // <-- ADD THIS
    //         'level3_members'      // <-- ADD THIS
    //     ));
    // }


    // public function team()
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login');
    //     }

    //     // Level 1 referrals (direct referrals)
    //     $level1_members = User::where('referrer_id', $user->id)->get();
    //     $level1_count = $level1_members->count();

    //     // Level 2 referrals
    //     $level2_members = collect();
    //     if ($level1_members->isNotEmpty()) {
    //         foreach ($level1_members as $level1_member) {
    //             $level2_members = $level2_members->merge(User::where('referrer_id', $level1_member->id)->get());
    //         }
    //     }
    //     $level2_count = $level2_members->count();

    //     // Level 3 referrals
    //     $level3_members = collect();
    //     if ($level2_members->isNotEmpty()) {
    //         foreach ($level2_members as $level2_member) {
    //             $level3_members = $level3_members->merge(User::where('referrer_id', $level2_member->id)->get());
    //         }
    //     }
    //     $level3_count = $level3_members->count();

    //     $total_registered_users = $level1_count + $level2_count + $level3_count;


    //     $active_users = $level1_members->where('balance', '>', 0)->count();

    //     // --- Calculate Deposits and Commissions ---
    //     // Assuming 'balance' on the User model represents the total deposited amount by that user

    //     $level1_deposit = $level1_members->sum('balance');
    //     $level1_commissions = $level1_deposit * 0.08; // 8% commission for level 1

    //     $level2_deposit = $level2_members->sum('balance');
    //     $level2_commissions = $level2_deposit * 0.04; // 4% commission for level 2

    //     $level3_deposit = $level3_members->sum('balance');
    //     $level3_commissions = $level3_deposit * 0.02; // 2% commission for level 3

    //     $total_deposits = $level1_deposit + $level2_deposit + $level3_deposit;
    //     $total_commissions = $level1_commissions + $level2_commissions + $level3_commissions;

    //     return view('user.layouts.team', compact(
    //         'user',
    //         'total_registered_users',
    //         'active_users',
    //         'level1_count',
    //         'level2_count',
    //         'level3_count',
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


    // In your Laravel Controller's team() method

    public function team()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Level 1 referrals (direct referrals)
        $level1_members = User::where('referrer_id', $user->id)->get();
        $level1_count = $level1_members->count();
        // Count active Level 1 members using the 'status' field
        $level1_active_count = User::where('referrer_id', $user->id)
            ->where('balance', '>', 15) // <<< CORRECTED LOGIC
            ->count();

        // Level 2 referrals
        $level2_members = collect();
        $level2_active_count = 0;
        if ($level1_members->isNotEmpty()) {
            foreach ($level1_members as $level1_member) {
                $current_level2_members = User::where('referrer_id', $level1_member->id)->get();
                $level2_members = $level2_members->merge($current_level2_members);
                // Count active ones among these L2 members
                $level2_active_count += User::where('referrer_id', $level1_member->id)
                    ->where('balance', '>', 15)  // <<< CORRECTED LOGIC
                    ->count();
            }
        }
        $level2_count = $level2_members->count(); // Total L2 members

        // Level 3 referrals
        $level3_members = collect();
        $level3_active_count = 0;
        if ($level2_members->isNotEmpty()) { // Iterate through all collected L2 members
            foreach ($level2_members as $level2_member) {
                $current_level3_members = User::where('referrer_id', $level2_member->id)->get();
                $level3_members = $level3_members->merge($current_level3_members);
                // Count active ones among these L3 members
                $level3_active_count += User::where('referrer_id', $level2_member->id)
                    ->where('balance', '>', 15)  // <<< CORRECTED LOGIC
                    ->count();
            }
        }
        $level3_count = $level3_members->count(); // Total L3 members

        $total_registered_users = $level1_count + $level2_count + $level3_count;

        // Total active users across all three levels
        $active_users = $level1_active_count + $level2_active_count + $level3_active_count;

        // --- Calculate Deposits and Commissions ---
        $level1_deposit = $level1_members->sum('balance');
        $level1_commissions = $level1_deposit * 0.08;

        $level2_deposit = $level2_members->sum('balance');
        $level2_commissions = $level2_deposit * 0.04;

        $level3_deposit = $level3_members->sum('balance');
        $level3_commissions = $level3_deposit * 0.02;

        $total_deposits = $level1_deposit + $level2_deposit + $level3_deposit;
        $total_commissions = $level1_commissions + $level2_commissions + $level3_commissions;

        return view('user.layouts.team', compact(
            'user',
            'total_registered_users',
            'active_users', // This now uses the status field
            'level1_count',
            'level2_count',
            'level3_count',
            // You can also pass individual active counts if your view needs them
            // 'level1_active_count',
            // 'level2_active_count',
            // 'level3_active_count',
            'level1_deposit',
            'level1_commissions',
            'level2_deposit',
            'level2_commissions',
            'level3_deposit',
            'level3_commissions',
            'total_deposits',
            'total_commissions',
            'level1_members',
            'level2_members',
            'level3_members'
        ));
    }



    public function aitrading()
    {

        $activeGameSetting = GameSetting::where('is_active', true)->first();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if a user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your investments.');
        }


        $userTimezone = 'Africa/Dar_es_Salaam'; // You might fetch this from $user->timezone_preference;

        if ($activeGameSetting) {
            // Convert start_time and end_time from UTC (database) to the user's local timezone
            $activeGameSetting->start_time_local = Carbon::parse($activeGameSetting->start_time)->timezone($userTimezone);
            $activeGameSetting->end_time_local = Carbon::parse($activeGameSetting->end_time)->timezone($userTimezone);
        }
        // --- End Timezone Conversion ---

        // Fetch user's active investments
        $userInvestments = $user->investments()->where('status', 'active')->get();

        // Pass the activeGameSetting (now with local time properties) and userInvestments to the view
        return view('user.layouts.bot', compact('activeGameSetting', 'userInvestments', 'user'));
    }


    public function bonuses()
    {
        return view('user.bonuses');
    }
}
