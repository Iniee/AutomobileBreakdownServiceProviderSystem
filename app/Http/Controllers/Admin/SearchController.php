<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Provider;
use App\Models\FundWallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
  public function searchAgentTable(Request $request){
    $query = $request->input('search');

    $agents = Agent::where('name', 'LIKE', '%'.$query. '%')
                      ->orWhere('lga', 'LIKE', '%'.$query. '%')
                      ->get();

    return view('content.agent.view-account', compact('agents'));
  }

  public function searchInactiveAgents(Request $request)
  {
    $query = $request->input('search');

    $users = User::where([
      ['status', 'pending'],
      ['role', 'client']
    ])
    ->join('agents', 'agents.user_id', '=', 'users.id')
    ->where('agents.name', 'LIKE', '%'.$query. '%')
    ->orWhere('agents.lga', 'LIKE', '%'.$query. '%')
    ->get();
    return view('content.agent.deactive-account', compact('users'));
  }

  public function searchActiveAgents(Request $request)
  {
    $query = $request->input('search');

    $users = User::where([
      ['status', 'active'],
      ['role', 'client']
    ])
    ->join('agents', 'agents.user_id', '=', 'users.id')
    ->where('agents.name', 'LIKE', '%'.$query. '%')
    ->orWhere('agents.lga', 'LIKE', '%'.$query. '%')
    ->get();
    return view('content.agent.active-account', compact('users'));
  }



  public function searchClientTable(Request $request){

    $query = $request->input('search');

    $clients = Client::where('name', 'LIKE', '%'.$query. '%')
                        ->orWhere('phone_number', 'LIKE', '%'.$query. '%')
                        ->get();
    dd($clients);
    return view('content.client.view-account', compact('clients'));

  }

  public function searchActiveClients(Request $request){

    $query = $request->input('search');

    $users = User::where([
      ['status', 'active'],
      ['role', 'client']
    ])
    ->join('clients', 'clients.user_id', '=', 'users.id')
    ->where('clients.name', 'LIKE', '%'.$query. '%')
    ->orWhere('clients.phone_number', 'LIKE', '%'.$query. '%')
    ->get();

    return view('content.client.active-account', compact('users'));
  }

  public function searchInactiveClients(Request $request){

    $query = $request->input('search');

    $users = User::where([
      ['status', 'pending'],
      ['role', 'client']
    ])
    ->join('clients', 'clients.user_id', '=', 'users.id')
    ->where('clients.name', 'LIKE', '%'.$query. '%')
    ->orWhere('clients.phone_number', 'LIKE', '%'.$query. '%')
    ->get();
    return view('content.client.deactive-account', compact('users'));
  }

  public function searchSevriceProviderTable(Request $request){
    $query = $request->input('search');

    $providers = Provider::where('name', 'LIKE', '%'.$query. '%')
                            ->orWhere('lga', 'LIKE', '%'.$query. '%')
                            ->get();

    return view('content.provider.view-account', compact('providers'));

  }




  public function searchTransactionTable(Request $request){
    $query = $request->input('search');

    $transactions = FundWallet::where('charged_amount', $query)->get();

    return view('content.transaction.client', compact('transactions'));

  }
}
