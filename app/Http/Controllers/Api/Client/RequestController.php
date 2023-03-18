<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Provider;
use App\Models\Breakdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        if ($spdata->type == 'Artisan') {
            return response()->json([
                'name' => $spdata->name,
                'profile_picture' => $spdata->profile_picture,
                'type' =>  $spdata->type,
                'latitude' => $spdata->latitude,
                'longitude' => $spdata->longitude,
                'phone_number' =>  $spdata->phone_number,

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
            ]);
        }
    }
}