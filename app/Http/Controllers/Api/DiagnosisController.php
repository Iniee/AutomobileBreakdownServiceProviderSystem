<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    public function submitForm(Request $request)
    {
    $input = Validator::make($request->all(),
            [
                'description' => 'required',
                'cost' => 'required|numeric',
            ]);
     if($input->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $input->errors()
                ], 401);
            }
    // Retrieve breakdown issues and charges from the form submission
    $description = $request->input('description');
    $cost = $request->input('cost');

    // Calculate the total amount to be charged
    $total = 0;
    foreach ($cost as $charge) {
        $total += $charge;
    }

    // Check if the client has sufficient balance
    $client = Auth::user();
    if ($client->wallet_balance < $total) {
        return response()->json(['error' => 'Insufficient balance'], 400);
    }

    // Deduct the total amount from the client's wallet balance
    $client->wallet_balance -= $total;
    $client->save();

    // Initiate a task or send a notification to the artisan to begin the repairs
    // ...

    return response()->json(['message' => 'Payment successful']);
   }

    public function store(Request $request, $id)
    {
        $input = Validator::make($request->all(),
            [
                'data' => 'required|json',
                'amount' => 'required|int',
            ]);
        
        if($input->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $input->errors()
                ], 401);
            }
        $data = Client::find($id);
        $form = Diagnosis::create([
            'data' => $request->data,
            'amount' => $request->amount,
            'provider_id' => Auth::user()->sp_id,
            'client_id' => $data->client_id
        ]);
        
        $client = Client::find($id);
        info($client);
        return response()->json($form, 201);
    }
}