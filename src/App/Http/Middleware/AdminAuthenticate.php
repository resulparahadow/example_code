<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (! $request->user('admin')) {
            return redirect()->route('admin.login.page');
        }

        return $next($request);
    }
}
