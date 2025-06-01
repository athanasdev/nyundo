<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class NowPaymentcontroller extends Controller
{



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
            'order_id' => 'required',
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
                'verify' => false,
            ]);

            $data = json_decode($response->getBody(), true);

            Payment::create([
                'user_id'            => Auth::id(),
                'payment_id'         => $data['payment_id'],
                'purchase_id'        => $data['purchase_id'] ?? null,
                'order_id'           => $data['order_id'],
                'payment_status'     => $data['payment_status'],
                'price_amount'       => $data['price_amount'],
                'price_currency'     => $data['price_currency'],
                'pay_amount'         => $data['pay_amount'],
                'pay_currency'       => $data['pay_currency'],
                'amount_received'    => $data['amount_received'],
                'pay_address'        => $data['pay_address'],
                'network'            => $data['network'] ?? null,
                'payment_created_at' => $data['created_at'] ?? null,
                'payment_updated_at' => $data['updated_at'] ?? null,
            ]);


            return view('user.layouts.confirm-deposit', ['paymentData' => $data], [
                'user' => Auth::user(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



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
        // return response()->json(['message' => 'Received']);

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
