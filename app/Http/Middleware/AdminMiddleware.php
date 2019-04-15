<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminMiddleware
{
    /**
     * Посредник входа в панель управления администратора
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->is_admin)
        {
			return $next($request);
		}
        
        abort(404);
    }
}
