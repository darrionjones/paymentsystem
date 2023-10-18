<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentPage;
use App\Models\USSDRequests;
use App\Services\USSDService;
use Illuminate\Http\Request;

class USSDSessionHandlerController extends Controller
{
    protected $ussd_service;

    public function __construct()
    {
        $this->ussd_service = new USSDService();
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $requestBody = $request->all();

        $sessionID = $requestBody['sessionID'];
        $userID = $requestBody['userID'];
        $newSession = $requestBody['newSession'];
        $msisdn = $requestBody['msisdn'];
        $userData = $requestBody['userData'];
        $network = $requestBody['network'];

        if ($newSession) {
            //check if the USSD extension exists for a merchant
            $merchant_extension = explode('*', rtrim($userData, '#'))[3];
            $merchant_page = PaymentPage::where('ussd_extension', $merchant_extension)->first();

            if ($merchant_page) {
                // This is a new session. Log USSD request if new session
                $ussd_data = [
                    'session_id' => $sessionID,
                    'user_id' => $userID,
                    'msisdn' => $msisdn,
                    'menu_level' => 0,
                    'session_data' => ['page_id' => $merchant_page->id, 'merchant_id' => $merchant_page->merchant_id, 'service_stage' => '0'],
                    'ussd_body' => $userData,
                ];

                $ussd_request = USSDRequests::create($ussd_data);

                $message = 'Welcome to '.$merchant_page->page_name."\n";
                $message .= "Enter the amount to pay\n";
                $continueSession = true;
            } else {
                $message = "No merchant found. Please try again.\n";
                $continueSession = true;
            }
        } elseif ($newSession == false) {
            $service_stage = $this->ussd_service->session_data_get($sessionID, 'service_stage');
            if ($service_stage == 0) {
                if ($userData > 0) {
                    // This is a new session. Log USSD request if new session
                    $ussd_request = $this->ussd_service->get_ussd_request($sessionID);

                    $merchant_page = PaymentPage::find($ussd_request->session_data['page_id']);

                    $amount = $userData;

                    $message = "Please select your mobile money provider \n";
                    $message .= "1. AirtelTigo \n";
                    $message .= "2. MTN \n";
                    $message .= "3. Vodafone \n";
                    $this->ussd_service->session_data_add($sessionID, 'service_stage', '1');
                    $this->ussd_service->session_data_add($sessionID, 'amount', $amount);

                    $continueSession = true;
                } else {
                    $message = "Invalid amount. Please try again.\n";
                    $continueSession = true;
                }
            } elseif ($service_stage == 1) {
                //confirm total amount and mobile money provider
                $ussd_request = $this->ussd_service->get_ussd_request($sessionID);

                $merchant_page = PaymentPage::find($ussd_request->session_data['page_id']);

                $amount = $ussd_request->session_data['amount'];

                //store the momo provider in the session
                $mobile_money_provider = $this->ussd_service->get_momo_providers()[$userData];
                $this->ussd_service->session_data_add($sessionID, 'service_stage', '2');
                $this->ussd_service->session_data_add($sessionID, 'mobile_money_provider', $mobile_money_provider);

                $message = 'Confirm payment of GHS '.$amount.' to '.$merchant_page->page_name." \n";
                $message .= "1. Confirm \n";
                $message .= "2. Cancel \n";

                $continueSession = true;
            } elseif ($service_stage == 2) {
                if ($userData == 1) {
                    //initiate payment and display success message
                    $ussd_request = $this->ussd_service->get_ussd_request($sessionID);
                    $merchant_page = PaymentPage::find($ussd_request->session_data['page_id']);
                    $merchant_id = $ussd_request->session_data['merchant_id'];
                    $amount = $ussd_request->session_data['amount'];
                    $mobile_money_provider = $ussd_request->session_data['mobile_money_provider'];

                    $payment_initiate = $this->ussd_service->initiatePayment($msisdn, $amount, $mobile_money_provider, $merchant_page->page_name, $merchant_id);

                    $this->ussd_service->session_data_add($sessionID, 'service_stage', '3');

                    if ($payment_initiate) {
                        $message = 'Payment of GHS '.$amount.' to '.$merchant_page->page_name." initiated. \n";
                        $message .= "You will receive a prompt shortly to confirm payment. \n";
                        $message .= "Thank you. \n";
                    } else {
                        $message = "Payment initiation failed. Please try again.\n";
                        $continueSession = false;
                    }

                    $continueSession = false;

                } elseif ($userData == 2) {
                    //cancel payment and display cancel message
                    $message = "Payment cancelled. \n";
                    $continueSession = false;
                }

            }
        }

        $response = [
            'sessionID' => $sessionID,
            'userID' => $userID,
            'msisdn' => $msisdn,
            'message' => $message,
            'continueSession' => $continueSession,
        ];

        http_response_code(200);

        // treat this as json
        header('Content-Type: application/json');

        return response()->json($response);
    }
}
