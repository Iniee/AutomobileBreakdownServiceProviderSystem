<?php

namespace App\Http\Controllers\Api;

use App\Models\State;
use Illuminate\Http\Request;
use App\Models\LocalGovernment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function getState() {
        $states = DB::table('states')->get();
        $data = [];

        foreach($states as $state) {
            $data[] = [
                'id' => $state->id, 
                'name' => $state->name
            ];
        }

        return response()->json([
            'message' => 'Request Successful',
            'status' => true,
            'data' => $data
        ]);
    }


   public function getLga() {
    $lgas = DB::table('local_governments')->get();
    $states = DB::table('states')->get();

    $stateData = [];
    foreach($states as $state) {
        $stateData[$state->id] = $state->name;
    }

    $lgaData = [];
    foreach($lgas as $lga) {
        $stateName = isset($stateData[$lga->state_id]) ? $stateData[$lga->state_id] : '';
        $lgaData[] = [
            'id' => $lga->id, 
            'LGA' => $lga->name,
            'state' => $stateName,
        ];
    }

    return response()->json([
        'message' => 'Request Successful',
        'status' => true,
        'data' => $lgaData
    ]);
}


}