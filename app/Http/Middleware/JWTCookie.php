<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class JWTCookie
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
        if (Auth::check()) {
            $token = JWTAuth::fromUser(Auth::user());
            if ($token) {
                setcookie('accessToken', $token);
                return $next($request);
            } else {
                abort(500);
            }
        } else {
            abort(403);
        }
    }
}
