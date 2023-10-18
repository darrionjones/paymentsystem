<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentAPIController extends Controller
{
    private $hubtel_merchantAccountNumber;

    private $hubtel_clientID;

    private $hubtel_clientSecret;

    private $merchant_id;

    public function __construct()
    {
        $this->hubtel_merchantAccountNumber = config('hubtel.payment.merchant_account_number');
        $this->hubtel_clientID = config('hubtel.payment.client_id');
        $this->hubtel_clientSecret = config('hubtel.payment.client_secret');
    }

    public function initiate(Request $request)
    {
        $this->validateAuthorizationHeader($request);

        $callbackUrl = $request->input('callback_url');
        $returnUrl = $request->input('return_url');
        $cancelUrl = $request->input('cancel_url');
        $description = $request->input('description');
        $merchant_reference = $request->input('merchant_reference');
        $amount = $request->input('amount');
        $channel = 'online';
        $referenceID = uniqid();

        $payload = [
            'description' => $description,
            'callbackUrl' => route('payment.hubtel.callback', $referenceID),
            'returnUrl' => route('payment.hubtel.return', $referenceID),
            'cancellationUrl' => route('payment.hubtel.cancel', $referenceID),
            'merchantAccountNumber' => $this->hubtel_merchantAccountNumber,
            'clientReference' => $referenceID,
            'totalAmount' => $amount,
        ];

        //log the transaction before initiating payment
        $transaction = new Transaction();
        $transaction->merchant_id = $this->merchant_id;
        $transaction->reference_id = $referenceID;
        $transaction->merchant_reference = $merchant_reference;
        $transaction->channel = $channel;
        $transaction->amount = $amount;
        $transaction->callback_url = $callbackUrl;
        $transaction->return_url = $returnUrl;
        $transaction->cancel_url = $cancelUrl;
        $transaction->description = $description;
        $transaction->save();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode("$this->hubtel_clientID:$this->hubtel_clientSecret"),
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

            return response()->json([
                'status' => 'success',
                'message' => 'Payment initiated successfully',
                'merchant_reference' => $merchant_reference,
                'reference_id' => $referenceID,
                'checkout_url' => $responseData['data']['checkoutUrl'],
                'checkout_id' => $responseData['data']['checkoutId'],
                'checkout_direct_url' => $responseData['data']['checkoutDirectUrl'],
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'merchant_reference' => $merchant_reference,
                'reference_id' => $referenceID,
                'message' => 'Unable to initiate payment',
                'errors' => $response->json(),
            ], $response->status());
        }
    }

    public function validateAuthorizationHeader(Request $request)
    {
        $header = $request->header('Authorization');

        if (! $header) {
            return response()->json([
                'message' => 'Authorization header is missing',
            ], 401);
        }

        $headerParts = explode(' ', $header);

        if (count($headerParts) != 2 || strtolower($headerParts[0]) !== 'basic') {
            return response()->json([
                'message' => 'Authorization header is invalid',
            ], 401);
        }

        $credentials = base64_decode($headerParts[1]);

        if (! $credentials) {
            return response()->json([
                'message' => 'Invalid client credentials',
            ], 401);
        }

        //find merchant and id of the merchant whose credentials match the credentials in the header
        $credentials = explode(':', $credentials);
        $merchant = Merchant::where('client_id', $credentials[0])->where('client_secret', $credentials[1])->first();

        if (! $merchant) {
            return response()->json([
                'message' => 'Invalid client credentials',
            ], 401);
        } else {
            return $this->merchant_id = $merchant->id;
        }
    }
}
