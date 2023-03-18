<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\FundWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
  public function getDashboard()
  {
    $transaction = FundWallet::sum('charged_amount');
    
    return view('content.dashboard.dashboards-analytics');
  }

  public function showProfileDetails()
  {
    
    $admin = auth()->user();
    $user = DB::table('users')
    ->join('admins', 'users.id', '=', 'admins.user_id')
    ->where('users.id', $admin->id)
    ->first();
    return view('content.admin-profile.profile', compact('user'));
  }



public function updateProfileDetails(Request $request)
{
    $validatedData = $request->validate([
        'account_number' => 'required|string|max:10|min:10',
        'bank_name' => 'required|string',
    ]);

    $admin = auth()->user()->admin;
    $admin->update([
        "account_number" => $validatedData['account_number'],
        "bank_name" => $validatedData['bank_name'],
    ]);

    return redirect('/dashboard');
}



  public function changePasswdPage()
  {
    return view('content.admin-profile.change_password');
  }



  public function changePassword(Request $request)
  {
    $validatedPasswd = $request->validate([
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (Hash::check($request->current_password, $user->password)) {
      $user->password = Hash::make($validatedPasswd['password']);
      $user->save();

      return redirect('/dashboard');
    }

    return redirect()->back()->withErrors([
      'password' => 'The current password is incorrect',
  ]);
  }
}