<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    use HttpResponses;
    public function register(Request $request)
    {
       try {
         // validate request data
         $validateUser = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

         if($validateUser->fails()){
                return $this->error(false,'validation error',$validateUser->errors());
            }
        
        $input = $request->all();
        $admin = Admin::create($input);

        return $this->success([
            'status' => true,
                'message' => 'Admin Created Successfully',
                'token' => $admin->createToken("ADMIN API TOKEN")->plainTextToken
            ], 200);
       }
       catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::guard('admin')->attempt($credentials)) {
                $admin = Auth::guard('admin')->user();

                return $this->success([
                    'status' => true,
                    'message' => 'Admin Logged In Successfully',
                    'token' => $admin->createToken("ADMIN API TOKEN")->plainTextToken
                ], 200);
            } else {
                return $this->error("No Record Found", "Email & Password does not match with our record.", 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

     public function logout () 
     {
       $accessToken = Auth::user('admin')->currentAccessToken();
       $accessToken->delete();
        return $this->success([
            'message' => 'You have successfully been logged out '
        ]);
     }
}