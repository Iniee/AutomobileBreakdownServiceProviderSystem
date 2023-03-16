<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Provider\FeedbackRequest;
use App\Models\User;
use App\Models\Client;
use App\Models\Breakdown;
use App\Models\Provider;
use App\Models\Feedback;
use App\Models\Request as ModelsRequest;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function feedback(FeedbackRequest $request, $id){
        $val_data = $request->all();
        //dd($val_data);
        $feedback = new Feedback;
        $feedback->review = $val_data['review'];
        $feedback->rating = $val_data['rating'];
        
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
        $feedback->client_id = $client->client_id;
        $breakdown = Breakdown::find($id);
        $feedback->breakdown_id = $breakdown->breakdown_id;
        $requestdata = ModelsRequest::where('breakdown_id', $breakdown->breakdown_id)->first();
       
        $feedback->sp_id = $requestdata->provider_id;

        
        if($feedback->save()){
            return response()->json([
                'status' => true,
                'data' => $feedback
            ]);
        }
        else {
            return response()->json([
             'status' => false,
             'message' => "Failed"
         ]);
         }

    }
}