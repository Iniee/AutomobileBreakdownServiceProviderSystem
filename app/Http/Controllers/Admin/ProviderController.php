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
    $providers = Provider::with('user', 'agent', 'diagnoses')->latest('created_at')->paginate(20);

    foreach ($providers as $provider) {
        $provider->total_earnings = $provider->diagnoses->sum('cost');
    }

    return view('content.provider.view-account', compact('providers'));
}


   public function deactiveProviders()
    {
            $users = User::where([
                ['users.status', 'pending'],
                ['users.role', 'provider']
            ])->with('providers')->latest('created_at')->paginate(20);
            return view('content.provider.deactive-account', compact('users'));
    }

    public function activeProviders()
    {
             $users = User::where([
                ['users.status', 'active'],
                ['users.role', 'provider']
            ])->with('providers')->latest('created_at')->paginate(20);
            return view('content.provider.active-account', compact('users'));
    }
}
