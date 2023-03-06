<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
   public function providerAccount()
   {
    $providers = Provider::with('user', 'agent')->latest('created_at')->paginate(20);
    return view('content.provider.view-account', compact('providers'));
   }

   // public function deactiveClient()
   //  {
   //          $users = User::where([
   //              ['status', 'pending'],
   //              ['role', 'provider']
   //          ])->with('provider')->latest('created_at')->paginate(20);          
   //          return view('content.provider.deactive-account', compact('users'));
   //  }
   //  public function activeClient()
   //  {
   //           $users = User::where([
   //              ['status', 'active'],
   //              ['role', 'provider']
   //          ])->with('provider')->latest('created_at')->paginate(20);          
   //          return view('content.provider.active-account', compact('users'));
   //  }
}