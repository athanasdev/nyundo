<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;


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



    public function aitrading()
    {
        return view('user.aitrading');
    }

    public function bonuses()
    {
        return view('user.bonuses');
    }
}
