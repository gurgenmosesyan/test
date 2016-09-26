<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Core\Exceptions\AccessDeniedException;

class AccessControl
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
        $admin = Auth::guard('admin')->user();
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        $action = $request->route()->getAction();

        /*$cRouteName = $request->route()->getName();
        if ($cRouteName == 'core_admin_profile' || $cRouteName == 'core_admin_profile_update') {
            $params = $request->route()->parameters();
            if (isset($params['id']) && $params['id'] == $admin->id) {
                return $next($request);
            }
        }*/

        if (isset($action['permission']) && !isset($admin->permissions[$action['permission']])) {
            throw new AccessDeniedException(403, 'Permission denied');
        }

        return $next($request);
    }
}