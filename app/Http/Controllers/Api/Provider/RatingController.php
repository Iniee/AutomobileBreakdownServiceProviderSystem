<?php

namespace App\Http\Controllers\Api\Provider;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function ProviderAvgRating(){
        $user = Auth::user();
        //dd($user);
        $client = Provider::where('user_id', $user->id)->first();
        //dd($client); 
        $id = $client->sp_id;
        $feedback = Feedback::where('sp_id', $id)->get();

        return response()->json([
            'status' => true,
            'Average Rating' => floatval($feedback->avg('rating'))
        ]);
    }
}