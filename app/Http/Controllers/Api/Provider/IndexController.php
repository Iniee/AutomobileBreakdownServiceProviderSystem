<?php

namespace App\Http\Controllers\Api\Provider;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Breakdown;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $provider = Provider::where('user_id', $user->id)->first();
        $id = $provider->sp_id;
        //dd($id);
        $breakdowns = Breakdown::whereHas('client_id', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();
        dd($breakdowns);
        return view('breakdowns.index', compact('breakdowns'));
    }
    public function getAllProvider ()
    {
        $provider = Provider::all();

        return $this->success([
                'service_provider' => $provider
            
        ]);   
    }
}