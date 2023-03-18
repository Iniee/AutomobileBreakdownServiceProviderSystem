<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Breakdown;
use App\Models\Client;
use App\Models\Diagnosis;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    public function storeartisan(Request $request, $breakdownid)
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
    $provider= Auth::user()->providers;
    $cost = $request->input('cost');

    // Add extra service charge of 500 to the cost
    $cost += 500;

    // Check if the client has sufficient balance
    $client = Client::find($id->client_id);

    if ($client->wallet_balance < $cost) {
        return response()->json(['error' => 'Insufficient balance'], 400);
    }

    // Deduct the total amount from the client's wallet balance
    $client->wallet_balance -= $cost;
    $client->save();

    $form = Diagnosis::create([
        'cost' => $cost,
        'provider_id' => $provider->sp_id,
        'client_id' => $client->client_id,
        'breakdown_id' => $id->breakdown_id
    ]);

    return response()->json(['message' => 'Payment successful', 'data' => $form]);
}



    public function storedriver($breakdownid)
    {
        $id = Breakdown::find($breakdownid);
        $user_id = Auth::user()->id;
        $sp= Provider::where('user_id', $user_id)->first();
        
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
        $chargePerKm = 50;//(50 naira)
        
        $cost = $distance*$chargePerKm;

        $client = Client::find($id->client_id);
        
        if ($client->wallet_balance < $cost) {
            return response()->json(
                ['error' => 'Insufficient balance'], 
                400);
        }

        // Deduct the total amount from the client's wallet balance
        $client->wallet_balance -= $cost;
        $client->save();
            
            $form = Diagnosis::create([
                'cost' => $cost,
                'provider_id' => $sp->sp_id,
                'client_id' => $client->client_id,
                'breakdown_id' => $id->breakdown_id
        ]);
        return response()->json([
            'message' => 'Payment successful',
            'data' => $form
        ]);
    }
}