<?php

namespace App\Http\Controllers\Api;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Feedback;
use App\Models\Provider;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile () {
      $user = Auth::user();
      
      if($user->role == 'client') {
      $client = Client::where('user_id', $user->id)->first();
      return response()->json([
        'status' => true,
        'data' => [
            'status'=> $user->status,
            'role' => $user->role,
            'name' => $client->name,
            'email' => $user->email,
            'phone_number' => $client->phone_number,
            'gender' => $client->gender,
            'wallet_balance' => $client->wallet_balance,
            'profile picture' => $client->profile_picture,
            'home address' => $client->home_address,
            'ftoken' => $user->push_notification_token
        ]
      ]);
      } 
      elseif($user->role == 'provider') 
      {
        $provider = Provider::where('user_id', $user->id)->first();
        $feedback = Feedback::where('sp_id', $provider->sp_id)->get();
        $requestdata = DB::table('requests')
            ->join('breakdowns', 'requests.breakdown_id', '=', 'breakdowns.breakdown_id')
            ->where('requests.provider_id', $provider->sp_id)
            ->where('breakdowns.status', 'accepted')
            ->count();
        $earnings = Diagnosis::where('provider_id', $provider->sp_id)->sum('cost');
       
      if ($provider->type =='Artisan') {
        return response()->json([
        'status' => true,
        'data' => [
            'status'=> $user->status,
            'role' => $user->role,
            'name' => $provider->name,
            'email' => $user->email,
            'phone_number' => $provider->phone_number,
            'gender' =>  $provider->gender,
            'LGA' => $provider->lga,
            'type' => $provider->type,
            'profile picture' => $provider->profile_picture,
            'business_address' => $provider->business_address,
            'account_number' => $provider->account_number,
            'bank' => $provider->bank_name,
            'ftoken' => $user->push_notification_token,
            'avgrating' => floatval($feedback->avg('rating')),
            'services' => $requestdata,
            'current_earning' => $earnings
        ]
      ]);
      } else {
         return response()->json([
        'status' => true,
        'data' => [
            'status'=> $user->status,
            'role' => $user->role,
            'name' => $provider->name,
            'email' => $user->email,
            'phone_number' => $provider->phone_number,
            'gender' =>  $provider->gender,
            'LGA' => $provider->lga,
            'type' => $provider->type,
            'plate number' => $provider->plate_number,
            'profile picture' => $provider->profile_picture,
            'business_address' => $provider->business_address,
            'account_number' => $provider->account_number,
            'bank' => $provider->bank_name,
            'ftoken' => $user->push_notification_token,
            'avgrating' => floatval($feedback->avg('rating')),
            'services' => $requestdata,
            'current_earning' => $earnings
        ]
      ]);
      }      
      } 
      else 
     {
          $agent = Agent::where('user_id', $user->id)->first();
      //dd($agent);
      return response()->json([
        'status' => true,
        'data' => [
            'status'=> $user->status,
            'role' => $user->role,
            'name' => $agent->name,
            'email' => $user->email,
            'phone_number' => $agent->phone_number,
            'gender' =>  $agent->gender,
            'LGA' => $agent->lga,
            'profile picture' => $agent->profile_picture,
            'ftoken' => $user->push_notification_token
        ]
      ]);
     }
      
    }
 }