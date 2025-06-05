<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User; // Your User model
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



    public function myaccount()
    {
        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->select('id', 'type', 'amount', 'description', 'currency', 'status', 'created_at', 'item_name')
            ->get();


         // Calculate Total Referral Earning (example query, adjust as needed)
    $totalReferralEarning = Transaction::where('user_id', $user->id)
                                ->where(function($query) {
                                    $query->where('description', 'like', '%Referral Commission%')
                                          ->orWhere('description', 'like', '%commission from%'); // Adjust based on your descriptions
                                })
                                ->where('type', 'credit') // Ensure it's an earning
                                ->sum('amount');

    // Invested Capital - This might be more complex.
    // You might have a dedicated field or need to sum specific transaction types.
    // Example: Sum of 'debit' transactions with 'investment' in description
    $investedCapital = Transaction::where('user_id', $user->id)
                            ->where('type', 'debit')
                            ->where(function($query) {
                                $query->where('description', 'like', '%investment in%')
                                      ->orWhere('description', 'like', '%trading in%'); // And not a loss
                            })
                            // This is a simplified example and might need refinement
                            // to accurately reflect only current investments vs total spent.
                            ->sum('amount');


    return view('user.layouts.accounts', compact(
        'user',
        'transactions',
        'totalReferralEarning',
        'investedCapital'
        
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
