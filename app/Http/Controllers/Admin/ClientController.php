<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
   public function clientAccount()
   {
    return view('content.client.view-account');
   }

  public function clientDeactivateAccount()
   {
    return view('content.client.deactivate-account');
   }
}