<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle($request, Closure $next, $type)
    {
        if (Auth::check() && Auth::user()->user_type == $type) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}
