<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
   public function providerAccount()
   {
    return view('content.provider.view-account');
   }

  public function providerDeactivateAccount()
   {
    return view('content.provider.deactivate-account');
   }
}