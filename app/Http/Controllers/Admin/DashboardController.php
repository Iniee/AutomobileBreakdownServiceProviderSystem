<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getDashboard()
   {
    return view('content.dashboard.dashboards-analytics');
   }
}