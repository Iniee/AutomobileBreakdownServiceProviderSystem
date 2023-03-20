<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Feedback;
use App\Models\Provider;
use App\Models\Breakdown;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as ModelsRequest;

class RequestController extends Controller
{
    public function storeRequest(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'breakdown_id' => 'required|integer',
            'provider_id' => 'required|integer',
        ]);

        // Retrieve the breakdown and provider records
        $breakdown = Breakdown::findOrFail($validatedData['breakdown_id']);
        $provider = Provider::findOrFail($validatedData['provider_id']);

        // Check if the breakdown and provider records exist
        if (!$breakdown || !$provider) {
            return response()->json(['error' => 'Breakdown or provider not found'], 404);
        }

        // Create a new request record
        $newRequest = ModelsRequest::create([
            'breakdown_id' => $breakdown->breakdown_id,
            'provider_id' => $provider->sp_id,
        ]);

        // Update the breakdown status to indicate that a provider has been requested
        $breakdown->status = 'requested';
        $breakdown->save();

        // Return a response indicating success
        return response()->json([
            'message' => 'Request Made to ' . $provider->name,
            'data' => $newRequest,
        ], 201);
    }

    public function requestSP(Request $request, $id)
    {

        $breakdown = Breakdown::find($id);
        $requestdata = ModelsRequest::where('breakdown_id', $breakdown->breakdown_id)->latest()
            ->first();

        $provider = $requestdata->provider_id;
        $providerdata = Provider::where('sp_id', $provider)->first();

        // Validate the incoming request data
        $validatedData = $request->validate([
            'status' => 'required|boolean',
        ]);

        if ($validatedData['status'] == true) {
            $breakdown->status = 'accepted';
            $breakdown->save();
            return response()->json([
                'message' => "Request was Accepted",
                'data' => $providerdata
            ]);
        } else {
            $breakdown->status = 'rejected';
            $breakdown->save();
            return response()->json([
                'message' => "Request was Declined"
            ]);
        }
    }

    public function statustype($id)
    {

        $request_id = Breakdown::find($id);

        $statustype = $request_id->status;

        if ($statustype == 'rejected') {
            return response()->json([
                'message' => 'Request was Declined'
            ]);
        } else if ($statustype == 'requested') {
            return response()->json([
                'message' => 'Request is Pending'
            ]);
        } else {
            return response()->json([
                'message' => 'Request has been Accepted'
            ]);
        }
    }

    public function spdata($id)
    {
        $breakdown = Breakdown::find($id);
        $requestdata = ModelsRequest::where('breakdown_id', $breakdown->breakdown_id)->latest()
            ->first();
        $data = $requestdata->provider_id;

        $spdata = Provider::find($data);
        $feedback = Feedback::where('sp_id', $spdata->sp_id)->get();

        if ($spdata->type == 'Artisan') {
            return response()->json([
                'name' => $spdata->name,
                'profile_picture' => $spdata->profile_picture,
                'type' =>  $spdata->type,
                'latitude' => $spdata->latitude,
                'longitude' => $spdata->longitude,
                'phone_number' =>  $spdata->phone_number,
                'business_address' => $spdata->business_address,
                'rating' => floatval($feedback->avg('rating')),

            ]);
        } else {
            return response()->json([
                'name' => $spdata->name,
                'profile_picture' => $spdata->profile_picture,
                'type' =>  $spdata->type,
                'plate_number' => $spdata->plate_number,
                'phone_number' =>  $spdata->phone_number,
                'latitude' => $spdata->latitude,
                'longitude' => $spdata->longitude,
                'business_address' => $spdata->business_address,
                'rating' => floatval($feedback->avg('rating')),
            ]);
        }
    }

   public function clienthistory()
{
    $client = Auth::user()->client;
    $history = Breakdown::where('client_id', $client->client_id)
        ->where('status', 'accepted')
        ->select('breakdown_id', 'breakdown_location', 'created_at')
        ->get();
    $history_with_cost = [];
    $total_cost = 0;
    foreach ($history as $record) {
        $diagnosis_cost = Diagnosis::where('breakdown_id', $record->breakdown_id)
            ->where('client_id', $client->client_id)
            ->select('cost')
            ->get();
        $cost_sum = 0;
        foreach ($diagnosis_cost as $diagnosis) {
            $cost_sum += (float) $diagnosis->cost;
        }
        $total_cost += $cost_sum;
        // Add the cost sum to the $record object
        $record->cost = $cost_sum;
        $history_with_cost[] = $record;
    }
    return response()->json([
        'data' => $history_with_cost,
    ]);
}

}