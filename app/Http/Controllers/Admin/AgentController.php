<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function agentAccount()
   {
    return view('content.agent.view-account');
   }

   public function createAgent()
   {
    return view('content.agent.register');
   }

  public function agentDeactivateAccount()
   {
    return view('content.agent.deactivate-account');
   }
}