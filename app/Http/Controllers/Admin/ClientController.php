<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
   public function clientAccount()
   {
    $clients = Client::with('user')->latest('created_at')->paginate(20);
    return view('content.client.view-account', compact('clients'));
   }
   
   public function deactiveClient()
    {
            $users = User::where([
                ['status', '!=', 'active'],
                ['role', 'client']
            ])->with('client')->latest('created_at')->paginate(20);
            
            return view('content.client.deactive-account', compact('users'));
    }
    public function activeClient()
    {
             $users = User::where([
                ['status', 'active'],
                ['role', 'client']
            ])->with('client')->latest('created_at')->paginate(20);       
          
            return view('content.client.active-account', compact('users'));
    }
   
}