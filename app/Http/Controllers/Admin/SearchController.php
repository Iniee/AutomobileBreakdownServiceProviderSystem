<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Provider;


class SearchController extends Controller
{
  public function searchAgentTable(Request $request){
    $query = $request->input('search');

    $agents = Agent::where('name', 'LIKE', '%'.$query. '%')
                      ->orWhere('lga', 'LIKE', '%'.$query. '%')
                      ->get();

    return view('content.agent.view-account', compact('agents'));


  }
  public function searchClientTable(Request $request){

    $query = $request->input('search');

    $clients = Client::where('name', 'LIKE', '%'.$query. '%')
                        ->orWhere('phone_number', 'LIKE', '%'.$query. '%')
                        ->get();

    return view('content.client.view-account', compact('clients'));

  }
  public function searchSevriceProviderTable(Request $request){
    $query = $request->input('search');

    $providers = Provider::where('name', 'LIKE', '%'.$query. '%')
                            ->orWhere('lga', 'LIKE', '%'.$query. '%')
                            ->get();

    return view('content.provider.view-account', compact('providers'));

  }
}
