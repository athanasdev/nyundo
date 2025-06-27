<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\Withdrawal;
use App\Models\User;
use App\Models\Transaction;
use App\Models\UserInvestment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

        $settings = DB::table('settings')->first();
        $minWithdrawal = $settings->min_withdraw_amount;
        $withdrawFeePercent = $settings->withdraw_fee_percentage;
        // Show withdraw page if everything is set
        return view('user.layouts.withdraw', compact('user', 'minWithdrawal', 'withdrawFeePercent'));
    }


    // public function withdrawRequest(Request $request)
    // {
    //     Log::info('Withdraw form input:', $request->all());

    //     $request->validate([
    //         'amount' => 'required|numeric|min:0.01',
    //         'withdraw_password' => 'required|string',
    //     ]);

    //     /** @var \Illuminate\Auth\AuthManager $auth */
    //     $auth = auth();
    //     $user = $auth->user();


    //     if (!$user->withdrawal_pin_hash) {
    //         return redirect()->back()->withErrors(['error' => 'You have not set a withdrawal PIN.']);
    //     }

    //     // Validate the withdrawal password
    //     if (!Hash::check($request->withdraw_password, $user->withdrawal_pin_hash)) {
    //         return redirect()->back()->withErrors(['error' => 'Incorrect withdrawal password.']);
    //     }

    //     // Check withdrawal address
    //     if (!$user->withdrawal_address) {
    //         return redirect()->back()->withErrors(['error' => 'No withdrawal address set.']);
    //     }

    //     // Fetch settings
    //     $setting = Setting::first();
    //     if (!$setting) {
    //         return redirect()->back()->withErrors(['error' => 'Withdrawal settings not configured.']);
    //     }

    //     $amount = $request->amount;

    //     // Check minimum withdrawal amount
    //     if ($amount < $setting->min_withdraw_amount) {
    //         return redirect()->back()->withErrors(['error' => 'Amount is less than the minimum withdrawal limit.']);
    //     }

    //     // Check user balance
    //     if ($user->balance < $amount) {
    //         return redirect()->back()->withErrors(['error' => 'Insufficient balance.']);
    //     }

    //     // Calculate fee and net
    //     $fee = ($amount * $setting->withdraw_fee_percentage) / 100;
    //     $netAmount = $amount - $fee;

    //     // Store withdrawal
    //     $withdrawal = new Withdrawal();
    //     $withdrawal->user_id = $user->id;
    //     $withdrawal->payment_address = $user->withdrawal_address;
    //     $withdrawal->withdraw_password = bcrypt($request->withdraw_password); // optional, hashed copy
    //     $withdrawal->status = 'pending';
    //     $withdrawal->amount = $netAmount;
    //     $withdrawal->save();

    //     // Deduct balance
    //     $user->balance -= $amount;
    //     $user->save();

    //     return redirect()->back()->with('success', 'Withdraw request submitted successfully. Amount: ' . $amount . ', Fee: ' . $fee . ', Net: ' . $netAmount);
    // }






    // public function withdrawRequest(Request $request)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric|min:10',
    //         'withdraw_password' => 'required|string',
    //     ]);

    //     /** @var \Illuminate\Auth\AuthManager $auth */
    //     $auth = auth();
    //     $user = $auth->user();


    //     if (!$user->withdrawal_pin_hash) {
    //         return redirect()->back()->withErrors(['error' => 'You have not set a withdrawal PIN.']);
    //     }

    //     if (!Hash::check($request->withdraw_password, $user->withdrawal_pin_hash)) {
    //         return redirect()->back()->withErrors(['error' => 'Incorrect withdrawal password.']);
    //     }

    //     if (!$user->withdrawal_address) {
    //         return redirect()->back()->withErrors(['error' => 'No withdrawal address set.']);
    //     }

    //     $investments = DB::table('user_investments')
    //         ->where('user_id', $user->id)
    //         ->get();

    //     if ($investments->isEmpty()) {
    //         return redirect()->back()->withErrors(['error' => 'A minimum of one trade is required prior to a withdrawal.']);
    //     }

    //     $trades = $investments->filter(function ($inv) {
    //         return in_array($inv->type, ['buy', 'sell']);
    //     });

    //     if ($trades->isEmpty()) {
    //         return redirect()->back()->withErrors(['error' => 'You must complete at least one trade before withdrawing.']);
    //     }

    //     $setting = Setting::first();
    //     if (!$setting) {
    //         return redirect()->back()->withErrors(['error' => 'Withdrawal settings not configured.']);
    //     }

    //     $amount = $request->amount;

    //     if ($amount < $setting->min_withdraw_amount) {
    //         return redirect()->back()->withErrors(['error' => 'Amount is less than the minimum withdrawal limit.']);
    //     }
    //     // e.g., filter out trades with NULL game_end_time or use another relevant timestamp.
    //     $lastTradeEndTime = $trades->max('game_end_time');

    //     // If for some reason game_end_time might be null for a relevant trade
    //     if (!$lastTradeEndTime) {
    //         return redirect()->back()->withErrors(['error' => 'Could not determine last trade completion time.']);
    //     }

    //     // Parse the last trade end time. Assume it's stored in UTC if your APP_TIMEZONE is UTC,
    //     // or specify 'UTC' explicitly if your DB stores UTC but APP_TIMEZONE is different.
    //     $lastTradeCarbon = Carbon::parse($lastTradeEndTime);

    //     // Get current server time (which should be UTC if APP_TIMEZONE is set to UTC)
    //     $nowUtc = Carbon::now();

    //     // Calculate the difference in minutes for precision
    //     $minutesSinceLastTrade = $nowUtc->diffInMinutes($lastTradeCarbon);
    //     $requiredMinutes = 26 * 60; // 24 hours in minutes

    //     if ($minutesSinceLastTrade < $requiredMinutes) {
    //         $remainingSeconds = $requiredMinutes * 60 - $nowUtc->diffInSeconds($lastTradeCarbon);
    //         $remainingHours = floor($remainingSeconds / 3600);
    //         $remainingMinutes = floor(($remainingSeconds % 3600) / 60);
    //         $remainingExactSeconds = $remainingSeconds % 60; // For even more precision

    //        return redirect()->back()->withErrors(['error' => 'One day before making a withdrawal ,you should not trading.']);
    //     }

    //     if ($user->balance < $amount) {
    //         return redirect()->back()->withErrors(['error' => 'Insufficient balance.']);
    //     }

    //     $fee = ($amount * $setting->withdraw_fee_percentage) / 100;
    //     $netAmount = $amount - $fee;

    //     $withdrawal = new Withdrawal();
    //     $withdrawal->user_id = $user->id;
    //     $withdrawal->payment_address = $user->withdrawal_address;
    //     $withdrawal->withdraw_password = bcrypt($request->withdraw_password);
    //     $withdrawal->status = 'pending';
    //     $withdrawal->amount = $netAmount;
    //     $withdrawal->save();

    //     $user->balance -= $amount;
    //     $user->save();

    //     return redirect()->back()->with('success', 'Withdraw request submitted successfully. Amount: ' . $amount . ', Fee: ' . $fee . ', Net: ' . $netAmount);
    // }




    public function withdrawRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'withdraw_password' => 'required|string',
        ]);

        /** @var \Illuminate\Auth\AuthManager $auth */
        $auth = auth();
        $user = auth()->user();

        if (!$user->withdrawal_pin_hash) {
            return redirect()->back()->withErrors(['error' => 'You have not set a withdrawal PIN.']);
        }

        if (!Hash::check($request->withdraw_password, $user->withdrawal_pin_hash)) {
            return redirect()->back()->withErrors(['error' => 'Incorrect withdrawal password.']);
        }

        if (!$user->withdrawal_address) {
            return redirect()->back()->withErrors(['error' => 'No withdrawal address set.']);
        }

        $investments = DB::table('user_investments')
            ->where('user_id', $user->id)
            ->get();

        if ($investments->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'A minimum of one trade is required prior to a withdrawal.']);
        }

        // Filter only real trades with non-null end time
        $trades = $investments->filter(function ($inv) {
            return in_array($inv->type, ['buy', 'sell']) && !is_null($inv->game_end_time);
        });

        if ($trades->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'You must complete at least one valid trade before withdrawing.']);
        }

        $setting = Setting::first();
        if (!$setting) {
            return redirect()->back()->withErrors(['error' => 'Withdrawal settings not configured.']);
        }

        $amount = $request->amount;

        if ($amount < $setting->min_withdraw_amount) {
            return redirect()->back()->withErrors(['error' => 'Amount is less than the minimum withdrawal limit.']);
        }

        $lastTradeEndTime = $trades->max('game_end_time');

        if (!$lastTradeEndTime) {
            return redirect()->back()->withErrors(['error' => 'Could not determine last trade completion time.']);
        }

        $lastTradeCarbon = Carbon::parse($lastTradeEndTime);
        $nowUtc = Carbon::now();

        // Require 24 full hours between last trade and withdrawal
        $eligibleTime = $lastTradeCarbon->copy()->addHours(24);

        if ($nowUtc->lessThan($eligibleTime)) {
            $remaining = $eligibleTime->diff($nowUtc);
            $remainingHours = $remaining->h;
            $remainingMinutes = $remaining->i;
            $remainingSeconds = $remaining->s;

            return redirect()->back()->withErrors([
                'error' => "One day before making a withdrawal ,you should not trading."
            ]);
        }

        if ($user->balance < $amount) {
            return redirect()->back()->withErrors(['error' => 'Insufficient balance.']);
        }

        // Calculate fee and net amount
        $fee = ($amount * $setting->withdraw_fee_percentage) / 100;
        $netAmount = $amount - $fee;

        // Save withdrawal
        $withdrawal = new Withdrawal();
        $withdrawal->user_id = $user->id;
        $withdrawal->payment_address = $user->withdrawal_address;
        $withdrawal->withdraw_password = bcrypt($request->withdraw_password);
        $withdrawal->status = 'pending';
        $withdrawal->amount = $netAmount;
        $withdrawal->save();

        // Deduct from balance
        $user->balance -= $amount;
        $user->save();

        return redirect()->back()->with('success', "Withdraw request submitted. Amount: $amount, Fee: $fee, Net: $netAmount");
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


    public function showChangeWithdrawalAddressForm()
    {

        return view('user.layouts.change-withdraw-address');
    }

    /**
     * Update the user's withdrawal address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWithdrawalAddress(Request $request)
    {
        $user = Auth::user();

        // 1. Check if the user has a withdrawal PIN set
        if (is_null($user->withdrawal_pin_hash)) {
            // You might want to redirect them to a page to set up their PIN first.
            // For now, we'll return an error.
            return back()->with('error', __('messages.withdrawal_pin_not_set_error', ['fallback' => 'Your withdrawal PIN is not set. Please set it up first.']));
            // Example for localization file:
            // 'withdrawal_pin_not_set_error' => 'Your withdrawal PIN is not set. Please set it up first. You can do so <a href=":url">here</a>.',
            // You would then pass the URL: ->with('error', __('messages.withdrawal_pin_not_set_error', ['url' => route('user.pin.setup')]))
        }

        // 2. Validate the request data
        $request->validate([
            'new_withdrawal_address' => [
                'required',
                'string',
                'max:255',
                // Basic regex for TRC20 address (starts with 'T', 34 chars, alphanumeric)
                // More robust validation might involve a checksum or library if available
                'regex:/^T[1-9A-HJ-NP-Za-km-z]{33}$/',
            ],
            'withdrawal_pin' => ['required', 'string'],
        ], [
            'new_withdrawal_address.regex' => __('messages.invalid_trc20_address_format', ['fallback' => 'The new withdrawal address format is invalid for TRC20.']),
            // Example for localization file:
            // 'invalid_trc20_address_format' => 'The new withdrawal address format is invalid for TRC20.',
        ]);

        // 3. Verify the withdrawal PIN
        if (!Hash::check($request->withdrawal_pin, $user->withdrawal_pin_hash)) {
            // Option 1: Redirect back with a general error
            // return back()->with('error', __('messages.incorrect_withdrawal_pin_error', ['fallback' => 'The withdrawal PIN you entered is incorrect.']));

            // Option 2: Throw a ValidationException to show error next to the field (often better UX)
            throw ValidationException::withMessages([
                'withdrawal_pin' => __('messages.incorrect_withdrawal_pin_field_error', ['fallback' => 'The provided withdrawal PIN is incorrect.']),
            ]);
            // Example for localization file:
            // 'incorrect_withdrawal_pin_field_error' => 'The provided withdrawal PIN is incorrect.',
        }

        // 4. Update the withdrawal address
        $user->withdrawal_address = $request->new_withdrawal_address;
        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', __('messages.withdrawal_address_updated_success', ['fallback' => 'Your withdrawal address has been updated successfully.']));
        // Example for localization file:
        // 'withdrawal_address_updated_success' => 'Your withdrawal address has been updated successfully.',
    }
}
