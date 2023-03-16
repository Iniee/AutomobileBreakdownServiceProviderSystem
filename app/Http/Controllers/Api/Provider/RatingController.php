<?php

namespace App\Http\Controllers\Api\Provider;

use App\Models\User;
use App\Models\Feedback;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function ProviderAvgRating(){
        $user = Auth::user()->providers;
       
        $id = $user->sp_id;
        $feedback = Feedback::where('sp_id', $id)->get();

        $requestdata = DB::table('requests')
            ->join('breakdowns', 'requests.breakdown_id', '=', 'breakdowns.breakdown_id')
            ->where('requests.provider_id', $id)
            ->where('breakdowns.status', 'accepted')
            ->count();


        return response()->json([
            'avgrating' => floatval($feedback->avg('rating')),
            'services' => $requestdata,
            'current_earning' => 34900
        ]);
    }
}