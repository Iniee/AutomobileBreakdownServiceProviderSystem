<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
       // $provider = User::where('id', $user->user_id)->first();
         if ($user->role!= 'provider') {
            return response()->json([
                'message' => 'Unauthorised Access',
            ], 400);
        }
        return $next($request);
    }
}