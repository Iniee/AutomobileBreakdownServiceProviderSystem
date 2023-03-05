<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            
            if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard');
            }
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