<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FundWallet;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    use HttpResponses;
    /**
     * Redirect the User to Paystack Payment Page
     */

    public function initiatePayment(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);

        $url = "https://api.paystack.co/transaction/initialize";
        $amount = $request->amount;
        $client = auth()->user()->client;
        $data = [
            "amount" => $amount * 100,
            "email" => auth()->user()->email,
            "callback_url" => route('payment.status'),
            "metadata" => [
                'client_id' => $client->client_id,
                'name' => $client->name,
                'amount' => $amount
            ],
        ];
        //return $data;
        $headers = [
            "Authorization: Bearer " . env("PAYSTACK_SECRET_KEY"),
            "Content-Type: application/json"
        ];
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADER => false,
                CURLOPT_REFERER => $url,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36",
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => $headers
            ),
        );

        $response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($response, true);

        if ($response) {
            return $result;
        } else {
            return response([
                'status' => curl_error($ch),
            ], 404);
        }
    }

    public function checkPaymentStatus()
    {
        $data = request();
        $reference = $data->reference;

        // Set up the Paystack API URL
        $url = "https://api.paystack.co/transaction/verify/$reference";

        // Set up the authorization headers
        $headers = [
            "Authorization: Bearer " . env("PAYSTACK_SECRET_KEY"),
            "Content-Type: application/json"
        ];

        // Set up the curl request
        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HEADER => false,
                CURLOPT_REFERER => $url,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36",
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $headers
            ),
        );


        // Send the curl request and get the response
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($result['data']['status'] == 'success') {
            $user = $result['data']['metadata']['client_id'];
            $client = Client::where('client_id', $user)->first();
            $client->wallet_balance = $client->wallet_balance + $result['data']['metadata']['amount'];
            //dd($client->wallet_balance);
            if ($client->save()) {
                FundWallet::create([
                    'client_id' => $result['data']['metadata']['client_id'],
                    'client_name' => $result['data']['metadata']['name'],
                    'client_email' => $result['data']['customer']['email'],
                    'paymentstatus' => $result['data']['status'],
                    'transaction_reference' => $result['data']['reference'],
                    'transaction_id' => $result['data']['id'],
                    'charged_amount' => $result['data']['metadata']['amount'],
                    'processor_response' => $result['data']['gateway_response'],
                ]);
                  return view('content.payment.status', compact('result'));

                // return response()->json([
                //     'data' => $result
                // ]);
            } else {
                FundWallet::create([
                    'client_id' => $result['data']['metadata']['client_id'],
                    'client_name' => $result['data']['metadata']['name'],
                    'client_email' => $result['data']['customer']['email'],
                    'paymentstatus' => $result['data']['status'],
                    'transaction_reference' => $result['data']['reference'],
                    'transaction_id' => $result['data']['id'],
                    'charged_amount' => $result['data']['amount'],
                    'processor_response' => $result['data']['gateway_response'],
                ]);
                return view('content.payment.status');
                // return response()->json([
                //     'data' => $result
                // ]);
            }
        }
    }
}