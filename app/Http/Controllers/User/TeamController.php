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




    public function team()
    {
        $user = Auth::user();

        if (!$user) {
            // Handle case where user is not logged in, perhaps redirect to login
            return redirect()->route('login');
        }

        // Level 1 referrals (direct referrals)
        $level1_members = User::where('referrer_id', $user->id)->get();
        $level1_count = $level1_members->count();

        // Level 2 referrals
        $level2_members = collect();
        foreach ($level1_members as $level1_member) {
            $level2_members = $level2_members->merge(User::where('referrer_id', $level1_member->id)->get());
        }
        $level2_count = $level2_members->count();

        // Level 3 referrals
        $level3_members = collect();
        foreach ($level2_members as $level2_member) {
            $level3_members = $level3_members->merge(User::where('referrer_id', $level2_member->id)->get());
        }
        $level3_count = $level3_members->count();

        $total_registered_users = $level1_count + $level2_count + $level3_count;
        // For "Active Users," you would need a column or a way to determine if a user is active (e.g., has made a deposit, logged in recently, etc.).
        // For demonstration, we'll assume 0 for now as there's no 'active' status in your provided schema.
        $active_users = 0; // You'll need to implement logic to determine active users

        // You'll need to implement logic for Deposit and Commissions based on your application's flow.
        // For now, they are set to 0.00.
        $level1_deposit = 0.00;
        $level1_commissions = 0.00;
        $level2_deposit = 0.00;
        $level2_commissions = 0.00;
        $level3_deposit = 0.00;
        $level3_commissions = 0.00;
        $total_deposits = 0.00;
        $total_commissions = 0.00;


        return view('user.team', compact(
            'user',
            'total_registered_users',
            'active_users',
            'level1_count',
            'level2_count',
            'level3_count',
            'level1_deposit',
            'level1_commissions',
            'level2_deposit',
            'level2_commissions',
            'level3_deposit',
            'level3_commissions',
            'total_deposits',
            'total_commissions'
        ));
    }



    // public function aitrading()
    // {
    //     return view('user.aitrading');
    // }

    // public function aitrading()
    // {
    //     $now = Carbon::now(); // Get the current date and time
    //     $currentTime = $now->format('H:i:s'); // Still useful for displaying the current time if needed

    //     // To correctly check if the game is active NOW,
    //     // you should compare the current time with the time parts of start_time and end_time,
    //     // AND ensure the game is active for today.

    //     $activeGameSetting = GameSetting::where('is_active', true)
    //         // Use whereTime for comparing only the time part of the columns
    //         ->whereTime('start_time', '<=', $currentTime)
    //         ->whereTime('end_time', '>=', $currentTime)
    //         // Additionally, check if the game setting is for the current day
    //         // This assumes your game_settings are set up daily.
    //         // If start_time and end_time also define the *day* of the game,
    //         // you might need to adjust this further.
    //         // For example, if a setting from yesterday could still be active today if it crosses midnight:
    //         // ->whereDate('start_time', '<=', $now->toDateString())
    //         // ->whereDate('end_time', '>=', $now->toDateString())
    //         // A more precise way if your start/end times can span across midnight is to use full Carbon objects
    //         // with the current date:
    //         ->where(function ($query) use ($now, $currentTime) {
    //             // Scenario 1: Game starts and ends on the same day
    //             $query->whereDate('start_time', $now->toDateString())
    //                 ->whereTime('start_time', '<=', $currentTime)
    //                 ->whereTime('end_time', '>=', $currentTime);
    //         })
    //         ->orWhere(function ($query) use ($now, $currentTime) {
    //             // Scenario 2: Game starts on previous day and ends today (crosses midnight)
    //             $query->whereDate('start_time', $now->subDay()->toDateString()) // starts yesterday
    //                 ->whereTime('start_time', '>', $currentTime) // started after current time yesterday (e.g. 11PM yesterday)
    //                 ->whereDate('end_time', $now->addDay()->toDateString())   // ends today
    //                 ->whereTime('end_time', '>=', $currentTime); // ends after current time today (e.g. 1AM today)
    //         })
    //         ->first();


    //     // Reverting to a simpler and more common scenario based on your data:
    //     // Assuming 'start_time' and 'end_time' are actual datetime columns
    //     // and you want to check if the CURRENT datetime is within that range.
    //     // If the date part of game_settings is always irrelevant or set to a future date,
    //     // but only the *time* matters for daily activity, then 'whereTime' is correct.
    //     // However, your database shows future dates (2025-05-26).
    //     // Let's go with the most common interpretation:
    //     // The game is active if the current time is between the start_time and end_time of a specific setting.

    //     $activeGameSetting = GameSetting::where('is_active', true)
    //         ->where('start_time', '<=', $now) // Compare against current Carbon instance
    //         ->where('end_time', '>=', $now)   // Compare against current Carbon instance
    //         ->first();


    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();

    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Please log in to view your investments.');
    //     }

    //     $userInvestments = $user->investments()->where('status', 'active')->get();

    //     return view('user.aitrading', compact('activeGameSetting', 'userInvestments'));
    // }

    // public function aitrading()
    // {
    //     // Find the first game setting where 'is_active' is true.
    //     // This will retrieve it regardless of its start_time or end_time.
    //     $activeGameSetting = GameSetting::where('is_active', true)->first();

    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();

    //     // It's crucial to check if a user is actually logged in before proceeding.
    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Please log in to view your investments.');
    //     }

    //     // Fetch user's active investments
    //     $userInvestments = $user->investments()->where('status', 'active')->get();

    //     // Pass the simplified activeGameSetting and userInvestments to the view
    //     return view('user.aitrading', compact('activeGameSetting', 'userInvestments'));
    // }

    public function aitrading()
    {
        // First, fetch the active game setting based on its 'is_active' status
        // (If you also want to check if it's currently within its time window,
        // you'd re-add the 'where' conditions for start_time and end_time vs Carbon::now())
        $activeGameSetting = GameSetting::where('is_active', true)->first();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if a user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your investments.');
        }

        // --- Timezone Conversion for Display ---
        // Assume the database stores times in UTC (recommended Laravel/PHP default behavior)
        // Define the target timezone for display. This should ideally come from user preferences.
        // For demonstration, let's use 'Africa/Dar_es_Salaam' (EAT, UTC+3) as per your example.
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
        return view('user.aitrading', compact('activeGameSetting', 'userInvestments'));
    }


    public function bonuses()
    {
        return view('user.bonuses');
    }
}
