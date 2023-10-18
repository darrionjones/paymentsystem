<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\PaymentPage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout($uuid)
    {
        // find the payment page based on the UUID
        $paymentPage = PaymentPage::where('id', $uuid)->firstOrFail();

        return view('merchants.checkout.checkout', compact('paymentPage', 'uuid'));
    }

    public function processCheckout(Request $request, $uuid)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'phone' => 'required|string|min:10|max:15',
            'email' => 'nullable|email|max:255',
        ]);

        $paymentPage = PaymentPage::where('id', $uuid)->firstOrFail();

        // generate unique transaction reference
        $referenceID = Str::uuid();

        // create new transaction
        $transaction = new Transaction();
        $transaction->reference_id = $referenceID;
        $transaction->amount = $request->input('amount');
        $transaction->merchant_id = $paymentPage->merchant_id;
        $transaction->customer_name = $request->input('name');
        $transaction->customer_phone_number = $request->input('phone');
        $transaction->customer_email = $request->input('email');
        $transaction->payment_page_id = $paymentPage->id;
        $transaction->return_url = route('merchants.payment.success', $uuid);
        $transaction->save();

        $hubtel_merchantAccountNumber = config('hubtel.payment.merchant_account_number');
        $hubtel_clientID = config('hubtel.payment.client_id');
        $hubtel_clientSecret = config('hubtel.payment.client_secret');

        // generate checkout URL
        $payload = [
            'description' => 'Payment for '.$paymentPage->page_name,
            'callbackUrl' => route('payment.hubtel.callback', $referenceID),
            'returnUrl' => route('payment.hubtel.return', $referenceID),
            'cancellationUrl' => route('payment.hubtel.cancel', $referenceID),
            'merchantAccountNumber' => $hubtel_merchantAccountNumber,
            'clientReference' => $referenceID,
            'totalAmount' => $transaction->amount,
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode("$hubtel_clientID:$hubtel_clientSecret"),
            'Content-Type' => 'application/json',
        ])->post(config('hubtel.payment.online_checkout_url'), $payload);

        if ($response->successful()) {
            $responseData = $response->json();

            //update the transaction with checkout id, checkout url and checkout direct url, response and status code
            $transaction->status = 'initiated';
            $transaction->status_code = $responseData['responseCode'];
            $transaction->meta_data = [
                'checkout_id' => $responseData['data']['checkoutId'],
                'checkout_url' => $responseData['data']['checkoutUrl'],
                'checkout_direct_url' => $responseData['data']['checkoutDirectUrl'],
                'message' => $responseData['data']['message'],
                'responseCode' => $responseData['responseCode'],
                'responsestatus' => $responseData['status'],
            ];
            $transaction->save();

            $checkout_direct_url = $responseData['data']['checkoutDirectUrl'];

            return view('merchants.checkout.payment', compact('checkout_direct_url', 'paymentPage'));
        } else {
            //update the transaction with response and status code
            $transaction->status = 'initiate-failed';
            $transaction->save();

            //redirect back with error message
            return redirect()->back()->with('error', 'Unable to initiate payment. Please try again.');
        }
    }

    public function success($uuid)
    {
        $paymentPage = PaymentPage::where('id', $uuid)->firstOrFail();

        return view('merchants.checkout.success', compact('paymentPage'));
    }
}
