<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class ActiveUserMiddleware
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
        $user = User::find(auth()->id());
        info($user);

        if ($user->status === 'pending') {
            return response()->json(
                [
                    'message' => 'Your account is inactive. Please contact an administrator to activate it.']
                , 401);
        }

        return $next($request);
    }

}