<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment; // Make sure this is your Eloquent Payment model
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class NowPaymentcontroller extends Controller
{
    // ... paymentForm() method ...
    public function paymentForm()
    {
        $user = Auth::user();
        return view('user.layouts.deposit', compact('user'));
    }

    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'price_amount' => 'required|numeric',
            'price_currency' => 'required|string',
            'pay_currency' => 'required|string',
            'order_id' => 'required', // Consider making this unique or generated
            'order_description' => 'required|string',
            'ipn_callback_url' => 'required|url',
            'customer_email' => 'nullable|email',
        ]);

        // Prevent duplicate submissions if order_id is meant to be unique per attempt
        // For example, you could check if a payment with this order_id already exists
        // and is not in a failed state. This is an additional layer of protection.
        // if (Payment::where('order_id', $validated['order_id'])->where('user_id', Auth::id())->exists()) {
        //     return back()->with('error', 'A payment with this order ID already exists or is being processed.');
        // }


        $client = new Client();
        $headers = [
            'x-api-key' => env('NOWPAYMENTS_API_KEY'),
            'Content-Type' => 'application/json',
        ];

        try {
            $response = $client->post('https://api.nowpayments.io/v1/payment', [
                'headers' => $headers,
                'json' => $validated,
                'verify' => false, // Consider setting to true in production if you have SSL configured
            ]);

            $nowPaymentData = json_decode($response->getBody(), true);

            // Important: Log the API response for debugging
            Log::info('NOWPayments API Response: ', $nowPaymentData);

            // Check if essential data is present
            if (empty($nowPaymentData['payment_id'])) {
                Log::error('payment_id missing from NOWPayments response.', $nowPaymentData);
                return back()->with('error', 'Payment creation failed. Please try again or contact support.');
            }

            $paymentData = Payment::create([
                'user_id'            => Auth::id(),
                'payment_id'         => $nowPaymentData['payment_id'],
                'purchase_id'        => $nowPaymentData['purchase_id'] ?? null,
                'order_id'           => $nowPaymentData['order_id'], // This is from the form, ensure it's correctly handled
                'payment_status'     => $nowPaymentData['payment_status'],
                'price_amount'       => $nowPaymentData['price_amount'],
                'price_currency'     => $nowPaymentData['price_currency'],
                'pay_amount'         => $nowPaymentData['pay_amount'],
                'pay_currency'       => $nowPaymentData['pay_currency'],
                'amount_received'    => $nowPaymentData['amount_received'] ?? 0.00, // Default if not present
                'pay_address'        => $nowPaymentData['pay_address'],
                'network'            => $nowPaymentData['network'] ?? null,
                'payment_created_at' => $nowPaymentData['created_at'] ?? now(), // Use current time as fallback
                'payment_updated_at' => $nowPaymentData['updated_at'] ?? now(), // Use current time as fallback
            ]);

            // Instead of returning a view, redirect to a new route
            // Pass the ID of the payment record you just created in your database
            return redirect()->route('payment.confirm.show', ['id' => Crypt::encrypt($paymentData->id)]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('NOWPayments API Client Exception: ' . $e->getMessage(), ['response' => $responseBody]);
            return back()->with('error', 'Payment gateway error. Please try again later. Details: ' . json_decode($responseBody)->message ?? $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Error in createPayment: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }


    /**
     * Display the deposit confirmation page.
     *
     * @param  int  $paymentRecordId The ID of the payment record from your local database,
     * passed from the route parameter.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */


    public function showConfirmDepositPage($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to view this page.');
        }

        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            Log::warning("Invalid encrypted payment ID accessed. User ID: {$user->id}");
            return redirect()->route('deposit.form')->with('error', 'Invalid payment reference.');
        }

        $paymentData = Payment::where('id', $decryptedId)
            ->where('user_id', $user->id)
            ->first();

        if (!$paymentData) {
            Log::warning("Attempt to view non-existent or unauthorized payment. User ID: {$user->id}, Payment Record ID: {$decryptedId}");
            return redirect()->route('deposit.form')->with('error', __('messages.payment_details_not_found_error', ['fallback' => 'Payment details not found or access denied.']));
        }

        return view('user.layouts.confirm-deposit', [
            'paymentData' => $paymentData,
            'user' => $user,
        ]);
    }



    // ... other methods (checkBalance, validateAddress) ...
    public function checkBalance()
    {
        $apiKey = env('NOWPAYMENTS_API_KEY');

        try {
            $client = new Client();
            $response = $client->request('GET', 'https://api.nowpayments.io/v1/balance', [
                'headers' => [
                    'x-api-key' => $apiKey,
                ],
                'verify' => false,
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch balance',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function validateAddress(Request $request)
    {
        Log::info('Validate Address Called', $request->all());

        $validated = $request->validate([
            'address' => 'required|string',
            'currency' => 'required|string',
            'extra_id' => 'nullable|string',
        ]);

        try {
            $client = new Client();
            $headers = [
                'x-api-key' => env('NOWPAYMENTS_API_KEY'),
                'Content-Type' => 'application/json',
            ];
            $body = json_encode([
                'address' => $validated['address'],
                'currency' => $validated['currency'],
                'extra_id' => $validated['extra_id'] ?? null,
            ]);

            $response = $client->post('https://api.nowpayments.io/v1/payout/validate-address', [
                'headers' => $headers,
                'body' => $body,
                'verify' => false,
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
