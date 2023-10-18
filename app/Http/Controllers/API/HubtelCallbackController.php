<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HubtelCallbackController extends Controller
{
    public function handleCallback(Request $request, $referenceID)
    {
        $response = json_decode($request->getContent(), true);

        //log the response
        \Log::info('Callback response: '.$request->getContent());

        // Extract relevant data from the response
        $checkoutId = $response['Data']['CheckoutId'];
        $amount = $response['Data']['Amount'];
        $status = $response['Data']['Status'];
        $metaData = $response['Data'];

        // Find the corresponding transaction and update its meta_data
        $transaction = Transaction::where('reference_id', $referenceID)->firstOrFail();
        if ($transaction) {
            $existingMetaData = $transaction->meta_data ?? [];
            $mergedMetaData = array_merge($existingMetaData, $metaData);
            $transaction->meta_data = $mergedMetaData;
            $transaction->status = strtolower($status);
            $transaction->save();
        }

        if ($status == 'Success') {
            $success = true;
        } else {
            $success = false;
        }

        // Pass the details to the merchant's checkout URL
        if ($transaction && $transaction->callback_url) {
            // send response to merchant callback url
            $payload = [
                'success' => $success,
                'reference_id' => $transaction->reference_id,
                'merchant_reference' => $transaction->merchant_reference,
                'status' => strtolower($transaction->status),
                'description' => $transaction->description,
                'amount' => $transaction->amount,
                'currency' => $transaction->currency,
                'meta_data' => $transaction->meta_data,
            ];

            // Make a POST request to the callback URL with the payload
            $client = new \GuzzleHttp\Client();
            try {
                $response = $client->request('POST', $transaction->callback_url, [
                    'json' => $payload,
                ]);
                // Handle successful response here
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                    //log the response
                    \Log::info('Callback URL response: '.$response->getBody());
                } else {
                    \Log::info('Failed to call callback URL for '.$transaction->reference_id);
                }
            }

            // Log the response
            \Log::info('Callback URL response: '.$response->getBody());
        }

        return response()->json(['message' => 'Callback handled successfully']);
    }

    public function return(Request $request, $referenceID)
    {
        $transaction = Transaction::where('reference_id', $referenceID)->firstOrFail();
        $returnURL = $transaction->return_url;

        if ($returnURL) {
            //redirect to the return URL
            return redirect($returnURL);
        } else {
            return response()->json(['message' => 'Return URL not found'], 404);
        }
    }

    public function cancel(Request $request, $referenceID)
    {
        $transaction = Transaction::where('reference_id', $referenceID)->firstOrFail();
        $cancelURL = $transaction->cancel_url;
        $response = Http::post($cancelURL, $request->all());

        return $response;
    }

    /**
     * Below are the callbacks for Direct Payment
     */
    /**
     * Handle successful callback from the payment provider.
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function DirectPaymentSuccess(Request $request, $referenceID)
    {
        $response = json_decode($request->getContent(), true);

        //log the response
        \Log::info('Direct payment callback response: '.$request->getContent());

        $metaData = $response['Data'];
        //convert status to lower case
        $status = strtolower($response['Message']);
        $status_code = $response['ResponseCode'];
        if ($response['Message'] == '0000') {
            $success = true;
        } else {
            $success = false;
        }

        $transaction = Transaction::where('reference_id', $referenceID)->firstOrFail();

        if ($transaction) {
            // merge new metadata with existing metadata
            $existingMetaData = $transaction->meta_data ?? [];
            $mergedMetaData = array_merge($existingMetaData, $metaData);
            $transaction->meta_data = $mergedMetaData;
            $transaction->status = $status;
            $transaction->status_code = $status_code;
            $transaction->save();

            $merchant = $transaction->merchant;

            // send response to merchant callback url
            $payload = [
                'success' => $success,
                'reference_id' => $transaction->reference_id,
                'merchant_reference' => $transaction->merchant_reference,
                'status' => $transaction->status,
                'description' => $transaction->description,
                'amount' => $transaction->amount,
                'currency' => $transaction->currency,
                'meta_data' => $transaction->meta_data,
            ];

            // Make a POST request to the callback URL with the payload
            $client = new \GuzzleHttp\Client();
            try {
                $response = $client->request('POST', $transaction->callback_url, [
                    'json' => $payload,
                ]);
                // Handle successful response here
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                    //log the response
                    \Log::info('Callback URL response: '.$response->getBody());
                } else {
                    \Log::info('Failed to call callback URL for '.$transaction->reference_id);
                }
            }

            return response()->json(['message' => 'Callback received'], 200);
        }
    }

    /**
     * Handle failed callback from the payment provider.
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function DirectPaymentFailed(Request $request)
    {
        $metaData = $request->input('Data');
        $status = 'failed';

        $transaction = Transaction::where('reference_id', $metaData['ClientReference'])->firstOrFail();
        $metaDataJson = json_encode($metaData);

        if ($transaction) {
            // merge new metadata with existing metadata
            $transaction->meta_data = json_encode(array_merge(json_decode($transaction->meta_data, true), $metaDataJson));
            $transaction->status = $status;
            $transaction->save();

            $merchant = $transaction->merchant;

            // send response to merchant callback url
            $callbackUrl = $transaction->callback_url ?? $merchant->callback_url;
            $response = [
                'success' => false,
                'reference_id' => $transaction->reference_id,
                'status' => $transaction->status,
                'description' => $transaction->description,
                'amount' => $transaction->amount,
                'currency' => $transaction->currency,
                'meta_data' => json_decode($transaction->meta_data),
            ];
            $client = new Client();
            $client->request('POST', $callbackUrl, ['json' => $response]);

            return response()->json(['message' => 'Callback received'], 200);
        }
    }
}
