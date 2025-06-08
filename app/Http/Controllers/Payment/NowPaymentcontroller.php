<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment; // Make sure this is your Eloquent Payment model
use Carbon\Carbon;
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
            'price_amount' => 'required|numeric|min:1',
            'price_currency' => 'required|string',
            'pay_currency' => 'required|string',
            // The order_id from your form MUST be the user's ID for the IPN to work
            'order_id' => 'required|exists:users,id',
            'order_description' => 'required|string',
            'ipn_callback_url' => 'required|url',
            'customer_email' => 'nullable|email',
        ]);

        $client = new Client();
        $headers = [
            'x-api-key' => env('NOWPAYMENTS_API_KEY'),
            'Content-Type' => 'application/json',
        ];

        try {
            $response = $client->post('https://api.nowpayments.io/v1/payment', [
                'headers' => $headers,
                'json' => $validated,
                'verify' => true, // Recommended to set to true in production
            ]);

            $nowPaymentData = json_decode($response->getBody()->getContents(), true);

            Log::info('NOWPayments API Response: ', $nowPaymentData);

            if (empty($nowPaymentData['payment_id'])) {
                Log::error('payment_id missing from NOWPayments response.', $nowPaymentData);
                return back()->with('error', 'Payment creation failed. Please try again or contact support.');
            }

            // Create the initial payment record in the database.
            // This is the correct logic.
            $paymentData = Payment::create([
                'user_id'            => Auth::id(), // The currently logged-in user
                'payment_id'         => $nowPaymentData['payment_id'],
                'purchase_id'        => $nowPaymentData['purchase_id'] ?? null,
                'order_id'           => $nowPaymentData['order_id'],
                'payment_status'     => $nowPaymentData['payment_status'], // Will be 'waiting'
                'price_amount'       => $nowPaymentData['price_amount'],
                'price_currency'     => $nowPaymentData['price_currency'],
                'pay_amount'         => $nowPaymentData['pay_amount'],
                'pay_currency'       => $nowPaymentData['pay_currency'],
                'amount_received'    => 0.00, // Amount received is always 0 initially
                'pay_address'        => $nowPaymentData['pay_address'],
                'network'            => $nowPaymentData['network'] ?? null,
                'payment_created_at' => Carbon::parse($nowPaymentData['created_at'] ?? now()),
                'payment_updated_at' => Carbon::parse($nowPaymentData['updated_at'] ?? now()),
                'is_processed'       => false, // Explicitly set to false. This is perfect.
            ]);

            // Redirect to a confirmation/payment instruction page
            return redirect()->route('payment.confirm.show', ['id' => Crypt::encrypt($paymentData->id)]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            Log::error('NOWPayments API Client Exception: ', ['response' => $responseBody]);
            $errorMessage = json_decode($responseBody)->message ?? 'Payment gateway error.';
            return back()->with('error', 'Payment gateway error. Please try again later. Details: ' . $errorMessage);
        } catch (\Exception $e) {
            Log::error('General Error in createPayment: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please contact support.');
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
