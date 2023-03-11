<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {

        // validate request data
        $request->validated($request->all());
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'push_notification_token' => $request->push_notification_token,
            'role' => 'admin'
        ]);
        
        $admin = Admin::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
         
        ]);

        return response()->json([
             'status' => true,
             'message' => 'Admin Created Successfully, Login to Generate token',
             'ftoken' => $user->push_notification_token

        ]);


    }

}