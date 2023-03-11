<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\FundWallet;
use App\Models\User;
use App\Models\Client;
use App\Models\Wallet;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class WalletController extends Controller
{
    use HttpResponses;

    public function viewtransaction()
    {
     
      $user = Auth::user();
        //dd($user);
        $client = Client::where('user_id', $user->id)->first();
        //dd($client);  
   
      $transaction= FundWallet::where('client_id', $client->client_id)->get();
      return response()->json([
        'data' =>$transaction,
    ]);

    }


}