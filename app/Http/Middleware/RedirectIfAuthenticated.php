<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->check()) {
            $route = $guard == 'admin' ? route('core_admin_table') : route('user_profile', cLng('code'));
			return redirect($route);
		}

		return $next($request);
	}
}
