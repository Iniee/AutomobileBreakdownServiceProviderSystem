<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Agent;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provider;

class StatusController extends Controller
{
   public function updateStatus(Request $request, Agent $agent)
   {

    $user = User::where("id", $agent->user_id)->first();
    // Get the selected status from the request
    $status = $request->input('status');

    // Update the user's status
    $user->status = $status;
    $user->save();

    // Redirect back to the user list with a success message
    return redirect()->route('agent-view-agent')->with('success', 'User status updated successfully.');
  }

  public function clientStatus(Request $request, Client $client)
  {

    $user = User::where("id", $client->user_id)->first();
    // Get the selected status from the request
    $status = $request->input('status');

    // Update the user's status
    $user->status = $status;
    $user->save();

    // Redirect back to the user list with a success message
    return redirect()->route('client-view-client')->with('success', 'User status updated successfully.');
  }
  public function providerStatus(Request $request, Provider $provider)
  {

    $user = User::where("id", $provider->user_id)->first();
    // Get the selected status from the request
    $status = $request->input('status');

    // Update the user's status
    $user->status = $status;
    $user->save();

    // Redirect back to the user list with a success message
    return redirect()->route('provider-view-provider')->with('success', 'User status updated successfully.');
  }
}
