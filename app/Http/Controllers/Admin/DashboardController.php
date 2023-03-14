<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
  public function getDashboard()
  {
    return view('content.dashboard.dashboards-analytics');
  }

  public function showProfileDetails()
  {
    $users = auth()->user()->where([
      ['role', 'admin'],
      ['status', 'active']
    ])->join('admins', 'admins.user_id', '=', 'users.id')->get();
    // dd($users);
    return view('content.admin-profile.profile', compact('users'));
  }



  public function updateProfileDetails(Request $request)
  {
    $validatedData = $request->validate([
      // 'name' => 'required|string|max:50',
      // 'email' => 'required|email|unique:users,email|string',
      // 'phone_number' => 'required|max:11|min:11|string|unique:admins,phone_number',
      'account_number' => 'required|string|max:10|min:10',
      'bank_name' => 'required|string',
      // 'gender' => 'required|in:male,female',
    ]);
    $user = auth()->user()->where([
      ['role', 'admin'],
      ['status', 'active']
    ])->join('admins', 'admins.user_id', '=', 'users.id')->update([
      // "name" => $validatedData['name'],
      // "email" => $validatedData['email'],
      // "phone_number" => $validatedData['phone_number'],
      "account_number" => $validatedData['account_number'],
      "bank_name" => $validatedData['bank_name'],
      // "gender" => $validatedData['gender'],
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
