<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CoinPaymentsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CoinPaymentsController extends Controller
{
    protected $coinPaymentsService;

    public function __construct(CoinPaymentsService $coinPaymentsService)
    {
        $this->coinPaymentsService = $coinPaymentsService;
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'amount'     => 'required|numeric|min:0.01',
            'currency1'  => 'required|string|size:3',
        ]);

        $params = [
            'amount'      => $request->input('amount'),
            'currency1'   => $request->input('currency1'),
            'currency2'   => 'USDT.TRC20', // Tron USDT
            'buyer_email' => Auth::user()->email,
            'item_name'   => 'Deposit',
            'ipn_url'     => config('coinpayments.ipn_url'),
            'success_url' => route('payment.success'),
            'cancel_url'  => route('payment.cancel'),
        ];

        try {
            $result = $this->coinPaymentsService->createTransaction($params);

            if (isset($result['error']) && $result['error'] === 'ok') {
                $paymentInfo = $result['result'];

                // TODO: Save transaction to DB here if needed

                return redirect()->away($paymentInfo['checkout_url']);
            } else {
                Log::error('CoinPayments Error:', ['error' => $result['error'] ?? 'Unknown']);
                return back()->with('error', 'Transaction creation failed: ' . ($result['error'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            Log::critical('CoinPayments Exception:', ['message' => $e->getMessage()]);
            return back()->with('error', 'A technical error occurred while processing your payment.');
        }
    }

    public function paymentSuccess()
    {
        return view('payments.success', ['message' => 'Your payment is being processed.']);
    }

    public function paymentCancel()
    {
        return view('payments.cancel', ['message' => 'Payment was cancelled.']);
    }
}
