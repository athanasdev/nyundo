<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Session; // No longer strictly needed if not using Session::flash() directly

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Referral Commissions';
        $referrals = Referral::orderBy('level')->get();
        return view('admin.dashbord.referral.index', compact('pageTitle', 'referrals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level'   => 'required|integer|min:1|unique:referrals,level',
            'percent' => 'required|numeric|min:0',
        ]);

        try {
            $referral = new Referral();
            $referral->level = $request->level;
            $referral->percent = $request->percent;
            $referral->status = 1;
            $referral->save();

            return back()->with('success', 'Referral level added successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to add referral: ' . $e->getMessage());
        }
    }
}
