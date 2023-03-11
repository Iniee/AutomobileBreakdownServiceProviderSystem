<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Client;
use App\Traits\HttpResponses;
use App\Models\FundWallet;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    use HttpResponses;
    
    public function countClient ()
    {
        $user = DB::table('users')
               ->where([
                ['status', 'active'],
                ['role', 'client']
            ])->count();
            
        return response()->json([
            'data' => $user
        ]);
    }
    public function countAgent ()
    {
        $user = DB::table('users')
               ->where([
                ['status', 'active'],
                ['role', 'agent']
            ])->count();
           
        return response()->json([
            'data' => $user
        ]);
    }
    public function countProvider ()
    {
        $user = DB::table('users')
               ->where([
                ['status', 'active'],
                ['role', 'provider']
            ])->count();
            
        return response()->json([
            'data' => $user
        ]);
    }
    public function transaction()
    {
    
        $transaction = Fundwallet::all();
        return response()->json([
            'status' => true,
            'transaction' => $transaction
        ]);
    }

    public function deactivateUser($user) 
    {
        $id = User::find($user);
        info($id);
        $id->status = "pending";
        $id->save();

        return response()->json([
            'message' => $id->email. " has been deactivated"
        ]);
    }

     public function activateUser($user) 
    {
        $id = User::find($user);
        info($id);
        $id->status = "active";
        $id->save();

        return response()->json([
            'message' => $id->email. " has been activated"
        ]);
    }

    public function activeClient()
    {
        $user = DB::table('users')
               ->where([
                ['status', 'active'],
                ['role', 'client']
            ])->first();
            
        $client = Client::where('user_id', $user->id)->first();
        return response()->json([
            'status' => true,
            'data' => $client
        ]);
    }
 
    public function activeAgent()
    {
        try {
            $user = DB::table('users')
                ->where([
                ['status', 'active'],
                ['role', 'agent']
            ])->first();
         $agent = Agent::where('user_id', $user->id)->first();
           return response()->json([
            'status' => true,
            'data' => $agent
        ]); 
        } catch (\Throwable $th) {
             return response()->json([
                'status' => true,
                'message' => "No Active Agent"
            ], 200);
        }
       
         
        }
       
    
    public function activeProvider()
    {
        try {
           $user = DB::table('users')
              ->where([
                ['status', 'active'],
                ['role', 'provider']
            ])->first();
            
        $provider = Provider::where('user_id', $user->id)->first();
        return response()->json([
            'status' => true,
            'data' => $provider
        ]);
        } catch (\Throwable $th) {
             return response()->json([
                'status' => true,
                'message' => "No Active Provider"
            ], 200);
        }
        
    }
    public function deactiveClient()
    {
        try {
            $user = DB::table('users')
               ->where([
                ['status', 'pending'],
                ['role', 'client']
            ])->first();
            
        $client = Client::where('user_id', $user->id)->first();
        return response()->json([
            'status' => true,
            'data' => $client
        ]);
        } catch (\Throwable $th) {
             return response()->json([
                'status' => true,
                'message' => "No Active Client"
            ], 200);
        }
        
    }
 
    public function deactiveAgent()
    {
        try {
          $user = DB::table('users')
              ->where([
                ['status', 'pending'],
                ['role', 'agent']
            ])->first();
         $agent = Agent::where('user_id', $user->id)->first();
           return response()->json([
            'status' => true,
            'data' => $agent
        ]);  
        } catch (\Throwable $th) {
             return response()->json([
                'status' => true,
                'message' => "No pending Agent"
            ], 200);
        }
       
        }
       
    
    public function deactiveProvider()
    {
        try {
           $user = DB::table('users')
              ->where([
                ['status', 'pending'],
                ['role', 'provider']
            ])->first();
            
        $provider = Provider::where('user_id', $user->id)->first();
        return response()->json([
            'status' => true,
            'data' => $provider
        ]); 
        } catch (\Throwable $th) {
             return response()->json([
                'status' => true,
                'message' => "No pending Service Provider "
            ], 200);
        }
       
        
        
        
    }
}