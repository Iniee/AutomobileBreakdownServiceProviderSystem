<?php

namespace App\Http\Controllers\Admin;

use App\Models\Breakdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

public function chart () {
    
    $totalBreakdownsPerMonth = DB::table('breakdowns')
    ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as total'))
    ->groupBy('month')
    ->get();

    $months = $totalBreakdownsPerMonth->pluck('month');
    $totals = $totalBreakdownsPerMonth->pluck('total');


    dd($totalBreakdownsPerMonth);

}

}