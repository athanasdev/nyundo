<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User; // Your User model
use App\Models\UserInvestment;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function home()
    {
        $user = Auth::user();
        return view('user.layouts.home', compact('user'));
    }



    // public function myaccount()
    // {
    //     $user = Auth::user();

    //     $transactions = Transaction::where('user_id', $user->id)
    //         ->orderBy('created_at', 'desc')
    //         ->select('id', 'type', 'amount', 'description', 'currency', 'status', 'created_at', 'item_name')
    //         ->get();


    //     // Calculate Total Referral Earning (example query, adjust as needed)
    //     $totalReferralEarning = Transaction::where('user_id', $user->id)
    //         ->where(function ($query) {
    //             $query->where('description', 'like', '%Referral Commission%')
    //                 ->orWhere('description', 'like', '%commission from%'); // Adjust based on your descriptions
    //         })
    //         ->where('type', 'credit') // Ensure it's an earning
    //         ->sum('amount');

    //     // Invested Capital - This might be more complex.
    //     // You might have a dedicated field or need to sum specific transaction types.
    //     // Example: Sum of 'debit' transactions with 'investment' in description
    //     $investedCapital = Transaction::where('user_id', $user->id)
    //         ->where('type', 'debit')
    //         ->where(function ($query) {
    //             $query->where('description', 'like', '%investment in%')
    //                 ->orWhere('description', 'like', '%trading in%'); // And not a loss
    //         })
    //         // This is a simplified example and might need refinement
    //         // to accurately reflect only current investments vs total spent.
    //         ->sum('amount');

    //     $totalWithdraws = Withdrawal::where('user_id', $user->id)
    //         ->where('status', 'complete')
    //         ->sum('amount');

    //     return view('user.layouts.accounts', compact(
    //         'user',
    //         'transactions',
    //         'totalReferralEarning',
    //         'totalWithdraws'

    //     ));
    // }

    public function myaccount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->select('id', 'type', 'amount', 'description', 'currency', 'status', 'created_at', 'item_name')
            ->get();

        // Calculate Total Referral Earning
        $totalReferralEarning = Transaction::where('user_id', $user->id)
            ->where('type', 'credit')
            ->where(function ($query) {
                $query->where('description', 'like', '%Referral Commission%')
                    ->orWhere('description', 'like', '%commission from%');
            })
            ->sum('amount');

        // --- Total Invested Capital (More Accurate Method) ---
        // This sums up every investment made, which is a more reliable
        // measure of total capital deployed than relying on transaction descriptions.
        $investedCapital = UserInvestment::where('user_id', $user->id)
            ->sum('amount');

        // --- Lifetime P&L Calculation ---
        // This is the same logic from the aitrading page.
        $total_gains = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'gain')
            ->sum('daily_profit_amount');

        $total_losses = UserInvestment::where('user_id', $user->id)
            ->where('investment_result', 'lose')
            ->sum('amount'); // The loss is the invested amount

        $lifetime_pnl = $total_gains - $total_losses;
        // --- End of P&L calculation ---

        // Total successful withdrawals
        $totalWithdraws = Withdrawal::where('user_id', $user->id)
            ->where('status', 'complete')
            ->sum('amount');

        return view('user.layouts.accounts', compact(
            'user',
            'transactions',
            'totalReferralEarning',
            'investedCapital',      // Now using the more accurate value
            'lifetime_pnl',         // The newly added P&L value
            'totalWithdraws'
        ));

        
    }

    /**
     * New method to fetch transactions for the authenticated user as JSON.
     */


    public function  order()
    {
        return view('user.order');
    }

    public function  assets()
    {
        return view('user.layouts.assets');
    }

    public function language()
    {
        return view('user.language');
    }
}
