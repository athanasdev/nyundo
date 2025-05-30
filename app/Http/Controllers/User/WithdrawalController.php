<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WithdrawalController extends Controller
{
    public function withdraw()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        // Check if withdrawal settings are missing
        if (is_null($user->withdrawal_address) || is_null($user->withdrawal_pin_hash)) {
            return redirect()->route('withdraw.setup')->with('warning', 'Please set your withdrawal address and PIN first.');
        }

        // Show withdraw page if everything is set
        return view('user.layouts.withdraw', compact('user'));
    }

    public function withdrawRequest(Request $request)
    {
         Log::info('Withdraw form input:', $request->all());
         return null;
    }

    public function setup()
    {
        $user = Auth::user();
        return view('user.layouts.setup_withdraw_details', compact('user'));
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'withdrawal_address' => 'required|string|max:255',
            'withdrawal_pin' => 'required|string|min:4|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->withdrawal_address = $request->withdrawal_address;
        $user->withdrawal_pin_hash = bcrypt($request->withdrawal_pin);
        $user->withdrawal_pin_set_at = now();
        $user->save();

        return redirect()->route('withdraw')->with('success', 'Withdrawal settings saved successfully.');
    }


}
