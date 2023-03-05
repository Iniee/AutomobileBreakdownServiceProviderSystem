<?php

namespace App\Http\Controllers\Api;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Provider;
use Illuminate\Http\Request;
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
            'name' => $client->name,
            'email' => $user->email,
            'wallet_balance' => $client->wallet_balance,
            'profile picture' => $client->profile_picture,
            'home address' => $client->home_address
        ]
      ]);
      } 
      elseif($user->role == 'provider') 
      {
        $provider = Provider::where('user_id', $user->id)->first();
      //dd($provider);
      if ($provider->type =='Artisan') {
        return response()->json([
        'status' => true,
        'data' => [
            'status'=> $user->status,
            'name' => $provider->name,
            'email' => $user->email,
            'LGA' => $provider->lga,
            'type' => $provider->type,
            'profile picture' => $provider->profile_picture,
            'business_address' => $provider->business_address,
            'account_number' => $provider->account_number,
            'bank' => $provider->bank_name,
        ]
      ]);
      } else {
         return response()->json([
        'status' => true,
        'data' => [
            'status'=> $user->status,
            'name' => $provider->name,
            'email' => $user->email,
            'LGA' => $provider->lga,
            'type' => $provider->type,
            'plate number' => $provider->plate_number,
            'profile picture' => $provider->profile_picture,
            'business_address' => $provider->business_address,
            'account_number' => $provider->account_number,
            'bank' => $provider->bank_name,
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
            'state' => $user->state,
            'LGA' => $agent->lga,
            'profile picture' => $agent->profile_picture,
        ]
      ]);
     }
      
    }
 }