<?php

namespace App\Http\Middleware;

use Closure;

class RoleAuth
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
        $prefix = $request->route()->getPrefix();
        $currentRoleID = \Auth::user()->role_id;
        switch($currentRoleID){
            case 1:
                if(!($prefix=='/customer' && $currentRoleID==1)){
                    return redirect('customer/profile');        
                }
            break;
            case 2:
                if(!($prefix=='/agent' && $currentRoleID==2)){
                    return redirect('agent/profile');        
                }
            break;
            case 3:
                if(!($prefix=='/operator' && $currentRoleID==3)){
                    return redirect('operator/profile');        
                }
            break;
            case 4:
                if(!($prefix=='/admin' && $currentRoleID==4)){
                    return redirect('admin/profile');        
                }
            break;
        }
        return $next($request);
    }
}
