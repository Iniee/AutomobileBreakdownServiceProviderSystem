<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboard()
   {
    return view('content.dashboard.dashboards-analytics');
   }
}