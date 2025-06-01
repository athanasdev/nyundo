<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class IPNController extends Controller
{
    public function handle(Request $request)
    {

        Log::error('TEST IPN ', ["IPN DATA"=>$request->all()]);

        $ipnSecret = env('NOWPAYMENTS_IPN_SECRET');

        // Get the signature from the header
        $receivedHmac = $request->header('x-nowpayments-sig');

        if (!$receivedHmac) {
            Log::error('No HMAC signature sent.');
            return response()->json(['error' => 'No HMAC signature sent.'], 400);
        }

        // Raw JSON and decoded array
        $requestJson = $request->getContent();
        $requestData = json_decode($requestJson, true);

        if (!$requestData) {
            Log::error('Error reading POST data');
            return response()->json(['error' => 'Error reading POST data'], 400);
        }

        // Sort the data recursively like tksort()
        $sortedData = $this->recursiveKeySort($requestData);
        $sortedJson = json_encode($sortedData, JSON_UNESCAPED_SLASHES);

        // Generate HMAC
        $hmac = hash_hmac("sha512", $sortedJson, trim($ipnSecret));

        if (hash_equals($hmac, $receivedHmac)) {
            Log::info('Valid IPN received:', $requestData);

            return response()->json(['message' => 'IPN verified'], 200);

        } else {
            Log::error('HMAC signature does not match.');
            return response()->json(['error' => 'HMAC signature does not match.'], 403);
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
