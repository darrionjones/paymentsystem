<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\USSDRequests;
use Illuminate\Support\Facades\Http;

class USSDService
{
    /**
     * Other services menu
     */
    public function get_service_menu()
    {
        $message = "Choose a service option below. \n";
        $message .= "1.  \n";

        return $message;
    }

    /**
     * Mobile Money Providers Menu
     */
    public function get_momo_menu()
    {
        $message = "Please select your mobile money provider \n";
        $message .= "1. AirtelTigo \n";
        $message .= "2. MTN \n";
        $message .= "3. Vodafone \n";

        return $message;
    }

    /**
     * Get list of MoMO providers
     */
    public function get_momo_providers()
    {
        return $momo_providers = ['1' => 'airteltigo', '2' => 'mtn', '3' => 'vodafone'];
    }

    /**
     * Get the last USSD Step
     */
    public function get_ussd_request($sessionID)
    {
        return USSDRequests::where('session_id', $sessionID)->first();
    }

    /**
     * Get the last USSD Step
     */
    public function get_ussd_step($sessionID, $msisdn)
    {
        return USSDRequests::where(['session_id' => $sessionID, 'msisdn' => $msisdn])->first()->menu_level;
    }

    public function update_ussd_step($sessionID, $msisdn, $step)
    {
        return USSDRequests::where('session_id', $sessionID)
            ->where('msisdn', $msisdn)
            ->update(['menu_level' => $step]);
    }

    /**
     * Add a new attribute to the existing json session data
     */
    public function session_data_add($sessionID, $key, $value)
    {
        USSDRequests::where('session_id', $sessionID)->update([
            'session_data->'.$key => $value,
        ]);
    }

    /**
     * Add a new attribute to the existing json session data in bulk
     */
    public function session_data_bulk_add($sessionID, $data)
    {
        foreach ($data as $key => $value) {
            USSDRequests::where('session_id', $sessionID)->update([
                'session_data->'.$key => $value,
            ]);
        }
    }

    /**
     * Update value for existing json session data
     */
    public function session_data_new($sessionID, $key, $value)
    {
        $ussd_request = USSDRequests::where('session_id', $sessionID)->first();
        $session_data = $ussd_request->session_data;
        $session_data[$key] = $value;
        $ussd_request->session_data = $session_data;

        return $ussd_request->save();
    }

    /**
     * Get json session data value
     */
    public function session_data_get($sessionID, $key)
    {
        $session_data = USSDRequests::where('session_id', $sessionID)->first()->session_data;
        (array_key_exists($key, $session_data)) ? $value = $session_data[$key] : $value = null;

        return $value;
    }

    /**
     * Get all json session data value
     */
    public function session_data_get_all($sessionID)
    {
        return USSDRequests::where('session_id', $sessionID)->first()->session_data;
    }

    public function initiatePayment($phone_number, $amount, $momo_provider, $description, $merchant_id)
    {
        $hubtel_merchantAccountNumber = config('hubtel.payment.merchant_account_number');
        $hubtel_clientID = config('hubtel.payment.client_id');
        $hubtel_clientSecret = config('hubtel.payment.client_secret');

        $customer_name = 'No name';
        $customer_msisdn = $phone_number;
        $customer_email = $phone_number.'@guest.com';
        $amount = $amount;
        $description = $description;
        $referenceID = uniqid();
        $momo_codes = ['mtn' => 'mtn-gh', 'vodafone' => 'vodafone-gh', 'airteltigo' => 'airteltigo-gh'];
        $channel = $momo_codes[$momo_provider];

        $transaction = new Transaction();
        $transaction->merchant_id = $merchant_id;
        $transaction->description = $description;
        $transaction->reference_id = $referenceID;
        $transaction->customer_phone_number = $phone_number;
        $transaction->amount = $amount;
        $transaction->status = 'pending';
        $transaction->currency = 'GHS';
        $transaction->channel = $channel;
        $transaction->save();

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic '.base64_encode("$hubtel_clientID:$hubtel_clientSecret"),
            'Content-Type' => 'application/json',
        ])->post('https://rmp.hubtel.com/merchantaccount/merchants/'.$hubtel_merchantAccountNumber.'/receive/mobilemoney', [
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

            return true;
        } else {
            //failed to initiate payment
            $transaction->status = 'initiate-failed';
            $transaction->save();

            return false;
        }

        return response()->json($responseData, 200);
    }
}
