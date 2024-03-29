<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('content.authentications.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and has the "admin" role
        if ($user && $user->role == 'admin' && Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        // Redirect with error message if login fails
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function forgotPassword()
    {
        return view('content.authentications.forgot-password');
    }




    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}