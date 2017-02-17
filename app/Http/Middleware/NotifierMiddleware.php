<?php

namespace App\Http\Middleware;

use Closure;

class NotifierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($request->is('compose') || $request->is('compose/*') || $request->is('dispatch') || $request->is('dispatch/*')) {
            if (!$user->hasAnyRole(['admin', 'power-user', 'notifier'])) {
                return redirect()->route('index');
            }
        }
        return $next($request);
    }
}
