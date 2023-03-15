<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FundWallet;
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
    
    $users = auth()->user()->where('role', 'admin')->join('admins', 'admins.user_id', '=', 'users.id')->get();
    // dd($users);
    return view('content.admin-profile.profile', compact('users'));
  }



  public function updateProfileDetails(Request $request)
  {
    $validatedData = $request->validate([
      'account_number' => 'required|string|max:10|min:10',
      'bank_name' => 'required|string',
    ]);
    $user = auth()->user()->where('role', 'admin')->join('admins', 'admins.user_id', '=', 'users.id')->update([
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