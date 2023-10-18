<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DirectPaymentAPIController extends Controller
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

    public function initiatePayment(Request $request)
    {
        $this->validateAuthorizationHeader($request);

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string',
            'customer_msisdn' => 'required|string',
            'customer_email' => 'email',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'merchant_reference' => 'required|string',
            'callback_url' => 'required|url',
            'channel' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer_name = $request->input('customer_name');
        $customer_msisdn = $request->input('customer_msisdn');
        $customer_email = $request->input('customer_email');
        $amount = $request->input('amount');
        $description = $request->input('description');
        $merchant_reference = $request->input('merchant_reference');
        $callback_url = $request->input('callback_url');
        $channel = $request->input('channel');
        $referenceID = uniqid();

        $transaction = new Transaction();
        $transaction->merchant_id = $this->merchant_id;
        $transaction->description = $description;
        $transaction->reference_id = $referenceID;
        $transaction->merchant_reference = $merchant_reference;
        $transaction->amount = $amount;
        $transaction->status = 'pending';
        $transaction->currency = 'GHS';
        $transaction->channel = $channel;
        $transaction->callback_url = $callback_url;
        //return and cancel urls are not required. Check if they should be deleted from the table columns
        $transaction->description = $description;
        $transaction->save();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode("$this->hubtel_clientID:$this->hubtel_clientSecret"),
            'Content-Type' => 'application/json',
        ])->post('https://rmp.hubtel.com/merchantaccount/merchants/'.$this->hubtel_merchantAccountNumber.'/receive/mobilemoney', [
            'CustomerName' => $customer_name,
            'CustomerMsisdn' => $customer_msisdn,
            'CustomerEmail' => $customer_email,
            'Channel' => $channel,
            'Amount' => $amount,
            'PrimaryCallbackUrl' => route('directpayment.hubtel.callback.success', $referenceID),
            'Description' => $description,
            'ClientReference' => $referenceID,
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $responseData['Data']['ReferenceId'] = $referenceID;

            if ($responseData['ResponseCode'] == '0000') {
                $transaction->status = 'initiated';
                $transaction->status_code = $responseData['ResponseCode'];
                $transaction->meta_data = [
                    'amount' => $responseData['Data']['Amount'],
                    'charges' => $responseData['Data']['Charges'],
                    'amount_after_charges' => $responseData['Data']['AmountAfterCharges'],
                    'transaction_id' => $responseData['Data']['TransactionId'],
                    'external_transaction_id' => $responseData['Data']['ExternalTransactionId'],
                    'amount_charged' => $responseData['Data']['AmountCharged'],
                    'order_id' => $responseData['Data']['OrderId'],
                ];

                $transaction->save();
            }
        } else {
            return response()->json([
                'message' => 'Unable to initiate payment',
                'errors' => $response->json(),
            ], $response->status());
        }

        return response()->json($responseData, 200);
    }

    /**
     * Verification of transaction to confirm if posting of callback came from EBITS and transacton was succesfull
     */
    public function verifyTransaction(Request $request, $referenceID)
    {
        $this->validateAuthorizationHeader($request);

        $transaction = Transaction::where('reference_id', $referenceID)->firstOrFail();

        if ($transaction) {
            if ($transaction->status == 'Success') {
                $response = [
                    'success' => true,
                    'reference_id' => $transaction->reference_id,
                    'merchant_reference' => $transaction->merchant_reference,
                    'status' => $transaction->status,
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency,
                    'meta_data' => $transaction->meta_data,
                ];

                return response()->json($response, 200);
            } else {
                return response()->json([
                    'success' => false,
                    'reference_id' => $transaction->reference_id,
                    'merchant_reference' => $transaction->merchant_reference,
                    'status' => $transaction->status,
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency,
                    'meta_data' => $transaction->meta_data,
                    'message' => 'Transaction not successful',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        }
    }

    /**
     * Validate the Authorization header
     */
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
