<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}