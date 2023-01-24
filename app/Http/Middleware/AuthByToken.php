<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthByToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('authorization')) {
            $bearertoken = $request->bearerToken();
            $token = $request->header('authorization');
            if (!empty($bearertoken)) {
                $token = str_replace('Bearer ', '', $token);
                $user = User::where('token', $token)->first();
                
                if ($user) {
                    Auth::login($user);
                } else {
                    if (strpos($request->url(), '/api/') > 0) {
                        return route('unauthenticated');
                    }
                }
            }
        }

        return $next($request);
    }
}
