<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, array $roles)
    {
        if (!in_array(auth()->user()->user_type, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
