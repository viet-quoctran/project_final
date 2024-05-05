<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
class PayPalController extends Controller
{
    public function handlePayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->setAccessToken($provider->getAccessToken());

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.success'),
                "cancel_url" => route('payment.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ],
                    "description" => $request->name
                ]
            ]
        ]);

        if (isset($order['id']) && $order['id'] != null) {
            session(['packageData' => ['id' => $request->id, 'amount' => $request->price]]);
            foreach ($order['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        return redirect()->back()->with('error', 'Something went wrong.');
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $accessToken = $provider->getAccessToken();
        $provider->setAccessToken($accessToken);

        $response = $provider->capturePaymentOrder($request->token);

        if ($response['status'] == 'COMPLETED') {
            $packageData = session('packageData');
            
            $payment = new Payment();
            $payment->amount = $packageData['amount'];
            $payment->package_id = $packageData['id'];
            $payment->save();
        
            DB::table('user_payment')->insert([
                'user_id' => auth()->id(),
                'payment_id' => $payment->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('user_package')->insert([
                'user_id' => auth()->id(),
                'package_id' => $packageData['id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
            session()->forget('packageData');
            return redirect()->route('user.dashboard')->with('success', 'Payment successful');
        }

        return redirect()->route('home')->with('error', 'Payment failed');
    }
}
