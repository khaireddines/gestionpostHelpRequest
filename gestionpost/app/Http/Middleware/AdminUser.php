<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use App\User;

class AdminUser
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
        $userId=$request->user()->id;
        $obj_user=User::find($userId);
        $userType=$obj_user->user_type;

        if($userType != Config::get('constants.ADMIN_USER')){

            $message=trans('lang.invalid_user');
            $status=Config::get('constants.UNAUTHORIZED');
            return response()->json([
                'status' => $status,
                'response' => $message]);
        }
        return $next($request);
    }
}
