<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;



class NowPaymentcontroller extends Controller
{



    public function paymentForm()
    {
        return view('payment');
    }



    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'price_amount' => 'required|numeric',
            'price_currency' => 'required|string', // ✅ Add this
            'pay_currency' => 'required|string',
            'order_id' => 'required|string',
            'order_description' => 'required|string',
            'ipn_callback_url' => 'required|url',
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
            return response()->json($data);
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
