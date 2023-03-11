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
            'message' => 'Request Made to '. $provider->name,
            'data' => $newRequest,
        ], 201);
    }
}