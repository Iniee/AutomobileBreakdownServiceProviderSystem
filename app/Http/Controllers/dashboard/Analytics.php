<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function index()
  {
    return view('content.dashboard.dashboards-analytics');
  }
}