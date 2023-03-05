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
        $breakdown = Breakdown::where('client_id', $client->client_id)->first();
        $feedback->breakdown_id = $breakdown->breakdown_id;
        $sp = Provider::find($id);
        //dd($sp);
        $feedback->sp_id = $sp->sp_id;

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