<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Request as ModelRequest;
use App\Models\Provider;
use App\Models\Breakdown;
use App\Models\Diagnosis;
use App\Models\FundWallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    public function calculateChargeAmount(Request $request, $breakdownid)
{
    $input = Validator::make($request->all(), [
        'cost' => 'required|numeric',
    ]);

    if ($input->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $input->errors()
        ], 401);
    }

    $id = Breakdown::find($breakdownid);
    $cost = $request->input('cost');

    // Add extra service charge of 500 to the cost
    $cost += 500;

    // Get the client's email
    $client = Client::find($id->client_id);
    $provider = Auth::user()->providers;

     $form = Diagnosis::create([
            'cost' => $cost,
            'provider_id' => $provider->sp_id,
            'client_id' => $client->client_id,
            'breakdown_id' => $id->breakdown_id
        ]);


    // Return the total charge amount
    return response()->json(['message' => 'Charge amount', 'cost' => $cost, 'client_id' => $client->client_id]);
}

    public function storeartisan( $breakdownid)
    {
        
        $id = Diagnosis::where('breakdown_id', $breakdownid)->first();
        $client = Client::find($id->client_id);
        $client_email = User::where('id', $client->user_id)->first();
        $cost = $id->cost;
        if ($client->wallet_balance < $cost) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }

        // Deduct the total amount from the client's wallet balance
        $client->wallet_balance -= $cost;
        $client->save();

        $transaction_reference = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $transaction_id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);

        $transaction = FundWallet::create([
            'charged_amount' => $cost,
            'processor_response' => 'debit',
            'client_id' => $client->client_id,
            'client_name' => $client->name,
            'client_email' =>$client_email->email,
            'paymentstatus' => 'success',
            'transaction_reference' =>  $transaction_reference,
            'transaction_id' => $transaction_id
        ]);

               return response()->json(['message' => 'Payment successful', 'amount' => $cost, 'transaction' => $transaction]);

    }



    public function storedriver($breakdownid)
    {
        $id = Breakdown::find($breakdownid);
        $request = ModelRequest::where('breakdown_id', $id->breakdown_id)->first();
        $sp = $request->provider_id;
        $origin_latitude = $id->breakdown_latitude;
        $origin_longitude = $id->breakdown_longitude;

        $destination_latitude = $id->destination_latitude;
        $destination_longitude = $id->destination_longitude;

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origin_latitude,$origin_longitude&destinations=$destination_latitude,$destination_longitude&key=AIzaSyDornqgr9WTKn7NBam4u0H9-nDrZ2p7vdQ";
        // Make the API request using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        $response = curl_exec($ch);
        //info($response);
        curl_close($ch);
        $result = json_decode($response, true);

        // Get the distance in kilometers
        $distance = $result['rows'][0]['elements'][0]['distance']['value'] / 1000;
        $chargePerKm = 50; //(50 naira)

        $cost = $distance * $chargePerKm;

        $client = Client::find($id->client_id);
        $client_email = User::where('id', $client->user_id)->first();
        if ($client->wallet_balance < $cost) {
            return response()->json(
                ['error' => 'Insufficient balance'],
                400
            );
        }

        // Deduct the total amount from the client's wallet balance
        $client->wallet_balance -= $cost;
        $client->save();
        $transaction_reference = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $transaction_id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);

        $transaction = FundWallet::create([
            'charged_amount' => $cost,
            'processor_response' => 'debit',
            'client_id' => $client->client_id,
            'client_name' => $client->name,
            'client_email' => $client_email->email,
            'paymentstatus' => 'success',
            'transaction_reference' =>  $transaction_reference,
            'transaction_id' => $transaction_id
        ]);
        $form = Diagnosis::create([
            'cost' => $cost,
            'provider_id' => $sp,
            'client_id' => $client->client_id,
            'breakdown_id' => $id->breakdown_id
        ]);
        return response()->json([
            'message' => 'Payment successful',
            'data' => $form,
            'transaction'=> $transaction
        ]);
    }

    public function hasBeenCharged($breakdown_id)
    {
        $client = Auth::user()->client;

        $charge = Diagnosis::where('breakdown_id', $breakdown_id)
            ->where('client_id', $client->client_id)
            ->first();

        if (!$charge) {
            return response()->json([
                'charged' => false
            ]);
        }

        return response()->json([
            'charged' => true,
            'charge_amount' => $charge->cost,
            'charge_date' => $charge->created_at
        ]);
    }

   
}