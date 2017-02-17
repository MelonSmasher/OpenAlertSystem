<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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

        if ($request->is('admin/*')) {
            if (!$user->hasAnyRole(['admin', 'power-user'])) {
                return redirect()->route('index');
            }
        }

        return $next($request);
    }
}
