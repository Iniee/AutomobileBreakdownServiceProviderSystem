<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'status' => true,
                'user' => $user->email,
                'role' => $user->role,
                'token' => $user->createToken("User Token of " . $user->email)->plainTextToken

            ]);
        } else {
            return response()->json([
            'Status' => false,
            'message'=>"Invalid Login Details"
        ], 404);
        }
    }

     public function logout(Request $request)
    {
     $accessToken = Auth::user()->currentAccessToken();
     $accessToken->delete();
        return response()->json([
            'status' => true,
            'message' => 'You have successfully been logged out '
        ]);
    }


    public function forgot(ForgotPassword $request)
    {
        $user = ($query = User::query());

        $user = $user->where($query->qualifyColumn('email'), $request->input('email'))->first();
         //dd($user);
        //if no such user exists then throw an error
        if (!$user || !$user->email) {
             return response()->json([
            'status' => false,
            'message'=>"Invalid Email Address"
        ], 404);
        }

        // Generate a 4 digit random Token
        $resetPasswordToken = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);

        //In case User has already requested for forgot password don't create another record
        //Instead Update the existing token with the new token

        if (!$userPassReset = PasswordReset::where('email', $user->email)->first()) {
            //Store Token in DB with Token Expiration Time i.e: 1 hour
            PasswordReset::create([
                'email' => $user->email,
                'token' => $resetPasswordToken,
            ]);
        } else {

            //Store Token in DB with Token Expiration Time
            $userPassReset->update([
                'email' => $user->email,
                'token' => $resetPasswordToken,
            ]);
        }

        //Send Notification to the User about the Reset Token
        $user->notify(
            new ResetPassword(
                $resetPasswordToken
            )
        );

        return response()->json([
            'message'=> 'A code has been sent to your email Address'
        ]);

    }

    public function reset(ResetPasswordRequest $request)
    {
        //Validate the request
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        //Throw Exception if user is not found
        if (!$user) {
             return response()->json([
            'status' => false,
            'message'=>"Invalid Email Address"
        ], 404);;
        }

        $resetRequest = PasswordReset::where('email', $user->email)->first();

        if (!$resetRequest || $resetRequest->token != $request->token) {
            return response()->json([
                'status' => false,
                'message'=>'An Error Occured' ], 400);
        }

        //Update User's Password
        $user->fill([
            'password' => Hash::make($attributes['password']),
        ]);

        $user->save();

        //Delete previous all Tokens
        $user->tokens()->delete();

        $resetRequest->delete();

        //Get Token or Authenticated User
        $token = $user->createToken("client Token of " . $user->email)->plainTextToken;

        //Create a Response
        $loginResponse = [
            'users' => $user->email,
            'token' => $token
        ];

        return response()->json([
            'data'=> $loginResponse, 
            'message' => 'Password Reset Success'
            , 201]);

    }
}