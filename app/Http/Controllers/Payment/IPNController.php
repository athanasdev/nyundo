<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class IPNController extends Controller
{
    // public function handle(Request $request)
    // {

    //     Log::error('TEST IPN ', ["IPN DATA" => $request->all()]);

    //     $ipnSecret = env('NOWPAYMENTS_IPN_SECRET');

    //     // Get the signature from the header
    //     $receivedHmac = $request->header('x-nowpayments-sig');

    //     if (!$receivedHmac) {
    //         Log::error('No HMAC signature sent.');
    //         return response()->json(['error' => 'No HMAC signature sent.'], 400);
    //     }

    //     // Raw JSON and decoded array
    //     $requestJson = $request->getContent();
    //     $requestData = json_decode($requestJson, true);

    //     if (!$requestData) {
    //         Log::error('Error reading POST data');
    //         return response()->json(['error' => 'Error reading POST data'], 400);
    //     }

    //     // Sort the data recursively like tksort()
    //     $sortedData = $this->recursiveKeySort($requestData);
    //     $sortedJson = json_encode($sortedData, JSON_UNESCAPED_SLASHES);

    //     // Generate HMAC
    //     $hmac = hash_hmac("sha512", $sortedJson, trim($ipnSecret));

    //     if (hash_equals($hmac, $receivedHmac)) {
    //         Log::info('Valid IPN received:', $requestData);

    //         // Find or create payment
    //         $payment = Payment::updateOrCreate(
    //             ['payment_id' => $requestData['payment_id']],
    //             [
    //                 'user_id' => $requestData['order_id'] ?? null,
    //                 'purchase_id' => $requestData['purchase_id'] ?? null,
    //                 'order_id' => $requestData['order_id'] ?? null,
    //                 'payment_status' => $requestData['payment_status'],
    //                 'price_amount' => $requestData['price_amount'],
    //                 'price_currency' => $requestData['price_currency'],
    //                 'pay_amount' => $requestData['pay_amount'],
    //                 'pay_currency' => $requestData['pay_currency'],
    //                 'amount_received' => $requestData['amount_received'] ?? 0,
    //                 'pay_address' => $requestData['pay_address'] ?? null,
    //                 'network' => $requestData['network'] ?? null,
    //                 'payment_created_at' => Carbon::parse($requestData['created_at'] ?? now()),
    //                 'payment_updated_at' => Carbon::parse($requestData['updated_at'] ?? now()),
    //             ]

    //         );

    //         // Optionally update user wallet here if payment is finished
    //         if ($requestData['payment_status'] === 'finished' && $payment->user_id) {
    //             $user = User::find($payment->user_id);
    //             if ($user) {
    //                 $user->wallet_balance = $user->wallet_balance + $payment->amount_received;
    //                 $user->save();

    //                 Log::info("User {$user->id} wallet updated. New balance: {$user->wallet_balance}");
    //             }
    //         }

    //         return response()->json(['message' => 'IPN verified and payment recorded.'], 200);
    //     }
    // }

    public function handle(Request $request)
    {
        Log::error('TEST IPN ', ["IPN DATA" => $request->all()]);

        $ipnSecret = env('NOWPAYMENTS_IPN_SECRET');
        $receivedHmac = $request->header('x-nowpayments-sig');

        if (!$receivedHmac) {
            Log::error('No HMAC signature sent.');
            return response()->json(['error' => 'No HMAC signature sent.'], 400);
        }

        $requestJson = $request->getContent();
        $requestData = json_decode($requestJson, true);

        if (!$requestData) {
            Log::error('Error reading POST data');
            return response()->json(['error' => 'Error reading POST data'], 400);
        }

        $sortedData = $this->recursiveKeySort($requestData);
        $sortedJson = json_encode($sortedData, JSON_UNESCAPED_SLASHES);
        $hmac = hash_hmac("sha512", $sortedJson, trim($ipnSecret));

        if (!hash_equals($hmac, $receivedHmac)) {
            Log::error('Invalid HMAC signature.');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        Log::info('Valid IPN received:', $requestData);

        DB::beginTransaction();
        try {
            $payment = Payment::updateOrCreate(
                ['payment_id' => $requestData['payment_id']],
                [
                    'user_id' => $requestData['order_id'] ?? null,
                    'purchase_id' => $requestData['purchase_id'] ?? null,
                    'order_id' => $requestData['order_id'] ?? null,
                    'payment_status' => $requestData['payment_status'],
                    'price_amount' => $requestData['price_amount'],
                    'price_currency' => $requestData['price_currency'],
                    'pay_amount' => $requestData['pay_amount'],
                    'pay_currency' => $requestData['pay_currency'],
                    'amount_received' => $requestData['amount_received'] ?? 0,
                    'pay_address' => $requestData['pay_address'] ?? null,
                    'network' => $requestData['network'] ?? null,
                    'payment_created_at' => Carbon::parse($requestData['created_at'] ?? now()),
                    'payment_updated_at' => Carbon::parse($requestData['updated_at'] ?? now()),
                ]
            );

            // Only process credit if payment is finished
            if ($requestData['payment_status'] === 'waiting' && $payment->user_id) {
                $user = User::find($payment->user_id);

                if ($user) {
                    $depositAmount = $payment->amount_received;
                    $bonusRate = 0.01; // 1% bonus
                    $bonusAmount = $depositAmount * $bonusRate;

                    $balanceBefore = $user->balance;
                    $balanceAfterDeposit = $balanceBefore + $depositAmount;
                    $finalBalance = $balanceAfterDeposit + $bonusAmount;

                    // Update user balance
                    $user->balance = $finalBalance;
                    $user->save();

                    // Main deposit transaction
                    Transaction::create([
                        'user_id'        => $user->id,
                        'type'           => 'credit',
                        'amount'         => $depositAmount,
                        'balance_before' => $balanceBefore,
                        'balance_after'  => $balanceAfterDeposit,
                        'description'    => ' Deposit',
                    ]);

                    // Bonus transaction
                    Transaction::create([
                        'user_id'        => $user->id,
                        'type'           => 'credit',
                        'amount'         => $bonusAmount,
                        'balance_before' => $balanceAfterDeposit,
                        'balance_after'  => $finalBalance,
                        'description'    => '1% Deposit Bonus',
                    ]);

                    // Optional: record deposit
                    Deposit::create([
                        'user_id'         => $user->id,
                        'network'         => $payment->network ?? 'trx',
                        'deposit_address' => $payment->pay_address ?? 'N/A',
                        'amount'          => $depositAmount,
                        'status'          => 'completed',
                        'currency'        => $payment->pay_currency ?? 'USD',
                        'type'            => 'automatic',
                    ]);

                    Log::info("User {$user->id} wallet updated. New balance: {$finalBalance}");
                }
            }

            DB::commit();
            return response()->json(['message' => 'IPN verified, payment and bonus recorded.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('IPN Handling failed: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    private function recursiveKeySort(array &$array)
    {
        ksort($array);
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursiveKeySort($value);
            }
        }
        return $array;
    }
}
