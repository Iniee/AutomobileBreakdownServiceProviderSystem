<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breakdown;
use Illuminate\Http\Request;

class BreakdownController extends Controller
{
public function breakdownHistory () 
{
    $breakdowns = Breakdown::where('status', 'accepted')
        ->latest('updated_at')
        ->with(['requests' => function ($query) {
            $query->select('breakdown_id', 'provider_id');
        }])
        ->paginate(12);
    return view('content.breakdown.history', compact('breakdowns'));
}

}