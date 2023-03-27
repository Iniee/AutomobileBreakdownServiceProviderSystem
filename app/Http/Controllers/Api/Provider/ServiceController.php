<?php

namespace App\Http\Controllers\Api\Provider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;

class ServiceController extends Controller
{

    public function historyService()
    {
        $provider = Auth::user()->providers;
        $requestdata = DB::table('requests')
            ->join('breakdowns', 'requests.breakdown_id', '=', 'breakdowns.breakdown_id')
            ->join('clients', 'clients.client_id', '=', 'breakdowns.client_id')
            ->leftJoin(DB::raw('(SELECT breakdown_id, cost FROM diagnoses) AS diagnoses'), 'diagnoses.breakdown_id', '=', 'breakdowns.breakdown_id')
            ->where('requests.provider_id', $provider->sp_id)
            ->where('breakdowns.status', 'accepted')
            ->select('clients.name as client_name', 'breakdowns.updated_at', 'diagnoses.cost')
            ->get();
        return response()->json([
            'data' => $requestdata
        ]);
    }
}